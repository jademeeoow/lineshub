<?php
session_start();
include_once "DBconnection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$message = "";
$message2 = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $message2 = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $adminId = $_SESSION['admin_id'];
        $updateSql = "UPDATE lines_admin SET password=?, last_login=? WHERE admin_id=?";
        $currentDateTime = date('Y-m-d H:i:s');
        $stmt = $conn->prepare($updateSql);

        if ($stmt === false) {
            $message2 = "Failed to prepare the SQL statement.";
        } else {
            $stmt->bind_param('ssi', $hashedPassword, $currentDateTime, $adminId);
            if ($stmt->execute()) {
                $message = "Password successfully updated.";
                session_destroy();
            } else {
                $message2 = "Failed to execute the SQL statement.";
            }
        }
    }
}
?>
