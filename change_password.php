<?php
include('./Components/header.php');
?>
<?php
    if(isset($_POST['changePassBtn'])){
        $user_id = $_SESSION['user_id'];
        $user_old_pass = $_POST['old_pass'];
        $user_new_pass = $_POST['new_pass'];
        $c_pass = $_POST['c_pass'];
        if($user_old_pass == '' || $user_new_pass == '' || $c_pass == ''){
            $_SESSION['status_danger'] = " Please fill all field";
        }
        elseif($user_new_pass != $c_pass){
            $_SESSION['status_danger'] = " Confirm password does not match";
        }
        else{
            $query = "SELECT user_password FROM users WHERE user_id = '$user_id'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                $db_password = $row['user_password'];
                if(password_verify($user_old_pass,$db_password)){
                    $hashedPass = password_hash($user_new_pass,PASSWORD_BCRYPT);
                    $updateQuery = "UPDATE users SET user_password = '$hashedPass' WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn,$updateQuery);
                    if($result){
                        $_SESSION['status_success'] = " Password Change Successfully!";
                    }
                    else{
                        $_SESSION['status_danger'] = " Password does not change";
                    }
                }
                else{
                    $_SESSION['status_danger'] = " Incorrect Old Password!";
                }
            }
        }
    }
?>

<div class="container-fluid mt-1 d-flex justify-content-center change_password">
    <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-5 pt-3 mt-5 m-3 rounded border-bottom border-top border-success">
        <h3 class="text-center"><u><i><strong>Change Password</strong></i></u></h3>
        <div class="mb-3">
            <label for="old_pass" class="form-label">Old Password</label>
            <input type="password" name="old_pass" id="old_pass" class="form-control" placeholder="Enter Old Password" required>
        </div>
        <div class="mb-3">
            <label for="new_pass" class="form-label">New Password</label>
            <input type="password" name="new_pass" id="new_pass" class="form-control" placeholder="Enter New Password" required>
        </div>
        <div class="mb-3">
            <label for="c_pass" class="form-label">Confirm Password</label>
            <input type="password" name="c_pass" id="c_pass" class="form-control" placeholder="Confirm Password" required>
        </div>
        <div class="mb-3">
            <input type="submit" name="changePassBtn" value="Change" class="btn btn-primary">
        </div>
    </form>
</div>
<?php
include('./Components/footer.php');
?>