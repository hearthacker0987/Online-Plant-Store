<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';




// *************** Function For User ********************
function sendForgetLinkInEmailForUser($user_id, $user_name, $Forgetemail)
{
    //Create an instance;
    $mail = new PHPMailer(true);
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    //$mail->Username   = 'expandnetwork0@gmail.com';                     //SMTP username
    //$mail->Password   = 'ipxcoaakifvlemai';
    include('../dbConnection.php');
    $EmailQuery = "SELECT * FROM setting";
    $run = mysqli_query($conn, $EmailQuery);
    if ($run) {
        $details = mysqli_fetch_assoc($run);
        $email = $details['sEmail'];
        $pass = $details['app_pass'];
    }
    $mail->Username = $email;                               //SMTP password
    $mail->Password = $pass;
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    include('../dbConnection.php');
    $query = "SELECT web_name FROM setting";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row2 = mysqli_fetch_assoc($result);
        $web_name = $row2['web_name'];
    } else {
        $web_name = "Website";
    }
    $mail->setFrom($email, $web_name);
    $mail->addAddress($Forgetemail, $user_name);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Forget Password Link From ' . $web_name;
    $email_template = '
            <h3><strong> Dear ' . $user_name . '</strong></h3>
            <h4>Your Reset Password Link Is Given Below</h4>
            <strong style="font-size:1.1rem">
                <a href="localhost/ops/forget_password_link.php?user_email=' . $Forgetemail . '&user_id=' . $user_id . '">Reset Password Link</a>
            </strong>
        ';
    $mail->Body = $email_template;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if ($mail->send()) {
        $_SESSION['status_success'] = " Password reset link send to your email";
        header('location: ../forget_password.php?identity=user');
    } else {
        $_SESSION['status_danger'] = " Message not send due to technical issue";
    }
}


if (isset($_POST['send_link'])) {
    include('../dbConnection.php');
    $Forgetemail = $_POST['send_link_email'];
    if ($Forgetemail == '') {
        $_SESSION['status_danger'] = " Please Enter Email";
        header('location: ../forget_password.php');
        die;
    } else {
        $query = "SELECT * FROM users WHERE user_email = '$Forgetemail'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_name = $row['user_name'];
            $user_id = $row['user_id'];
            sendForgetLinkInEmailForUser($user_id, $user_name, $Forgetemail);
        } else {
            $_SESSION['status_danger'] = " Email not found";
            header('location: ../forget_password.php');
        }
    }
}
