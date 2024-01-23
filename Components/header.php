<?php
ob_start();
// Checking session already start or not 
if(session_id() == ''){
    session_start();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Plant Store</title>
    <!--------------------------- Font Awesome ------------------------------------->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!--------------------------- Bootstrap Icons Cdn ------------------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <!---------------------------------------- Bootstrap Link -------------------------------->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./Assets/css/style.css">
</head>

<body>
    <header>
        <div class="topHeader d-flex justify-content-between align-items-center bg-light fixed-top" style="background-color: white;height:110px;">
            <!-- Toggle Button For Mobile View -->
            <div class="nav-toggle-mobile-view d-none border rounded">
                <button class="navbar-toggler p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list-task fs-2"></i>
                </button>
            </div>
            <!-- Logo div  -->
            <?php 
                include('./dbConnection.php');
                $query = "SELECT * FROM setting";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    if(isset($row['web_name']) && $row['web_name'] != null && $row['web_logo'] == null){
                        echo "<div class='ms-2'><strong style ='font-size:1.5rem;'>".$row['web_name']." </strong></div>";
                    }
                    elseif(isset($row['web_logo']) && $row['web_logo'] != null && isset($row['web_name']) && $row['web_name'] != null){
            ?>
                        <div class="d-flex align-items-center">
                            <div class="logo" style="width: 60px;">
                                <img src="./Admin/<?php if(isset($row['web_logo'])){ echo $row['web_logo'];} ?>" alt="not found" class="w-100">
                            </div>
                            <div class="ms-2" style="font-size: 1.2rem;"><strong><?php if(isset($row['web_name'])){ echo $row['web_name'];} ?></strong></div>
                        </div>
            <?php
                    }
                    elseif($row['web_logo'] == null && $row['web_name'] == null){
                        echo '<div class="ms-2" style="font-size: 1.2rem;"><strong>Website Name</strong></div>';
                    }
                }
                else{
                    echo '<div class="ms-2" style="font-size: 1.2rem;"><strong>Website Name</strong></div>';
                }
            ?>
            <!-- Search Bar  -->
            <div class="search-bar w-50">
                <form action="search_query.php" method="get" class="d-flex">
                    <input type="text" class="form-control" name="q" placeholder="Search plants by name or category" 
                    value="<?php if(isset($_GET['q'])){ echo $_GET['q'];} ?>" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">
                    <button type="submit" class="btn btn-success" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <!-- Top Right div  -->
            <div class="top-right mt-2">
                <ul class="d-flex ">
                    <!-- Add To Cart offCanva  -->
                    <?php
                    if (isset($_SESSION['user_login'])) {
                    ?>
                        <li class="me-3 mt-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <span class="text-dark">
                                <i class="bi bi-cart-check fs-3 position-relative">
                                    <span class=" position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 12px;">
                                        <?php 
                                            include('./dbConnection.php');
                                            $query = "SELECT * FROM add_to_cart WHERE user_id = '{$_SESSION['user_id']}'";
                                            $result = mysqli_query($conn,$query);
                                            if(mysqli_num_rows($result) > 0){
                                                echo mysqli_num_rows($result);
                                            }
                                            else{
                                                echo 0;
                                            }
                                        ?>
                                    </span>
                                </i>
                            </span>
                        </li>
                        <div class="btn-group dropstart ms-2" style="outline: none;">
                            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" >
                                <i class="bi bi-person-fill fs-3" ></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="./track_orders.php">Track Orders</a></li>
                                <li><a class="dropdown-item" href="./change_password.php">Change Password</a></li>
                                <li><a class="dropdown-item" href="./logout.php">Log Out</a></li>
                            </ul>
                        </div>
                    <?php
                        // Start OffCanvas
                        include('./Components/AddToCartOffCanvas.php');
                        // End Offconvas 
                    }
                    ?>

                    <?php
                    if (!isset($_SESSION['user_login'])) {
                    ?>
                        <!-- ******** Login Button *********** -->
                        <li class="nav-item"><a href="./Login.php" class="btn-login btn btn-light">Login</a></li>
                        <li class="nav-item"><a href="./Registration.php" class="btn btn-warning">Sign Up</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-------------------- Second Top Header ------------------------>
        <nav class=" navbar navbar-expand-lg header-2" style="margin-top:104px;background:linear-gradient(#04BF00,#015D00)">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav d-flex justify-content-center w-100 p-2">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./index.php">Home</a>
                        </li>
                        <?php
                        include('./dbConnection.php');
                        $query = "SELECT * FROM category LEFT JOIN sub_category ON category.cate_id = sub_category.cate_id";
                        $result = mysqli_query($conn, $query);
                        $categories = array();
                        if (mysqli_num_rows($result) > 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                $categoryName = $rows['cate_name'];
                                $subCategoryName = $rows['sub_cate_name'];
                                $categories[$categoryName][] = $subCategoryName;
                            }
                            foreach ($categories as $category => $subCategory) {
                                echo '<li class="nav-item dropdown">';
                                echo '<span class="nav-link dropdown-toggle text-white">' . $category . '</span>';
                                for ($i = 0; $i < count($subCategory); $i++) {
                                    if ($subCategory[$i]) {
                                        echo '<ul class="dropdown-menu">';
                                        foreach ($subCategory as $subcate) {
                                            echo '<li><a class="dropdown-item" href="./Products.php?subCate='. $subcate .'">' . $subcate . '</a></li>';
                                        }
                                        echo '</ul>';
                                        echo '</li>';
                                    }
                                    else 
                                    {
                                        echo '<ul class="dropdown-menu">';
                                        echo '<li><a class="dropdown-item text-danger" href="#">Unavailabe</a></li>';
                                        echo '</ul>';
                                        echo '</li>';
                                    }
                                }
                            }
                        ?>
                            <!-- Search Bar In Mobile View  -->
                            <li class="nav-item d-none search-bar-mobile-view ">
                                <div class=" w-100">
                                    <form action="search_query.php" method="get" class="d-flex justify-content-center">
                                        <input type="text" class="form-control" name="q" placeholder="Search Plants by Name or Category"
                                        value="<?php if(isset($_GET['q'])){ echo $_GET['q'];} ?>" style="border-top-right-radius: 0px;border-bottom-right-radius: 0px;">
                                        <button type="submit" class="btn btn-success" style="border-top-left-radius: 0px;border-bottom-left-radius: 0px;"><i class="bi bi-search"></i></button>
                                    </form>
                                </div> 
                            </li>
                        <?php
                            echo '</ul>';
                        }
                        ?>
                </div>
            </div>
        </nav>
    </header>