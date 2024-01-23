<?php
include('./Components/header.php');
?>
<?php
// Logic for users 
if(isset($_GET['user_email']) && isset($_GET['user_id'])){
    $user_email = $_GET['user_email'];
    $user_id = $_GET['user_id'];
    $query = "SELECT * FROM users WHERE user_id = '$user_id' AND user_email = '$user_email'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) == 0){
        $_SESSION['status_danger'] = " You are not allowed!";
        header('location: ./Login.php');
        die;
    }
}
else{
    $_SESSION['status_danger'] = " You are not allowed!";
    header('location: ./Login.php');
    die;
}
?>
<?php
if(isset($_POST['set_new_pass'])){
    include('./dbConnection.php');
    $set_pass  = $conn->real_escape_string($_POST['enter_new_pass']);
    $set_c_pass  = $conn->real_escape_string($_POST['enter_c_pass']);
    if($set_pass == '' || $set_c_pass == ''){
        $_SESSION['status_danger'] = " Please fill all fields!";
    }
    elseif($set_pass != $set_c_pass){
        $_SESSION['status_danger'] = " Confirm password does not match!";
    }
    elseif(strlen($set_pass) < 6){
        $_SESSION['status_danger'] = " Password must be at least 6 characters long!";
    }
    else{
        $hashedPass = password_hash($set_pass,PASSWORD_BCRYPT);
        $query = "UPDATE users SET user_password = '$hashedPass' WHERE user_id = '$user_id'";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['status_success'] = " New password set successfully";
        }
        else{
            $_SESSION['status_danger'] = " Incorrect Password";
        }
    }

}
?>
<div class="container-fluid mt-1 d-flex justify-content-center login">
    <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-5 pt-3 mt-5 m-3 rounded border-bottom border-top border-success">
        <h3 class="text-center"><u><i><strong>Set Password</strong></i></u></h3>
        <div class="mb-2 mt-1">
            <label for="enter_new_pass" class="form-label">Set New Password</label>
            <input type="password" name="enter_new_pass" id="enter_new_pass" class="form-control" placeholder="Enter New Password">
        </div>
        <div class="mb-3">
            <label for="enter_c_pass" class="form-label">Confirm Password</label>
            <input type="password" name="enter_c_pass" id="enter_c_pass" class="form-control" placeholder="Confirm Password">
        </div>
        <div class="mb-3 text-center">
            <input type="submit" name="set_new_pass" value="Set Password" class="btn btn-primary">
        </div>        
    </form>
</div>

<?php
include('./Components/footer.php');
?>