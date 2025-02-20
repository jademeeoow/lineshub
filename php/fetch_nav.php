<?php

$admin_id = $_SESSION['admin_id'];


$query = "SELECT image_path, role, sales_nav, product_nav, order_nav, account_nav, supplies_nav FROM lines_admin WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $admin = $result->fetch_assoc();
    

    $image_path = $admin['image_path'] ? $admin['image_path'] : ''; 
    $role = $admin['role'] ? $admin['role'] : ''; 
    $sales_nav = $admin['sales_nav'] ? $admin['sales_nav'] : 0; 
    $product_nav = $admin['product_nav'] ? $admin['product_nav'] : 0; 
    $order_nav = $admin['order_nav'] ? $admin['order_nav'] : 0; 
    $account_nav = $admin['account_nav'] ? $admin['account_nav'] : 0; 
    $supplies_nav = $admin['supplies_nav'] ? $admin['supplies_nav'] : 0; 
} else {
   
    $image_path = '';
    $role = '';
    $sales_nav = 0;
    $product_nav = 0;
    $order_nav = 0;
    $account_nav = 0;
    $supplies_nav = 0;
}

$stmt->close();
?>
