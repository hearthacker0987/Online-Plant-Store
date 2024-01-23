<?php
include('./Components/header.php');
include('./dbConnection.php');
$query = "SELECT * FROM setting";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    $_SESSION['status_danger'] = " Please Contact Administrator!";
    header('location: ./Login.php');
    die;
}
else{
    $row = mysqli_fetch_assoc($result);
    if($row['sEmail'] == null){
    $_SESSION['status_danger'] = " Please Contact Administrator!";
    header('location: ./Login.php');
    die;
    }
}
?>
<div class="container-fluid mt-1 d-flex justify-content-center login">
    <form action="./PHPMailer/sendEmail.php" method="post" class="col-sm-12 col-md-8 col-lg-6 shadow p-5 pt-3 mt-5 m-3 rounded border-bottom border-top border-success">
        <h3 class="text-center"><u><i><strong>Forget Password</strong></i></u></h3>
        <div class="mb-2 mt-1">
            <label for="send_link_email" class="form-label">Email</label>
            <input type="text" name="send_link_email" id="send_link_email" class="form-control" placeholder="Enter Your Email">
        </div>
        <div class="d-flex justify-content-end">
            Don't have an account? <span class="fw-bold ms-2"><a href="./Registration.php" class="" > Sign Up</a></span>
        </div>
        <div class="mb-3 text-center">
            <input type="submit" name="send_link" value="Send Link" class="btn btn-primary">
        </div>
    </form>
</div>

<?php
include('./Components/footer.php');
?>