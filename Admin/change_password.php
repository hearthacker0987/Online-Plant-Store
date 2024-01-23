<?php
include('./MainInclude/header.php');
?>

<?php
if(isset($_POST['ChangeAdminPassBtn'])){
    include('../dbConnection.php');
    $old_pass = $_POST['admin_old_username'];
    $new_pass = $_POST['admin_new_pass'];
    $c_new_pass = $_POST['c_admin_new_pass'];
    if($old_pass == '' || $new_pass == '' || $c_new_pass == ''){
        $_SESSION['status_danger'] = " Please fill all feilds";
    }
    elseif($new_pass != $c_new_pass){
        $_SESSION['status_danger'] = " Confirm password does not match";
    }
    elseif(strlen($new_pass) < 6){
        $_SESSION['status_danger'] = " Password must be at least 6 character long!";
    }
    else{
        $query = "SELECT * FROM users WHERE role_as = 'admin'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $db_old_pass = $row['user_password'];
            if(password_verify($old_pass,$db_old_pass)){
                $hash_new_pass = password_hash($new_pass,PASSWORD_BCRYPT);
                $admin_id = $_SESSION['admin_id'];
                $query = "UPDATE users SET user_password = '$hash_new_pass' WHERE user_id = '$admin_id'";
                $result = mysqli_query($conn,$query);
                if($result){
                    $_SESSION['status_success'] = " Password changed successfully!";
                }
                else{
                    $_SESSION['status_danger'] = " Db Error";

                }
            }
            else
            {
                $_SESSION['status_danger'] = " Old password incorrect";
            }
        }
    }
}

?>
<div class="div-2 w-100 " style="overflow-y:auto;">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="margin-top: 40px;">
        <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-4 mt-5 m-3 rounded border-bottom border-top border-danger">
            <h4 class="text-center"><u><strong>Change Password</strong></u></h4>
            <div class="d-flex justify-content-end">
                <a href="./dashboard.php" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="mt-2">
                <label for="admin_old_username" class="form-label">Old Password</label>
                <input type="password" id="admin_old_username" name="admin_old_username" class="form-control" placeholder="Enter Old Password" required>
            </div>
            <div class="mt-2">
                <label for="admin_new_pass" class="form-label">New Password</label>
                <input type="password" id="admin_new_pass" name="admin_new_pass" class="form-control" placeholder="Enter New Password " required>
            </div>
            <div class="mt-2">
                <label for="c_admin_new_pass" class="form-label">Confirm New Password</label>
                <input type="password" id="c_admin_new_pass" name="c_admin_new_pass" class="form-control" placeholder="Enter Confirm Password " required>
            </div>
            <div class="mt-2">
                <input type="submit" name="ChangeAdminPassBtn" id="ChangeAdminPassBtn" value="Change" class="btn btn-sm btn-primary">
            </div>
        </form>
    </div>
</div>

<?php
include('./MainInclude/footer.php');
?>