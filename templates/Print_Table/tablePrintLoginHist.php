<?php
include_once "../../php/history.php"; 



$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : null;
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : null;


$loginHistory = fetchLoginHistory($selectedYear, $selectedMonth);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Login History</title>
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
            <p>Login History</p>
            <?php if ($selectedMonth && $selectedYear): ?>
                <p>For <?= date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " " . $selectedYear; ?></p>
            <?php elseif ($selectedYear): ?>
                <p>For Year <?= $selectedYear; ?></p>
            <?php endif; ?>
        </div>

        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Admin Name</td>
                    <td>Login Date</td>
                    <td>Login Time</td>
                    <td>Logout Date</td>
                    <td>Logout Time</td>
                </tr>

                <?php if (!empty($loginHistory)): ?>
                    <?php foreach ($loginHistory as $record): ?>
                        <tr>
                            <td><?= htmlspecialchars($record['first_name']); ?></td>
                            <td><?= htmlspecialchars(formatDateTime($record['login_date'])); ?></td>
                            <td><?= htmlspecialchars(formatDateTime($record['last_login'])); ?></td>
                            <td><?= htmlspecialchars(formatDateTime($record['last_logout'])); ?></td>
                            <td><?= htmlspecialchars(formatDateTime($record['last_logout'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No login history found for this period.</td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
