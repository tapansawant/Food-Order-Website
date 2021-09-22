<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br>
        <br>

        <?php
            if(isset($_SESSION['add'])) //checking whether the session is set or not
            {
                echo $_SESSION['add']; //Display the session message if SET
                unset($_SESSION['add']); //Remove Session message
            }

            if(isset($_SESSION['upload'])) //checking whether the session is set or not
            {
                echo $_SESSION['upload']; //Display the session message if SET
                unset($_SESSION['upload']); //Remove Session message
            }
        ?>
        <br>
        <br>


        <!-- Add category form starts -->

        <form action="" method="POST" enctype="multipart/form-data">
        <!-- enctype="multipart/form-data"> this will aloow us to upload file image --> 
        
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td><input type="text" name="title" placeholder="Category Title"></td>
            </tr>

            <tr>
                <td>Select Image : </td>
                <td>
                    <input type="file" name="image" >
                </td>
            
            </tr>


            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
                </td>
            
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No
                </td>
            
            </tr>

            <tr>
                <td colspan="2"> 
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">     
                </td>
            </tr>
        </table>
    
    
    </form>
        <!-- Add category form ends -->

    <?php

        //process the value from form and save it in database

        //check whether the submit btn id clicked or not
        if(isset($_POST['submit']))
        {
            // Button Clicked 
            //echo "Button Clicked";

            //1. Get the data from Category form
            $title = $_POST['title'];

            //For radio input type, we need to check whether the button is selected or not
            if(isset($_POST['featured']))
            {
                //Get the value from form
                $featured = $_POST['featured'];

            } 
            else
            {
                //Set the default value
                $featured = "No";

            }

            if(isset($_POST['active']))
            {
                //Get the value from form
                $active = $_POST['active'];

            } 
            else
            {
                //Set the default value
                $active = "No";
            }

            //check whether the image is selected or not and set the value for image name accordingly
            //print_r($_FILES['image']); //array ahe mhnun echo use kela nhii

            //die(); //Break the code here ani database mdhye pn takaycha nhi
            
            if(isset($_FILES['image']['name']))
            {
                //Upload the image
                //To upload image we need image name, source path and destination path

                $image_name = $_FILES['image']['name'];

                // Upload the image only if image is selected
                if($image_name!= "")
                {

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
                        header("location:".SITEURL.'admin/add-category.php');
                        //Stop the process coz if image isnt inserted then data should not br uploaded
                        die();

                    }

                }

            } 
            else
            {
                //Don't upload image and set the image name value blank
                $image_name = "";

                //
            }

            //2. SQL Query to insert category into database
            $sql = "INSERT INTO tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
            ";

            //3. Executing Query and Saving Data into Database
            $res = mysqli_query($conn, $sql) or die(mysqli_error());

            //4.Check whether the(Query is Executed) data is inserted or not and display appropriate message
            if($res==TRUE)
            {
                //Category INSERTED
                //echo "Data Inserted";
                //Create a session variable to display message
                $_SESSION['add'] = "Category Added Successfully";
                //Redirect Page to Manage Category Page
                header("location:".SITEURL.'admin/manage-category.php');
 
            }
            else
            {
                //FAILED TO INSERT Category
                //echo "Failed to Insert category";
                //Create a session variable to display message
                $_SESSION['add'] = "Failed to add Category";
                //Redirect Page to Manage Category Page
                header("location :".SITEURL.'admin/manage-category.php');
 
            }
        

      
    }
    

       
?>

    
</div>

</div>


        









<?php include('partials/footer.php');?>