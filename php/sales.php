<?php
session_start();
include_once "can_access.php";


include_once "DBconnection.php"; 


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





function fetchTopSellingProducts() {
    global $conn;

    $query = "
        SELECT oi.product_name, SUM(oi.quantity * oi.unit_price) AS total_sales
        FROM lines_order_items oi
        JOIN lines_orders o ON oi.order_id = o.order_id
        WHERE o.status = 'Delivered'
        GROUP BY oi.product_name 
        ORDER BY total_sales DESC
        LIMIT 3
    ";

    $result = $conn->query($query);

    if (!$result) {
        echo "Error: " . $conn->error;
        return;
    }

    if ($result->num_rows > 0) {
        $rank = 1;
        while ($row = $result->fetch_assoc()) {
            $productName = $row['product_name'];
            $totalSales = $row['total_sales'];
            $imagePath = '../../static/images/logolines.jpg';

            echo "<div class='conproducts'>";
            echo "<div class='tops'>";
            echo "<div><p>Top $rank: </p></div>";
            echo "<div><p>$productName</p></div>";
            echo "</div>";
            echo "<div class='bots'>";
            echo "<div class='botsimgcon'><img src='" . htmlspecialchars($imagePath) . "' alt=''></div>";
            echo "<div class='botsp'>";
            echo "<p>Total Sales</p>";
            echo "<div class='fsf'><p>₱</p><p>" . number_format($totalSales, 2) . "</p></div>"; 
            echo "</div></div></div>";

            $rank++;
        }
    } else {
        echo "<p>No top-selling products found</p>";
    }
}
function fetchOverallTotalSales($year, $month) {
    global $conn;


    $query = "
        SELECT SUM(total_amount - delivery_fee) AS overall_total_sales
        FROM lines_orders
        WHERE status = 'Delivered' AND YEAR(created_at) = ?
    ";

    if ($month != 0) {
        $query .= " AND MONTH(created_at) = ?";
    }

    $stmt = $conn->prepare($query);
    if ($month != 0) {
        $stmt->bind_param("ii", $year, $month);
    } else {
        $stmt->bind_param("i", $year);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['overall_total_sales'] ?? 0;
    } else {
        echo "Error: " . $conn->error;
        return 0;
    }
}

if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];


    $fromDateTime = $fromDate . ' 00:00:00';
    $toDateTime = $toDate . ' 23:59:59';

    $query = "
        SELECT SUM(total_amount - delivery_fee) AS overall_total_sales
        FROM lines_orders
        WHERE status = 'Delivered' AND created_at BETWEEN ? AND ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $fromDateTime, $toDateTime);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo json_encode(['overallTotalSales' => floatval($row['overall_total_sales'] ?? 0)]);
    exit;
}



