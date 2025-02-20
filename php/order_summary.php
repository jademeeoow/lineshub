<?php

include_once "DBconnection.php"; 
session_start();
include_once "can_access.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit(); 
}


$admin_id = $_SESSION['admin_id'];

$query = "SELECT image_path FROM lines_admin WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $admin = $result->fetch_assoc();
    $image_path = $admin['image_path'];
} else {
    $image_path = ''; 
}

include_once "fetch_nav.php";

$pendingOrders = [];

try {
    $stmt = $conn->prepare("
    SELECT c.company_name,
        c.customer_id, c.first_name, c.last_name, c.phone_number, c.house_no, c.street_address, 
        c.barangay, c.landmark,
        o.order_id, o.additional_instructions, o.delivery_method, o.delivery_date, o.delivery_fee, o.order_type, 
        o.rush_fee, o.status , o.customization_fee, o.discount,  o.downpayment, o.total_amount, o.payment_mode, o.created_at, o.processed_by,
        i.order_item_id, i.product_name, i.variant_color, i.variant_size, i.quantity, i.unit_price, i.total_price, i.variant_id 
    FROM lines_orders o
    INNER JOIN lines_customers c ON o.customer_id = c.customer_id
    INNER JOIN lines_order_items i ON o.order_id = i.order_id
    ORDER BY o.created_at DESC
");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];

        if (!isset($pendingOrders[$order_id])) {
            $pendingOrders[$order_id] = [
                'customer' => [
                    'company_name' => $row['company_name'],
                    'customer_id' => $row['customer_id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'phone_number' => $row['phone_number'],
                    'house_no' => $row['house_no'],
                    'street_address' => $row['street_address'],
                    'barangay' => $row['barangay'],
                    'landmark' => $row['landmark']
                ],
                'order' => [

                   
                    'order_id' => $order_id,
                    'additional_instructions' => $row['additional_instructions'],
                    'delivery_method' => $row['delivery_method'],
                    'delivery_date' => $row['delivery_date'],
                    'order_type' => $row['order_type'],
                    'rush_fee' => $row['rush_fee'],
                    'customization_fee' => $row['customization_fee'],
                    'discount' => $row['discount'],
                    'delivery_fee' => $row['delivery_fee'],
                    'downpayment' => $row['downpayment'],
                    'total_amount' => $row['total_amount'],
                    'payment_mode' => $row['payment_mode'], 
                    'status' => $row['status'],
                    'created_at' => $row['created_at'],
                    'processed_by' => $row['processed_by'],
                    'items' => []
                ]
            ];
        }

        $pendingOrders[$order_id]['order']['items'][] = [
            'order_item_id' => $row['order_item_id'], 
            'variant_id' => $row['variant_id'],
            'product_name' => $row['product_name'],
            'variant_color' => $row['variant_color'],
            'variant_size' => $row['variant_size'],  
            'quantity' => $row['quantity'],
            'unit_price' => $row['unit_price'],
            'total_price' => $row['total_price']
        ];
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

$orderId = $_GET['order_id'] ?? null;


if ($orderId !== null && isset($pendingOrders[$orderId])) {
    $orderData = $pendingOrders[$orderId];
} else {
    $orderData = null; 
}





$totalOrdersAmount = 0;
$specificOrderId = $_GET['order_id'] ?? null;

if ($specificOrderId !== null) {

    $filteredOrder = array_filter($pendingOrders, function ($order) use ($specificOrderId) {
        return $order['order']['order_id'] == $specificOrderId;
    });


    $pendingOrders = !empty($filteredOrder) ? array_values($filteredOrder) : [];
}

foreach ($pendingOrders as $order) {
    $totalOrdersAmount += $order['order']['total_amount'];
}



?>



