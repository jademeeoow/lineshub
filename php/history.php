<?php
session_start();
include_once "can_access.php";
include_once "DBconnection.php";

// Check if the user is logged in; if not, redirect to login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the admin's image path for the header
function fetchAdminImagePath($admin_id) {
    global $conn;
    $sql = "SELECT image_path FROM lines_admin WHERE admin_id = $admin_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        return $admin['image_path'];
    } else {
        return '';
    }
}


function formatDateTime($datetime) {
    if (empty($datetime) || $datetime == '0000-00-00 00:00:00') {
        return '';
    }
    return date('F j, Y h:i A', strtotime($datetime)); 
}



function fetchTransactionHistory($year = null, $month = null) {
    global $conn;

    $sql = "SELECT o.order_id, 
                   CONCAT(c.first_name, ' ', c.last_name) AS customer_name, 
                   o.rush_fee, o.customization_fee, o.discount, 
                   o.downpayment, o.total_amount, o.created_at, 
                   CONCAT(a.first_name, ' ', a.last_name) AS processed_by, 
                   o.status, 
                   oi.product_name, 
                   oi.quantity 
            FROM lines_orders o 
            JOIN lines_order_items oi ON o.order_id = oi.order_id 
            JOIN lines_customers c ON o.customer_id = c.customer_id 
            LEFT JOIN lines_admin a ON o.processed_by = a.admin_id
            WHERE 1=1";

    if ($year) {
        $sql .= " AND YEAR(o.created_at) = $year";
    }
    if ($month) {
        $sql .= " AND MONTH(o.created_at) = $month";
    }


    $sql .= " ORDER BY o.created_at DESC, o.order_id DESC";

    $result = $conn->query($sql);
    $orders = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $order_id = $row['order_id'];
            if (!isset($orders[$order_id])) {
                $orders[$order_id] = [
                    'customer_name' => $row['customer_name'],
                    'rush_fee' => $row['rush_fee'],
                    'customization_fee' => $row['customization_fee'],
                    'discount' => $row['discount'],
                    'downpayment' => $row['downpayment'],
                    'total_amount' => $row['total_amount'],
                    'created_at' => $row['created_at'],
                    'processed_by' => $row['processed_by'] ?? 'N/A',
                    'status' => $row['status'],
                    'products' => []
                ];
            }
            $orders[$order_id]['products'][] = [
                'product_name' => $row['product_name'],
                'quantity' => $row['quantity']
            ];
        }
    }
    
    return $orders;
}

// Fetch login history for the admin table
function fetchLoginHistory() {
    global $conn;
    
    $sql = "SELECT first_name, last_login, last_logout, login_date FROM lines_admin ORDER BY login_date DESC";
    $result = $conn->query($sql);
    $loginHistory = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $loginHistory[] = [
                'first_name' => $row['first_name'],
                'login_date' => $row['login_date'],
                'last_login' => $row['last_login'],
                'last_logout' => $row['last_logout']
            ];
        }
    }

    return $loginHistory;
}


$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : null;
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : null;


$transactionHistory = fetchTransactionHistory($selectedYear, $selectedMonth);
$loginHistory = fetchLoginHistory();

$admin_id = $_SESSION['admin_id'];
$image_path = fetchAdminImagePath($admin_id);

include_once "fetch_nav.php";
?>
