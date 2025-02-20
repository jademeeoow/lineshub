<?php
session_start();
include_once 'DBconnection.php';

if (!isset($_SESSION['admin_id'])) {

    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];


$variant_id = $_POST['variant_id'] ?? null;
$add_stock = $_POST['add_stock'] ?? null;

if (!$variant_id || !$add_stock) {
    $response = [
        'status' => 'error',
        'message' => 'Invalid input. Variant ID or stock value is missing.'
    ];
    echo json_encode($response);
    exit();
}

try {

    $conn->begin_transaction();


    $stmt = $conn->prepare("SELECT variant_stock FROM lines_product_variants WHERE variant_id = ?");
    $stmt->bind_param("i", $variant_id);
    $stmt->execute();
    $stmt->bind_result($current_stock);
    $stmt->fetch();
    $stmt->close();

    if ($current_stock === null) {
        throw new Exception("Variant not found.");
    }


    $new_stock = $current_stock + intval($add_stock);


    $stmt = $conn->prepare("UPDATE lines_product_variants SET variant_stock = ? WHERE variant_id = ?");
    $stmt->bind_param("ii", $new_stock, $variant_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to update stock: " . $stmt->error);
    }


    $conn->commit();


    $response = [
        'status' => 'success',
        'message' => 'Stock updated successfully.',
        'new_stock' => $new_stock
    ];
    echo json_encode($response);

} catch (Exception $e) {
 
    $conn->rollback();


    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
