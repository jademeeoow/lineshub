<?php
session_start();
include_once "DBconnection.php";
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    date_default_timezone_set('Asia/Manila');

    function generateRandomCode()
    {
        return mt_rand(100000, 999999);
    }

    $_SESSION['message'] = '';

    $stmt = $conn->prepare("SELECT admin_id FROM lines_admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($admin_id);
    $stmt->fetch();
    $stmt->close();

    if ($admin_id) {
        $code = generateRandomCode();
        $hashed_code = password_hash($code, PASSWORD_DEFAULT);
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $stmt = $conn->prepare("UPDATE lines_admin SET reset_code = ?, reset_code_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $hashed_code, $expiry, $email);
        $stmt->execute();

        if ($stmt->errno) {
            $_SESSION['message'] = "SQL error: " . $stmt->error;
        }

        $stmt->close();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lineshub2024@gmail.com';
            $mail->Password = 'rfnq ydkm bupp kbui';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('lineshub@gmail.com', 'Lines Hub');
            $mail->addAddress($email);

            $imageURL = 'https://i.imgur.com/fN8S4RP.png'; 

            $mail->isHTML(true);
            $mail->Subject = 'Reset Password Code';
            $mail->Body = "
            <html>
            <head>
                <style>
                    .email-container {
                        font-family: Arial, sans-serif;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #ccc;
                        border-radius: 10px;
                        background-color: #FFC000;
                    }
                    .email-header {
                        text-align: center;
                        padding-bottom: 20px;
                    }
                    .email-header img {
                        max-width: 150px;
                    }
                    .email-body {
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 10px;
                        border: 1px solid #ddd;
                    }
                    .email-footer {
                        text-align: center;
                        padding-top: 20px;
                        font-size: 12px;
                        font-weight:bold;
                        color: #000;
                    }
                    .bold-text {
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <img src='$imageURL' alt='Lines Hub Logo'>
                    </div>
                    <div class='email-body'>
                        <h2 class='bold-text'>Hello,</h2>
                        <p class='bold-text'>Your reset password code is:</p>
                        <h1 style='color: black;'>$code</h1>
                        <p class='bold-text'>Please use this code within 10 minutes.</p>
                    </div>
                    <div class='email-footer'>
                        &copy; 2024 Lines Hub. All rights reserved.
                    </div>
                </div>
            </body>
            </html>";
            $mail->AltBody = "Your reset password code is: $code. Please use this code within 10 minutes.";

            $mail->send();

            $_SESSION['message'] = '';

            header("Location: authentication.php?email=$email&admin_id=$admin_id");
            exit();
        } catch (Exception $e) {
            $_SESSION['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['message'] = "No user found with this email address.";
    }
}

$conn->close();
?>
