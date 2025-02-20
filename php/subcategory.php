<?php
session_start();
include_once "can_access.php";
include_once "DBconnection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}


$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

if (!$categoryId) {
    $_SESSION['message2'] = ["Invalid category ID."];
    header("Location: category.php");
    exit();
}

include_once "fetch_nav.php";



$categoryName = '';
if ($stmt = $conn->prepare("SELECT category_name FROM lines_category WHERE category_id = ?")) {
    $stmt->bind_param('i', $categoryId);
    $stmt->execute();
    $stmt->bind_result($categoryName);
    $stmt->fetch();
    $stmt->close();
}


$subcategories = [];
if ($stmt = $conn->prepare("SELECT sub_category_id, sub_category_name FROM lines_sub_category WHERE category_id = ?")) {
    $stmt->bind_param('i', $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }
    $stmt->close();
}
?>