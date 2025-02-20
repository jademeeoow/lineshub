<?php
include_once "DBconnection.php";
session_start();
include_once "can_access.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$sql_admins = "SELECT * FROM lines_admin ORDER BY role DESC";
$result_admins = $conn->query($sql_admins);
$admins = [];
if ($result_admins->num_rows > 0) {
    while ($row = $result_admins->fetch_assoc()) {
        $admins[] = $row;
    }
}

include_once "fetch_nav.php";


function getAdminPermissions($conn, $adminId) {
    $stmt = $conn->prepare("SELECT role, sales_nav, product_nav, order_nav, account_nav, supplies_nav FROM lines_admin WHERE admin_id = ?");
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    $permissions = $result->fetch_assoc();
    $stmt->close();

    if ($permissions['role'] === 'super_admin') {
        $permissions['sales_nav'] = 1;
        $permissions['product_nav'] = 1;
        $permissions['order_nav'] = 1;
        $permissions['account_nav'] = 1;
        $permissions['supplies_nav'] = 1;
    }

    return $permissions;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminId = $_POST['adminId'] ?? null;
    $email = $_POST['email'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $phoneNumber = $_POST['phoneNumber'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $role = $_POST['role'] ?? '';

    $salesAccess = isset($_POST['setAccessSales']) ? 1 : 0;
    $productsAccess = isset($_POST['setAccessProducts']) ? 1 : 0;
    $ordersAccess = isset($_POST['setAccessOrders']) ? 1 : 0;
    $accountAccess = isset($_POST['setAccessAccount']) ? 1 : 0;
    $suppliesAccess = isset($_POST['setAccessSupplies']) ? 1 : 0;

    $salesAccessEdit = isset($_POST['setAccessSalesEdit']) ? 1 : 0;
    $productsAccessEdit = isset($_POST['setAccessProductsEdit']) ? 1 : 0;
    $ordersAccessEdit = isset($_POST['setAccessOrdersEdit']) ? 1 : 0;
    $accountAccessEdit = isset($_POST['setAccessAccountEdit']) ? 1 : 0;
    $suppliesAccessEdit = isset($_POST['setAccessSuppliesEdit']) ? 1 : 0;


    if ($role === 'super_admin') {
        $salesAccess = $productsAccess = $ordersAccess = $accountAccess = $suppliesAccess = 1;
        $salesAccessEdit = $productsAccessEdit = $ordersAccessEdit = $accountAccessEdit = $suppliesAccessEdit = 1;
    }

    if ($email && $firstName && $lastName && $phoneNumber && $role) {

        if ($password && $confirmPassword && $password !== $confirmPassword) {
            $_SESSION['errors'] = ["Passwords do not match."];
            header("Location: account.php");
            exit();
        }

        $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imagePath = '../../static/images/member/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        if ($adminId) {
            $sql = "UPDATE lines_admin SET email=?, first_name=?, last_name=?, phone_number=?, role=?, sales_nav=?, product_nav=?, order_nav=?, account_nav=?, supplies_nav=?";
            $params = [$email, $firstName, $lastName, $phoneNumber, $role, $salesAccessEdit, $productsAccessEdit, $ordersAccessEdit, $accountAccessEdit, $suppliesAccessEdit];

            if ($imagePath) {
                $sql .= ", image_path=?";
                $params[] = $imagePath;
            }

            if ($hashedPassword) {
                $sql .= ", password=?";
                $params[] = $hashedPassword;
            }

            $sql .= " WHERE admin_id=?";
            $params[] = $adminId;

            $stmt = $conn->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Account updated successfully";
            } else {
                $_SESSION['errors'] = ["Error updating account: " . $stmt->error];
            }

        } else {
     
            if ($password && $confirmPassword && $email && $firstName && $lastName && $phoneNumber && $role) {
                $stmt = $conn->prepare("INSERT INTO lines_admin (image_path, username, email, first_name, last_name, phone_number, password, role, sales_nav, product_nav, order_nav, account_nav, supplies_nav) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssiiiii", 
                    $imagePath, 
                    $email, 
                    $email, 
                    $firstName, 
                    $lastName, 
                    $phoneNumber, 
                    $hashedPassword, 
                    $role, 
                    $salesAccess, 
                    $productsAccess, 
                    $ordersAccess, 
                    $accountAccess,
                    $suppliesAccess
                );

                if ($stmt->execute()) {
                    $_SESSION['success'] = "New account created successfully";
                } else {
                    $_SESSION['errors'] = ["Error creating account: " . $stmt->error];
                }
                $stmt->close();
            }
        }
    } else {
        $_SESSION['errors'] = ["All fields are required."];
    }

    header("Location: account.php");
    exit();
}


$permissions = isset($_GET['edit_admin_id']) ? getAdminPermissions($conn, $_GET['edit_admin_id']) : [
    'sales_nav' => 0,
    'product_nav' => 0,
    'order_nav' => 0,
    'account_nav' => 0,
    'supplies_nav' => 0,
];

$conn->close();
?>
