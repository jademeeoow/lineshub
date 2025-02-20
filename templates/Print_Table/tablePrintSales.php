<?php


include_once "../../php/sales.php";

$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : 0;

$salesData = fetchSalesForMonth($selectedYear, $selectedMonth);
$overallTotalSales = fetchOverallTotalSales($selectedYear, $selectedMonth);
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
          
            <h3>
                <?php echo $selectedMonth == 0 ? "Sales Data for Entire Year $selectedYear" : "Sales Data for " . date("F", mktime(0, 0, 0, $selectedMonth, 1)) . " $selectedYear"; ?>
            </h3>
            <h3>Overall Total Sales with Discount Factor: ₱<?php echo number_format($overallTotalSales, 2); ?></h3>
        </div>

        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Product Name</td>
                    <td>Category</td>
                    <td>Quantity Sold</td>
                    <td>Total Sales w/o Discount</td>
                </tr>

                <?php if (!empty($salesData)) : ?>
                    <?php foreach ($salesData as $data): ?>
                        <tr>
                            <td><?php echo isset($data['product_name']) ? htmlspecialchars($data['product_name']) : 'N/A'; ?></td>
                            <td><?php echo isset($data['category']) ? htmlspecialchars($data['category']) : 'N/A'; ?></td>
                            <td><?php echo isset($data['total_quantity']) ? htmlspecialchars($data['total_quantity']) : 'N/A'; ?></td>
                            <td>₱<?php echo isset($data['total_sales']) ? number_format($data['total_sales'], 2) : '0.00'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">No sales data found for this period.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
