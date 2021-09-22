<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br />
                <br />
                <br />

                <?php
                if(isset($_SESSION['update'])) //checking whether the session is set or not
                {
                    echo $_SESSION['update']; //Display the session message if SET
                    unset($_SESSION['update']); //Remove Session message
                }
                ?>
                <br>
                <br>

               
                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty.</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //Query to get all orders from database
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC";  //order shevti yeill ti vr hoil descending i.e display the order at first
                        //Execute the query
                        $res = mysqli_query($conn, $sql);

                        //check whether the query is executed or not
                        if($res==TRUE)
                        {
                            //Count Rows to check whether we have data in database
                            $count = mysqli_num_rows($res); // function to get all the rows in database

                            $sn=1; //Create a variable for serial no and assign the value to 1

                            //check whether we have data in database or not
                            if($count>0)
                            {
                                //Order Available
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    // Using while loop to get all the data from database
                                    // And while loop will run as long as we have data in database

                                    //Get all order details
                                    $id=$rows['id'];
                                    $food=$rows['food'];
                                    $price = $rows['price'];
                                    $qty=$rows['qty'];
                                    $total=$rows['total'];
                                    $order_date=$rows['order_date'];
                                    $status=$rows['status'];
                                    $customer_name=$rows['customer_name'];
                                    $customer_contact=$rows['customer_contact'];
                                    $customer_email=$rows['customer_email'];
                                    $customer_address=$rows['customer_address'];

                                    //Display the values in our table
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++; ?> </td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $order_date; ?></td>

                                        <td>
                                            <?php
                                                // Ordered on ,Delivery, Delivered, Cancelled

                                                if($status=="Ordered")
                                                {
                                                    echo "<label>$status</label>";
                                                }
                                                elseif($status=="On Delivery")
                                                {
                                                    echo "<label style='color: orange'>$status</label>";
                                                }
                                                elseif($status=="Delivered")
                                                {
                                                    echo "<label style='color: green'>$status</label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color: red'>$status</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $customer_name; ?></td>
                                        <td><?php echo $customer_contact; ?></td>
                                        <td><?php echo $customer_email; ?></td>
                                        <td><?php echo $customer_address; ?></td>

                                        <td>
                                           
                                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                                        
                                        </td>
                                    </tr>  



                                    <?php
                                }

                            }
                            else
                            {
                                // Order not Availalbe
                               
                                ?>
                                <tr>
                                    <td colspan="12"><div class="error">Orders Not Availalbe</div></td>
                                </tr>


                                <?php
                
                            }
                        }
                    ?>


                </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>