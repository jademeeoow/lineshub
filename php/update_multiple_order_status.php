<?php
include_once "DBconnection.php";

header('Content-Type: application/json');

$response = [
    'success' => false,
    'success_message' => '',
    'error_message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['order_ids']) && is_array($data['order_ids']) && isset($data['status']) && isset($data['admin_id'])) {
        $order_ids = $data['order_ids'];
        $status = $data['status'];
        $admin_id = $data['admin_id'];

        $conn->begin_transaction();

        try {
            $successfulUpdates = [];
            $failedUpdates = [];

            foreach ($order_ids as $order_id) {
              
                if ($status === 'Cancelled' || $status === 'Returned') {
                 
                    $item_stmt = $conn->prepare("
                        SELECT variant_id, quantity 
                        FROM lines_order_items 
                        WHERE order_id = ?
                    ");
                    if (!$item_stmt) {
                        throw new Exception("Prepare failed: " . $conn->error);
                    }

                    $item_stmt->bind_param('i', $order_id);
                    if (!$item_stmt->execute()) {
                        throw new Exception("Execute failed: " . $item_stmt->error);
                    }

                    $result = $item_stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $variant_id = $row['variant_id'];
                        $quantity = $row['quantity'];

                        $update_stmt = $conn->prepare("
                            UPDATE lines_product_variants 
                            SET variant_stock = variant_stock + ? 
                            WHERE variant_id = ?
                        ");
                        if (!$update_stmt) {
                            throw new Exception("Prepare failed: " . $conn->error);
                        }

                        $update_stmt->bind_param('ii', $quantity, $variant_id);
                        if (!$update_stmt->execute()) {
                            throw new Exception("Execute failed: " . $update_stmt->error);
                        }
                        $update_stmt->close();
                    }
                    $item_stmt->close();
                } elseif ($status === 'Pending') {
                   
                    $item_stmt = $conn->prepare("
                        SELECT variant_id, quantity 
                        FROM lines_order_items 
                        WHERE order_id = ?
                    ");
                    if (!$item_stmt) {
                        throw new Exception("Prepare failed: " . $conn->error);
                    }

                    $item_stmt->bind_param('i', $order_id);
                    if (!$item_stmt->execute()) {
                        throw new Exception("Execute failed: " . $item_stmt->error);
                    }

                    $result = $item_stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $variant_id = $row['variant_id'];
                        $quantity = $row['quantity'];

                        $update_stmt = $conn->prepare("
                            UPDATE lines_product_variants 
                            SET variant_stock = variant_stock - ? 
                            WHERE variant_id = ?
                        ");
                        if (!$update_stmt) {
                            throw new Exception("Prepare failed: " . $conn->error);
                        }

                        $update_stmt->bind_param('ii', $quantity, $variant_id);
                        if (!$update_stmt->execute()) {
                            throw new Exception("Execute failed: " . $update_stmt->error);
                        }
                        $update_stmt->close();
                    }
                    $item_stmt->close();
                }

         
                $status_stmt = $conn->prepare("
                    UPDATE lines_orders 
                    SET status = ?, processed_by = ? 
                    WHERE order_id = ?
                ");
                if (!$status_stmt) {
                    $failedUpdates[] = $order_id;
                    throw new Exception("Prepare failed: " . $conn->error);
                }

                $status_stmt->bind_param('sii', $status, $admin_id, $order_id);
                if (!$status_stmt->execute()) {
                    $failedUpdates[] = $order_id;
                } else {
                    $successfulUpdates[] = $order_id;
                }

                $status_stmt->close();
            }

            $conn->commit();

         
            if (!empty($successfulUpdates)) {
                $response['success'] = true;
                $response['success_message'] = 'Order statuses updated successfully for orders: ' . implode(', ', $successfulUpdates) . '.';
            }
            if (!empty($failedUpdates)) {
                $response['error_message'] = 'Failed to update statuses for orders: ' . implode(', ', $failedUpdates) . '.';
            }
        } catch (Exception $e) {
            $conn->rollback();
            $response['error_message'] = $e->getMessage();
        }
    } else {
        $response['error_message'] = 'Invalid parameters';
    }
} else {
    $response['error_message'] = 'Invalid request method';
}

echo json_encode($response);
?>
