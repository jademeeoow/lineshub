<?php
session_start();
include_once "../../php/DBconnection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Get supplier ID from the URL
$supplierId = isset($_GET['supplier_id']) ? intval($_GET['supplier_id']) : null;

if (!$supplierId) {
    $_SESSION['message2'] = ["Invalid supplier ID."];
    header("Location: suppliers.php");
    exit();
}


include_once "fetch_nav.php";
// Fetch supplier details
$supplierName = '';
$query = "SELECT company_name FROM lines_suppliers WHERE supplier_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $supplierId);
$stmt->execute();
$stmt->bind_result($supplierName);
$stmt->fetch();
$stmt->close();

// Fetch products for the selected supplier
$products = [];
$query = "SELECT product_id, product_name FROM lines_suppliers_products WHERE supplier_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $supplierId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$stmt->close();
?>