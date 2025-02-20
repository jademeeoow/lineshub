\<?php

session_start();
include_once 'DBconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$variant_id = $_POST['variant_id'] ?? null;
$product_name = $_POST['product_name'] ?? null;
$product_description = $_POST['product_description'] ?? null;
$variant_color = $_POST['variant_color'] ?? null;
$variant_size = $_POST['variant_size'] ?? null;
$variant_price = $_POST['variant_price'] ?? null;
$variant_stock = $_POST['variant_stock'] ?? null;
$supplier = $_POST['supplier'] ?? null;
$category_id = $_POST['category_id'] ?? null;

if (!$variant_id) {
    $message = "Error: Variant ID is missing.";
    $redirect_url = "../templates/html/supplies_variants.php?message2=" . urlencode($message);
    if ($category_id) {
        $redirect_url .= "&category_id=" . urlencode($category_id);
    }
    header("Location: " . $redirect_url);
    exit();
}

try {
    $conn->begin_transaction();


    $stmt = $conn->prepare("
        UPDATE lines_supplies_product_variants 
        SET variant_color = ?, variant_size = ?, variant_price = ?, variant_stock = ?, initial_stock = ?, supplier = ?
        WHERE variant_id = ?
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }


    $stmt->bind_param("ssssisi", $variant_color, $variant_size, $variant_price, $variant_stock, $variant_stock, $supplier, $variant_id);
    if (!$stmt->execute()) {
        throw new Exception("Update failed: " . $stmt->error);
    }


    if ($product_name && $product_description) {
        $stmt = $conn->prepare("
            UPDATE lines_supplies_product
            SET product_name = ?, product_description = ?
            WHERE product_id = (
                SELECT product_id FROM lines_supplies_product_variants WHERE variant_id = ?
            )
        ");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssi", $product_name, $product_description, $variant_id);
        if (!$stmt->execute()) {
            throw new Exception("Product update failed: " . $stmt->error);
        }
    }

    $conn->commit();

    $message = "Variant updated successfully.";
    $redirect_url = "../templates/html/supplies_variants.php?message=" . urlencode($message);
    if ($category_id) {
        $redirect_url .= "&category_id=" . urlencode($category_id);
    }
    header("Location: " . $redirect_url);
} catch (Exception $e) {
    $conn->rollback();

    $message = "Error: " . $e->getMessage();
    $redirect_url = "../templates/html/supplies_variants.php?message2=" . urlencode($message);
    if ($category_id) {
        $redirect_url .= "&category_id=" . urlencode($category_id);
    }
    header("Location: " . $redirect_url);
}
?>
