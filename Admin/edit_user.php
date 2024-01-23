<?php
include('./MainInclude/header.php');
if (!isset($_GET['user_id'])) {
    header('location: ./all_users.php');
}
else{
    $user_id = $_GET['user_id'];
}

if (isset($_POST['edit_user_btn'])) {
    include('../dbConnection.php');
    $user_id = $_GET['user_id'];
    $name = $_POST['username'];
    $email = $_POST['userEmail'];
    $num = $_POST['userNumber'];
    $pass = $_POST['userPassword'];
    $cpass = $_POST['userCPassword'];

    if($name == '' || $email == '' || $num == ''|| $pass == '' || $cpass == ''){
        $_SESSION['status_danger'] = " Inavalid Fields";
    }
    else{
        $hasPass = password_hash($pass , PASSWORD_BCRYPT);
        $upQuery = "UPDATE users SET user_name = '$name',user_email = '$email', user_number = '$num',user_password = '$hasPass' WHERE user_id = '$user_id' ";
        $run = mysqli_query($conn, $upQuery);
        if($run){
            $_SESSION['status_success'] = " Update Successfully";
        }
        else{
            $_SESSION['status_danger'] = " Some Error";

        }
        
    }

}
?>
<div class="div-2 w-100">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-center align-items-center mt-2 mb-3">
            <form action="" method="post" class="w-50 rounded add_cate_form border shadow p-3 pt-1">
                <h5 class="shadow mb-4 d-flex align-items-center p-1" style="width:100%;background-color:#B3005E;">
                    <strong class="p-2 text-white text-center w-100">Edit Users</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="./all_users.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <?php
                if (isset($_GET['user_id'])) {
                    $user_id = $_GET['user_id'];
                    include('../dbConnection.php');
                    $query = "SELECT * FROM users WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                    ?>
                <div class="mt-1">
                    <label for="username" class="form-label"><strong>Username</strong></label>
                    <input type="text" class="form-control" name="username" id="username" required value="<?php echo $row['user_name'];?>">
                </div>
                <div class="mt-1">
                    <label for="userEmail" class="form-label"><strong>Email</strong></label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $row['user_email'];?>" required>
                </div>
                <div class="mt-1">
                    <label for="userNumber" class="form-label"><strong>Mobile No</strong></label>
                    <input type="text" class="form-control" id="userNumber" name="userNumber" value="<?php echo $row['user_number'];?>" required>
                </div>
                <div class="mt-1">
                    <label for="userPassword" class="form-label"><strong>Change Password</strong></label>
                    <input type="Password" class="form-control" id="userPassword" name="userPassword" >
                </div>
                <div class="mt-1">
                    <label for="userCPassword" class="form-label"><strong>Confirm Password</strong></label>
                    <input type="Password" class="form-control" id="userCPassword" name="userCPassword" >
                </div>
            <?php
                }
                }
                ?>
                <div class="mt-2">
                    <input type="submit" class="btn btn-sm btn-primary ps-3 pe-3" name="edit_user_btn" id="edit_user_btn" value="Edit">
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>