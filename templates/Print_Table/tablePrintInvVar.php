<?php
include_once "../../php/variants.php"; // Assuming variants.php already contains required data

// Use `category_id` to filter the category
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$category_name = getCategoryName($conn, $category_id);
$variants = getVariants($conn, $category_id);

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
            <p> Product Variant Inventory</p>
            <h3>Category: <?php echo htmlspecialchars($category_name); ?></h3>
        </div>

        <div class="table">
            <table>
                <tr class="trheader">
                    <td>Sub Category</td>
                    <td>Product Name</td>
                    <td>Product Description</td>
                    <td>Variant Color</td>
                    <td>Variant Size</td>
                    <td>Variant Price</td>
                    <td>Variant Stock</td>
                    <td>Supplier</td>
                </tr>
                <?php if (!empty($variants)) : ?>
                    <?php foreach ($variants as $variant) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($variant['sub_category_name']); ?></td>
                            <td><?php echo htmlspecialchars($variant['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($variant['product_description']); ?></td>
                            <td><?php echo htmlspecialchars($variant['variant_color']); ?></td>
                            <td><?php echo htmlspecialchars($variant['variant_size']); ?></td>
                            <td><?php echo htmlspecialchars($variant['variant_price']); ?></td>
                            <td><?php echo htmlspecialchars($variant['variant_stock']); ?></td>
                            <td><?php echo htmlspecialchars($variant['supplier']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">No variants found for this category.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
