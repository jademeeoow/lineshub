<?php
include_once "DBconnection.php";
session_start();
include_once "can_access.php";

// Check admin session
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
    $query = "SELECT category_id, category_name, has_subcategories FROM lines_supplies_category";
    $result = $conn->query($query);

    if ($result) {
        while ($category = $result->fetch_assoc()) {
            $categoryId = $category['category_id'];
            $categoryName = $category['category_name'];
            $hasSubcategories = $category['has_subcategories'];

            $subcategories = [];
            if ($hasSubcategories) {
                $subQuery = "SELECT sub_category_id, sub_category_name FROM lines_supplies_sub_category WHERE category_id = ?";
                $subStmt = $conn->prepare($subQuery);
                $subStmt->bind_param('i', $categoryId);
                $subStmt->execute();
                $subResult = $subStmt->get_result();

                // Check if there are valid subcategories
                $hasValidSubcategories = false;

                while ($subcat = $subResult->fetch_assoc()) {
                    if (strtolower(trim($subcat['sub_category_name'])) !== 'none') {
                        $subcategories[] = [
                            'sub_category_id' => $subcat['sub_category_id'],
                            'sub_category_name' => $subcat['sub_category_name']
                        ];
                        $hasValidSubcategories = true;
                    }
                }
                $subStmt->close();
                
         
                if (!$hasValidSubcategories) {
                    $subcategories[] = [
                        'sub_category_id' => null,
                        'sub_category_name' => ''
                    ];
                }
            }

            $categories[] = [
                'category_id' => $categoryId,
                'category_name' => $categoryName,
                'has_subcategories' => $hasSubcategories,
                'subcategories' => $subcategories
            ];
        }
        $result->close();
    } else {
        $_SESSION['errorMessage'] = "Error retrieving categories: " . $conn->error;
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




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = trim($_POST['categoryName']);
    $hasSubcategories = 1; 
    $subcategories = $_POST['subcategories'] ?? [];

    if (!empty($categoryName)) {

        $insertCategoryQuery = "INSERT INTO lines_supplies_category (category_name, has_subcategories) VALUES (?, ?)";
        $stmt = $conn->prepare($insertCategoryQuery);

        if ($stmt) {
            $stmt->bind_param('si', $categoryName, $hasSubcategories);

            if ($stmt->execute()) {
                $categoryId = $stmt->insert_id;
                $stmt->close();

     
                if (empty($subcategories) || (count($subcategories) === 1 && $subcategories[0] === '')) {
              
                    $subcategories = ['None'];
                }

               
                $insertSubcategoryQuery = "INSERT INTO lines_supplies_sub_category (category_id, sub_category_name) VALUES (?, ?)";
                $subStmt = $conn->prepare($insertSubcategoryQuery);

                if ($subStmt) {
                    foreach ($subcategories as $subcategoryName) {
                        if (!empty(trim($subcategoryName))) {
                            $subcategoryName = trim($subcategoryName); 
                            $subStmt->bind_param('is', $categoryId, $subcategoryName);
                            $subStmt->execute();
                        }
                    }
                    $subStmt->close();
                }

                $_SESSION['message'] = "Category and subcategories added successfully!";
            } else {
                $_SESSION['message2'] = "Error adding category: " . $stmt->error;
            }
        } else {
            $_SESSION['message2'] = "Error preparing category statement: " . $conn->error;
        }
    } else {
        $_SESSION['message2'] = "Category name is required.";
    }

    header("Location: supplies_category.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category'])) {
    $categoryId = intval($_POST['category_id']);
    $categoryName = $_POST['categoryName'] ?? '';
    $hasSubcategories = ($_POST['hasSubcategories'] == 'yes') ? 1 : 0;
    $subcategories = $_POST['subcategories'] ?? [];

    if (!empty($categoryName)) {
        
        if ($stmt = $conn->prepare("UPDATE lines_supplies_category SET category_name = ?, has_subcategories = ? WHERE category_id = ?")) {
            $stmt->bind_param('sii', $categoryName, $hasSubcategories, $categoryId);

            if ($stmt->execute()) {
                $stmt->close();

                
                if ($hasSubcategories) {
                  
                    $existingSubcategories = [];
                    if ($subStmt = $conn->prepare("SELECT sub_category_id, sub_category_name FROM lines_supplies_sub_category WHERE category_id = ?")) {
                        $subStmt->bind_param('i', $categoryId);
                        $subStmt->execute();
                        $subResult = $subStmt->get_result();

                        while ($subcat = $subResult->fetch_assoc()) {
                            $existingSubcategories[$subcat['sub_category_id']] = $subcat['sub_category_name'];
                        }
                        $subStmt->close();
                    }

                
                    $insertStmt = $conn->prepare("INSERT INTO lines_supplies_sub_category (sub_category_name, category_id) VALUES (?, ?)");
                    $updateStmt = $conn->prepare("UPDATE lines_supplies_sub_category SET sub_category_name = ? WHERE sub_category_id = ?");

                    $submittedSubcategoryIds = [];

                    foreach ($subcategories as $index => $subcatName) {
                        $subcatName = trim($subcatName);
                        $subcatId = $_POST['sub_category_ids'][$index] ?? null;

                        if ($subcatId && isset($existingSubcategories[$subcatId])) {
                          
                            $updateStmt->bind_param('si', $subcatName, $subcatId);
                            $updateStmt->execute();
                            $submittedSubcategoryIds[] = $subcatId;
                        } elseif (!empty($subcatName)) {
                         
                            $insertStmt->bind_param('si', $subcatName, $categoryId);
                            $insertStmt->execute();
                        }
                    }

                    $insertStmt->close();
                    $updateStmt->close();

                   
                    foreach ($existingSubcategories as $subcatId => $subcatName) {
                        if (!in_array($subcatId, $submittedSubcategoryIds)) {
                            if ($deleteStmt = $conn->prepare("DELETE FROM lines_supplies_sub_category WHERE sub_category_id = ?")) {
                                $deleteStmt->bind_param('i', $subcatId);
                                $deleteStmt->execute();
                                $deleteStmt->close();
                            }
                        }
                    }
                } else {
           
                    if ($deleteSubStmt = $conn->prepare("DELETE FROM lines_supplies_sub_category WHERE category_id = ?")) {
                        $deleteSubStmt->bind_param('i', $categoryId);
                        $deleteSubStmt->execute();
                        $deleteSubStmt->close();
                    }
                }

                $_SESSION['message'] = "Category updated successfully!";
            } else {
                $_SESSION['message2'] = "Error updating category: " . $stmt->error;
            }
        } else {
            $_SESSION['message2'] = "Error preparing category statement: " . $conn->error;
        }
    } else {
        $_SESSION['message2'] = "Category name is required.";
    }

    header("Location: supplies_category.php");
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
            $stmt = $conn->prepare("INSERT INTO lines_supplies_product (product_name, product_description, category_id, sub_category_id) VALUES (?, ?, ?, NULL)");
            $stmt->bind_param('ssi', $productName, $productDescription, $categoryId);
        } else {
            $stmt = $conn->prepare("INSERT INTO lines_supplies_product (product_name, product_description, category_id, sub_category_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssii', $productName, $productDescription, $categoryId, $subCategoryId);
        }

        if ($stmt->execute()) {
            $productId = $stmt->insert_id;

       
            $validVariantExists = false;
            foreach ($variants as $variant) {
                $variantColor = $variant['color'] ?? '';
                $variantSize = $variant['size'] ?? '';
                $variantPrice = $variant['price'] ?? 0.00;
                $variantStock = $variant['stock'] ?? '';
                $variantSupplier = $variant['supplier'] ?? '';

               
                if (!empty($variantColor) || !empty($variantSize) || $variantPrice > 0 || !empty($variantStock) || !empty($variantSupplier)) {
                    $validVariantExists = true;
                    break;
                }
            }

         
            if ($validVariantExists) {
                if ($varStmt = $conn->prepare("INSERT INTO lines_supplies_product_variants (product_id, variant_color, variant_size, variant_price, variant_stock, initial_stock, supplier) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
                    foreach ($variants as $variant) {
                        $variantColor = $variant['color'] ?? '';
                        $variantSize = $variant['size'] ?? '';
                        $variantPrice = $variant['price'] ?? 0.00;
                        $variantStock = $variant['stock'] ?? '';
                        $initialStock = $variantStock;
                        $variantSupplier = $variant['supplier'] ?? '';

                      
                        if (!empty($variantColor) || !empty($variantSize) || $variantPrice > 0 || !empty($variantStock) || !empty($variantSupplier)) {
                            $varStmt->bind_param('issssss', $productId, $variantColor, $variantSize, $variantPrice, $variantStock, $initialStock, $variantSupplier);
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

    header("Location: supplies_category.php");
    exit();
}






$conn->close();
?>
