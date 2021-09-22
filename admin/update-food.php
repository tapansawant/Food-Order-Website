<?php include('partials/menu.php'); ?>

<div class ="main-content">
    <div class ="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <?php
            //1. Get the ID of selected Category
            $id=$_GET['id'];

            //2. Create SQL Query to get the Details
            $sql2="SELECT * FROM tbl_food WHERE id=$id";

            //Execute the Query
            $res2=mysqli_query($conn, $sql2);

            //check whether the query is executed or not
            if($res2==TRUE)
            {
                //Check whether the data is available or not
                $count = mysqli_num_rows($res2);
                //Check whether we have admin data or not
                if($count==1)
                {
                    //echo "Category Available";
                    
                    
                    $row2=mysqli_fetch_assoc($res2);
                    
                    //Get the details indivisual

                    $title=$row2['title'];
                    $description=$row2['description'];
                    $price=$row2['price'];
                    $current_image=$row2['image_name'];
                    $current_category=$row2['category_id'];
                    $featured=$row2['featured'];
                    $active=$row2['active'];
                }
                else
                {
                    //Redirect to manage Food page with Session page
                    
                    $_SESSION['no-category-found'] = "<div class ='error'>Category not found</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');

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
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" value="<?php echo $description; ?>"></textarea>
                </td>
                </tr>

                <tr>
                <td>Price: </td>
                <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>

             
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image!= "")
                            {
                                //Display the Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Image not avalilable
                                echo "<div class = 'error'>Image not Available.</div>";
                            }
                        ?>
                    </td>
                
                </tr>

                <tr>
                    <td>Select New Image : </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                
                </tr>

                <tr>
                <td>Category: </td>
                <td>
                    <select name="category">
                        <?php
                            //Create php code to display categories from database
                            //1. Create Sql to get all active categorues from database
                            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                            //Executing query
                            $res = mysqli_query($conn , $sql);

                            //Count rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            //If count is grater than 0 , we have categories else we dont hava
                            if($count>0)
                            {
                                //We have categories
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    //Get the details of Categories
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    ?>

                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $id ?>"><?php echo $category_title; ?></option>

                                    <?php
                                }
                            }
                            else
                            {
                                //We do not have category
                                ?>
                                <option value="0">Category Not Available.</option>
                                <?php
                            }

                            //2. Display on dropdown

                        ?>


                        
                    </select>
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
                            <input type="submit" name="submit" value="Update Food" class="btn-secondary">     
                    </td>
                </tr>
            </table>
        
    
    </form>


    

<?php

        //Check whether the submit Button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "Button Clicked";
            //1. Get all the values from form to update
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];

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
                    $image_name = "Food_Name_".rand(0000,9999).'.'.$ext; //e.g. renamed image

                    //Get src and dst path
                    $src_path = $_FILES['image']['tmp_name'];

                    $dest_path = "../images/food/".$image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //Check whether the image uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error messge
                    if($upload==false)
                    {
                        //Set message

                        $_SESSION['upload'] = "Failed to upload new image.";
                        //Redirect to add category page
                        header("location:".SITEURL.'admin/manage-food.php');
                        //Stop the process coz if image isnt inserted then data should not br uploaded
                        die();

                    }


                    //B. Remove the current Image if available
                    if($current_image!="")
                    {
                        $remove_path = "../images/food/".$current_image;

                        $remove = unlink($remove_path);
    
                        //Check whether the image is removed or not
                        //If failed to remove then display message and stop the process
                        if($remove==false)
                        {
                            //Failed to remove image
                            $_SESSION['remove-failed'] = "<div class = 'error'>Failed to remove current Image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die(); // Stop the process
                        }
                    }
                   
                }
                else
                {
                    $image_name = $current_image; //default image when image is not selected
                }
            }
            else
            {
                $image_name = $current_image; //Default image when button is not clicked
            }

            

            //Create a SQL Query to Update Category
            $sql3 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
            ";

            //Execute the Query
            $res3 = mysqli_query($conn, $sql3);

            //Check whether the query executed successfully or not
            if($res3==true)
            {
                //Query Executed and Food Updated
                $_SESSION['update'] = "<div class = 'success'>Food Updated Successfully</div>";
                //Redirect to Manage Food Page
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //Failed to update Food
                $_SESSION['update'] = "<div class = 'error'>Failed to update Food.</div>";
                //Redirect to Manage Food Page
                header('location:'.SITEURL.'admin/manage-food.php');
            }

        }

        

    ?>

    </div>
</div>
        

<?php include('partials/footer.php'); ?>