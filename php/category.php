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


function getCategoriesAndSubcategories($conn) {
    $categories = [];

    // Prepare main category query
    if ($stmt = $conn->prepare("SELECT category_id, category_name, has_sub_categories FROM lines_category")) {
        $stmt->execute();
        $result = $stmt->get_result();

        while ($category = $result->fetch_assoc()) {
            $categoryId = $category['category_id'];
            $categoryName = $category['category_name'];
            $hasSubcategories = $category['has_sub_categories'];

            $subcategories = [];
            $hasValidSubcategories = false; // Flag to track valid subcategories

            // Fetch subcategories if they exist
            if ($hasSubcategories) {
                if ($subStmt = $conn->prepare("SELECT sub_category_id, sub_category_name FROM lines_sub_category WHERE category_id = ?")) {
                    $subStmt->bind_param('i', $categoryId);
                    $subStmt->execute();
                    $subResult = $subStmt->get_result();

                    while ($subcat = $subResult->fetch_assoc()) {
                        // Skip "None" subcategories
                        if (strtolower(trim($subcat['sub_category_name'])) !== 'none') {
                            $subcategories[] = [
                                'sub_category_id' => $subcat['sub_category_id'],
                                'sub_category_name' => $subcat['sub_category_name']
                            ];
                            $hasValidSubcategories = true; // Found a valid subcategory
                        }
                    }
                    $subStmt->close();
                }
            }

            // Add an empty subcategory if no valid subcategories found
            if (!$hasValidSubcategories) {
                $subcategories[] = [
                    'sub_category_id' => null,
                    'sub_category_name' => '' // Placeholder for frontend
                ];
            }

            $categories[] = [
                'category_id' => $categoryId,
                'category_name' => $categoryName,
                'has_sub_categories' => $hasSubcategories,
                'subcategories' => $subcategories
            ];
        }
        $stmt->close();
    } else {
        $_SESSION['message2'] = ["Error preparing categories query: " . $conn->error];
    }

    return $categories;
}


$categories = getCategoriesAndSubcategories($conn);


