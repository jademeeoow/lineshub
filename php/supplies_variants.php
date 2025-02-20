<?php

include_once "DBconnection.php";
session_start();
include_once "can_access.php";


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


function getSuppliers($conn) {
    $suppliers = [];
    $query = "SELECT supplier_id, contact_person FROM lines_suppliers";
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
        $result->close();
    } else {
        $_SESSION['message2'] = "Error retrieving suppliers: " . $conn->error;
    }
    return $suppliers;
}


function getVariants($conn, $category_id) {
    $variants = [];
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
        ls.sub_category_name,
        COALESCE(s.contact_person, 'N/A') AS supplier_name
      FROM 
        lines_supplies_product_variants lv
      JOIN 
        lines_supplies_product p ON lv.product_id = p.product_id
      LEFT JOIN 
        lines_supplies_sub_category ls ON p.sub_category_id = ls.sub_category_id
      LEFT JOIN 
        lines_suppliers s ON lv.supplier = s.supplier_id
      WHERE 
        p.category_id = ?";
                               
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $variants[] = [
                'variant_id' => $row['variant_id'],
                'product_name' => $row['product_name'],
                'product_description' => $row['product_description'],
                'variant_color' => $row['variant_color'],
                'variant_size' => $row['variant_size'],
                'variant_price' => $row['variant_price'],
                'variant_stock' => $row['variant_stock'],
                'supplier_id' => $row['supplier_id'],
                'supplier' => $row['supplier_name'],
                'sub_category_name' => $row['sub_category_name']
            ];
        }
        $result->close();
    } else {
        $_SESSION['message2'] = "Error retrieving variants: " . $conn->error;
    }

    $stmt->close();
    return $variants;
}



function getProductId($conn, $product_name, $product_description) {
    $query = "SELECT product_id FROM lines_supplies_product WHERE product_name = ? AND product_description = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['message2'] = "Error preparing statement to find product: " . $conn->error;
        return false;
    }

    $stmt->bind_param("ss", $product_name, $product_description);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $product_id = $row['product_id'];
        $stmt->close();
        return $product_id;
    } else {
        $_SESSION['message2'] = "Product not found.";
        $stmt->close();
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_variant'])) {
        $existing_product_id = isset($_POST['existing_product_id']) ? intval($_POST['existing_product_id']) : null;
        $product_name = !empty(trim($_POST['product_name'])) ? trim($_POST['product_name']) : null;
        $product_description = trim($_POST['product_description']);
        $subcategory_id = intval($_POST['subcategory'] ?? 0);
        $category_id = intval($_POST['category_id'] ?? 0);
        $variants = $_POST['variants'];


        error_log("Received Product Name: $product_name");
        error_log("Received Product Description: $product_description");
        error_log("Received Subcategory ID: $subcategory_id");
        error_log("Received Category ID: $category_id");


        if ($existing_product_id) {
            $product_id = $existing_product_id;
        } else {
            $product_id = getOrCreateProduct($conn, $product_name, $product_description, $subcategory_id, $category_id);
        }

   
        if (!$product_id) {
            $_SESSION['message2'] = "Failed to create or find product. Please check input values.";
            error_log("Failed to create/find product with name: $product_name, description: $product_description");
            header("Location: supplies_variants.php?category_id=" . $category_id . "&status=error");
            exit();
        } else {
            error_log("Product ID: $product_id"); 
        }

    
foreach ($variants as $variant) {
    $color = !empty(trim($variant['color'])) ? trim($variant['color']) : '';
    

    $size = !empty(trim($variant['size'])) ? trim($variant['size']) : '';
    
    $price = !empty($variant['price']) ? floatval($variant['price']) :'';
    $stock = !empty(trim($variant['stock'])) ? trim($variant['stock']) : '';
    $supplier = !empty($variant['supplier']) ? intval($variant['supplier']) : '';

    $initial_stock = $stock;

    
    $insertQuery = "INSERT INTO lines_supplies_product_variants 
                    (product_id, variant_color, variant_size, variant_price, variant_stock, initial_stock, supplier) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);

    if ($stmt) {
        $stmt->bind_param(
            "issdsii", 
            $product_id, 
            $color, 
            $size, 
            $price, 
            $stock, 
            $initial_stock, 
            $supplier
        );

        if ($stmt->execute()) {
            $_SESSION['message'] = "Variant added successfully.";
        } else {
            $_SESSION['message2'] = "Error adding variant: " . $stmt->error;
            error_log("Error adding variant: " . $stmt->error);
        }
        $stmt->close();
    } else {
        $_SESSION['message2'] = "Error preparing statement: " . $conn->error;
        error_log("Error preparing statement: " . $conn->error); 
    }
}


        header("Location: supplies_variants.php?category_id=" . $category_id . "&status=success");
        exit();
    }
}


function getOrCreateProduct($conn, $product_name, $product_description, $subcategory_id, $category_id)
{

    $subcategory_id = !empty($subcategory_id) ? $subcategory_id : null;


    if (!empty($product_name) && !empty($product_description)) {
      
        $query = "SELECT product_id FROM lines_supplies_product
                  WHERE product_name = ? AND product_description = ? 
                  AND (sub_category_id <=> ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            $_SESSION['message2'] = "Error preparing statement to find product: " . $conn->error;
            return false;
        }

        $stmt->bind_param("ssi", $product_name, $product_description, $subcategory_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $stmt->close();
            return $product_id;
        }

        $stmt->close();
        $insertQuery = "INSERT INTO lines_supplies_product
                        (product_name, product_description, sub_category_id, category_id) 
                        VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);

        if ($stmt) {
            $stmt->bind_param("ssii", $product_name, $product_description, $subcategory_id, $category_id);
            if ($stmt->execute()) {
                $new_product_id = $stmt->insert_id;
                $stmt->close();
                return $new_product_id;
            } else {
                $_SESSION['message2'] = "Error creating product: " . $stmt->error;
                $stmt->close();
                return false;
            }
        } else {
            $_SESSION['message2'] = "Error preparing statement to create product: " . $conn->error;
            return false;
        }
    } else {
        $_SESSION['message2'] = "Product name and description cannot be empty.";
        return false;
    }
}







if (isset($_GET['delete_variant'])) {
    $variant_id = intval($_GET['delete_variant']);
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

    if ($variant_id > 0) {
        $deleteQuery = "DELETE FROM lines_supplies_product_variants WHERE variant_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $variant_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Variant deleted successfully.";
        } else {
            $_SESSION['message2'] = "Error deleting variant: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['message2'] = "Invalid variant ID.";
    }

    header("Location: supplies_variants.php?category_id=" . $category_id . "&status=success");
    exit();
}




function getCategoryName($conn, $category_id) {
    $query = "SELECT category_name FROM lines_supplies_category WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $row = $result->fetch_assoc()) {
            $stmt->close();
            return $row['category_name'];
        }
        
        $stmt->close();
    }
    
    return null;
}


function getExistingProducts($conn, $category_id)
{
    $products = [];
    $query = "SELECT product_id, product_name, product_description 
              FROM lines_supplies_product 
              WHERE category_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['message2'] = "Error preparing statement to fetch products: " . $conn->error;
        return $products;
    }

    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $result->close();
    } else {
        $_SESSION['message2'] = "Error retrieving products: " . $conn->error;
    }

    $stmt->close();
    return $products;
}




$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$existingProducts = getExistingProducts($conn, $category_id);

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$category_name = getCategoryName($conn, $category_id);





$suppliers = getSuppliers($conn);


$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$variants = getVariants($conn, $category_id);




?>
