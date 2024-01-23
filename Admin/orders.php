<?php
include('./MainInclude/header.php');
include('../dbConnection.php');
?>

<div class="div-2 w-100 " style="overflow-y:auto;">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">
        <h5 class="shadow mb-4 mt-3 d-flex align-items-center" style="width:100%;background-color:#B3005E;">
            <strong class="p-2 text-white text-center w-100">Orders</strong>
        </h5>
        <div class="d-flex justify-content-center">
            <form action="" method="post" class=" d-flex  col-md-6 ">
                <input type="text" name="search_order_input" id="search_order_input" class="form-control searchBar " placeholder="Search Order">
                <button class="btn searchBarBtn"><i class="bi bi-search"></i></button>
            </form>            
        </div>
        <div class="continer-fluid mt-3" style="overflow-x:auto;">
            <table  class="table table-hover table-responsive" id="order_table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Username</th>
                        <th scope="col">Products</th>
                        <th scope="col">Price</th>
                        <th scope="col">Shipping Address</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Mark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT * FROM orders AS o 
                        JOIN users AS u ON o.user_id = u.user_id";
                        $result = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result) > 0){
                            while($rows = mysqli_fetch_assoc($result)){
                                if (isset($rows['status'])) {
                                    $status = $rows['status'];
                                    if ($status == 0) {
                                        $status = "Pending";
                                    } else if ($status == 1) {
                                        $status = "Packed";
                                    } else if ($status == 2) {
                                        $status = "Shipped";
                                    } else if ($status == 3) {
                                        $status = "Delivered";
                                    }
                                    else{
                                        $status = "Cancal";
                                    }
                                }
                    ?>
                    <tr class="">
                        <th scope="row" class="order_id"><?php if(isset($rows['order_id'])){ echo $rows['order_id'];} ?></th>
                        <td>
                            <!-- Convert DateTime to Date  -->
                            <?php 
                                $timestamp =  $rows['order_date'];
                                $dateTime = new DateTime($timestamp);
                                $date = $dateTime->format('d-m-Y');
                                echo $date;
                            ?>
                        </td>
                        <td><?php if(isset($rows['user_name'])){ echo $rows['user_name'];} ?></td>
                        <td style="width: 270px;">
                            <?php 
                                if($rows['product_ids']){
                                    $pairs = explode(',',$rows['product_ids']);
                                    $res = [];
                                    foreach($pairs as $pair){
                                        // Extracting Products ID 
                                        $start =  strpos($pair,'(');
                                        $prd_id = trim( substr($pair,0,$start));
                                        // Extracting Products Name
                                        $end = strpos($pair,')');
                                        $quant = trim(substr($pair,$start + 1,$end - $start - 1));
                                        $res[] = [
                                            'prd_id' => $prd_id,
                                            'q' => $quant
                                        ]; 
                                    }
                                    foreach($res as $r){
                                        echo "<strong>Product id: </strong>".$r['prd_id']."<strong> Quantity: </strong>".$r['q'].",";
                                        echo "<BR>";
                                    }
                                }
                            ?>
                        
                        </td>
                        <td><?php if(isset($rows['total_price'])){ echo $rows['total_price'];} ?></td>
                        <td style="width: 280px;"><?php  echo $rows['shipping_address']." ".$rows['city']." ".$rows['country']." ".$rows['zip_code']; ?></td>
                        <td><?php if(isset($rows['u_number'])){ echo $rows['u_number'];} ?></td>
                        <td><?php if(isset($rows['user_email'])){ echo $rows['user_email'];} ?></td>
                        <td><h5><div class="badge bg-danger"><?php echo $status;?></div></h5></td>
                        <td>
                            <select name="mark_orders" id="mark_orders" class="form-select mark_orders">
                                <option value="0" <?php echo $rows['status'] == 0? "selected":"" ?>>Pending</option>
                                <option value="1" <?php echo $rows['status'] == 1? "selected":"" ?>>Packed</option>
                                <option value="2" <?php echo $rows['status'] == 2? "selected":"" ?>>Shipped</option>
                                <option value="3" <?php echo $rows['status'] == 3? "selected":"" ?>>Deliver</option>
                                <option value="4" <?php echo $rows['status'] == 4? "selected":"" ?>>Cancel</option>
                            </select>
                        </td>
                    </tr>
                    <?php
                        }
                            }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('./MainInclude/footer.php');
?>