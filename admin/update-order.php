<?php include('partials/menu.php'); ?>

<div class ="main-content">
    <div class ="wrapper">
        <h1>Update Order</h1>

        <br><br>

        <?php
            //1. Get the ID of selected Category
            $id=$_GET['id'];

            //2. Create SQL Query to get the Details
            $sql2="SELECT * FROM tbl_order WHERE id=$id";

            //Execute the Query
            $res2=mysqli_query($conn, $sql2);

            //check whether the query is executed or not
            if($res2==TRUE)
            {
                //Check whether the data is available or not
                $count = mysqli_num_rows($res2);
                //Check whether we have data or not
                if($count==1)
                {
                    //echo "detrails Available";
                    
                    
                    $row2=mysqli_fetch_assoc($res2);
                    
                    //Get the details indivisual

                    $food=$row2['food'];
                    $price=$row2['price'];
                    $qty=$row2['qty'];
                    $status=$row2['status'];
                    $customer_name=$row2['customer_name'];
                    $customer_contact=$row2['customer_contact'];
                    $customer_email=$row2['customer_email'];
                    $customer_address=$row2['customer_address'];
                }
                else
                {
                    //Redirect to manage Order page with Session page
                    
                    $_SESSION['no-category-found'] = "<div class ='error'>Category not found</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');

                }
            }


        
        
        ?>

        <form action="" method="POST">
        
        
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b><value="<?php echo $food; ?>"></td>
                </tr>

                <tr>
                <td>Price: </td>
                <td><b> <value="<?php echo $price; ?>"></td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>


                <tr>
                    <td>Customer Name: </td>
                    <td><input type="text" name="customer_name" value="<?php echo $customer_name; ?>"></td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td><input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>"></td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td><input type="text" name="customer_email" value="<?php echo $customer_email; ?>"></td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?> </textarea>
                </tr>      

                
                   <td colspan="2"> 
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="price" value="<?php echo $price; ?>">

                            <input type="submit" name="submit" value="Update Order" class="btn-secondary">     
                    </td>
                </tr>
            </table>
        
    
    </form>


    

<?php

        //Check whether the update Button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "Button Clicked";
            //1. Get all the values from form to update
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];

            $total = $price * $qty;

            $status = $_POST['status'];

            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];
            
           

            //Create a SQL Query to Update Values
            $sql3 = "UPDATE tbl_order SET
            qty = $qty,
            total = $total,
            status = '$status',
            customer_name = '$customer_name',
            customer_contact = '$customer_contact',
            customer_email = '$customer_email',
            customer_address = '$customer_address'
            WHERE id = $id
            ";

            //Execute the Query
            $res3 = mysqli_query($conn, $sql3);

            //Check whether the query executed successfully or not
            if($res3==true)
            {
                //Query Executed and Order Updated
                $_SESSION['update'] = "<div class = 'success'>Order Updated Successfully</div>";
                //Redirect to Manage Food Page
                header('location:'.SITEURL.'admin/manage-order.php');
            }
            else
            {
                //Failed to update 
                $_SESSION['update'] = "<div class = 'error'>Failed to update Order.</div>";
                //Redirect to Manage Order Page
                header('location:'.SITEURL.'admin/manage-order.php');
            }

        }

        

    ?>

    </div>
</div>
        

<?php include('partials/footer.php'); ?>