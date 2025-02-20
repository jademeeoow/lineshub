<?php

session_start();
include_once 'DBconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Capture form data
$firstName = $_POST['firstName'] ?? null;
$lastName = $_POST['lastName'] ?? null;
$phoneNumber = $_POST['phoneNumber'] ?? null;
$companyName = $_POST['companyName'] ?? null;
$additionalInstructions = $_POST['additionalInstructions'] ?? null;
$deliveryType = $_POST['delivery_method'] ?? null;
$deliveryDate = $_POST['deliveryDate'] ?? null;
$houseNo = $_POST['houseNo'] ?? null;
$streetAddress = $_POST['streetAddress'] ?? null;
$barangay = $_POST['barangay'] ?? null;
$landmark = $_POST['landmark'] ?? null;
$rushFee = $_POST['RushInput'] ?? 0;
$customizationFee = $_POST['Customization'] ?? 0;
$discountValue = $_POST['rawDiscountValue'] ?? 0;
$downpayment = $_POST['Downpayment'] ?? 0;
$totalAmount = $_POST['total_amount'] ?? 0;
$order_type = $_POST['RR'] ?? 'Regular';
$deliveryFee = $_POST['DeliveryFee'] ?? 0;
$paymentMode = $_POST['paymentMode'] ?? null;

// Validate Payment Mode
$validPaymentModes = ['Cash', 'Gcash', 'Paymaya', 'Online Banking'];
if (!in_array($paymentMode, $validPaymentModes)) {
    header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "?message=Error: Invalid payment mode.");
    exit();
}

// Capture product details
$productNames = $_POST['ProductName'] ?? '[]';
$colors = $_POST['Color'] ?? '[]';
$sizes = $_POST['Size'] ?? '[]';
$quantities = $_POST['Quantity'] ?? '[]';
$unitPrices = $_POST['unitPrice'] ?? '[]';
$variantIds = $_POST['VariantID'] ?? '[]';

$productNamesArray = json_decode($productNames, true);
$colorsArray = json_decode($colors, true);
$sizesArray = json_decode($sizes, true);
$quantitiesArray = json_decode($quantities, true);
$unitPricesArray = json_decode($unitPrices, true);
$variantIdsArray = json_decode($variantIds, true);

// Validate arrays
if (!is_array($productNamesArray) || !is_array($colorsArray) || !is_array($sizesArray) || 
    !is_array($quantitiesArray) || !is_array($unitPricesArray) || !is_array($variantIdsArray)) {
    header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "?message=Error: Invalid data received.");
    exit();
}

if (count($productNamesArray) !== count($colorsArray) || count($productNamesArray) !== count($sizesArray) || 
    count($productNamesArray) !== count($quantitiesArray) || count($productNamesArray) !== count($unitPricesArray) || 
    count($productNamesArray) !== count($variantIdsArray)) {
    header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "?message=Error: Mismatch in array lengths for order items.");
    exit();
}

// Generate a unique order ID
function generateOrderId($conn) {
    do {
        $order_id = rand(100000, 999999);
        $query = $conn->prepare("SELECT COUNT(*) FROM lines_orders WHERE order_id = ?");
        $query->bind_param("i", $order_id);
        $query->execute();
        $result = $query->get_result();
        $count = $result->fetch_row()[0];
    } while ($count > 0);
    return $order_id;
}

try {
    $conn->begin_transaction();
    $order_id = generateOrderId($conn);

    // Check if customer exists
    $stmt = $conn->prepare("
        SELECT customer_id FROM lines_customers 
        WHERE first_name = ? AND last_name = ? AND phone_number = ? AND (company_name = ? OR company_name IS NULL)
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssss", $firstName, $lastName, $phoneNumber, $companyName);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
    $customer_id = $customer ? $customer['customer_id'] : null;

    // Add new customer if not found
    if (!$customer_id) {
        $stmt = $conn->prepare("
            INSERT INTO lines_customers (
                first_name, last_name, phone_number, house_no, street_address, barangay, landmark, company_name
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssssssss", $firstName, $lastName, $phoneNumber, $houseNo, $streetAddress, $barangay, $landmark, $companyName);
        if (!$stmt->execute()) {
            throw new Exception("Customer insert failed: " . $stmt->error);
        }
        $customer_id = $stmt->insert_id;
    }

    // Insert the order
    $stmt = $conn->prepare("
        INSERT INTO lines_orders (
            order_id, customer_id, additional_instructions, delivery_method, delivery_date, 
            rush_fee, customization_fee, discount, downpayment, total_amount, created_at, 
            processed_by, order_type, delivery_fee, payment_mode
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)
    ");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param(
        "iissssssdddsds", 
        $order_id, $customer_id, $additionalInstructions, $deliveryType, $deliveryDate, 
        $rushFee, $customizationFee, $discountValue, $downpayment, $totalAmount, 
        $admin_id, $order_type, $deliveryFee, $paymentMode
    );
    if (!$stmt->execute()) {
        throw new Exception("Order insert failed: " . $stmt->error);
    }

    // Insert order items and update stock
    $stmtOrderItem = $conn->prepare("
        INSERT INTO lines_order_items (
            order_id, product_name, variant_color, variant_size, quantity, unit_price, total_price, variant_id, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtOrderItem) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmtUpdateStock = $conn->prepare("
        UPDATE lines_product_variants 
        SET variant_stock = variant_stock - ? 
        WHERE variant_id = ?
    ");
    if (!$stmtUpdateStock) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    for ($i = 0; $i < count($productNamesArray); $i++) {
        $total_price = $quantitiesArray[$i] * $unitPricesArray[$i];
        $color = $colorsArray[$i] ?? null;
        $size = $sizesArray[$i] ?? null;
        $variant_id = $variantIdsArray[$i] ?? null;

        $stmtOrderItem->bind_param("isssdddi", $order_id, $productNamesArray[$i], $color, $size, $quantitiesArray[$i], $unitPricesArray[$i], $total_price, $variant_id);
        if (!$stmtOrderItem->execute()) {
            throw new Exception("Order item insert failed: " . $stmtOrderItem->error);
        }

        $stmtUpdateStock->bind_param("ii", $quantitiesArray[$i], $variant_id);
        if (!$stmtUpdateStock->execute()) {
            throw new Exception("Stock update failed: " . $stmtUpdateStock->error);
        }
    }

    $conn->commit();

    header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "?message=Order saved successfully.");
} catch (Exception $e) {
    $conn->rollback();
    header("Location: " . strtok($_SERVER['HTTP_REFERER'], '?') . "?message=Error: " . $e->getMessage());
}

?>
