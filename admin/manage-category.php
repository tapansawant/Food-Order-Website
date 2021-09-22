<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br />
                <br />
                <br />
                <?php
                if(isset($_SESSION['add'])) //checking whether the session is set or not
                {
                    echo $_SESSION['add']; //Display the session message if SET
                    unset($_SESSION['add']); //Remove Session message
                }

                if(isset($_SESSION['remove'])) //checking whether the session is set or not
                {
                    echo $_SESSION['remove']; //Display the session message if SET
                    unset($_SESSION['remove']); //Remove Session message
                }

                if(isset($_SESSION['delete'])) //checking whether the session is set or not
                {
                    echo $_SESSION['delete']; //Display the session message if SET
                    unset($_SESSION['delete']); //Remove Session message
                }

                if(isset($_SESSION['no-category-found'])) //checking whether the session is set or not
                {
                    echo $_SESSION['no-category-found']; //Display the session message if SET
                    unset($_SESSION['no-category-found']); //Remove Session message
                }

                if(isset($_SESSION['update'])) //checking whether the session is set or not
                {
                    echo $_SESSION['update']; //Display the session message if SET
                    unset($_SESSION['update']); //Remove Session message
                }

                if(isset($_SESSION['upload'])) //checking whether the session is set or not
                {
                    echo $_SESSION['upload']; //Display the session message if SET
                    unset($_SESSION['upload']); //Remove Session message
                }

                if(isset($_SESSION['failed-remove'])) //checking whether the session is set or not
                {
                    echo $_SESSION['failed-remove']; //Display the session message if SET
                    unset($_SESSION['failed-remove']); //Remove Session message
                }


                ?>
                <br />
                <br />


                <!-- Button to Add Admmin -->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
                <br />
                <br />
                <br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //Query to get all Category from database
                        $sql = "SELECT * FROM tbl_category";
                        //Execute the query
                        $res = mysqli_query($conn, $sql);

                        //check whether the query is executed or not
                        if($res==TRUE)
                        {
                            //Count Rows to check whether we have data in database
                            $count = mysqli_num_rows($res); // function to get all the rows in database

                            $sn=1; //Create a variable for serial no and assign the value

                            //check whether we have data in database or not
                            if($count>0)
                            {
                                //We have data in database
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    // Using while loop to get all the data from database
                                    // And while loop will run as long as we have data in database

                                    //Get individual Data
                                    $id=$rows['id'];
                                    $title=$rows['title'];
                                    $image_name=$rows['image_name'];
                                    $featured=$rows['featured'];
                                    $active=$rows['active'];

                                    //Display the values in our table
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++; ?> </td>
                                        <td><?php echo $title; ?></td>

                                        <td>

                                            <?php  
                                                //Check whether image name is available or not
                                                if($image_name=="")
                                                {
                                                    //Display the message
                                                    echo "<div class = 'error'>Image not Added.</div>";
                                                }
                                                else
                                                {
                                                    //Display the message
                                                   
                                                    ?>

                                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px" >


                                                    <?php
                                                }
                                            
                                            ?>

                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                           
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                                        </td>
                                    </tr>  



                                    <?php
                                }

                            }
                            else
                            {
                                // We do not have data in databse
                                //we'll dislpay the msg inside table
                                ?>
                                <tr>
                                    <td colspan="6"><div class="error">No category Added</div></td>
                                </tr>


                                <?php
                
                            }
                        }
                    ?>

                    
                            
                    
                </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>