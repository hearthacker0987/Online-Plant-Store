<?php
if (session_id() == '') {
  session_start();
}
ob_start();
if (!isset($_SESSION['admin_login']) && !isset($_SESSION['admin_id'])) {
  header('location: ../Login.php');
}

$directiryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directiryURI,PHP_URL_PATH);
$components = explode('/',$path);
$page = $components[3];
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php
    include('../dbConnection.php');
    $titleQuery = "SELECT web_name FROM setting";
    $titleRunQ = mysqli_query($conn, $titleQuery);
    if (mysqli_num_rows($titleRunQ) > 0) {
        $web_detail = mysqli_fetch_assoc($titleRunQ);
      if (isset($web_detail['web_name']) && $web_detail['web_name'] != null) {
        echo $web_detail['web_name'];
      }
      else {
        echo "Website Name";
      }
    } else {
      echo "Website";
    }
    ?>
  </title>
  <!--------------------------- Font Awesome ------------------------------------->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!--------------------------- Bootstrap Icons Cdn ------------------------------------->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
  <!---------------------------------------- Bootstrap Link -------------------------------->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="Main d-flex">
    <div class="div-1 Sidebar-menu bg-dark shadow" style="width: 250px;height:100vh;">
      <h6 class=" text-white p-2 pt-4 pb-3 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid white;">
        <div class=" d-flex justify-content-center w-100">
          <strong class="sidebarHeading" style="font-size: 17px;">
            <?php
            include('../dbConnection.php');
            $admin_id = $_SESSION['admin_id'];
            $query = "SELECT user_name FROM users WHERE user_id = '$admin_id'";
            $runQ = mysqli_query($conn, $query);
            if (mysqli_num_rows($runQ) > 0) {
              $admin_detail = mysqli_fetch_assoc($runQ);
              echo $admin_detail['user_name'];
            }
            else {
              echo "Admin";
            }
            ?>
          </strong>
        </div>
        <i class="bi bi-x-square close-menu-btn fs-5" style="filter:brightness(0) invert(1);cursor:pointer;"></i>
      </h6>
      <nav class="sidebar">
        <ul class="p-1 me-1" id="myDiv">
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'dashboard.php'){ echo "active";}?>" style="width: auto;">
            <a href="./dashboard.php" class="dropdown-icon nav-link text-white w-100 p-2">
              <i class="fa-sharp fa-solid fa-gauge dropdown-icon"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'categories.php'){ echo "active";}?>" style="width: auto;">
            <a href="./categories.php" class="dropdown-icon nav-link text-white w-100  p-2">
              <i class="bi bi-bookmarks-fill dropdown-icon"></i>
              <span>Category</span>
            </a>
          </li>
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'sub_category.php'){ echo "active";}?>" style="width: auto;">
            <a href="./sub_category.php" class="dropdown-icon nav-link text-white w-100  p-2">
              <i class="bi bi-bookmarks dropdown-icon"></i>
              <span>Sub Category</span>
            </a>
          </li>
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'products.php'){ echo "active";}?>" style="width: auto;">
            <a href="./products.php" class="dropdown-icon nav-link text-white w-100  p-2">
              <i class="bi bi-boxes dropdown-icon"></i>
              <span>Products</span>
            </a>
          </li>
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'cart_items.php'){ echo "active";}?>" style="width: auto;">
            <a href="./cart_items.php" class="dropdown-icon nav-link text-white w-100  p-2">
              <i class="bi bi-cart4 dropdown-icon"></i>
              <span>Cart items</span>
            </a>
          </li>
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'all_users.php'){ echo "active";}?>" style="width: auto;">
            <a href="./all_users.php" class="dropdown-icon nav-link text-white w-100  p-2">
              <i class="bi bi-people-fill dropdown-icon"></i>
              <span>Users</span>
            </a>
          </li>
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'orders.php'){ echo "active";}?>" style="width: auto;">
            <a href="./orders.php" class="dropdown-icon nav-link text-white w-100  p-2">
              <i class="bi bi-bag-check-fill dropdown-icon"></i>
              <span>Orders</span>
            </a>
          </li>
          <li class="dropable transition text-white mt-2 nav-li <?php if($page == 'feedback.php'){ echo "active";}?>" style="width: auto;">
            <a href="./feedback.php" class="dropdown-icon nav-link text-white w-100  p-2">
              <i class="bi bi-chat-dots-fill dropdown-icon"></i>
              <span>Feedback</span>
            </a>
          </li>
        </ul>
      </nav>
    </div> <!-- - Sidebar Menu div close !- -->