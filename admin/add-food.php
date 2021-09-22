<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br>
        <br>

       
        <br>
        <br>


        <!-- Add food form starts -->

        <form action="" method="POST" enctype="multipart/form-data">
        <!-- enctype="multipart/form-data"> this will aloow us to upload file image --> 
        
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td><input type="text" name="title" placeholder="Title of the Food"></td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td><input type="number" name="price"></td>
            </tr>

            <tr>
                <td>Select Image : </td>
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
                            //1. Create Sql to get all active categories from database
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
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>

                                    <option value="<?php echo $id ?>"><?php echo $title; ?></option>

                                    <?php
                                }
                            }
                            else
                            {
                                //We do not have category
                                ?>
                                <option value="0">No Category Found</option>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">     
                </td>
            </tr>
        </table>
    
    
    </form>
        <!-- Add Food form ends -->

    <?php

        //process the value from form and save it in database

        //check whether the submit btn id clicked or not
        if(isset($_POST['submit']))
        {
            // Button Clicked 
            //echo "Button Clicked";

            //1. Get the data from  form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

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

                //  check and Upload the image only if image is selected
                if($image_name!= "")
                {

                    //Auto Rename our image
                    //Get the extension of our image(jpg,png,gif,etc) e.g. "specialfood1.jpg"
                    $ext =end(explode('.', $image_name));

                    //Rename the image
                    $image_name = "Food_Name_".rand(000,999).'.'.$ext; //e.g. Food_Name_834.jpg
                    //Get the src path and destination path

                    //Source path is the current location of the image
                    $src = $_FILES['image']['tmp_name'];

                    //Destination path for the current location of the image
                    $dst = "../images/food/".$image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($src, $dst);

                    //Check whether the image uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error messge
                    if($upload==false)
                    {
                        //Set message

                        $_SESSION['upload'] = "Failed to upload image.";
                        //Redirect to add food page
                        header("location:".SITEURL.'admin/add-food.php');
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
            //for numerical we don't need to pass value inside ''
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category, 
                featured = '$featured',
                active = '$active'
            ";

            //3. Executing Query and Saving Data into Database
            $res2 = mysqli_query($conn, $sql2) ;

            //4.Check whether the(Query is Executed) data is inserted or not and display appropriate message and redirect
            if($res==TRUE)
            {
                //Data INSERTED successfully
                //echo "Data Inserted";
                //Create a session variable to display message
                $_SESSION['add'] = "Food Added Successfully";
                //Redirect Page to Manage Food Page
                header("location:".SITEURL.'admin/manage-food.php');
 
            }
            else
            {
                //FAILED TO INSERT data
                //echo "Failed to Insert category";
                //Create a session variable to display message
                $_SESSION['add'] = "Failed to add Food";
                //Redirect Page to Manage Category Page
                header("location :".SITEURL.'admin/manage-food.php');
 
            }
        

      
    }
    

       
?>

    
</div>

</div>


        

<?php include('partials/footer.php'); ?>