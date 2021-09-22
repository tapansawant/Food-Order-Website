<?php

    //Include constants.php file here
    include('../config/constants.php');


    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the value and Delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file if avalilable
        if($image_name != "")
        {
            //Image is available. So remove it.
            $path = "../images/category/".$image_name;
            //Remove the image
            $remove = unlink($path);

            //If failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //Set the session msg
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove Category Image</div>";
                //Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //Stop the process
                die();
            }
        }

        //Delete data from database
        // Create SQL query to delete category
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the query executed successfully or not means data is delete from database or not
        if($res==true)
        {
            //Query Executed Successfully and Category Deleted
            //echo "Category Deleted";
            //Create Session Variable to display message
            $_SESSION['delete'] = "<div class='success'> Category Deleted Successfully</div>";
            //Redirect to Manage Category Page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Set fail message and redirect
            //echo "Failed to Delete Admin";

            $_SESSION['delete'] = "<div class= 'error'> Failed to Delete Category. Try Again Later.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        


        }

        
    }
    else
    {
        //Redirect to Manage Category Page
        header('location:'.SITEURL.'admin/manage-category.php');
    }




?>