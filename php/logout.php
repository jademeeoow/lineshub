<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once "DBconnection.php";
session_start();



date_default_timezone_set('Asia/Manila');


if (isset($_SESSION['admin_id'])) {
   
    $admin_id = $_SESSION['admin_id'];

   
    $currentDateTime = date('Y-m-d H:i:s');

 
    $updateSql = "UPDATE lines_admin SET last_logout=? WHERE admin_id=?";
    $stmt = $conn->prepare($updateSql);
    if ($stmt) {
        $stmt->bind_param('si', $currentDateTime, $admin_id);
        $stmt->execute();
        $stmt->close();
    } else {
     
        error_log("Failed to prepare the SQL statement for updating last_logout.");
    }

  
    $_SESSION = array();

 
    session_destroy();
}


header("Location: ../templates/html/index.php");
exit();
?>
