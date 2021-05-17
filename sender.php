<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

date_default_timezone_set('UTC');
header('Content-Type: application/json');

// data

$name = $_POST['name'];
// $email = $_POST['email'];
$phone = $_POST['phone'];
$date = date('Y / m / d');

// validation

function throwError($field, $error) {
    http_response_code(400);
    echo "{
        \"status\": \"bad_request\",
        \"field\": \"$field\",
        \"message\": \"$error\"
    }";
}

if (strlen($name) === 0) {
    throwError('name', 'This is required field');
    exit();
}
if (strlen($phone) === 0) {
    throwError('phone', 'This is required field');
    exit();
}
// preg_match('/^.+@.+\..+$/', $email, $matches);
// if (count($matches) === 0) {
//     throwError('email', 'Email is not correctly');
//     exit();
// }
// if (strlen($email) === 0) {
//     throwError('email', 'This is required field');
//     exit();
// }

// send email

$mail = new PHPMailer();

try {
    //Server settings
    $mail->charSet = "UTF-8";
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Username = '**********************';           // SMTP username
    $mail->Password = '********';                         // SMTP password
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($email, 'WebSite Mailer');
    $mail->setFrom('tanjakuparlb@gmail.com', 'WebSite Mailer');
    $mail->addAddress('tanjakuparlb@gmail.com');          // Add a recipient

    //Content
    $styles = 'font-weight: 400; line-height: 1.4em;';
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'I want learn!';
    $mail->Body    =
        "<p style=\"$styles\">My name:      <b>$name</b> </p>".
        // "<p style=\"$styles\">Email:           $email    </p>".
        "<p style=\"$styles\">Phone:        <b>$phone</b></p>".
        "<p style=\"$styles\">Sending date: <b>$date</b> </p>";

    $mail->send();

    echo '{"status": "success"}';
} catch (Exception $e) {
    http_response_code(500);
    echo "{
        \"status\": \"error\",
        \"message\": \"internal server error\"
    }";
}
