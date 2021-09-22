<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 
                //Get the Search Keyword
                $search = $_POST['search'];
            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!--food-menu Section starts here-->
    <section class ="food-menu">
        <div class ="container">
            <h2 class="text-centre">Food Menu</h2>

            <?php 


                //SQL Query to get foods based on search keyword
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count the rows to check whether the food is available or not
                $count = mysqli_num_rows($res);

                //Check whether food available or not
                if($count>0)
                {
                    //Food Available 
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the details
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

                                <a href="order.html" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>


                        <?php
                    }
                }
                else
                {
                    //Food not Available
                    echo "<div class ='error'>Food not found.</div>";
                }
                
            ?>

           
            
            

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!--food-menu Section ends here-->



    <?php include('partials-front/footer.php'); ?>