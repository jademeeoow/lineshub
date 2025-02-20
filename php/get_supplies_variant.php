<?php
include_once "DBconnection.php";

if (isset($_GET['variant_id'])) {
    $variant_id = intval($_GET['variant_id']);

    $query = "SELECT 
                lv.variant_id, 
                lv.product_id, 
                lv.variant_color, 
                lv.variant_size, 
                lv.variant_price, 
                lv.variant_stock, 
                lv.supplier AS supplier_id, 
                p.product_name, 
                p.product_description,
                ls.sub_category_name
              FROM 
                lines_supplies_product_variants lv
              JOIN 
                lines_supplies_product p ON lv.product_id = p.product_id
              LEFT JOIN 
                lines_supplies_sub_category ls ON p.sub_category_id = ls.sub_category_id
              WHERE 
                lv.variant_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $variant_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'variant' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Variant not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

$conn->close();
?>
