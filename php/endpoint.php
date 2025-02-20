<?php
include_once "DBconnection.php";

// Fetching product variants
$sqlProducts = "SELECT 
                    v.variant_id, 
                    p.product_name, 
                    v.variant_color, 
                    v.variant_size, 
                    v.variant_price, 
                    v.variant_stock, 
                    v.initial_stock, 
                    c.category_name, 
                    c.category_id 
                FROM 
                    lines_product_variants v 
                JOIN 
                    lines_products p ON v.product_id = p.product_id
                JOIN 
                    lines_category c ON p.category_id = c.category_id";

$resultProducts = $conn->query($sqlProducts);
$stockData = [];

if ($resultProducts) {
    while ($row = $resultProducts->fetch_assoc()) {
        $row['variant_id'] = (int) $row['variant_id'];
        $row['variant_stock'] = (int) $row['variant_stock'];
        $row['initial_stock'] = (int) $row['initial_stock'];
        $row['type'] = 'product'; 
        $stockData[] = $row;
    }
}

// Fetching supplies variants
$sqlSupplies = "SELECT 
                    sv.variant_id, 
                    s.product_name, 
                    sv.variant_color, 
                    sv.variant_size, 
                    sv.variant_price, 
                    sv.variant_stock, 
                    sv.initial_stock, 
                    sc.category_name, 
                    sc.category_id 
                FROM 
                    lines_supplies_product_variants sv
                JOIN 
                    lines_supplies_product s ON sv.product_id = s.product_id
                JOIN 
                    lines_supplies_category sc ON s.category_id = sc.category_id";

$resultSupplies = $conn->query($sqlSupplies);

if ($resultSupplies) {
    while ($row = $resultSupplies->fetch_assoc()) {
        $row['variant_id'] = (int) $row['variant_id'];
        $row['variant_stock'] = (int) $row['variant_stock'];
        $row['initial_stock'] = (int) $row['initial_stock'];
        $row['type'] = 'supply'; 
        $stockData[] = $row;
    }
}

// Return the combined stock data
header('Content-Type: application/json');
echo json_encode($stockData);
?>
