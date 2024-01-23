<?php
include('./Components/header.php')
?>

<?php
  $query = "SELECT * FROM admin";
  $result = mysqli_query($conn,$query);
  if(mysqli_num_rows($result) == 0){
    header('location: ./set_admin_details.php');
    die;
  }
?>

<?php
if (isset($_POST['AdminLoginBtn'])) {
  include('./dbConnection.php');
  $admin_email = $_POST['admin_email'];
  $admin_password = $_POST['admin_pass'];
  if ($admin_email == '' || $admin_password == '') {
    $_SESSION['status_danger'] = " Please fill all feilds";
  } else {
    $query = "SELECT * FROM admin WHERE admin_email = '$admin_email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $db_password = $row['admin_password'];
      if (password_verify($admin_password, $db_password)) {
        session_start();
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['admin_name'] = $row['admin_username'];
        header('location: ./Admin/dashboard.php');
      } else {
        $_SESSION['status_danger'] = " Incorrect Password";
      }
    } else {
      $_SESSION['status_danger'] = " Email does not exists";
    }
  }
}
?>

<div class="container-fluid d-flex justify-content-center align-items-center" style="margin-top: 40px;">
  <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-4 mt-5 m-3 rounded border-bottom border-top border-danger">
    <h3 class="text-center"><u><strong>Admin Login</strong></u></h3>
    <div class="mt-2">
      <label for="admin_email" class="form-label">Email</label>
      <input type="email" id="admin_email" name="admin_email" class="form-control" placeholder="Enter Email" required>
    </div>
    <div class="mt-2">
      <label for="admin_pass" class="form-label">Password</label>
      <input type="password" id="admin_pass" name="admin_pass" class="form-control" placeholder="Enter Password " required>
    </div>
    <div class="mt-3">
      <input type="submit" name="AdminLoginBtn" id="AdminLoginBtn" value="Login" class="btn btn-primary">
    </div>
    <div class="mt-3">
      <a href="forget_password.php?identity=admin" class="nav-link fw-bold">Forget Password?</a>
    </div>
  </form>
</div>



<?php
include('./Components/footer.php')
?>