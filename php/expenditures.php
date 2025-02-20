<?php


session_start();
include_once "can_access.php";
include_once "DBconnection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

include_once "fetch_nav.php";


$admin_id = $_SESSION['admin_id'];
$query = "SELECT image_path FROM lines_admin WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$image_path = $result ? $result->fetch_assoc()['image_path'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_expenditure'])) {
    $expenditure_id = $_POST['delete_expenditure_id'];
    $stmt = $conn->prepare("DELETE FROM lines_expenditures WHERE expenditure_id = ?");
    $stmt->bind_param('i', $expenditure_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Expenditure deleted successfully!";
    } else {
        $_SESSION['message2'] = "Error deleting expenditure: " . $stmt->error;
    }

    header("Location: expenditures.php");
    exit();
}

function generateRandomId($length = 6) {
    $randomId = '';
    $characters = '0123456789';
    $maxIndex = strlen($characters) - 1;
    
    for ($i = 0; $i < $length; $i++) {
        $randomId .= $characters[rand(0, $maxIndex)];
    }
    return (int)$randomId; 
}

function addExpenditure($conn, $expenditureDetails) {

    $selected_year = $expenditureDetails['selected_year'] ?? date('Y');
    $selected_month = $expenditureDetails['selected_month'] ?? date('m');
    $expenditure_date = "$selected_year-$selected_month-01"; 

    $capital_descs = $expenditureDetails['capital_desc'] ?? [];
    $capital_amounts = $expenditureDetails['capital_amount'] ?? [];
    $electricity_descs = $expenditureDetails['electricity_desc'] ?? [];
    $electricity_amounts = $expenditureDetails['electricity_amount'] ?? [];
    $maintenance_descs = $expenditureDetails['maintenance_desc'] ?? [];
    $maintenance_amounts = $expenditureDetails['maintenance_amount'] ?? [];
    $logistics_descs = $expenditureDetails['logistics_desc'] ?? [];
    $logistics_amounts = $expenditureDetails['logistics_amount'] ?? [];

    $capital_total = array_sum($capital_amounts);
    $electricity_total = array_sum($electricity_amounts);
    $maintenance_total = array_sum($maintenance_amounts);
    $logistics_total = array_sum($logistics_amounts);
    $total = $capital_total + $electricity_total + $maintenance_total + $logistics_total;

   
    $year = date('Y', strtotime($expenditure_date));
    $month = date('m', strtotime($expenditure_date));

  
    $stmt = $conn->prepare("
        SELECT expenditure_id 
        FROM lines_expenditures 
        WHERE YEAR(date) = ? AND MONTH(date) = ?
    ");
    if (!$stmt) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param('ii', $year, $month);
    $stmt->execute();
    if ($stmt->error) {
        die('MySQL execute error: ' . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $existingExpenditure = $result->fetch_assoc();

    if ($existingExpenditure) {
       
        $expenditure_id = $existingExpenditure['expenditure_id'];

        $stmt = $conn->prepare("
            UPDATE lines_expenditures 
            SET total_amount = total_amount + ?, 
                capital_total = capital_total + ?, 
                electricity_total = electricity_total + ?, 
                maintenance_total = maintenance_total + ?, 
                logistics_total = logistics_total + ? 
            WHERE expenditure_id = ?
        ");
        if (!$stmt) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param('dddddi', $total, $capital_total, $electricity_total, $maintenance_total, $logistics_total, $expenditure_id);
        $stmt->execute();
        if ($stmt->error) {
            die('MySQL execute error: ' . $stmt->error);
        }

       
        updateBreakdowns($conn, $expenditure_id, $capital_descs, $capital_amounts, $electricity_descs, $electricity_amounts, $maintenance_descs, $maintenance_amounts, $logistics_descs, $logistics_amounts);
    } else {
     
        $expenditure_id = generateRandomId();

        $stmt = $conn->prepare("
            INSERT INTO lines_expenditures (expenditure_id, date, total_amount, capital_total, electricity_total, maintenance_total, logistics_total) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        if (!$stmt) {
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param('isddddd', $expenditure_id, $expenditure_date, $total, $capital_total, $electricity_total, $maintenance_total, $logistics_total);
        $stmt->execute();
        if ($stmt->error) {
            die('MySQL execute error: ' . $stmt->error);
        }

        insertBreakdown($conn, 'lines_capital_costs', $expenditure_id, $capital_descs, $capital_amounts);
        insertBreakdown($conn, 'lines_electricity_costs', $expenditure_id, $electricity_descs, $electricity_amounts);
        insertBreakdown($conn, 'lines_maintenance_costs', $expenditure_id, $maintenance_descs, $maintenance_amounts);
        insertBreakdown($conn, 'lines_logistics_costs', $expenditure_id, $logistics_descs, $logistics_amounts);
    }

    $_SESSION['message'] = "Expenditure added successfully!";


    header("Location: expenditures.php?year=$selected_year&month=$selected_month");
    exit();
}

function insertBreakdown($conn, $table, $expenditure_id, $descriptions, $amounts) {
    for ($i = 0; $i < count($descriptions); $i++) {
        $description = $descriptions[$i];
        $amount = $amounts[$i];

        if (!empty($description) && $amount > 0) {
            $stmt = $conn->prepare("INSERT INTO $table (expenditure_id, description, amount) VALUES (?, ?, ?)");
            $stmt->bind_param('isd', $expenditure_id, $description, $amount);
            $stmt->execute();
        }
    }
}

function updateBreakdowns($conn, $expenditure_id, $capital_descs, $capital_amounts, $electricity_descs, $electricity_amounts, $maintenance_descs, $maintenance_amounts, $logistics_descs, $logistics_amounts) {
    insertBreakdown($conn, 'lines_capital_costs', $expenditure_id, $capital_descs, $capital_amounts);
    insertBreakdown($conn, 'lines_electricity_costs', $expenditure_id, $electricity_descs, $electricity_amounts);
    insertBreakdown($conn, 'lines_maintenance_costs', $expenditure_id, $maintenance_descs, $maintenance_amounts);
    insertBreakdown($conn, 'lines_logistics_costs', $expenditure_id, $logistics_descs, $logistics_amounts);
}

function editExpenditure($conn, $expenditureDetails) {


    $expenditure_id = $expenditureDetails['edit_expenditure_id'];
    $capital_ids = $expenditureDetails['edit_capital_id'] ?? [];
    $capital_descs = $expenditureDetails['edit_capital_desc'] ?? [];
    $capital_amounts = $expenditureDetails['edit_capital_amount'] ?? [];
    $electricity_ids = $expenditureDetails['edit_electricity_id'] ?? [];
    $electricity_descs = $expenditureDetails['edit_electricity_desc'] ?? [];
    $electricity_amounts = $expenditureDetails['edit_electricity_amount'] ?? [];
    $maintenance_ids = $expenditureDetails['edit_maintenance_id'] ?? [];
    $maintenance_descs = $expenditureDetails['edit_maintenance_desc'] ?? [];
    $maintenance_amounts = $expenditureDetails['edit_maintenance_amount'] ?? [];
    $logistics_ids = $expenditureDetails['edit_logistics_id'] ?? [];
    $logistics_descs = $expenditureDetails['edit_logistics_desc'] ?? [];
    $logistics_amounts = $expenditureDetails['edit_logistics_amount'] ?? [];

    $selected_year = $expenditureDetails['selected_year'] ?? date('Y');
    $selected_month = $expenditureDetails['selected_month'] ?? date('m');


    $delete_capital_flags = array_map(fn($arr) => $arr[0], $expenditureDetails['delete_edit_capital_id'] ?? []);
    $delete_electricity_flags = array_map(fn($arr) => $arr[0], $expenditureDetails['delete_edit_electricity_id'] ?? []);
    $delete_maintenance_flags = array_map(fn($arr) => $arr[0], $expenditureDetails['delete_edit_maintenance_id'] ?? []);
    $delete_logistics_flags = array_map(fn($arr) => $arr[0], $expenditureDetails['delete_edit_logistics_id'] ?? []);

 


    updateBreakdownsForEdit(
        $conn,
        $expenditure_id,
        $capital_ids,
        $capital_descs,
        $capital_amounts,
        $electricity_ids,
        $electricity_descs,
        $electricity_amounts,
        $maintenance_ids,
        $maintenance_descs,
        $maintenance_amounts,
        $logistics_ids,
        $logistics_descs,
        $logistics_amounts,
        $delete_capital_flags,
        $delete_electricity_flags,
        $delete_maintenance_flags,
        $delete_logistics_flags
    );

    // Recalculate totals
    $capital_total = calculateTotal($conn, 'lines_capital_costs', $expenditure_id);
    $electricity_total = calculateTotal($conn, 'lines_electricity_costs', $expenditure_id);
    $maintenance_total = calculateTotal($conn, 'lines_maintenance_costs', $expenditure_id);
    $logistics_total = calculateTotal($conn, 'lines_logistics_costs', $expenditure_id);
    $total_amount = $capital_total + $electricity_total + $maintenance_total + $logistics_total;

    // Update lines_expenditures table with new totals
    $update_stmt = $conn->prepare("
        UPDATE lines_expenditures 
        SET total_amount = ?, 
            capital_total = ?, 
            electricity_total = ?, 
            maintenance_total = ?, 
            logistics_total = ? 
        WHERE expenditure_id = ?
    ");
    if ($update_stmt === false) {
        die("Error in UPDATE query preparation for lines_expenditures: (" . $conn->errno . ") " . $conn->error);
    }
    $update_stmt->bind_param('dddddi', $total_amount, $capital_total, $electricity_total, $maintenance_total, $logistics_total, $expenditure_id);
    $update_stmt->execute();
    if ($update_stmt->error) {
        die("Error in executing UPDATE for lines_expenditures: (" . $update_stmt->errno . ") " . $update_stmt->error);
    }

    $_SESSION['message'] = "Expenditure updated successfully!";
    header("Location: expenditures.php?year=$selected_year&month=$selected_month");
    exit();
}

// Function to calculate total
function calculateTotal($conn, $table, $expenditure_id) {
    $query = "SELECT SUM(amount) AS total FROM $table WHERE expenditure_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $expenditure_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc()['total'];
    return $total ?: 0;
}

// Function to handle updating specific breakdowns with delete flags
function updateBreakdownsForEdit($conn, $expenditure_id, $capital_ids, $capital_descs, $capital_amounts, $electricity_ids, $electricity_descs, $electricity_amounts, $maintenance_ids, $maintenance_descs, $maintenance_amounts, $logistics_ids, $logistics_descs, $logistics_amounts, $delete_capital_flags, $delete_electricity_flags, $delete_maintenance_flags, $delete_logistics_flags) {
    updateSpecificBreakdownForEdit($conn, 'lines_capital_costs', 'capital_id', $expenditure_id, $capital_ids, $capital_descs, $capital_amounts, $delete_capital_flags);
    updateSpecificBreakdownForEdit($conn, 'lines_electricity_costs', 'electricity_id', $expenditure_id, $electricity_ids, $electricity_descs, $electricity_amounts, $delete_electricity_flags);
    updateSpecificBreakdownForEdit($conn, 'lines_maintenance_costs', 'maintenance_id', $expenditure_id, $maintenance_ids, $maintenance_descs, $maintenance_amounts, $delete_maintenance_flags);
    updateSpecificBreakdownForEdit($conn, 'lines_logistics_costs', 'logistics_id', $expenditure_id, $logistics_ids, $logistics_descs, $logistics_amounts, $delete_logistics_flags);
}

// Function to update or delete entries in a specific breakdown table
function updateSpecificBreakdownForEdit($conn, $table, $id_column, $expenditure_id, $ids, $descriptions, $amounts, $deleteFlags) {
    for ($i = 0; $i < count($descriptions); $i++) {
        $entry_id = $ids[$i] ?? null;
        $description = $descriptions[$i];
        $amount = $amounts[$i];
        $deleteFlag = $deleteFlags[$i] ?? '0';

        echo "Processing ID: $entry_id, Delete Flag: $deleteFlag <br>";

        if ($deleteFlag == '1' && !empty($entry_id)) {
            // Delete entry
            echo "Attempting to delete ID: $entry_id from $table <br>";
            $delete_stmt = $conn->prepare("DELETE FROM $table WHERE $id_column = ?");
            if ($delete_stmt === false) {
                die("Error in DELETE query preparation for $table: (" . $conn->errno . ") " . $conn->error);
            }
            $delete_stmt->bind_param('i', $entry_id);
            $delete_stmt->execute();

            if ($delete_stmt->affected_rows > 0) {
                echo "Deleted ID: $entry_id successfully.<br>";
            } else {
                echo "Deletion failed for ID: $entry_id.<br>";
            }
        } elseif (!empty($description) && isset($amount) && $deleteFlag == '0') {
            // Update entry if it's not marked for deletion
            if ($entry_id) {
                echo "Updating ID: $entry_id with Description: $description and Amount: $amount <br>";
                $update_stmt = $conn->prepare("UPDATE $table SET description = ?, amount = ? WHERE $id_column = ?");
                if ($update_stmt === false) {
                    die("Error in UPDATE query preparation for $table: (" . $conn->errno . ") " . $conn->error);
                }
                $update_stmt->bind_param('sdi', $description, $amount, $entry_id);
                $update_stmt->execute();
                if ($update_stmt->affected_rows > 0) {
                    echo "Updated ID: $entry_id successfully.<br>";
                } else {
                    echo "Update failed for ID: $entry_id.<br>";
                }
            }
        }
    }
}

// Additional function for generating a random ID (if needed)





if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_expenditure'])) {
    addExpenditure($conn, $_POST);
    header("Location: expenditures.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_edit_expenditure'])) {
    editExpenditure($conn, $_POST);
    header("Location: expenditures.php");
    exit();
}




function fetchExpenditures($conn, $selectedYear = null, $selectedMonth = null) {
    $query = "
        SELECT e.expenditure_id, e.date, e.total_amount, e.capital_total, e.electricity_total, 
               e.maintenance_total, e.logistics_total
        FROM lines_expenditures e
        WHERE 1 = 1
    ";

    if ($selectedYear) {
        $query .= " AND YEAR(e.date) = " . intval($selectedYear);
    }
    if ($selectedMonth) {
        $query .= " AND MONTH(e.date) = " . intval($selectedMonth);
    }
    $query .= " ORDER BY e.date DESC";

    $result = $conn->query($query);
    $expenditures = [];
    while ($row = $result->fetch_assoc()) {
        $row['capital_breakdown'] = getBreakdown($conn, 'lines_capital_costs', $row['expenditure_id']);
        $row['electricity_breakdown'] = getBreakdown($conn, 'lines_electricity_costs', $row['expenditure_id']);
        $row['maintenance_breakdown'] = getBreakdown($conn, 'lines_maintenance_costs', $row['expenditure_id']);
        $row['logistics_breakdown'] = getBreakdown($conn, 'lines_logistics_costs', $row['expenditure_id']);
        $expenditures[] = $row;
    }
    return $expenditures;
}

function getBreakdown($conn, $table, $expenditureId) {
   
    $idColumn = '';
    switch ($table) {
        case 'lines_capital_costs':
            $idColumn = 'capital_id';
            break;
        case 'lines_electricity_costs':
            $idColumn = 'electricity_id';
            break;
        case 'lines_logistics_costs':
            $idColumn = 'logistics_id';
            break;
        case 'lines_maintenance_costs':
            $idColumn = 'maintenance_id';
            break;
        
        default:
            die("Unknown table: $table");
    }

    $query = "SELECT $idColumn AS id, description, amount FROM $table WHERE expenditure_id = ?";


   
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param('i', $expenditureId);
    $stmt->execute();
    $result = $stmt->get_result();

  
    return $result->fetch_all(MYSQLI_ASSOC);
}





$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$expenditures = fetchExpenditures($conn, $selectedYear, $selectedMonth);

mysqli_close($conn);
?>
