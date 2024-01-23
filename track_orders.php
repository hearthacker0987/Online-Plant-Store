<?php
include('./Components/header.php');
?>

<div class="container-fluid mt-5">
    <h3 class="text-center">
        <u><i><strong>Tracking Orders</strong></i></u>
    </h3>
    <div class="container-fluid">
        
            <?php 
            include('./dbConnection.php');
            $query = "SELECT * FROM orders AS o JOIN users AS u ON o.user_id = u.user_id WHERE o.user_id = '$user_id' ORDER BY o.order_id DESC";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0){
                while($rows = mysqli_fetch_assoc($result)){
            ?>  
                <div class="bg-light p-2 mb-3  mt-5">
                    <h5>Order: <span class="text-primary">#<?php echo $rows['order_id'];?></span></h5>
                    <div>Placed on <?php echo $rows['order_date'];?></span></div>
                </div>
                <div class="ms-5">
                    <?php 
                        $string = $rows['product_ids'];
                        $pairs = explode(',',$string);
                        $array = [];
                        foreach($pairs as $pair){
                            $start = strpos($pair,'(');
                            $product = trim(substr($pair,0,$start));
                            $end = strpos($pair,')');
                            $qty = trim(substr($pair,$start + 1, $end - $start - 1));
                            $array[] = [
                                'product' => $product,
                                'quantity' => $qty
                            ];
                        }
                        foreach($array as $items){
                            $p_id = $items['product'];
                            $Fetchquery = "SELECT * FROM products WHERE prod_id = '$p_id'";
                            $result2 = mysqli_query($conn,$Fetchquery);
                            if($result2){
                                $pr = mysqli_fetch_assoc($result2);
                                if($pr){
                                    echo '
                                    <div class="d-flex mb-3">
                                        <div class="d-flex w-50">
                                            <div class="img me-3" style="width: 90px;">
                                                <img src="./Admin/'.$pr['prod_img'].'" alt="" class="w-100 rounded">
                                            </div>
                                            <span>'.$pr['prod_name'].'</span>
                                        </div>
                                        <div class="quantity">Quantity: <strong>'.$items['quantity'].'</strong></div>
                                    </div>
                                    ';
                                }
                            }
                        }
                    ?>
                    <div class="address mt-2">
                        <strong>Email Address:</strong> <span class="ms-5"><?php echo $rows['user_email'];?></span>
                    </div>
                    <div class="address mt-2">
                        <strong>Phone Number:</strong> <span class="ms-5"><?php echo $rows['u_number'];?></span>
                    </div>
                    <div class="address mt-2">
                        <strong> Shipping Address:</strong> <span class="ms-4"><?php echo $rows['shipping_address']." ".$rows['city']." ".$rows['zip_code']." ".$rows['country'];?></span>
                    </div>
                    <div class="total_price d-flex mt-2 w-100">
                        <strong class="w-50">Total Price: <span class="ms-5">Rs <?php echo $rows['total_price']."/-";?></span></strong>
                        <div class="badge bg-danger">
                            <?php 
                                if($rows['status'] == 0){
                                    echo "Process";
                                }    
                                elseif($rows['status'] == 1){
                                    echo "Packed";
                                }    
                                elseif($rows['status'] == 2){
                                    echo "Shipped";
                                }    
                                elseif($rows['status'] == 3){
                                    echo "Delivered";
                                }
                                else{
                                    echo "Cancel";
                                }    
                            ?>
                        </div>
                    </div>
                </div>
            <?php
                }

            }else{
                echo'
                    <div class="alert alert-warning mt-3"> 0 Orders </div>
                ';
            }
            ?>
    </div>
</div>

<?php
include('./Components/footer.php');
?>