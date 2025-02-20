<?php
include_once "../../php/suppliers.php";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Supplier Information</title>
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
            <p>Supplier Information</p>
        </div>
        
        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Company Name</td>
                    <td>Contact Person</td>
                    <td>Email</td>
                    <td>Phone Number</td>
                    <td>Business Type</td>
                    <td>Products</td>
                </tr>
                <?php if (!empty($suppliers)) : ?>
                    <?php foreach ($suppliers as $supplier): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($supplier['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['contact_person']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['email']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['business_type']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['products']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No supplier information available.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
