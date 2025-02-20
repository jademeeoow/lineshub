<?php
include_once "DBconnection.php";


function getSubCategories($conn, $category_id) {
    $subcategories = [];
    $query = "SELECT sub_category_id, sub_category_name FROM lines_sub_category WHERE category_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $subcategories[] = $row;
            }
            $result->close();
        }

        $stmt->close();
    }

    return $subcategories;
}


$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

if ($category_id > 0) {
    $subcategories = getSubCategories($conn, $category_id);
    echo json_encode($subcategories);
} else {
    echo json_encode([]);
}

$conn->close();
?>
