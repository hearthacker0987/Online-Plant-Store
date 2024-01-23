<?php
include('./Components/header.php');
include('./dbConnection.php');
// Checking admin Exists or not 
$query = "SELECT * FROM users WHERE role_as = 'admin'";
$run = mysqli_query($conn,$query);
if(mysqli_num_rows($run) == 0){
    $_SESSION['status_success'] = " Set Strong Password!";
    header('location: ./set-password.php');
    die;
}
?>
<?php
if(isset($_POST['loginBtn'])){
    $email  = $conn->real_escape_string($_POST['userEmail']);
    $pass  = $conn->real_escape_string($_POST['userPass']);
    if($email == '' || $pass == ''){
        $_SESSION['status_danger'] = " Please fill all fields!";
    }
    else{
        // Checking User Exists Or Not 
        $Checkquery = "SELECT * FROM users WHERE user_email = '$email'";
        $result = mysqli_query($conn,$Checkquery);
        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                $db_pass = $row['user_password'];
                if(password_verify($pass,$db_pass)){
                    if($row['role_as'] == 'admin'){
                        $_SESSION['admin_login'] = true;
                        $_SESSION['admin_id'] = $row['user_id'];
                        $_SESSION['admin_name'] = $row['user_name'];
                        $_SESSION['admin_email'] = $row['user_email'];
                        $_SESSION['status_success'] = " Welcome!";
                        header('location: ./Admin/dashboard.php');
                        die;
                    }
                    else{
                        $_SESSION['user_login'] = true;
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_name'] = $row['user_name'];
                        $_SESSION['user_email'] = $row['user_email'];
                        $_SESSION['status_success'] = " Welcome!";
                        header('location: ./index.php');
                        die;
                    }
                }
            }
            if(!password_verify($pass,$db_pass)){
                $_SESSION['status_danger'] = " Incorrect Password";
            }
        }
        else
        {
            $_SESSION['status_danger'] = " User does not exist! ";

        }
    }

}
?>
<div class="container-fluid mt-1 d-flex justify-content-center login">
    <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-5 pt-3 mt-5 m-3 rounded border-bottom border-top border-success">
        <h3 class="text-center"><u><i><strong>Login</strong></i></u></h3>
        <div class="mb-2 mt-1">
            <label for="userEmail" class="form-label">Email</label>
            <input type="text" name="userEmail" id="userEmail" class="form-control" placeholder="Enter Your Email">
        </div>
        <div class="mb-3">
            <label for="userPass" class="form-label">Password</label>
            <input type="password" name="userPass" id="userPass" class="form-control" placeholder="Enter Your Password">
        </div>
        <div class="mb-3">
            <input type="submit" name="loginBtn" value="Login" class="btn btn-primary">
        </div>
        <div class="mb-2">
            <a href="forget_password.php" class="nav-link fw-bold">Forget Password?</a>
        </div>
        <div>
            Don't have an account?
            <span>
                <a href="./Registration.php" class="fw-bold" style="color:black">Sign Up</a>
            </span>
        </div>
    </form>
</div>

<?php
include('./Components/footer.php')
?>