$suppliers = [];
if ($stmt = $conn->prepare("SELECT supplier_id, contact_person FROM lines_suppliers")) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($supplier = $result->fetch_assoc()) {
        $suppliers[] = $supplier;
    }
    $stmt->close();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category'])) {
    $categoryId = intval($_POST['category_id']);
    $categoryName = $_POST['categoryName'] ?? '';
    $hasSubcategoriesInt = isset($_POST['hasSubcategories']) && $_POST['hasSubcategories'] == 'yes' ? 1 : 0;
    $subcategories = $_POST['subcategories'] ?? [];

    if (!empty($categoryName)) {
    
        if ($stmt = $conn->prepare("UPDATE lines_category SET category_name = ?, has_sub_categories = ? WHERE category_id = ?")) {
            $stmt->bind_param('sii', $categoryName, $hasSubcategoriesInt, $categoryId);

            if ($stmt->execute()) {
                $stmt->close();

          
                if ($hasSubcategoriesInt) {
                
                    $existingSubcategories = [];
                    if ($subStmt = $conn->prepare("SELECT sub_category_id, sub_category_name FROM lines_sub_category WHERE category_id = ?")) {
                        $subStmt->bind_param('i', $categoryId);
                        $subStmt->execute();
                        $subResult = $subStmt->get_result();

                        while ($subcat = $subResult->fetch_assoc()) {
                            $existingSubcategories[$subcat['sub_category_id']] = $subcat['sub_category_name'];
                        }
                        $subStmt->close();
                    }

        
                    $insertStmt = $conn->prepare("INSERT INTO lines_sub_category (sub_category_name, category_id) VALUES (?, ?)");
                    $updateStmt = $conn->prepare("UPDATE lines_sub_category SET sub_category_name = ? WHERE sub_category_id = ?");

       
                    $submittedSubcategoryIds = [];

                    foreach ($subcategories as $index => $subcat) {
                        $subcat = trim($subcat);
                        $subcatId = $_POST['sub_category_ids'][$index] ?? null;

                        if ($subcatId && isset($existingSubcategories[$subcatId])) {
               
                            $updateStmt->bind_param('si', $subcat, $subcatId);
                            $updateStmt->execute();
                            $submittedSubcategoryIds[] = $subcatId;
                        } else {
                       
                            $insertStmt->bind_param('si', $subcat, $categoryId);
                            $insertStmt->execute();
                        }
                    }

                    // Close insert and update statements
                    $insertStmt->close();
                    $updateStmt->close();

                    // Delete subcategories that were removed
                    foreach ($existingSubcategories as $subcatId => $subcatName) {
                        if (!in_array($subcatId, $submittedSubcategoryIds)) {
                            if ($deleteStmt = $conn->prepare("DELETE FROM lines_sub_category WHERE sub_category_id = ?")) {
                                $deleteStmt->bind_param('i', $subcatId);
                                $deleteStmt->execute();
                                $deleteStmt->close();
                            }
                        }
                    }
                } else {
                    // If no subcategories, delete all existing subcategories
                    if ($subStmt = $conn->prepare("DELETE FROM lines_sub_category WHERE category_id = ?")) {
                        $subStmt->bind_param('i', $categoryId);
                        $subStmt->execute();
                        $subStmt->close();
                    }
                }

                $_SESSION['message'] = "Category updated successfully!";
            } else {
                $_SESSION['message2'] = ["Error updating category: " . $stmt->error];
            }
        } else {
            $_SESSION['message2'] = ["Error preparing category statement: " . $conn->error];
        }
    } else {
        $_SESSION['message2'] = ["Category name is required"];
    }

    header("Location: category.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $categoryName = $_POST['categoryName'] ?? '';
    $hasSubcategoriesInt = 1;
    $subcategories = $_POST['subcategories'] ?? [];

    if (!empty($categoryName)) {
        if ($stmt = $conn->prepare("INSERT INTO lines_category (category_name, has_sub_categories) VALUES (?, ?)")) {
            $stmt->bind_param('si', $categoryName, $hasSubcategoriesInt);

            if ($stmt->execute()) {
                $categoryId = $stmt->insert_id;
                $stmt->close(); 

         
                if (!empty($subcategories)) {
                    if ($subStmt = $conn->prepare("INSERT INTO lines_sub_category (sub_category_name, category_id) VALUES (?, ?)")) {
                        foreach ($subcategories as $subcat) {
                            $subcat = trim($subcat) === '' ? 'None' : $subcat;
                            $subStmt->bind_param('si', $subcat, $categoryId);
                            $subStmt->execute();
                        }
                        $subStmt->close(); 
                    } else {
                        $_SESSION['message2'] = ["Error preparing subcategory statement: " . $conn->error];
                    }
                } else {
                   
                    if ($subStmt = $conn->prepare("INSERT INTO lines_sub_category (sub_category_name, category_id) VALUES (?, ?)")) {
                        $noneCategory = 'None';
                        $subStmt->bind_param('si', $noneCategory, $categoryId);
                        $subStmt->execute();
                        $subStmt->close(); 
                    } else {
                        $_SESSION['message2'] = ["Error preparing subcategory statement: " . $conn->error];
                    }
                }
                $_SESSION['message'] = "Category and subcategories added successfully!";
            } else {
                $_SESSION['message2'] = ["Error adding category: " . $stmt->error];
            }
        } else {
            $_SESSION['message2'] = ["Error preparing category statement: " . $conn->error];
        }
    } else {
        $_SESSION['message2'] = ["Category name is required"];
    }

    header("Location: category.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $productName = $_POST['productName'] ?? '';
    $productDescription = $_POST['productDescription'] ?? '';
    $categoryId = $_POST['category'] ?? null;
    $subCategoryId = $_POST['subcategory'] ?? null; 
    $variants = $_POST['variants'] ?? [];

    
    if ($subCategoryId === '0' || $subCategoryId === '' || $subCategoryId === 'Select Subcategory') {
        $subCategoryId = null; 
    }

 
    if (!empty($productName) && !empty($productDescription) && $categoryId) {
        
        if ($subCategoryId === null) {
            $stmt = $conn->prepare("INSERT INTO lines_products (product_name, product_description, category_id, sub_category_id) VALUES (?, ?, ?, NULL)");
            $stmt->bind_param('ssi', $productName, $productDescription, $categoryId);
        } else {
            $stmt = $conn->prepare("INSERT INTO lines_products (product_name, product_description, category_id, sub_category_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssii', $productName, $productDescription, $categoryId, $subCategoryId);
        }

        
        if ($stmt->execute()) {
            $productId = $stmt->insert_id;

        
            $validVariantExists = false;
            foreach ($variants as $variant) {
                $variantColor = $variant['color'] ?? '';
                $variantSize = $variant['size'] ?? '';
                $variantPrice = $variant['price'] ?? 0.00;
                $variantStock = $variant['stock'] ?? 0;
                $variantSupplier = $variant['supplier'] ?? '';

            
                if (!empty($variantColor) || !empty($variantSize) || $variantPrice > 0 || $variantStock > 0 || !empty($variantSupplier)) {
                    $validVariantExists = true;
                    break;
                }
            }

          
            if ($validVariantExists) {
                if ($varStmt = $conn->prepare("INSERT INTO lines_product_variants (product_id, variant_color, variant_size, variant_price, variant_stock, initial_stock, supplier) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
                    foreach ($variants as $variant) {
                        $variantColor = $variant['color'] ?? '';
                        $variantSize = $variant['size'] ?? '';
                        $variantPrice = $variant['price'] ?? 0.00;
                        $variantStock = $variant['stock'] ?? 0;
                        $initialStock = $variantStock;
                        $variantSupplier = $variant['supplier'] ?? '';

                     
                        if (!empty($variantColor) || !empty($variantSize) || $variantPrice > 0 || $variantStock > 0 || !empty($variantSupplier)) {
                            $varStmt->bind_param('issdiis', $productId, $variantColor, $variantSize, $variantPrice, $variantStock, $initialStock, $variantSupplier);
                            $varStmt->execute();
                        }
                    }
                    $varStmt->close();
                } else {
                    $_SESSION['message2'] = ["Error preparing variant statement: " . $conn->error];
                }
            }

            $_SESSION['message'] = "Product added successfully! You can now manage it in the inventory.";
        } else {
            $_SESSION['message2'] = ["Error adding product: " . $stmt->error];
        }

        $stmt->close();
    } else {
        $_SESSION['message2'] = ["Product name, description, and category are required"];
    }

    header("Location: category.php");
    exit();
}

if (isset($_GET['delete_category'])) {
    $categoryId = intval($_GET['delete_category']);

    $conn->begin_transaction();

    try {
  
        if ($stmt = $conn->prepare("DELETE FROM lines_products WHERE category_id = ?")) {
            $stmt->bind_param('i', $categoryId);
            $stmt->execute();
            $stmt->close();
        }

        if ($subStmt = $conn->prepare("DELETE FROM lines_sub_category WHERE category_id = ?")) {
            $subStmt->bind_param('i', $categoryId);
            $subStmt->execute();
            $subStmt->close();
        }

       
        if ($stmt = $conn->prepare("DELETE FROM lines_category WHERE category_id = ?")) {
            $stmt->bind_param('i', $categoryId);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Category deleted successfully!";
            } else {
                $_SESSION['message2'] = ["Error deleting category: " . $stmt->error];
            }
            $stmt->close();
        } else {
            $_SESSION['message2'] = ["Error preparing delete statement: " . $conn->error];
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['message2'] = ["Error deleting category: " . $e->getMessage()];
    }

    header("Location: category.php");
    exit();
}
?>
