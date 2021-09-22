<?php include('partials/menu.php'); ?>

<div class ="main-content">
    <div class ="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
            //1. Get the ID of selected Category
            $id=$_GET['id'];

            //2. Create SQL Query to get the Details
            $sql="SELECT * FROM tbl_category WHERE id=$id";

            //Execute the Query
            $res=mysqli_query($conn, $sql);

            //check whether the query is executed or not
            if($res==TRUE)
            {
                //Check whether the data is available or not
                $count = mysqli_num_rows($res);
                //Check whether we have admin data or not
                if($count==1)
                {
                    //echo "Category Available";
                    //Get the details
                    
                    $row=mysqli_fetch_assoc($res);

                    $title=$row['title'];
                    $current_image=$row['image_name'];
                    $featured=$row['featured'];
                    $active=$row['active'];
                }
                else
                {
                    //Redirect to manage Category page with Session page
                    
                    $_SESSION['no-category-found'] = "<div class ='error'>Category not found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');

                }
            }


        
        
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <!-- enctype="multipart/form-data"> this will aloow us to upload file image --> 
        
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                //Display the Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Display Message
                                echo "<div class = 'error'>Image not Added.</div>";
                            }
                        ?>
                    </td>
                
                </tr>

                <tr>
                    <td>New Image : </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                
                </tr>


                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured== "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured== "No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($featured== "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($featured== "No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                
                </tr>

                <tr>
                    <td colspan="2"> 
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?> ">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Category" class="btn-secondary">     
                    </td>
                </tr>
            </table>
        
    
    </form>


    </div>
</div>


<?php

        //Check whether the submit Button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "Button Clicked";
            //1. Get all the values from form to update
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. Updating new image if selected
            //check whether the image is selected or not
            if(isset($_FILES['image']['name']))
            {
                //Get the Image Details
                $image_name = $_FILES['image']['name'];

                //check whether the image is available or not
                if($image_name != "")
                {
                    //Image Available
                    //A. Upload the new Image

                    //Auto Rename our image
                    //Get the extension of our image(jpg,png,gif,etc) e.g. "specialfood1.jpg"
                    $ext =end(explode('.', $image_name));

                    //Rename the image
                    $image_name = "Food_Category_".rand(000,999).'.'.$ext; //e.g. Food_Category_834.jpg

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //Check whether the image uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error messge
                    if($upload==false)
                    {
                        //Set message

                        $_SESSION['upload'] = "Failed to upload image.";
                        //Redirect to add category page
                        header("location:".SITEURL.'admin/manage-category.php');
                        //Stop the process coz if image isnt inserted then data should not br uploaded
                        die();

                    }


                    //B. Remove the current Image if available
                    if($current_image!="")
                    {
                        $remove_path = "../images/category/".$current_image;

                        $remove = unlink($remove_path);
    
                        //Check whether the image is removed or not
                        //If failed to remove then display message and stop the process
                        if($remove==false)
                        {
                            //Failed to remove image
                            $_SESSION['failed-remove'] = "<div class = 'error'>Failed to remove current Image.</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die(); // Stop the process
                        }
                    }
                   
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            

            //Create a SQL Query to Update Category
            $sql2 = "UPDATE tbl_category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
            ";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Check whether the query executed successfully or not
            if($res2==true)
            {
                //Query Executed and Catgory Updated
                $_SESSION['update'] = "<div class = 'success'>Category Updated Successfully</div>";
                //Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                //Failed to update Admin
                $_SESSION['update'] = "<div class = 'error'>Failed to update Category.</div>";
                //Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
            }

        }

?>

<?php include('partials/footer.php'); ?>