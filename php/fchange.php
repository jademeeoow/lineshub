<?php
include_once "DBconnection.php";

date_default_timezone_set('Asia/Manila');

$message = '';
$message2 = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['new_password'], $_POST['confirm_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message2 = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $timestamp = date('Y-m-d H:i:s'); 

    
        $stmt = $conn->prepare("UPDATE lines_admin SET password = ?, last_password_change = ? WHERE email = ?");
        $stmt->bind_param("sss", $hashed_password, $timestamp, $email);

        if ($stmt->execute()) {
        
            $stmt = $conn->prepare("SELECT admin_id FROM lines_admin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
           

           
            $message = "Password updated successfully.";
          
           

        } else {
            $message2 = "Failed to update password: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
  
}

?>
