<?php

session_start();
$admin_id = $_SESSION['admin_id']; 

include_once "DBconnection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mark_all']) && $_POST['mark_all'] === 'true') {
        $query = "UPDATE lines_email_notifications SET is_read = 1 WHERE admin_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $admin_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to mark notifications as read.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

$conn->close();
    