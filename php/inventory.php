<?php
session_start();
include_once "DBconnection.php"; 

include_once "can_access.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}



$admin_id = $_SESSION['admin_id'];
$query = "SELECT image_path FROM lines_admin WHERE admin_id = $admin_id";
$result = mysqli_query($conn, $query);

if ($result) {
    $admin = mysqli_fetch_assoc($result);
    $image_path = $admin['image_path'];
} else {
    $image_path = '';
}

include_once "fetch_nav.php";

function getCategories($conn)
{
    $categories = [];
    $query = "SELECT category_id, category_name FROM lines_category ORDER by  category_name ASC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = [
                'category_id' => $row['category_id'],
                'category_name' => $row['category_name']
            ];
        }
    } else {
        $_SESSION['message2'] = ["Error retrieving categories: " . mysqli_error($conn)];
    }

    return $categories;
}

function getProductHistory($conn, $year = null, $month = null) {
    $historyData = [];

    $query = "
    SELECT 
        c.category_name,
        p.product_name,
        v.variant_size,
        v.variant_color,
        oi.quantity,
        v.variant_price,
        s.contact_person AS supplier_name,
        o.created_at AS order_date,
        o.status
    FROM 
        lines_order_items oi
    LEFT JOIN 
        lines_product_variants v ON oi.variant_id = v.variant_id
    LEFT JOIN 
        lines_products p ON v.product_id = p.product_id
    LEFT JOIN 
        lines_category c ON p.category_id = c.category_id
    LEFT JOIN 
        lines_suppliers s ON v.supplier = s.supplier_id
    LEFT JOIN 
        lines_orders o ON oi.order_id = o.order_id
    WHERE 
        1=1";

    if ($year) {
        $query .= " AND YEAR(o.created_at) = $year";
    }
    if ($month) {
        $query .= " AND MONTH(o.created_at) = $month";
    }

    $query .= " ORDER BY o.created_at DESC, p.product_name, v.variant_size, v.variant_color";

    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $historyData[] = $row;
        }
    } else {
        $_SESSION['message2'] = ["Error retrieving product history: " . mysqli_error($conn)];
    }

    return $historyData;
}



$selectedView = isset($_GET['view']) ? $_GET['view'] : 'products'; 


$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : null;
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : null;
$productHistory = getProductHistory($conn, $selectedYear, $selectedMonth);
$categories = getCategories($conn);


?>
