<?php
session_start();
include_once "can_access.php";
include_once "DBconnection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$query = "SELECT image_path FROM lines_admin WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$image_path = ($result && $admin = $result->fetch_assoc()) ? $admin['image_path'] : '';
$stmt->close();

include_once "fetch_nav.php";

function getCategories($conn)
{
    $categories = [];
    $query = "SELECT category_id, category_name FROM lines_supplies_category";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = [
                'category_id' => $row['category_id'],
                'category_name' => $row['category_name']
            ];
        }
    } else {
        $_SESSION['message2'] = "Error retrieving categories: " . mysqli_error($conn);
    }

    return $categories;
}

function getSupplyRequests($conn, $year, $month)
{
    $supplyRequests = [];
    $query = "
        SELECT 
            sr.request_id, 
            sr.variant_id, 
            sr.requested_quantity, 
            sr.requested_by, 
            sr.created_at,
            v.product_id,
            v.variant_color, 
            v.variant_size, 
            p.product_name, 
            CONCAT(a.first_name, ' ', a.last_name) AS admin_name
        FROM 
            lines_supply_request sr
        LEFT JOIN 
            lines_supplies_product_variants v ON sr.variant_id = v.variant_id
        LEFT JOIN 
            lines_supplies_product p ON v.product_id = p.product_id
        LEFT JOIN 
            lines_admin a ON sr.requested_by = a.admin_id
        WHERE YEAR(sr.created_at) = ?";
    
    if ($month > 0) {
        $query .= " AND MONTH(sr.created_at) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $year, $month);
    } else {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $year);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $supplyRequests[] = $row;
        }
    } else {
        $_SESSION['message2'] = "Error retrieving supply requests: " . $stmt->error;
    }

    $stmt->close();
    return $supplyRequests;
}

$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : 0;

$supplyRequests = getSupplyRequests($conn, $selectedYear, $selectedMonth);
$categories = getCategories($conn);

mysqli_close($conn);
?>