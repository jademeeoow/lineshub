<?php
session_start();
include_once 'DBconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$variant_id = $_POST['variant_id'] ?? null;
$requested_quantity = $_POST['requested_quantity'] ?? null;
$admin_id = $_SESSION['admin_id'];

if (!$variant_id || !$requested_quantity) {
    $response = [
        'message2' => 'Invalid input. Variant ID or requested quantity is missing.'
    ];
    echo json_encode($response);
    exit();
}

try {
    $conn->begin_transaction();

    // Fetch the current variant_stock
    $select_stmt = $conn->prepare("
        SELECT variant_stock FROM lines_supplies_product_variants WHERE variant_id = ?
    ");

    if (!$select_stmt) {
        throw new Exception("Failed to prepare select statement: " . $conn->error);
    }

    $select_stmt->bind_param("i", $variant_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    $variant = $result->fetch_assoc();
    $current_stock = $variant['variant_stock'];
    $select_stmt->close();

    // Extract the numeric part and unit from variant_stock
    preg_match('/(\d+)(.*)/', $current_stock, $matches);
    $numeric_stock = $matches[1] ?? 0;
    $unit_part = $matches[2] ?? '';

    // Convert requested_quantity to include unit if present
    $requested_quantity_with_unit = $requested_quantity . $unit_part;

    // Check if there is enough stock to fulfill the request
    if ($numeric_stock >= $requested_quantity) {
        $new_stock = $numeric_stock - $requested_quantity;
        $new_variant_stock = $new_stock . $unit_part;

        // Insert the supply request with the unit part
        $insert_stmt = $conn->prepare("
            INSERT INTO lines_supply_request (variant_id, requested_quantity, requested_by)
            VALUES (?, ?, ?)
        ");

        if (!$insert_stmt) {
            throw new Exception("Failed to prepare insert statement: " . $conn->error);
        }

        $insert_stmt->bind_param("ssi", $variant_id, $requested_quantity_with_unit, $admin_id);

        if ($insert_stmt->execute()) {
            // Update the variant stock
            $update_stmt = $conn->prepare("
                UPDATE lines_supplies_product_variants 
                SET variant_stock = ?
                WHERE variant_id = ?
            ");

            if (!$update_stmt) {
                throw new Exception("Failed to prepare update statement: " . $conn->error);
            }

            $update_stmt->bind_param("si", $new_variant_stock, $variant_id);

            if ($update_stmt->execute()) {
                $response = [
                    'message' => 'Supply request submitted successfully, and stock updated.'
                ];
            } else {
                throw new Exception("Failed to update variant stock: " . $update_stmt->error);
            }

            $update_stmt->close();
        } else {
            throw new Exception("Failed to submit request: " . $insert_stmt->error);
        }

        $insert_stmt->close();
    } else {
        throw new Exception("Requested quantity exceeds current stock.");
    }

    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();

    $response = [
        'message2' => $e->getMessage()
    ];
}

echo json_encode($response);
?>
