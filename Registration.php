<?php
include('./Components/header.php')
?>

<?php
if(isset($_POST['registerBtn'])){
    include('./dbConnection.php');
    $user_name = $conn->real_escape_string(ucwords($_POST['add_first_name']." ".$_POST['add_last_name']));
    $user_email = $conn->real_escape_string($_POST['add_email']);
    $user_num = $conn->real_escape_string($_POST['add_num']);
    $user_pass = $conn->real_escape_string($_POST['add_pass']);
    $user_c_pass = $conn->real_escape_string($_POST['add_c_pass']);
    if($user_name == '' || $user_email == '' || $user_num == '' || $user_pass == '' || $user_c_pass == ''){
        $_SESSION['status_danger'] = " Please fill all fields!";
    }
    elseif(strlen($user_pass) <= 6){
        $_SESSION['status_danger'] = " Password must be 6 character long";
    }
    elseif($user_pass != $user_c_pass){
        $_SESSION['status_danger'] = " Confirm password does not match";
    }
    else{
        // Checking User Already Exists Or Not 
        $Checkquery = "SELECT user_email FROM users WHERE user_email = '$user_email' AND role_as = 'user'";
        $result = mysqli_query($conn,$Checkquery);
        if(mysqli_num_rows($result) > 0){
            $_SESSION['status_danger'] = " Email Already Exists";
        }
        else
        {
            $hashedPassword = password_hash($user_pass,PASSWORD_BCRYPT);
            $query = "INSERT INTO users (user_name,user_email,user_number,user_password,role_as) VALUES ('$user_name','$user_email','$user_num','$hashedPassword','user');";
            $result = mysqli_query($conn,$query);
            if($result){
                $_SESSION['status_success'] = " Registration completed now you can login!";
                header('location: ./Login.php');
                die;
            }
        }
    }
    
}

?>

<div class="container-fluid mt-1 d-flex justify-content-center registration">
    <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-4 pt-3 m-3 rounded border-top border-bottom border-success">
        <h3 class="text-center"><u><i><strong>Registration</strong></i></u></h3>
        <div class="mb-2 mt-3 row">
            <div class="col-md-6">
                <label for="add_first_name" class="form-label">First Name</label>
                <input type="text" name="add_first_name" id="add_first_name" class="form-control" placeholder="Enter First Name">
            </div>
            <div class="col-md-6">
                <label for="add_last_name" class="form-label">Last Name</label>
                <input type="text" name="add_last_name" id="add_last_name" class="form-control" placeholder="Enter Last Name">
            </div>
        </div>
        <div class="mb-2">
            <label for="add_email" class="form-label">Email</label>
            <input type="email" name="add_email" id="add_email" class="form-control" placeholder="Enter Email">
        </div>
        <div class="mb-2">
            <label for="add_num" class="form-label">Phone Number</label>
            <input type="text" name="add_num" id="add_num" class="form-control" placeholder="Enter Phone Number">
        </div>
        <div class="mb-2">
            <label for="add_pass" class="form-label">Password</label>
            <input type="password" name="add_pass" id="add_pass" class="form-control" placeholder="Enter Password">
        </div>
        <div class="mb-3">
            <label for="add_c_pass" class="form-label">Confirm Password</label>
            <input type="password" name="add_c_pass" id="add_c_pass" class="form-control" placeholder="Confirm Password">
        </div>
        <div class="mb-3">
            <input type="submit" value="Register" class="btn btn-primary" name="registerBtn">
        </div>
        <div class="mb-2">
            Do you have an account? <a href="./Login.php" class="fw-bold">Login</a>
        </div>
    </form>
</div>


<?php
include('./Components/footer.php')
?>