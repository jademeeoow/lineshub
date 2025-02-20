<?php
include_once "DBconnection.php";

session_start();

date_default_timezone_set('Asia/Manila');

function decryptPassword($encryptedPassword, $iv) {
    $key = '1234567890123456'; 
    $iv = base64_decode($iv);  

    $decrypted = openssl_decrypt(
        base64_decode($encryptedPassword),
        'aes-128-cbc',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    return $decrypted;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $encryptedPassword = $_POST['encryptedPassword'];
    $iv = $_POST['iv']; 

    $password = decryptPassword($encryptedPassword, $iv); 

    $sql = "SELECT * FROM lines_admin WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['role'] == 'inactive') {
            $error = "Invalid Login, Your Account is Inactive";
        } else {
            if (is_null($user['last_login'])) {
                $_SESSION['admin_id'] = $user['admin_id'];
                $_SESSION['role'] = $user['role'];
                header("Location: changepass.php");
                exit();
            }

            $currentDateTime = date('Y-m-d H:i:s');
            $loginDate = date('Y-m-d');

            $updateSql = "UPDATE lines_admin SET last_login=?, login_date=? WHERE admin_id=?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('ssi', $currentDateTime, $loginDate, $user['admin_id']);
            $updateStmt->execute();

            $_SESSION['admin_id'] = $user['admin_id'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $error = "Invalid username/email or password.";
    }
}
?>
