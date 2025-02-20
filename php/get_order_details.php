<?php
include_once 'DBconnection.php'; 


$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id <= 0) {
    echo json_encode(['error' => 'Invalid order ID']);
    exit();
}


$response = [];


$sql = "SELECT * FROM lines_orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param('i', $order_id);
$stmt->execute();
$orderResult = $stmt->get_result()->fetch_assoc();

if (!$orderResult) {
    echo json_encode(['error' => 'Order not found']);
    exit();
}

$response['order'] = $orderResult;


$sql = "SELECT * FROM lines_customers WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param('i', $orderResult['customer_id']);
$stmt->execute();
$customerResult = $stmt->get_result()->fetch_assoc();

if (!$customerResult) {
    echo json_encode(['error' => 'Customer not found']);
    exit();
}

$response['customer'] = $customerResult;


$sql = "SELECT * FROM lines_order_items WHERE order_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param('i', $order_id);
$stmt->execute();
$orderItemsResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$response['items'] = $orderItemsResult;


header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
