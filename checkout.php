<?php
include('./Components/header.php');
// -------------------------------------- Fetching User details ----------------------------------- 
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT user_name,user_email,user_number FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user_info = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['status_danger'] = " User Not Found!";
    }
} else {
    $_SESSION['status_danger'] = " You need to login first for entering this page";
    header('location: ./Login.php');
}

// ----------------------------------- Place Order Button ---------------------- 
if (isset($_POST['placeOrderBtn'])) {
    $query = "SELECT * FROM add_to_cart AS a 
            JOIN products AS p ON a.prod_id = p.prod_id
            WHERE user_id = '$user_id' ";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user_name = $_SESSION['user_name'];
        $user_email = $_SESSION['user_email'];
        $num = $conn->real_escape_string($_POST['usernum']);
        $deliveryAddress = $conn->real_escape_string($_POST['houseDetails'] . ' ' . $_POST['apartmentDetails']);
        $city = $conn->real_escape_string($_POST['city']);
        $country = $conn->real_escape_string($_POST['country']);
        $zip_code = $conn->real_escape_string($_POST['ps_code']);
        if ($num == '' || $deliveryAddress == '' || $city == '' || $country == '' || $zip_code == '') {
            $_SESSION['status_danger'] = " Please fill all fields!";
        } 
        else {
            $total_price = 0;
            while ($product_item = mysqli_fetch_assoc($result)) {
                // Stock Checking 
                if ($product_item['stock'] < $product_item['prod_quantity']) {
                    $_SESSION['status_danger'] = " " . $product_item['prod_name'] . " have only " . $product_item['stock'] . " items left!";
                    header('location: ./index.php');
                    die;
                } 
                else 
                {
                    $products_ids[] = $product_item['prod_id'] . '(' . $product_item['prod_quantity'] . ')';
                    $products_name[] = $product_item['prod_name'] . '(' . $product_item['prod_quantity'] . ')';
                    $product_price = $product_item['price'] * $product_item['prod_quantity'];
                    $total_price += $product_price;
                    $updatedStock =  $product_item['stock'] - $product_item['prod_quantity'];
                    $updateStockQuery = "UPDATE products SET stock = '$updatedStock' WHERE prod_id = '{$product_item['prod_id']}'";
                    $upStockResult = mysqli_query($conn, $updateStockQuery);
                }
            }
            
            $total_products_ids = implode(',', $products_ids);
            $total_products_names = implode(',', $products_name);
            $order_query = "INSERT INTO orders (user_id,u_number,shipping_address,city,country,zip_code,product_ids,total_products,total_price)
            VALUES ('{$_SESSION['user_id']}','$num','$deliveryAddress','$city','$country','$zip_code','$total_products_ids','$total_products_names','$total_price');";
            $run_order_q = mysqli_query($conn, $order_query);
            if ($run_order_q) {
                // Remove items from cart after order 
                $deleteCartQuery = "DELETE FROM add_to_cart WHERE user_id = '{$_SESSION['user_id']}'";
                $run_del_q = mysqli_query($conn, $deleteCartQuery);
                $_SESSION['status_success'] = " Your Order Place Successfully!";
                header('location: ./index.php');
                die;
            } else {
                $_SESSION['status_danger'] = "Order Not Please!";
            }
        }
    }
}
?>
<div class="container-fluid mt-1 d-flex justify-content-center login">
    <form action="" method="post" class="col-sm-12 col-md-10 col-lg-8 shadow p-5 pt-3 mt-2 m-3 rounded border-bottom border-top border-success">
        <h3 class="text-center"><u><i><strong>Checkout</strong></i></u></h3>
        <?php
        // if(isset($_SESSION['user_id'])){
        //     $cartQuery = "SELECT * FROM add_to_cart AS a
        //             JOIN products AS p  ON a.prod_id = p.prod_id  
        //             WHERE user_id = '$user_id'";
        //     $result2 = mysqli_query($conn,$cartQuery);
        //     if(mysqli_num_rows($result2) > 0){
        //         echo '<div class="mt-3" style="width:200px;">';
        //         echo '<div class="d-flex justify-content-center flex-wrap">';
        //         $total = 0;
        //         $gtotal = 0;
        //         while($rows = mysqli_fetch_assoc($result2)){
        //             echo '<div class="ms-2"><span class="text-danger bg-light">'.$rows['prod_name'].'('.$user_infos['prod_quantity'].'),</span></div>';
        //             $totalPrice = $rows['price']*$rows['prod_quantity'];
        //             $gtotal = $total += $totalPrice; 
        //         }
        //         echo '</div>';
        //         echo '<div class="text-center bg-danger text-white">'.$gtotal.'</div>';
        //         echo '</div>';
        //     }
        //     else{
        //         echo "helo";
        //     }
        // }
        ?>
        <div class="mb-2 mt-1">
            <label for="username" class="form-label">Full Name</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo $user_info['user_name']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="userEmail" class="form-label">Email Address</label>
            <input type="email" name="userEmail" id="userEmail" class="form-control" value="<?php echo $user_info['user_email']; ?>" placeholder="Enter Email" readonly>
        </div>
        <div class="mb-3">
            <label for="usernum" class="form-label">Phone Number</label>
            <input type="text" name="usernum" id="usernum" class="form-control" value="<?php echo $user_info['user_number']; ?>" placeholder="Enter Phone Number">
        </div>
        <h5>Delivery Address</h5>
        <div class="mb-3">
            <label for="steet" class="form-label">Street Address</label>
            <input type="text" name="houseDetails" id="houseDetails" class="form-control" placeholder="House number and street number">
            <input type="text" name="apartmentDetails" id="apartmentDetails" class="form-control mt-2" placeholder="Apartment,suite,unit,etc (optional)">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">Town / City</label>
            <input type="text" name="city" id="city" class="form-control">
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">State / County </label>
            <input type="text" name="country" id="country" class="form-control">
        </div>
        <div class="mb-3">
            <label for="ps_code" class="form-label">Postal / Zip code </label>
            <input type="text" name="ps_code" id="ps_code" class="form-control">
        </div>
        <div class="mb-3">
            <label for="pMode" class="form-label">Payment Mode</label>
            <div>
                <input type="radio" name="pMode" value="Cash On Delivery" id="pMode" class="form-radio" checked>
                <label for="pMode" class="form-label">Cash On Delivery</label>
            </div>
        </div>
        <div class="mb-3 text-center">
            <input type="submit" name="placeOrderBtn" id="placeOrderBtn" value="Place Order" class="btn btn-primary">
        </div>
    </form>
</div>

<?php
include('./Components/footer.php')
?>