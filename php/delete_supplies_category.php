<?php
include_once "DBconnection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);


    if (isset($data['delete_category_id']) && is_numeric($data['delete_category_id'])) {
        $categoryId = intval($data['delete_category_id']);

        try {
            $stmt = $conn->prepare("DELETE FROM lines_supplies_category WHERE category_id = ?");
            $stmt->bind_param('i', $categoryId);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Category deleted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete category.']);
            }
            $stmt->close();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid category ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
