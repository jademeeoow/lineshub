<?php
include_once "DBconnection.php";
session_start();

$response = [
    'notifications' => [],
    'error' => ''
];

if (!isset($_SESSION['admin_id'])) {
    $response['error'] = 'User is not logged in.';
    echo json_encode($response);
    exit(); 
}

$admin_id = $_SESSION['admin_id'];
$role = $_SESSION['role'];
$default_image = 'static/images/member/default-image.jpg';

if ($role === 'super_admin') {
    $stmt = $conn->prepare("SELECT en.message, en.timestamp, a.first_name AS admin_first_name, a.image_path AS admin_image, en.is_read
                             FROM lines_email_notifications en
                             JOIN lines_admin a ON en.admin_id = a.admin_id
                             ORDER BY en.timestamp DESC");
} else {
    $stmt = $conn->prepare("SELECT en.message, en.timestamp, a.image_path AS admin_image, en.is_read
                             FROM lines_email_notifications en
                             JOIN lines_admin a ON en.admin_id = a.admin_id
                             WHERE en.admin_id = ?
                             ORDER BY en.timestamp DESC");
    $stmt->bind_param("i", $admin_id);
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response['notifications'][] = [
            'message' => $role === 'super_admin' ? $row['admin_first_name'] . " changed their password." : $row['message'],
            'timestamp' => $row['timestamp'],
            'image_path' => $row['admin_image'] ?: $default_image,
            'is_read' => $row['is_read'] 
        ];
    }
} else {
    $response['error'] = 'Failed to fetch notifications: ' . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
