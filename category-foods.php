
<?php include('partials-front/menu.php'); ?>

<?php
    //Check whether id id passed or nogt
    if(isset($_GET['category_id']))
    {
        //Category id is set and get the id
        $category_id = $_GET['category_id'];
        //Get the Category title based on category_ID
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //Get the value from database
        $row = mysqli_fetch_assoc($res);

        //Get the Title
        $category_title = $row['title'];

    }
    else
    {
        //Category not passed
        //Redirect to home page
        header('location:'.SITEURL);
    }
?>




    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-centre">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!--food-menu Section starts here-->
    <section class ="food-menu">
        <div class ="container">
            <h2 class="text-centre">Food Menu</h2>

            <?php
                //Create SQL Query to get foods based on selected category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Count the Rows
                $count2 = mysqli_num_rows($res2);

                //Check whether food is available or not
                if($count2>0)
                {
                    //Food is Available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
                        <div class= "food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    //Check whether Image available or not
                                    if($image_name=="")
                                    {
                                        //Image not Available
                                        echo "<div class = 'error'>Image not avaiable.</div>";
                                    }  
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicken Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                            
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">&#x20B9 <?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>



                        <?php
                    }
                }
                else
                {
                    //Food not available
                    echo "<div class = 'error'>Food not Available.</div>";
                }

            ?>

           
            
            

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!--food-menu Section ends here-->


   
    <?php include('partials-front/footer.php'); ?>