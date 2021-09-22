<?php include('partials/menu.php'); ?>
        

        <!-- Main Content Section Starts -->
        <div class ="main-content">
            <div class="wrapper">
                <h1>DASHBOARD</h1>
                <br><br>
                <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
            
                ?>
                <br><br>


                <div class="col-4 text-centre">
                    <?php
                        //SQL Query
                        $sql = "SELECT * FROM tbl_category";
                        //Ececute Query
                        $res = mysqli_query($conn, $sql);
                        //count rows
                        $count = mysqli_num_rows($res);

                    ?>
                    <h1><?php echo $count; ?></h1>
                    <br/>
                    categories
                </div>

                <div class="col-4 text-centre">
                    <?php
                        //SQL Query
                        $sql2 = "SELECT * FROM tbl_food";
                        //Ececute Query
                        $res2 = mysqli_query($conn, $sql2);
                        //count rows
                        $count2 = mysqli_num_rows($res2);

                    ?>
                    <h1><?php echo $count2; ?></h1>
                    <br>
                    Foods
                </div>

                <div class="col-4 text-centre">
                    <?php
                        //SQL Query
                        $sql3 = "SELECT * FROM tbl_order";
                        //Ececute Query
                        $res3 = mysqli_query($conn, $sql3);
                        //count rows
                        $count3 = mysqli_num_rows($res3);

                    ?>
                    <h1><?php echo $count3; ?></h1>
                    <br>
                    Total Orders
                </div>

                <div class="col-4 text-centre">
                    <?php
                        //SQL Query to get total revenue generated
                        //Aggregate function in SQL
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status = 'DElivered'";

                        //Ececute Query
                        $res4 = mysqli_query($conn, $sql4);

                        //Get the values
                        $row4 = mysqli_fetch_assoc($res4);

                        //Get the total revenue
                        $total_revenue = $row4['Total'];

                    ?>
                    <h1><?php echo $total_revenue; ?></h1>
                    <br>
                    Revenue Generated
                </div>

               <div class ="clearfix"></div>
                </div>
            </div>
        </div>      
        <!-- Main Content Section ends -->

<?php include('partials/footer.php') ?>