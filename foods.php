<?php include('partials-front/menu.php'); ?>



    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-centre">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



     <!--food-menu Section starts here-->
     <section class ="food-menu">
        <div class ="container">
            <h2 class="text-centre">Food Menu</h2>
            <?php
            //Getting foods from database that are active
            //Sql Query
            $sql2 = "SELECT * FROM tbl_food WHERE active ='Yes'";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);
            
            //Count the rows to check whether the food is available or not
            $count2 = mysqli_num_rows($res2);

            //Check whether food is available or not
            if($count2>0)
            {
                //Food Available
                while($row =mysqli_fetch_assoc($res2))
                {
                    //Get all the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
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
                //Food Not Available
                echo "<div class = 'error'>Food not available.</div>"; 
            }


            ?>       

            <div class="clearfix"></div>
        </div>
    </section>
    <!--food-menu Section ends here-->



    <?php include('partials-front/footer.php'); ?>