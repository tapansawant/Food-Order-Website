<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>


        <br />
        <br />
        <br />

        <?php
            if(isset($_SESSION['add'])) //checking whether the session is set or not
            {
                echo $_SESSION['add']; //Display the session message if SET
                unset($_SESSION['add']); //Remove Session message
            }
        ?>


        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" placeholder="ur username">
                    
                    </td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="ur pswd">
                    </td>
                
                </tr>

                <tr>
                    <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    
                    </td>
                </tr>
            </table>
        
        
        </form>
    </div>



</div>


<?php include('partials/footer.php');?>


<?php

    //process the value from form and save it in database

    //check whether the submit btn id clicked or not
    if(isset($_POST['submit']))
    {
       // Button Clicked 
       //echo "Button Clicked";

       //1. Get the data from form
       $full_name = $_POST['full_name'];
       $username = $_POST['username'];
       $password = md5($_POST['password']); //PAssword encryption with md5

       //2. SQL Query to save the data into database
       $sql = "INSERT INTO tbl_admin SET
            full_name= '$full_name',
            username= '$username',
            password= '$password'
       ";

       //3. Executing Query and Saving Data into Database
       $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4.Check whether the(Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //DATA INSERTED
            //echo "Data Inserted";
            //Create a session variable to display message
            $_SESSION['add'] = "Admin Added Successfully";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
 
        }
        else
        {
            //FAILED TO INSERT DATA
            //echo "Failed to Insert Data";
            //Create a session variable to display message
            $_SESSION['add'] = "Failed to add Admin";
            //Redirect Page to Add Admin
            header("location :".SITEURL.'admin/add-admin.php');
 
        }
        

      
    }
    

       
?>