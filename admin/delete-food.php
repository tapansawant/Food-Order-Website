<?php

    //Include constants.php file here
    include('../config/constants.php');


    //Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the value and Delete i.e ID and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file if avalilable
        if($image_name != "")
        {
            //Image is available. So remove it from folder.
            $path = "../images/food/".$image_name;
            //Remove the image from folder
            $remove = unlink($path);

            //Check If failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //Failed to remove
                //Set the session msg
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove Food Image</div>";
                //Redirect to manage food page
                header('location:'.SITEURL.'admin/manage-food.php');
                //Stop the process
                die();
            }
        }

        //3. Delete data from database
        // Create SQL query to delete category
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the query executed successfully or not means data is delete from database or not
        if($res==true)
        {
            //Query Executed Successfully and Category Deleted
            //echo "Category Deleted";
            //Create Session Variable to display message
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            //Redirect to Manage Food Page
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Set fail message and redirect
            //echo "Failed to Delete Food";

            $_SESSION['delete'] = "<div class= 'error'> Failed to Delete Food. Try Again Later.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        


        }

        
    }
    else
    {
        //Redirect to Manage Food Page
        $_SESSION['unauthorize'] = "<div class= 'error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }




?>