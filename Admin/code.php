<?php
    session_start();
    // Update Orders Status
    if(isset($_POST['markOrderStatus'])){
        $status = $_POST['status'];
        $order_id = $_POST['order_id'];
        if($status == '' || $order_id == ''){
            $_SESSION['status_danger'] = " Invalid input fields";
        }
        else{
            include('../dbConnection.php');
            if($status != 4){
                $query = "UPDATE orders SET status = '$status' WHERE order_id = '$order_id'";
                $result = mysqli_query($conn,$query);
                if($result){
                    $_SESSION['status_success'] = " Updated Successfully";
                }
                else{
                    $_SESSION['status_danger'] = " Error ";
                }
            }
            else{
                $query = "SELECT * FROM orders WHERE order_id = '$order_id'";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    $products = $row['product_ids'];
                    $pairs = explode(',',$products);
                    $finalProductsArr = [];
                    foreach($pairs as $pair){
                        // Extract Products ID
                        $start = strpos($pair,'(');
                        $product_id = substr($pair,0,$start);
                        // Extract Products Quantity
                        $end = strpos($pair,')');
                        $quantity = substr($pair,$start+1,$end -$start - 1);
                        // Add Products ID and quantity in Array 
                        $finalProductsArr[] = [
                            'products_ids' => $product_id,
                            'quantity' => $quantity
                        ];                       
                    }
                    foreach($finalProductsArr as $items){
                        $p_id = $items['products_ids'];
                        $p_quant = $items['quantity']; 
                        $decrementStockQuery = "UPDATE products SET stock = stock + '$p_quant' WHERE prod_id = '$p_id'";
                        $run = mysqli_query($conn,$decrementStockQuery); 
                    };
                    if($run){
                        $updateStatus = "UPDATE orders SET status = '$status' WHERE order_id = '$order_id'";
                        $run_query = mysqli_query($conn,$updateStatus);
                        if($run_query){
                            $_SESSION['status_success'] = " Update #$order_id Order Successfully!";
                        }
                    }
                    
                    
                }
            }
        }
    }
    // For Adding Website Logo 
    if(isset($_POST['webLogoBtn'])){
        include('../dbConnection.php');
        if($_FILES['web_logo']['name'] == ''){
            $_SESSION['status_danger'] = " Please select logo!";
            header('location: ./setting.php');
            die;
        }
        $quary = "SELECT * FROM setting";
        $result = mysqli_query($conn,$quary);
        if(mysqli_num_rows($result) == 0){
            $_SESSION['status_danger'] = " You should set site name first";
            header('location: ./setting.php');
            die;
        }
        else{
            $img_name = $_FILES['web_logo']['name'];
            $temp_name = $_FILES['web_logo']['tmp_name'];
            $path = "Images/setting/".$img_name;
            move_uploaded_file($temp_name,"./".$path);
            $updateQuery = "UPDATE setting SET web_logo = '$path'";
            $result = mysqli_query($conn,$updateQuery);
            if($result){
                $_SESSION['status_success'] = " Logo updated successfully!";
                header('location: ./setting.php');
                die;
            }
            else{
                $_SESSION['status_danger'] = "Does not save";
                header('location: ./setting.php');
                die;
            }
        }
    }
    // For Website Name 
    if(isset($_POST['webNameBtn'])){
        include('../dbConnection.php');
        if($_POST['web_name'] == ''){
            $_SESSION['status_danger'] = " Invalid Input!";
            header('location: ./setting.php');
            die;
        }
        else{
            $site_name = $conn->real_escape_string($_POST['web_name']);
            $quary = "SELECT * FROM setting";
            $result = mysqli_query($conn,$quary);
            if(mysqli_num_rows($result) == 0){
                $inserQuery = "INSERT INTO setting (web_name) VALUES ('$site_name');";
                $result = mysqli_query($conn,$inserQuery);
                if($result){
                    $_SESSION['status_success'] = " Website Name added successfully!";
                    header('location: ./setting.php');
                    die;
                }
                else{
                    $_SESSION['status_danger'] = " Does not save";
                    header('location: ./setting.php');
                    die;
                }
            }
            else{
                $inserQuery = "UPDATE setting SET web_name = '$site_name'";
                $result = mysqli_query($conn,$inserQuery);
                if($result){
                    $_SESSION['status_success'] = " Website Name Updated successfully!";
                    header('location: ./setting.php');
                    die;
                }
                else{
                    $_SESSION['status_danger'] = " Does not save";
                    header('location: ./setting.php');
                    die;
                }
            }
        }
    }
    // For Website Links  
    if(isset($_POST['siteLinkBtn'])){
        include('../dbConnection.php');
        if($_POST['fb-link'] == '' || $_POST['instagram-link'] == '' || $_POST['you-link'] == '' || $_POST['whats-link'] == ''){
            $_SESSION['status_danger'] = " Invalid Input!";
            header('location: ./setting.php');
            die;
        }
        else{
            // $site_name = $_POST['web_name'];
            $quary = "SELECT * FROM setting";
            $result = mysqli_query($conn,$quary);
            if(mysqli_num_rows($result) == 0){
                $_SESSION['status_danger'] = " You should set site logo or name first!";
                header('location: ./setting.php');
                die;
            }
            else{
                $fb = $conn->real_escape_string($_POST['fb-link']);
                $insta = $conn->real_escape_string($_POST['instagram-link']);
                $yt = $conn->real_escape_string($_POST['you-link']);
                $whats = $conn->real_escape_string($_POST['whats-link']);
                $updateQuery = "UPDATE setting SET fb_link = '$fb', insta_link = '$insta', you_link = '$yt',whatsapp = '$whats' ";
                $result = mysqli_query($conn,$updateQuery);
                if($result){
                    $_SESSION['status_success'] = " Website Links Update Successfully";
                    header('location: ./setting.php');
                    die;
                }
                else{
                    $_SESSION['status_danger'] = " Does not update";
                    header('location: ./setting.php');
                    die;
                }
            }
        }
    }
    // For Website Carousel Details 
    // 1st Carousel 
    if(isset($_POST['firstCarouselBtn'])){
        include('../dbConnection.php');
        $c1_img = $_FILES['carousel-1-img']['name'];
        $c1_heading = $conn->real_escape_string($_POST['carousel-1-heading']);
        $c1_text = $conn->real_escape_string($_POST['carousel-1-text']);
        if($c1_heading == '' || $c1_text == ''){
            $_SESSION['status_danger'] = " Invalid Input!";
            header('location: ./setting.php');
            die;
        }
        else{
            // if img is not select 
            if($c1_img == ''){
                $quary = "SELECT * FROM setting";
                $result = mysqli_query($conn,$quary);
                if(mysqli_num_rows($result) == 0){
                $_SESSION['status_danger'] = " You should set site logo or name first!";
                header('location: ./setting.php');
                die;
                }
                else{
                    $updateQuery = "UPDATE setting SET car_1_heading = '$c1_heading', car_1_text = '$c1_text'";
                    $result = mysqli_query($conn,$updateQuery);
                    if($result){
                        $_SESSION['status_success'] = " Carousel 1 Update Seccussfully!";
                        header('location: ./setting.php');
                        die;
                    }
                }
            }
            // if img is selected 
            else{
                $quary = "SELECT * FROM setting";
                $result = mysqli_query($conn,$quary);
                if(mysqli_num_rows($result) == 0){
                $_SESSION['status_danger'] = " You should set site logo or name first!";
                header('location: ./setting.php');
                die;
                }
                else{
                    $img_tmp_name = $_FILES['carousel-1-img']['tmp_name'];
                    $img_path = "/Images/setting/".$c1_img;
                    $updateQuery = "UPDATE setting SET car_1_img = '$img_path', car_1_heading = '$c1_heading',car_1_text = '$c1_text'";
                    $result = mysqli_query($conn,$updateQuery);
                    if($result){
                        move_uploaded_file($img_tmp_name,"./".$img_path);
                        $_SESSION['status_success'] = " Carousel 1 Update Seccussfully!";
                        header('location: ./setting.php');
                        die;
                    }
                    else{
                        $_SESSION['status_danger'] = " Not Updated!";
                        header('location: ./setting.php');
                        die;
                    }
                }

            }
            
        }
    }
    // 2nd Carousel 
    if(isset($_POST['secondCarouselBtn'])){
        include('../dbConnection.php');
        $c2_img = $_FILES['carousel-2-img']['name'];
        $c2_heading = $conn->real_escape_string($_POST['carousel-2-heading']);
        $c2_text = $conn->real_escape_string($_POST['carousel-2-text']);
        if($c2_heading == '' || $c2_text == ''){
            $_SESSION['status_danger'] = " Invalid Input!";
            header('location: ./setting.php');
            die;
        }
        else{
            // if img is not select 
            if($c2_img == ''){
                $quary = "SELECT * FROM setting";
                $result = mysqli_query($conn,$quary);
                if(mysqli_num_rows($result) == 0){
                $_SESSION['status_danger'] = " You should set site logo or name first!";
                header('location: ./setting.php');
                die;
                }
                else{
                    $updateQuery = "UPDATE setting SET car_2_heading = '$c2_heading', car_2_text = '$c2_text'";
                    $result = mysqli_query($conn,$updateQuery);
                    if($result){
                        $_SESSION['status_success'] = " Carousel 2 Update Seccussfully!";
                        header('location: ./setting.php');
                        die;
                    }
                }
            }
            // if img is selected 
            else{
                $quary = "SELECT * FROM setting";
                $result = mysqli_query($conn,$quary);
                if(mysqli_num_rows($result) == 0){
                $_SESSION['status_danger'] = " You should set site logo or name first!";
                header('location: ./setting.php');
                die;
                }
                else{
                    $img_tmp_name = $_FILES['carousel-2-img']['tmp_name'];
                    $img_path = "/Images/setting/".$c2_img;
                    $updateQuery = "UPDATE setting SET car_2_img = '$img_path', car_2_heading = '$c2_heading',car_2_text = '$c2_text'";
                    $result = mysqli_query($conn,$updateQuery);
                    if($result){
                        move_uploaded_file($img_tmp_name,"./".$img_path);
                        $_SESSION['status_success'] = " Carousel 2 Update Seccussfully!";
                        header('location: ./setting.php');
                        die;
                    }
                    else{
                        $_SESSION['status_danger'] = " Not Updated!";
                        header('location: ./setting.php');
                        die;
                    }
                }

            }
        }
    }
    // 3rd Carousel 
    if(isset($_POST['thirdCarouselBtn'])){
        include('../dbConnection.php');
        $c3_img = $_FILES['carousel-3-img']['name'];
        $c3_heading = $conn->real_escape_string($_POST['carousel-3-heading']);
        $c3_text = $conn->real_escape_string($_POST['carousel-3-text']);
        if($c3_heading == '' || $c3_text == ''){
            $_SESSION['status_danger'] = " Invalid Input!";
            header('location: ./setting.php');
            die;
        }
        else{
            // if img is not select 
            if($c3_img == ''){
                $quary = "SELECT * FROM setting";
                $result = mysqli_query($conn,$quary);
                if(mysqli_num_rows($result) == 0){
                $_SESSION['status_danger'] = " You should set site logo or name first!";
                header('location: ./setting.php');
                die;
                }
                else{
                    $updateQuery = "UPDATE setting SET car_3_heading = '$c3_heading', car_3_text = '$c3_text'";
                    $result = mysqli_query($conn,$updateQuery);
                    if($result){
                        $_SESSION['status_success'] = " Carousel 3 Update Seccussfully!";
                        header('location: ./setting.php');
                        die;
                    }
                }
            }
            // if img is selected 
            else{
                $quary = "SELECT * FROM setting";
                $result = mysqli_query($conn,$quary);
                if(mysqli_num_rows($result) == 0){
                $_SESSION['status_danger'] = " You should set site logo or name first!";
                header('location: ./setting.php');
                die;
                }
                else{
                    $img_tmp_name = $_FILES['carousel-3-img']['tmp_name'];
                    $img_path = "/Images/setting/".$c3_img;
                    $updateQuery = "UPDATE setting SET car_3_img = '$img_path', car_3_heading = '$c3_heading',car_3_text = '$c3_text'";
                    $result = mysqli_query($conn,$updateQuery);
                    if($result){
                        move_uploaded_file($img_tmp_name,"./".$img_path);
                        $_SESSION['status_success'] = " Carousel 3 Update Seccussfully!";
                        header('location: ./setting.php');
                        die;
                    }
                    else{
                        $_SESSION['status_danger'] = " Not Updated!";
                        header('location: ./setting.php');
                        die;
                    }
                }

            }
        }
    }

    if(isset($_POST['SmtpDetailsBtn'])){
        include('../dbConnection.php');
        $mail = $_POST['smtpMail'];
        $pass = $_POST['appPass'];
        if($mail == '' && $pass == ''){
            $_SESSION['status_danger'] = " Invalid Inputs!";
            header('location: ./setting.php');
            die;
        }
        else{
            $checkQuary = "SELECT * FROM setting";
            $run = mysqli_query($conn,$checkQuary);
            if(mysqli_num_rows($run) == 0){
                $_SESSION['status_danger'] = " Set site name first!";
                header('location: ./setting.php');
                die;
            }
            else{
                $quary = "UPDATE setting SET sEmail = '$mail',app_pass = '$pass'";
                $result = mysqli_query($conn,$quary);
                if($result){
                    $_SESSION['status_success'] = " Email Added Successfully!";
                    header('location: ./setting.php');
                    die;
                }
                else{
                    $_SESSION['status_danger'] = " Some Error !";
                    header('location: ./setting.php');
                    die;
                }
            }
        }
    }


    // Delete Logo 
    if(isset($_POST['webDelLogoBtn'])){
        include('../dbConnection.php');
        $query = "UPDATE setting SET web_logo = null";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['status_success'] = " Remove logo Successfully!";
            header('location: ./setting.php');
            die;
        }
    }
    // Reset All Setting  
    if(isset($_POST['resetSetting'])){
        include('../dbConnection.php');
        $query = "DELETE FROM  setting";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['status_success'] = " Reset All Setting Successfully";
            header('location: ./setting.php');
            die;
        }
    }
?>