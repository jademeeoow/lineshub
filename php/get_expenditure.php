<?php
include_once "DBconnection.php"; 

if (isset($_GET['expenditure_id'])) {
    $expenditure_id = (int)$_GET['expenditure_id'];
    $expenditure = getExpenditureById($conn, $expenditure_id);

    if ($expenditure) {
        echo json_encode(['status' => 'success', 'expenditure' => $expenditure]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Expenditure not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No expenditure ID provided.']);
}

function getExpenditureById($conn, $expenditure_id) {

    $query = "  
        SELECT expenditure_id, date, total_amount 
        FROM lines_expenditures 
        WHERE expenditure_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $expenditure_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $expenditure = $result->fetch_assoc();

    if ($expenditure) {
    
    
        $expenditure['capital_breakdown'] = getCapitalBreakdown($conn, $expenditure_id);
        $expenditure['electricity_breakdown'] = getElectricityBreakdown($conn, $expenditure_id);
        $expenditure['maintenance_breakdown'] = getMaintenanceBreakdown($conn, $expenditure_id);
        $expenditure['logistics_breakdown'] = getLogisticsBreakdown($conn, $expenditure_id);

        return $expenditure;
    }
    return null;
}


function getCapitalBreakdown($conn, $expenditure_id) {
    $query = "SELECT capital_id AS id, description, amount FROM lines_capital_costs WHERE expenditure_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $expenditure_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


function getElectricityBreakdown($conn, $expenditure_id) {
    $query = "SELECT electricity_id AS id, description, amount FROM lines_electricity_costs WHERE expenditure_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $expenditure_id);
    $stmt->execute();
 
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

}


function getMaintenanceBreakdown($conn, $expenditure_id) {
    $query = "SELECT maintenance_id AS id, description, amount FROM lines_maintenance_costs WHERE expenditure_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $expenditure_id);
    $stmt->execute();
   
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


function getLogisticsBreakdown($conn, $expenditure_id) {
    $query = "SELECT logistics_id AS id, description, amount FROM lines_logistics_costs WHERE expenditure_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $expenditure_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   
}
?>