function fetchSalesData() {
    global $conn;

    $query = "
        SELECT oi.product_name, SUM(oi.quantity * oi.unit_price) AS total_sales, p.category_id, o.created_at
        FROM lines_order_items oi
        JOIN lines_orders o ON o.order_id = oi.order_id
        JOIN lines_product_variants pv ON oi.variant_id = pv.variant_id
        JOIN lines_products p ON pv.product_id = p.product_id
        WHERE o.status = 'Delivered'
        GROUP BY oi.product_name, p.category_id, o.created_at
    ";

    $result = $conn->query($query);

    if (!$result) {
        echo "Error: " . $conn->error;
        return;
    }

    if ($result->num_rows > 0) {
        $salesData = [];

        while ($row = $result->fetch_assoc()) {
            $productName = $row['product_name'];
            $categoryId = $row['category_id'];
            $totalSales = $row['total_sales'];
            $createdAt = $row['created_at'];

            $categoryQuery = "SELECT category_name FROM lines_category WHERE category_id = ?";
            $categoryStmt = $conn->prepare($categoryQuery);
            $categoryStmt->bind_param("i", $categoryId);
            $categoryStmt->execute();
            $categoryResult = $categoryStmt->get_result();
            $categoryName = $categoryResult->fetch_assoc()['category_name'] ?? 'Unknown';

            $salesData[] = [
                'product_name' => $productName,
                'category' => $categoryName,
                'total_sales' => $totalSales,
                'created_at' => $createdAt,
                'image_path' => '../../static/images/logolines.jpg'
            ];

            $categoryStmt->close();
        }

        foreach ($salesData as $data) {
            echo "<tr>";
            echo "<td><img src='" . htmlspecialchars($data['image_path']) . "' alt='Product Image' style='width:50px;height:50px;'></td>";
            echo "<td>" . htmlspecialchars($data['product_name']) . "</td>";
            echo "<td>" . htmlspecialchars($data['category']) . "</td>";
            echo "<td>₱" . number_format($data['total_sales'], 2) . "</td>";
            echo "<td>" . date("F d, Y", strtotime($data['created_at'])) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No sales data found</td></tr>";
    }
}

function fetchSalesForMonth($year, $month) {
    global $conn;

    $query = "
        SELECT oi.product_name, SUM(oi.quantity) AS total_quantity, 
               SUM(oi.quantity * oi.unit_price) AS total_sales, 
               p.category_id, o.created_at
        FROM lines_order_items oi
        JOIN lines_orders o ON o.order_id = oi.order_id
        JOIN lines_product_variants pv ON oi.variant_id = pv.variant_id
        JOIN lines_products p ON pv.product_id = p.product_id
        WHERE o.status = 'Delivered' AND YEAR(o.created_at) = ?
    ";

    if ($month != 0) {
        $query .= " AND MONTH(o.created_at) = ?";
    }

    $query .= " GROUP BY oi.product_name, p.category_id, o.created_at ORDER BY total_quantity DESC";

    $stmt = $conn->prepare($query);
    if ($month != 0) {
        $stmt->bind_param("ii", $year, $month);
    } else {
        $stmt->bind_param("i", $year);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $salesData = [];
    while ($row = $result->fetch_assoc()) {
        $productName = $row['product_name'];
        $categoryId = $row['category_id'];
        $totalSales = $row['total_sales'];
        $totalQuantity = $row['total_quantity'];
        $createdAt = $row['created_at'];

        $categoryQuery = "SELECT category_name FROM lines_category WHERE category_id = ?";
        $categoryStmt = $conn->prepare($categoryQuery);
        $categoryStmt->bind_param("i", $categoryId);
        $categoryStmt->execute();
        $categoryResult = $categoryStmt->get_result();
        $categoryName = $categoryResult->fetch_assoc()['category_name'] ?? 'Unknown';

        $salesData[] = [
            'product_name' => $productName,
            'category' => $categoryName,
            'total_sales' => $totalSales,
            'total_quantity' => $totalQuantity,
            'created_at' => $createdAt,
            'image_path' => '../../static/images/logolines.jpg'
        ];

        $categoryStmt->close();
    }

    return $salesData;
}

function fetchPaidAndUnderpaidOrdersForMonth($year, $month) {
    global $conn;

    $sql = "
        SELECT o.order_id, o.customer_id, c.first_name, c.last_name, o.created_at, o.status, 
               o.downpayment, o.rush_fee, o.customization_fee, o.delivery_fee, o.delivery_date, o.discount,o.payment_mode,o.total_amount,
               COALESCE(SUM(oi.total_price), 0) AS base_price
        FROM lines_orders o
        JOIN lines_customers c ON o.customer_id = c.customer_id
        LEFT JOIN lines_order_items oi ON o.order_id = oi.order_id
        WHERE YEAR(o.created_at) = ?
    ";

 
    if ($month != 0) {
        $sql .= " AND MONTH(o.created_at) = ?";
    }

    $sql .= "
        GROUP BY o.order_id  
        ORDER BY o.created_at DESC
    ";


    if ($stmt = $conn->prepare($sql)) {
    
        if ($month != 0) {
            $stmt->bind_param("ii", $year, $month);
        } else {
            $stmt->bind_param("i", $year);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {

        
            $discount_value = 0;
            if (strpos($row['discount'], '%') !== false) {
                $discount_percentage = floatval(rtrim($row['discount'], '%'));
                $discount_value = ($discount_percentage / 100) * $row['base_price'];
            } else {
                $discount_value = floatval($row['discount']);
            }

          
            $total_after_discount = $row['base_price'] - $discount_value;
            $total_with_fees = $total_after_discount + $row['rush_fee'] + $row['customization_fee'] + $row['delivery_fee'];
            $remaining_balance = $total_with_fees - $row['downpayment'];

       
            $row['total_balance'] = $total_with_fees;
            $row['remaining_balance'] = $remaining_balance;

            $orders[] = $row;
        }

        $stmt->close();
        return $orders;
    } else {
        echo "SQL Error: " . $conn->error;
        return false;
    }
}

$selectedView = isset($_GET['view']) ? $_GET['view'] : 'Sales';






?>
