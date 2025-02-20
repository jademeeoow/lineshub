<?php
include_once "DBconnection.php";



$accessPages = [
    'account_nav' => ['account.php'], 
    'sales_nav' => ['expenditures.php', 'sales.php', 'history.php','tablePrintExpenditures.php','tablePrintSales.php','tablePrintOrders.php','tablePrintTransHist.php'
   ,'tablePrintLoginHist.php'],
    'product_nav' => ['category.php', 'inventory.php', 'variants.php','tablePrintInvHist.php','tablePrintInvVar.php','subcategory.php'],
    'order_nav' => ['pending.php', 'todeliver.php', 'received.php', 'cancelled.php', 'returned.php', 'order_summary.php','tablePrintPending.php','tablePrintToDeliver.php'
   ,'tablePrintReceived.php','tablePrintCancelled.php','tablePrintReturned.php'],
    'supplies_nav' => ['supplies_category.php', 'suppliers.php', 'supplies_inventory.php', 'supplies_variants.php', 'tablePrintSupplier.php','tablePrintSuppInv.php',  'tablePrintSuppVar.php','supplier_products.php'], 
];

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$query = "SELECT role, account_nav, sales_nav, product_nav, order_nav, supplies_nav FROM lines_admin WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $admin = $result->fetch_assoc()) {
    $role = $admin['role'];
    
  
    if ($role === 'inactive') {
     
        session_unset();
        session_destroy();
        header("Location: index.php?error=account_inactive");
        exit();
    }


    $account_nav = (int)$admin['account_nav'];
    $sales_nav = (int)$admin['sales_nav'];
    $product_nav = (int)$admin['product_nav'];
    $order_nav = (int)$admin['order_nav'];
    $supplies_nav = (int)$admin['supplies_nav'];
} else {
    header("Location: index.php?error=invalid_user");
    exit();
}

$stmt->close();


if ($role === 'super_admin') {
    return; 
}

$currentPage = basename($_SERVER['PHP_SELF']);
$hasAccess = false;


foreach ($accessPages as $permission => $pages) {
    if ($admin[$permission] === 1 && in_array($currentPage, $pages)) {
        $hasAccess = true;
        break;
    }
}


if (!$hasAccess) {
    header("Location: error404.php");
    exit();
}
?>
