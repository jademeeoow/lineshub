<?php
session_start();
include_once "../../php/DBconnection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : 0;

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
    $query .= " ORDER BY e.date ASC";

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
    $query = "SELECT description, amount FROM $table WHERE expenditure_id = ?";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    
    $stmt->bind_param('i', $expenditureId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}




$expenditures = fetchExpenditures($conn, $selectedYear, $selectedMonth);
mysqli_close($conn);

$totalCapital = $totalElectricity = $totalMaintenance = $totalLogistics = $grandTotal = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Expenditures</title>
    <link rel="stylesheet" href="../../static/style/tablePrint.css">
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 1rem; 
            }
        }

        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        };

        window.onafterprint = function() {
            window.close();
        };

        window.addEventListener('focus', function() {
            setTimeout(() => {
                if (!window.printTriggered) {
                    window.close();
                }
            }, 100);
        });
    </script>
</head>
<body>
    <div class="whole">
        <div class="topTitle">
            <h3><?php echo $selectedMonth ? "Expenditures Data for " . date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " $selectedYear" : "Expenditures Data for Entire Year $selectedYear"; ?></h3>
        </div>

        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Date</td>
                    <td>Capital Cost Breakdown</td>
                    <td>Capital Cost</td>
                    <td>Electricity Cost Breakdown</td>
                    <td>Electricity Cost</td>
                    <td>Maintenance Cost Breakdown</td>
                    <td>Maintenance Cost</td>
                    <td>Logistics Cost Breakdown</td>
                    <td>Logistics Cost</td>
                    <td>Total Amount</td>
                </tr>

                <?php if (!empty($expenditures)): ?>
                    <?php 
                    $previousDate = '';
                    foreach ($expenditures as $expenditure): 
                        $date = date('F Y', strtotime($expenditure['date']));

                        $maxRows = max(
                            count($expenditure['capital_breakdown']),
                            count($expenditure['electricity_breakdown']),
                            count($expenditure['maintenance_breakdown']),
                            count($expenditure['logistics_breakdown'])
                        );

                        $totalCapital += $expenditure['capital_total'];
                        $totalElectricity += $expenditure['electricity_total'];
                        $totalMaintenance += $expenditure['maintenance_total'];
                        $totalLogistics += $expenditure['logistics_total'];
                        $grandTotal += $expenditure['total_amount'];
                    ?>

                    <?php for ($i = 0; $i < $maxRows; $i++): ?>
                        <tr>
                            <!-- Display date only in the first row of each group -->
                            <?php if ($i === 0 && $date !== $previousDate): ?>
                                <td rowspan="<?php echo $maxRows; ?>"><?php echo htmlspecialchars($date); ?></td>
                                <?php $previousDate = $date; ?>
                            <?php endif; ?>

                            <td><?php echo htmlspecialchars($expenditure['capital_breakdown'][$i]['description'] ?? ''); ?></td>
                            <td><?php echo isset($expenditure['capital_breakdown'][$i]['amount']) ? '₱' . number_format($expenditure['capital_breakdown'][$i]['amount'], 2) : ''; ?></td>

                            <td><?php echo htmlspecialchars($expenditure['electricity_breakdown'][$i]['description'] ?? ''); ?></td>
                            <td><?php echo isset($expenditure['electricity_breakdown'][$i]['amount']) ? '₱' . number_format($expenditure['electricity_breakdown'][$i]['amount'], 2) : ''; ?></td>

                            <td><?php echo htmlspecialchars($expenditure['maintenance_breakdown'][$i]['description'] ?? ''); ?></td>
                            <td><?php echo isset($expenditure['maintenance_breakdown'][$i]['amount']) ? '₱' . number_format($expenditure['maintenance_breakdown'][$i]['amount'], 2) : ''; ?></td>

                            <td><?php echo htmlspecialchars($expenditure['logistics_breakdown'][$i]['description'] ?? ''); ?></td>
                            <td><?php echo isset($expenditure['logistics_breakdown'][$i]['amount']) ? '₱' . number_format($expenditure['logistics_breakdown'][$i]['amount'], 2) : ''; ?></td>

                            <?php if ($i === 0): ?>
                                <td rowspan="<?php echo $maxRows; ?>"><?php echo '₱' . number_format($expenditure['total_amount'], 2); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endfor; ?>
                    <?php endforeach; ?>

                    <tr class="trfooter">
                        <td><strong>TOTAL</strong></td>
                        <td colspan="2"><strong>₱<?php echo number_format($totalCapital, 2); ?></strong></td>
                        <td colspan="2"><strong>₱<?php echo number_format($totalElectricity, 2); ?></strong></td>
                        <td colspan="2"><strong>₱<?php echo number_format($totalMaintenance, 2); ?></strong></td>
                        <td colspan="2"><strong>₱<?php echo number_format($totalLogistics, 2); ?></strong></td>
                        <td><strong>₱<?php echo number_format($grandTotal, 2); ?></strong></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="10">No expenditures found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
