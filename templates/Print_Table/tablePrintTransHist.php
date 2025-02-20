<?php
include_once "../../php/history.php"; 

// Get the selected year and month from the URL parameters
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : 0;

// Fetch filtered transaction history based on selected year and month
$transactionHistory = fetchTransactionHistory($selectedYear, $selectedMonth);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Transaction History</title>
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
           
            <?php if ($selectedMonth > 0): ?>
                <p>Transaction History  for <?= date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " " . $selectedYear; ?></p>
            <?php else: ?>
                <p>Transaction History for Entire Year <?= $selectedYear; ?></p>
            <?php endif; ?>
        </div>

        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Order ID</td>
                    <td>Customer Name</td>
                    <td>Product</td>
                    <td>Quantity</td>
                    <td>Payment Received by</td>
                    <td>Status (Paid, Unpaid, Staggered)</td>
                    <td>Processed by</td>
                    <td>Date and Time</td>
                </tr>

                <?php if (!empty($transactionHistory)): ?>
                    <?php foreach ($transactionHistory as $order_id => $order): ?>
                        <tr>
                            <td rowspan="<?= count($order['products']); ?>"><?= htmlspecialchars($order_id); ?></td>
                            <td rowspan="<?= count($order['products']); ?>"><?= htmlspecialchars($order['customer_name']); ?></td>
                            
                            <?php foreach ($order['products'] as $index => $product): ?>
                                <?php if ($index > 0): ?>
                                    <tr>
                                <?php endif; ?>
                                    <td><?= htmlspecialchars($product['product_name']); ?></td>
                                    <td><?= htmlspecialchars($product['quantity']); ?></td>
                                    
                                    <?php if ($index === 0): ?>
                                        <td rowspan="<?= count($order['products']); ?>"><?= htmlspecialchars($order['processed_by']); ?></td>
                                        <td rowspan="<?= count($order['products']); ?>">
                                            <?php
                                            if ($order['status'] === 'Received') {
                                                echo 'Paid';
                                            } elseif ($order['downpayment'] > 0 && $order['total_amount'] > 0) {
                                                echo 'Staggered';
                                            } elseif ($order['downpayment'] > 0 && $order['total_amount'] == 0) {
                                                echo 'Paid';
                                            } else {
                                                echo 'Unpaid';
                                            }
                                            ?>
                                        </td>
                                        <td rowspan="<?= count($order['products']); ?>"><?= htmlspecialchars($order['processed_by']); ?></td>
                                        <td rowspan="<?= count($order['products']); ?>"><?= formatDateTime($order['created_at']); ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No transaction history available.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
