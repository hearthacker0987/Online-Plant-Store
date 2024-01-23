<?php
include('./MainInclude/header.php');
?>

<?php
if(isset($_POST['UpdateAdminProBtn'])){
    include('../dbConnection.php');
    $admin_up_name = $_POST['a_name'];
    $admin_up_email = $_POST['a_email'];
    if($admin_up_name == '' || $admin_up_email == ''){
        $_SESSION['status_danger'] = " Please fill all feilds!";
    }
    else{
        $admin_id = $_SESSION['admin_id'];
        $query = "UPDATE users SET user_name = '$admin_up_name', user_email = '$admin_up_email' WHERE user_id = '$admin_id'";
        $result = mysqli_query($conn,$query);
        if($result){
            $_SESSION['status_success'] = " Update details successfully!";
            header('location: ./admin_profile.php');
            die;
        }
        else{
            $_SESSION['status_danger'] = " Db Error";
        }
    }    
}

?>
<div class="div-2 w-100 " style="overflow-y:auto;">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid d-flex justify-content-center align-items-center" style="margin-top: 40px;">
        <?php
            include('../dbConnection.php');
            $admin_id = $_SESSION['admin_id'];
            $query = "SELECT * FROM users WHERE user_id = '$admin_id'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
            }
        ?>
        <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-4 mt-5 m-3 rounded border-bottom border-top border-danger">
            <h4 class="text-center"><u><strong>My Profile</strong></u></h4>
            <div class="d-flex justify-content-end">
                <a href="./dashboard.php" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="mt-2">
                <label for="a_name" class="form-label">Name</label>
                <input type="text" id="a_name" name="a_name" class="form-control" value="<?php if(isset($row['user_name'])){echo $row['user_name'];} ?>">
            </div>
            <div class="mt-2">
                <label for="a_email" class="form-label">Email</label>
                <input type="email" id="a_email" name="a_email" class="form-control" value="<?php if(isset($row['user_email'])){echo $row['user_email'];} ?>" required>
            </div>
            <div class="mt-2">
                <input type="submit" name="UpdateAdminProBtn" id="UpdateAdminProBtn" value="Update" class="btn btn-sm btn-primary">
            </div>
        </form>
    </div>
</div>

<?php
include('./MainInclude/footer.php');
?>