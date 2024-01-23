<?php
include('./Components/header.php')
?>
<?php
if(isset($_POST['profileBtn'])){
    include('./dbConnection.php');
    $user_name  = $conn->real_escape_string($_POST['user_name']);
    $user_email  = $conn->real_escape_string($_POST['user_email']);
    $user_number  = $conn->real_escape_string($_POST['user_number']);
    if($user_name == '' || $user_email == '' || $user_number == ''){
        $_SESSION['status_danger'] = " Please fill all fields!";
    }
    else{
        $query = "UPDATE users SET user_name = '$user_name', user_email = '$user_email',user_number = '$user_number' WHERE user_id =  {$_SESSION['user_id']}";
        $result = mysqli_query($conn,$query);
        if($result ){
            $_SESSION['status_success'] = " Update profile successfully! ";
        }
        else
        {
            $_SESSION['status_danger'] = " You are not our member ";

        }
    }

}
?>
<div class="container-fluid mt-1 d-flex justify-content-center login">
    <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-5 pt-3 mt-5 m-3 rounded border-bottom border-top border-success">
        <h3 class="text-center"><u><i><strong>Profile</strong></i></u></h3>
        <?php
            if(isset($_SESSION['user_id'])){
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM users WHERE user_id = '$user_id'";
                $result = mysqli_query($conn,$query);
                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result); 
                }
            }
        ?>
        <div class="mb-2 mt-1">
            <label for="user_name" class="form-label">Full Name</label>
            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Your Name" value="<?php if(isset($row['user_name'])){ echo $row['user_name'];}?>">
        </div>
        <div class="mb-3">
            <label for="user_email" class="form-label">Email Address</label>
            <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Enter Your Email" value="<?php if(isset($row['user_email'])){ echo $row['user_email'];}?>">
        </div>
        <div class="mb-3">
            <label for="user_number" class="form-label">Phone Number</label>
            <input type="text" name="user_number" id="user_number" class="form-control" placeholder="Enter Phone Number" value="<?php if(isset($row['user_number'])){ echo $row['user_number'];}?>">
        </div>
        <div class="mb-3">
            <input type="submit" name="profileBtn" value="Change" class="btn btn-primary">
        </div>
    </form>
</div>

<?php
include('./Components/footer.php')
?>