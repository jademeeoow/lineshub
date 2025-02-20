<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include_once "DBconnection.php";
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';
$message2 = '';

function generateRandomCode()
{
    return mt_rand(100000, 999999);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    date_default_timezone_set('Asia/Manila');

    $code = generateRandomCode();
    $hashed_code = password_hash($code, PASSWORD_DEFAULT); 
    $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    $stmt = $conn->prepare("UPDATE lines_admin SET reset_code = ?, reset_code_expiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $hashed_code, $expiry, $email);
    if ($stmt->execute()) {
       
    } else {
        $message2 = 'Failed to update reset code: ' . $stmt->error;
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

        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Code';

        $imageURL = 'https://i.imgur.com/fN8S4RP.png';

        $mail->Body = "<html>
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
                    </style>
                        </head>
                        <body>
                            <div class='email-container'>
                                <div class='email-header'>
                                    <img src='$imageURL' alt='Lines Hub Logo'>
                                </div>
                                <div class='email-body'>
                                    <h2>Hello,</h2>
                                    <p>Your reset password code is:</p>
                                    <p class='code'>$code</p>
                                    <p>Please use this code within 10 minutes.</p>
                                </div>
                                <div class='email-footer'>
                                    &copy; 2024 Lines Hub. All rights reserved.
                                </div>
                            </div>
                        </body>
                        </html>";

        $mail->AltBody = "Your new reset password code is: $code. Please use this code within 10 minutes.";

        if ($mail->send()) {
            $message .= ' New reset code sent successfully. Please check your email.';
        } else {
            $message2 .= " Failed to send email: {$mail->ErrorInfo}";
        }
    } catch (Exception $e) {
        $message2 .= " Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email']) && isset($_GET['code'])) {
    $email = $_GET['email'];
    $code = $_GET['code'];

    date_default_timezone_set('Asia/Manila');

    $stmt = $conn->prepare("SELECT admin_id, reset_code, reset_code_expiry FROM lines_admin WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($admin_id, $storedCode, $expiry);
            $stmt->fetch();
            if (password_verify($code, $storedCode) && strtotime($expiry) > time()) {
                header("Location: fchange.php?admin_id=" . urlencode($admin_id) . "&email=" . urlencode($email));
                exit();
            } else {
                $message2 = "Invalid or expired reset code. Please request a new one.";
            }
        } else {
            $message2 = "Invalid email address. Please check and try again.";
        }
    } else {
        $message2 = "Database error: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>
