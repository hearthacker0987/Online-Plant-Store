<?php
include('./MainInclude/header.php');
?>
<!--------------------------------------- Inlude Database File --------------------------------------->
<?php
  if(isset($_REQUEST['add_stu_btn']))
  {
    if($_POST['username'] == "" || $_POST['userEmail'] == "" || $_POST['userNumber'] == "" || 
       $_POST['userPassword'] == "" || $_POST['userCPassword'] == "")
    {
      $_SESSION['status_danger'] = ' Please Fill All Fields';
    }
    else
    {
      if($_POST['userPassword'] == $_POST['userCPassword'])
      {
        include('../dbConnection.php');
        $username = ucwords($_POST['username']);
        $userEmail = $_POST['userEmail'];
        $userNumber = $_POST['userNumber'];
        $userPassword = $_POST['userPassword'];
        $query = "INSERT INTO users (user_name,user_email,user_number,user_password) VALUES ('$username','$userEmail','$userNumber','$userPassword');";
        $result = mysqli_query($conn,$query);
        if($result){
          $_SESSION['status_success'] = "User Added Successfully";
        }
      }
      else
      {
        $_SESSION['status_danger'] = ' Password Does Not Match';
      }
    }
  }
?>
<div class="div-2 w-100">
    <?php
    include('MainInclude/topHeader.php');
    ?>
    <div class="container-fluid d-flex align-items-center justify-content-center">
            <form action="" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-4 mt-5 m-1 rounded border-bottom border-top border-danger">
                <h5 class="shadow mb-4 d-flex align-items-center p-1" style="background-color:#B3005E;">
                    <strong class="p-1 text-white text-center w-100">Add New Users</strong>
                </h5>
                <div class="d-flex justify-content-end">
                    <a href="./all_users.php" class="btn btn-sm btn-primary">Back</a>
                </div>
                <div class="mt-1">
                    <label for="username" class="form-label"><strong>Username</strong></label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="mt-1">
                    <label for="userEmail" class="form-label"><strong>Email</strong></label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                </div>
                <div class="mt-1">
                    <label for="userNumber" class="form-label"><strong>Mobile No</strong></label>
                    <input type="text" class="form-control" id="userNumber" name="userNumber" required>
                </div>
                <div class="mt-1">
                    <label for="userPassword" class="form-label"><strong>Set Password</strong></label>
                    <input type="Password" class="form-control" id="userPassword" name="userPassword" required>
                </div>
                <div class="mt-1">
                    <label for="userCPassword" class="form-label"><strong>Confirm Password</strong></label>
                    <input type="Password" class="form-control" id="userCPassword" name="userCPassword" required>
                </div>
                <div class="mt-2">
                    <input type="submit" class="btn btn-sm btn-primary ps-3 pe-3" name="add_stu_btn" id="add_stu_btn" value="Add">
                </div>
            </form>
    </div>
</div>


<?php
include('./MainInclude/footer.php');
?>