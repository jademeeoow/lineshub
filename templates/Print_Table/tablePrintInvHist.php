<?php

include_once "../../php/inventory.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Table</title>
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
          
            <?php if ($selectedYear && $selectedMonth && $selectedMonth != 0): ?>
                <p>Product Inventory History Data for <?= date("F", mktime(0, 0, 0, $selectedMonth, 1)); ?> <?= $selectedYear; ?></p>
            <?php elseif ($selectedYear): ?>
                <p>Product Inventory History Data for the Entire Year of <?= $selectedYear; ?></p>
            <?php else: ?>
               
            <?php endif; ?>
        </div>

        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Category</td>
                    <td>Product Name</td>
                    <td>Size</td>
                    <td>Variant</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Supplier</td>
                    <td>Date</td>
                    <td>Status</td>
                </tr>
                <?php if (!empty($productHistory)): ?>
                    <?php foreach ($productHistory as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['category_name']); ?></td>
                            <td><?= htmlspecialchars($item['product_name']); ?></td>
                            <td><?= htmlspecialchars($item['variant_size']); ?></td>
                            <td><?= htmlspecialchars($item['variant_color']); ?></td>
                            <td><?= htmlspecialchars($item['quantity']); ?></td>
                            <td><?= htmlspecialchars($item['variant_price']); ?></td>
                            <td><?= htmlspecialchars($item['supplier_name']); ?></td>
                            <td><?= htmlspecialchars(date('F-d-Y g:i A', strtotime($item['order_date']))); ?></td>
                            <td><?= htmlspecialchars($item['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No product history available for this period.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
