<?php
if(session_id() == ''){
    session_start();
}
if(isset($_POST['addToCardProdBtn'])){
    if(!isset($_SESSION['user_login'])){
        $_SESSION['status_danger'] = " You need to Login First";
        echo 0;
    }
    else
    {
        include('./dbConnection.php');
        $prod_id = $_POST['prod_id'];
        $user_id = $_SESSION['user_id'];
        // checking product already added or not
        $checkQuery = "SELECT * FROM add_to_cart WHERE prod_id = '$prod_id' AND user_id = '$user_id'";
        $result = mysqli_query($conn,$checkQuery);
        if(mysqli_num_rows($result) > 0){
            $_SESSION['status_danger'] = " Product already in the cart you should choose quantity";
            echo 1;
        }
        else{
            // Checking Product Stock available or not 
            $checkStockQuery = "SELECT stock FROM products WHERE prod_id = '$prod_id'";
            $result = mysqli_query($conn,$checkStockQuery);
            if($result){
                $rows = mysqli_fetch_assoc($result);
                $stock = $rows['stock'];
                if($stock == 0){
                    $_SESSION['status_danger'] = " Product Out of Stock!";
                    echo 1;
                }
                else{
                    $query = "INSERT add_to_cart (prod_id,user_id) VALUES ('$prod_id','$user_id');";
                    $result = mysqli_query($conn,$query);
                    if($result){
                        $_SESSION['status_success'] = " Product added in the cart successfully!";
                        echo 1;
                    }
                }
            }
            else
            {
                $_SESSION['status_danger'] = " Error !";
            }
        }

    }
}

// For Remove Cart Items 
if(isset($_POST['removeProductFromCart'])){
    $user_id = $_SESSION['user_id'];
    $prod_id = $_POST['product_id'];
    include('./dbConnection.php');
    $query = "DELETE FROM add_to_cart WHERE prod_id = '$prod_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn,$query);
    if($result){
        $_SESSION['status_success'] = " One item remove from your cart!";
    }
    else{
        $_SESSION['status_danger'] = " Error!";
    }
}

// For updateproductQuantity 
if(isset($_POST['updateQuantity'])){
    include('./dbConnection.php');
    $prod_id =  $_POST['prod_id'];
    $quantity =  $_POST['quantity'];
    $user_id = $_SESSION['user_id'];
    if($prod_id != '' && $quantity != ''){
        $query = "UPDATE add_to_cart SET prod_quantity = '$quantity' WHERE prod_id = '$prod_id' AND user_id = '$user_id'";
        $result = mysqli_query($conn,$query);
        if($result){
            echo 1;
        }else{
            echo 0;
        }
    }
}


// For Submit User FeedBack 
if(isset($_POST['submitFeedback'])){
    if(!isset($_SESSION['user_login'])){
        $_SESSION['status_danger'] = " First login for add reviews";
        header('location: ./Login.php');
        die;
    }
    else{
        include('./dbConnection.php');
        $user_id = $_SESSION['user_id'];
        $comment = $conn->real_escape_string($_POST['comment']);
        $prod_id = $conn->real_escape_string($_POST['product_id']);
        $cate_id = $conn->real_escape_string($_POST['cate_id']);
        if($comment == ''){
            $_SESSION['status_danger'] = " Input field empty!";
            header('location: ./Product.php?product_id='.$prod_id.'&cate_id='.$cate_id.'');
            die;
        }
        $query = "INSERT INTO user_feedback (user_id,prod_id,comment) VALUES ('$user_id',
        '$prod_id', '$comment');";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['status_success'] = " Your Review Added Successfully";
            header('location: ./Product.php?product_id='.$prod_id.'&cate_id='.$cate_id.'');
            die;
        }
    }
}