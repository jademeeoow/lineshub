<?php
include_once 'DBconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'] ?? null;

    if (!$orderId) {
        header("Location: ../templates/html/order_summary.php?message2=Invalid order ID.");
        exit;
    }

    $companyName = trim($_POST['companyName']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phoneNumber = trim($_POST['phoneNumber']);
    $additionalInstructions = trim($_POST['additionalInstructions']);
    $deliveryMethod = trim($_POST['delivery_method']);
    $deliveryDate = trim($_POST['deliveryDate']);
    $houseNo = trim($_POST['houseNo']);
    $streetAddress = trim($_POST['streetAddress']);
    $barangay = trim($_POST['barangay']);
    $landmark = trim($_POST['landmark']);
    $orderType = trim($_POST['order_type']);
    $rushFee = floatval($_POST['RushInputEdit']);
    $customizationFee = floatval($_POST['Customization']);
    $downpayment = floatval($_POST['Downpayment']);
    $deliveryFee = floatval($_POST['DeliveryFee']);
    $totalAmount = floatval($_POST['total_amount']);
    $paymentMode = trim($_POST['paymentMode']);

    // Validate payment mode
    $validPaymentModes = ['Cash', 'Gcash', 'Paymaya', 'Online Banking'];
    if (!in_array($paymentMode, $validPaymentModes)) {
        header("Location: ../templates/html/order_summary.php?order_id=$orderId&message2=Invalid payment mode.");
        exit;
    }

    $variantIds = is_array($_POST['VariantID']) ? $_POST['VariantID'] : explode(',', $_POST['VariantID']);
    $productNames = is_array($_POST['ProductName']) ? $_POST['ProductName'] : explode(',', $_POST['ProductName']);
    $colors = is_array($_POST['Color']) ? $_POST['Color'] : explode(',', $_POST['Color']);
    $sizes = is_array($_POST['Size']) ? $_POST['Size'] : explode(',', $_POST['Size']);
    $quantities = is_array($_POST['Quantity']) ? $_POST['Quantity'] : explode(',', $_POST['Quantity']);
    $unitPrices = is_array($_POST['unitPrice']) ? $_POST['unitPrice'] : explode(',', $_POST['unitPrice']);
    $itemIds = is_array($_POST['item_ids']) ? $_POST['item_ids'] : explode(',', $_POST['item_ids']);

    $productTotal = 0;
    foreach ($quantities as $index => $quantity) {
        $productTotal += floatval($quantities[$index]) * floatval($unitPrices[$index]);
    }

    $discountInput = $_POST['Discount'];
    $discount = strpos($discountInput, '%') !== false
        ? $productTotal * (floatval(str_replace('%', '', $discountInput)) / 100)
        : floatval($discountInput);

    $netTotal = $productTotal - $discount + $rushFee + $customizationFee + $deliveryFee;
    $finalTotal = max($netTotal - $downpayment, 0);

    $conn->begin_transaction();

    try {
        $currentItems = [];
        $stmt = $conn->prepare("
            SELECT order_item_id, variant_id, quantity 
            FROM lines_order_items 
            WHERE order_id = ?
        ");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $currentItems[$row['order_item_id']] = [
                'variant_id' => $row['variant_id'],
                'quantity' => $row['quantity']
            ];
        }

        $stmt = $conn->prepare("
            UPDATE lines_customers 
            SET company_name = ?, first_name = ?, last_name = ?, phone_number = ?, house_no = ?, street_address = ?, barangay = ?, landmark = ?
            WHERE customer_id = (SELECT customer_id FROM lines_orders WHERE order_id = ?)
        ");
        $stmt->bind_param("ssssssssi", $companyName, $firstName, $lastName, $phoneNumber, $houseNo, $streetAddress, $barangay, $landmark, $orderId);
        $stmt->execute();

        $stmt = $conn->prepare("
            UPDATE lines_orders 
            SET additional_instructions = ?, delivery_method = ?, delivery_date = ?, order_type = ?, 
                rush_fee = ?, customization_fee = ?, discount = ?, downpayment = ?, delivery_fee = ?, total_amount = ?, 
                payment_mode = ? 
            WHERE order_id = ?
        ");
        $stmt->bind_param(
            "ssssdddddssi", 
            $additionalInstructions, $deliveryMethod, $deliveryDate, $orderType, 
            $rushFee, $customizationFee, $discount, $downpayment, $deliveryFee, $finalTotal, 
            $paymentMode, $orderId
        );
        $stmt->execute();

        $retainedItemIds = [];

        foreach ($variantIds as $index => $variantId) {
            $productName = $productNames[$index];
            $color = $colors[$index];
            $size = $sizes[$index];
            $quantity = intval($quantities[$index]);
            $unitPrice = floatval($unitPrices[$index]);
            $itemId = $itemIds[$index];
            $totalPrice = $quantity * $unitPrice;

            $quantityDifference = $quantity - ($currentItems[$itemId]['quantity'] ?? 0);

            if (!empty($itemId) && isset($currentItems[$itemId])) {
                $stmt = $conn->prepare("
                    UPDATE lines_order_items 
                    SET quantity = ?, total_price = ? 
                    WHERE order_item_id = ? AND order_id = ?
                ");
                $stmt->bind_param("idii", $quantity, $totalPrice, $itemId, $orderId);
                $retainedItemIds[] = $itemId;
            } else {
                $stmt = $conn->prepare("
                    INSERT INTO lines_order_items (order_id, variant_id, product_name, variant_color, variant_size, quantity, unit_price, total_price)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("iisssidd", $orderId, $variantId, $productName, $color, $size, $quantity, $unitPrice, $totalPrice);
            }

            $stmt->execute();

            $stmtStock = $conn->prepare("
                UPDATE lines_product_variants 
                SET variant_stock = variant_stock - ? 
                WHERE variant_id = ?
            ");
            $stmtStock->bind_param("ii", $quantityDifference, $variantId);
            $stmtStock->execute();
        }

        $itemsToDelete = array_diff(array_keys($currentItems), $retainedItemIds);
        if (!empty($itemsToDelete)) {
            $placeholders = implode(',', array_fill(0, count($itemsToDelete), '?'));
            $stmtDelete = $conn->prepare("
                DELETE FROM lines_order_items 
                WHERE order_item_id IN ($placeholders) AND order_id = ?
            ");

            if ($stmtDelete) {
                $types = str_repeat('i', count($itemsToDelete)) . 'i';
                $params = array_merge($itemsToDelete, [$orderId]);
                $stmtDelete->bind_param($types, ...$params);
                $stmtDelete->execute();
            } else {
                throw new Exception("Prepare failed for item deletion: " . $conn->error);
            }
        }

        $conn->commit();
        header("Location: ../templates/html/order_summary.php?order_id=$orderId&message=Order updated successfully.");
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: ../templates/html/order_summary.php?order_id=$orderId&message2=Failed to update the order: " . $e->getMessage());
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
} else {
    header("Location: order_summary.php?message2=Invalid request method.");
}
?>
