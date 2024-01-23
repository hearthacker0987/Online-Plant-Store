<?php
include('./Components/header.php')
?>
<?php
  include('./dbConnection.php');
  $query = "SELECT * FROM users WHERE role_as = 'admin'";
  $result = mysqli_query($conn,$query);
  if(mysqli_num_rows($result) != 0){
    header('location: ./login-form.php');
    die;
  }
?>
<?php
    if(isset($_POST['setAdminBtn'])){
        $admin_email = $_POST['set_admin_email'];
        $admin_password = $_POST['set_admin_pass'];
        $admin_confirm_password = $_POST['c_admin_pass'];
        if($admin_email == '' || $admin_password == '' || $admin_confirm_password == ''){
            $_SESSION['status_danger'] = " Please fill all feilds";
        }
        elseif(strlen($admin_password) < 6){
            $_SESSION['status_danger'] = " Password must be at least 6 characters long!";
        }
        else{
            if($admin_password != $admin_confirm_password){
                $_SESSION['status_danger'] = " Password does not match!";
            }
            else{
                $hash_password = password_hash($admin_password,PASSWORD_BCRYPT);
                $query = "INSERT INTO users(user_name,user_email,user_password,role_as) VALUES ('Admin','$admin_email','$hash_password','admin');";
                $result = mysqli_query($conn,$query);
                if($result){
                    $fetchDetailQ = "SELECT * FROM users WHERE user_email = '$admin_email' AND role_as = 'admin'";
                    $result2 = mysqli_query($conn, $fetchDetailQ);
                    if(mysqli_num_rows($result2) > 0){
                        $admin = mysqli_fetch_assoc($result2);
                        $admin_id = $admin['user_id'];
                        $_SESSION['admin_login'] = true;
                        $_SESSION['admin_id'] = $admin_id;
                        $_SESSION['status_success'] = " Welcome!";
                        header('location: ./Admin/dashboard.php');
                        die;
                    }
                }
                else{
                    $_SESSION['status_success'] = " Some Db Error";
                }
            }
        }
    }
?>
  <div class="container-fluid">
    <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 mx-auto shadow rounded p-4 mt-5 border-bottom border-top border-danger">
        <h3 class="text-center"><u><i><strong>Set Admin Password</strong></i></u></h3>
        <div class="mt-2">
            <label for="set_admin_email" class="form-label">Email</label>
            <input type="email" id="set_admin_email" name="set_admin_email" class="form-control" placeholder="Enter Email" required>
        </div>
        <div class="mt-2">
            <label for="set_admin_pass" class="form-label">Set Password</label>
            <input type="password" id="set_admin_pass" name="set_admin_pass" class="form-control" placeholder="Enter Password " required>
        </div>
        <div class="mt-2">
            <label for="c_admin_pass" class="form-label">Confirm Password</label>
            <input type="password" id="c_admin_pass" name="c_admin_pass" class="form-control" placeholder="Confirm Password" required>
        </div>
        <div class="mt-2">
            <input type="submit" name="setAdminBtn" id="setAdminBtn" value="Set Details" class="btn btn-sm btn-primary">
        </div>
    </form>
  </div>
  
<?php
include('./Components/footer.php')
?>   