<?php
ob_start();
header('Content-Type: application/json');

include_once 'DBconnection.php';

function getProducts($conn) {
    $query = "
        SELECT
            p.product_id,
            p.product_name,
            p.product_description,
            c.category_name,
            COALESCE(s.sub_category_name, 'None') AS sub_category_name,
            GROUP_CONCAT(
                CONCAT(
                    pv.variant_id, '|', 
                    pv.variant_color, '|', 
                    pv.variant_size, '|', 
                    pv.variant_stock, '|',
                    pv.variant_price
                ) SEPARATOR ';'
            ) AS variants
        FROM
            lines_product_variants pv
        JOIN
            lines_products p ON pv.product_id = p.product_id
        JOIN
            lines_category c ON p.category_id = c.category_id
        LEFT JOIN
            lines_sub_category s ON p.sub_category_id = s.sub_category_id
        GROUP BY
            p.product_id, p.product_name, c.category_name, sub_category_name
    ";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        return ['error' => mysqli_error($conn)];
    }

    $products = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $variants = explode(';', $row['variants']);
        $formattedVariants = array_map(function($variant) {
            $details = explode('|', $variant);
            return [
                'variant_id' => $details[0] ?? null,
                'variant_color' => $details[1] ?? 'N/A',
                'variant_size' => $details[2] ?? 'N/A',
                'variant_stock' => $details[3] ?? 0,
                'variant_price' => $details[4] ?? 0.00
            ];
        }, $variants);

        $row['variants'] = $formattedVariants;
        $products[] = $row;
    }

    return $products;
}

$products = getProducts($conn);

mysqli_close($conn);

$json = json_encode($products);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'JSON encoding error: ' . json_last_error_msg()]);
    exit;
}

echo $json;
?>
