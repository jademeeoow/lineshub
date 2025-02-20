<?php
include_once "../../php/returned.php";

$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : null;
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : null;

$filteredOrders = array_filter($returnedOrders, function($order) use ($fromDate, $toDate) {
    $orderDate = strtotime($order['order']['delivery_date']);
    
    $fromDateCheck = $fromDate ? strtotime($fromDate) <= $orderDate : true;
    $toDateCheck = $toDate ? strtotime($toDate) >= $orderDate : true;
    
    return $fromDateCheck && $toDateCheck;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Returned Orders</title>
    <link rel="stylesheet" href="../../static/style/tablePrint.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
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
            <p>Returned Orders
                <?php
                if ($fromDate || $toDate) {
                    $formattedFromDate = $fromDate ? date("F j", strtotime($fromDate)) : '';
                    $formattedToDate = $toDate ? date("F j, Y", strtotime($toDate)) : '';

                    if ($fromDate && $toDate) {
                        echo "from $formattedFromDate to $formattedToDate";
                    } elseif ($fromDate) {
                        echo "from $formattedFromDate";
                    } elseif ($toDate) {
                        echo "up to $formattedToDate";
                    }
                }
                ?>
            </p>
        </div>
        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Order ID</td>
                    <td>Company Name</td>
                    <td>Customer Name</td>
                    <td>Product</td>
                     <td>Color</td>
                      <td>Size</td>
                    <td>Quantity</td>
                    <td>Regular/Rush</td>
                    <td>Order Date</td>
                </tr>
                
                <?php foreach ($filteredOrders as $order) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order']['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer']['company_name'] ?? 'None'); ?></td>
                        <td><?php echo htmlspecialchars($order['customer']['first_name'] . ' ' . $order['customer']['last_name']); ?></td>
                        <td>
                            <?php foreach ($order['order']['items'] as $item) : ?>
                                <?php echo htmlspecialchars($item['product_name']); ?><br>
                            <?php endforeach; ?>
                        </td>
                          <td>
                            <?php foreach ($order['order']['items'] as $item) : ?>
                                <?php echo htmlspecialchars($item['variant_color']); ?><br>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php foreach ($order['order']['items'] as $item) : ?>
                                <?php echo htmlspecialchars($item['variant_size']); ?><br>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php foreach ($order['order']['items'] as $item) : ?>
                                <?php echo htmlspecialchars($item['quantity']); ?><br>
                            <?php endforeach; ?>
                        </td>
                        <td><?php echo htmlspecialchars($order['order']['order_type']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($order['order']['delivery_date'])); ?></td>
                    </tr>
                <?php endforeach; ?>
                
                <?php if (empty($filteredOrders)) : ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No returned orders found within the selected date range.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
