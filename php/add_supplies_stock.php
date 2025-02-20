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

if (!$variant_id || $add_stock === null) {
    $response = [
        'status' => 'error',
        'message' => 'Invalid input. Variant ID or stock value is missing.'
    ];
    echo json_encode($response);
    exit();
}

try {
 
    $conn->begin_transaction();


    $stmt = $conn->prepare("SELECT variant_stock FROM lines_supplies_product_variants WHERE variant_id = ?");
    $stmt->bind_param("i", $variant_id);
    $stmt->execute();
    $stmt->bind_result($current_stock);
    $stmt->fetch();
    $stmt->close();

    if ($current_stock === null) {
        throw new Exception("Variant not found.");
    }

    
    $add_stock = strtolower(trim($add_stock));

 
    if (preg_match('/^(\d+)\s*(meters|meter|m)$/i', $current_stock, $matches)) {
     
        $current_stock_value = intval($matches[1]);
        $current_stock_unit = $matches[2];
    } else {
     
        $current_stock_value = intval($current_stock);
        $current_stock_unit = '';
    }

  
    if (preg_match('/^(\d+)\s*(meters|meter|m)$/i', $add_stock, $matches)) {
        $add_stock_value = intval($matches[1]);
        $add_stock_unit = $matches[2];

   
        if (!empty($current_stock_unit) && $current_stock_unit == $add_stock_unit) {
            $new_stock = ($current_stock_value + $add_stock_value) . ' ' . $current_stock_unit;
        } else {
          
            $new_stock = $current_stock . ' + ' . $add_stock;
        }
    } else {
  
        $add_stock_value = intval($add_stock);
        $new_stock = ($current_stock_value + $add_stock_value) . (empty($current_stock_unit) ? '' : ' ' . $current_stock_unit);
    }

 
    $stmt = $conn->prepare("UPDATE lines_supplies_product_variants SET variant_stock = ? WHERE variant_id = ?");
    $stmt->bind_param("si", $new_stock, $variant_id);
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
    // Rollback transaction
    $conn->rollback();

    // Return error response
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    echo json_encode($response);
}
?>
