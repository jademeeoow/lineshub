<?php 
include_once "../../php/sales.php";

// Decode orders data only once at the start
$ordersData = !empty($_GET['ordersData']) ? json_decode(urldecode($_GET['ordersData']), true) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Orders Table</title>
    <link rel="stylesheet" href="../../static/style/tablePrint.css">
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 0rem;
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
            <?php
            $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
            $selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : 0;

            if ($selectedMonth === 0) {
                echo "<h3>Orders Report for Entire Year $selectedYear</h3>";
            } else {
                $monthName = date("F", mktime(0, 0, 0, $selectedMonth, 1));
                echo "<h3>Orders Report for $monthName $selectedYear</h3>";
            }
            ?>
        </div>

        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Order ID</td>
                    <td>Customer Name</td>
             
                    <td>Delivery Date</td>
                    <td>Item Price</td>
                    <td>Rush Fee</td>
                    <td>Customization Fee</td>
                    <td>Delivery Fee</td>
                    <td>Discount</td>
                    <td>Downpayment</td>
                    <td>Net Balance</td>
                    <td>Payment Method</td>
                    <td>Payment Status</td>
                    <td>Status</td>
                </tr>
                <?php if (!empty($ordersData)): ?>
                    <?php foreach ($ordersData as $order): 
                    
                        // Handle payment status calculation
                        if (strtolower($order['status']) === 'delivered') {
                            $totalPaid = $order['downpayment'] + $order['remaining_balance'];
                            $remainingBalance = 0;
                            $paymentStatus = 'Fully Paid';
                        } else {
                            $totalPaid = $order['downpayment'];
                            $remainingBalance = $order['total_amount'] - $totalPaid;
                            $paymentStatus = ($remainingBalance <= 0) ? 'Fully Paid' : (($totalPaid > 0) ? 'Partially Paid' : 'Unpaid');
                        }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                        
                            <td><?php echo date("F d, Y", strtotime($order['delivery_date'])); ?></td>
                            <td>₱<?php echo number_format($order['base_price'] ?? 0, 2); ?></td>
                            <td>₱<?php echo number_format($order['rush_fee'] ?? 0, 2); ?></td>
                            <td>₱<?php echo number_format($order['customization_fee'] ?? 0, 2); ?></td>
                            <td>₱<?php echo number_format($order['delivery_fee'] ?? 0, 2); ?></td>
                            <td>₱<?php echo number_format($order['discount'] ?? 0, 2); ?></td>
                            <td>₱<?php echo number_format($totalPaid, 2); ?></td>
                            <td>₱<?php echo number_format($remainingBalance, 2); ?></td>
                            <td><?php echo htmlspecialchars($order['payment_mode'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($paymentStatus); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="14">No orders data available for this period.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
