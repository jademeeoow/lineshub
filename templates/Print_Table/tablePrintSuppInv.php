<?php
include_once "../../php/supplies_inventory.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Table</title>
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
          
          <?php if ($selectedYear && $selectedMonth && $selectedMonth != 0): ?>
              <p> Supply Request  Data for <?= date("F", mktime(0, 0, 0, $selectedMonth, 1)); ?> <?= $selectedYear; ?></p>
          <?php elseif ($selectedYear): ?>
              <p>Supply Request  Data for the Entire Year of <?= $selectedYear; ?></p>
          <?php else: ?>
             
          <?php endif; ?>
      </div>
     
        
        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Product Name</td>
                    <td>Variant Color</td>
                    <td>Variant Size</td>
                    <td>Requested Quantity</td>
                    <td>Requested By</td>
                    <td>Request Date</td>
                </tr>

                <?php foreach ($supplyRequests as $request) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($request['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($request['variant_color']); ?></td>
                        <td><?php echo htmlspecialchars($request['variant_size']); ?></td>
                        <td><?php echo htmlspecialchars($request['requested_quantity']); ?></td>
                        <td><?php echo htmlspecialchars($request['admin_name']); ?></td>
                        <td><?php echo date('F-j-Y g:i A', strtotime($request['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
                
                <?php if (empty($supplyRequests)) : ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No supply requests found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
