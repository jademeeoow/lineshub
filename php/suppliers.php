<?php
session_start();
include_once "can_access.php";
include_once "DBconnection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$image_path = '';

if ($stmt = $conn->prepare("SELECT image_path FROM lines_admin WHERE admin_id = ?")) {
    $stmt->bind_param('i', $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        $image_path = $admin['image_path'];
    }
    $stmt->close();
}

include_once "fetch_nav.php";


$suppliers = [];
if ($stmt = $conn->prepare(
    "SELECT s.supplier_id, s.company_name, s.contact_person, s.email, s.phone_number, s.address, s.business_type, 
    GROUP_CONCAT(p.product_name SEPARATOR ', ') AS products 
    FROM lines_suppliers s 
    LEFT JOIN lines_suppliers_products p ON s.supplier_id = p.supplier_id 
    GROUP BY s.supplier_id ORDER BY s.company_name ASC "
)) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($supplier = $result->fetch_assoc()) {
        $suppliers[] = $supplier;
    }
    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['supplierId']) && !empty($_POST['supplierId'])) {
        editSupplier($conn);
    } else {
        addSupplier($conn);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_supplier'])) {
    $supplierId = $_GET['delete_supplier'];
    deleteSupplier($conn, $supplierId);
}


function addSupplier($conn) {
    $companyName = $_POST['supplierName'];
    $contactPerson = $_POST['contactPerson'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $businessType = $_POST['businessType'];
    $productsProvided = $_POST['productsProvided'];

    try {
        $stmt = $conn->prepare("INSERT INTO lines_suppliers (company_name, contact_person, email, phone_number, address, business_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $companyName, $contactPerson, $email, $phoneNumber, $address, $businessType);

        if ($stmt->execute()) {
            $supplierId = $stmt->insert_id;

            if (!empty($productsProvided) && is_array($productsProvided)) {
                $productStmt = $conn->prepare("INSERT INTO lines_suppliers_products (supplier_id, product_name) VALUES (?, ?)");
                foreach ($productsProvided as $product) {
                    if (!empty($product)) {
                        $productStmt->bind_param("is", $supplierId, $product);
                        $productStmt->execute();
                    }
                }
            }

            $_SESSION['success'] = 'Supplier added successfully!';
        } else {
            throw new Exception('Error adding supplier.');
        }
    } catch (Exception $e) {
        $_SESSION['message2'] = 'Error: ' . $e->getMessage();
    }

    if (isset($stmt)) $stmt->close();
    if (isset($productStmt)) $productStmt->close();
    $conn->close();

    header("Location: suppliers.php");
    exit();
}


function editSupplier($conn) {
    $supplierId = $_POST['supplierId'];
    $companyName = $_POST['editSupplierName'];
    $contactPerson = $_POST['editContactPerson'];
    $email = $_POST['editEmail'];
    $phoneNumber = $_POST['editPhoneNumber'];
    $address = $_POST['editAddress'];
    $businessType = $_POST['editBusinessType'];
    $productsProvided = $_POST['editproductsProvided'];

    try {
        $stmt = $conn->prepare("UPDATE lines_suppliers SET company_name = ?, contact_person = ?, email = ?, phone_number = ?, address = ?, business_type = ? WHERE supplier_id = ?");
        $stmt->bind_param("ssssssi", $companyName, $contactPerson, $email, $phoneNumber, $address, $businessType, $supplierId);

        if ($stmt->execute()) {
            if (!empty($productsProvided) && is_array($productsProvided)) {
                $deleteStmt = $conn->prepare("DELETE FROM lines_suppliers_products WHERE supplier_id = ?");
                $deleteStmt->bind_param("i", $supplierId);
                $deleteStmt->execute();

                $productStmt = $conn->prepare("INSERT INTO lines_suppliers_products (supplier_id, product_name) VALUES (?, ?)");
                foreach ($productsProvided as $product) {
                    if (!empty($product)) {
                        $productStmt->bind_param("is", $supplierId, $product);
                        $productStmt->execute();
                    }
                }
            }

            $_SESSION['success'] = 'Supplier updated successfully!';
        } else {
            throw new Exception('Error updating supplier.');
        }
    } catch (Exception $e) {
        $_SESSION['message2'] = 'Error: ' . $e->getMessage();
    }

    if (isset($stmt)) $stmt->close();
    if (isset($deleteStmt)) $deleteStmt->close();
    if (isset($productStmt)) $productStmt->close();
    $conn->close();

    header("Location: suppliers.php");
    exit();
}


function deleteSupplier($conn, $supplierId) {
    try {
   
        $deleteProductsStmt = $conn->prepare("DELETE FROM lines_suppliers_products WHERE supplier_id = ?");
        $deleteProductsStmt->bind_param("i", $supplierId);
        $deleteProductsStmt->execute();

       
        $deleteSupplierStmt = $conn->prepare("DELETE FROM lines_suppliers WHERE supplier_id = ?");
        $deleteSupplierStmt->bind_param("i", $supplierId);

        if ($deleteSupplierStmt->execute()) {
            $_SESSION['success'] = 'Supplier deleted successfully!';
        } else {
            throw new Exception('Error deleting supplier.');
        }
    } catch (Exception $e) {
        $_SESSION['message2'] = 'Error: ' . $e->getMessage();
    }

    if (isset($deleteProductsStmt)) $deleteProductsStmt->close();
    if (isset($deleteSupplierStmt)) $deleteSupplierStmt->close();
    $conn->close();

    header("Location: suppliers.php");
    exit();
}
?>
