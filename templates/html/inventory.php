<?php

include_once "../../php/inventory.php"



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="../../static/style/product.css">
    <link rel="stylesheet" href="../../static/style/dashboard.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<body>
    <div class="notifTooltipCon">
        <p>hvjhvjhvjh</p>
    </div>
    <div class="whole">
        <main-header data-image-path="<?php echo $image_path; ?>" data-role="<?php echo $_SESSION['role']; ?>"></main-header>
        <div class="con">
            <?php

            include_once  "sidemenu.php";

            ?>


            <!-- END OF SIDEMENU -->

            <div class="content">
                <div class="title">
                    <h1>INVENTORY</h1>
                </div>
                <div class="marjcontent">
                    <div class="rbtn">
                        <div class="rbtn-admin">
                            <input type="radio" name="inventoryBtn" id="inventoryProducts" <?php echo $selectedView === 'products' ? 'checked' : ''; ?>>
                            <label for="inventoryProducts">Products</label>
                        </div>
                        <div class="rbtn-user" style="display: none;">
                            <input type="radio" name="inventoryBtn" id="inventoryHistoryOfTheProducts" <?php echo $selectedView === 'history' ? 'checked' : ''; ?>>
                            <label for="inventoryHistoryOfTheProducts">History Of The Products</label>
                        </div>
                    </div>



                    <div class="contool-table">
                        <div class="tabletag">
                            <div class="list" id="list">

                            </div>
                            <div class="searchinp" id="searchinp">
                                <input type="text" id="searchInput" placeholder="Search.." oninput="searchTable()">
                                <i class="fas fa-times" onclick="clearSearch()"></i>
                            </div>

                        </div>



                        <div class="tabletool">
                            <div class="n">
                                <i class="fas fa-print" id="printIcon" onclick="redirectToPrintPage()" target="_blank"></i>
                            </div>

                            <div class="n">
                                <i class="fas fa-search searchicon" onclick="searchToggle()"></i>

                            </div>

                            <div class="n">





                                <div id="h3s">

                                </div>

                                <div class="searchinp" id="searchinp" style="display: none;">
                                    <input type="text" name="" placeholder="Search.." id="searchInput" spellcheck="false" oninput="searchTable()">

                                    <i class="fas fa-times" onclick="cancelSearch()"></i>

                                </div>

                                <div class="filwrap">
                                    <i class="fas fa-filter" onclick="toggleFilter()" id="filterIcon" style="background-color: white;"></i>

                                    <div class="filterSales" id="filterSales" style="display: none;">
                                        <div class="sales-filter">
                                            <h2>View Data by Month</h2>
                                            <form method="GET" action="inventory.php" id="salesForm">
                                                <input type="hidden" name="view" id="viewInput" value="history">



                                                <label for="year">Year:</label>
                                                <select name="year" id="year">
                                                    <?php
                                                    $startYear = 2024;
                                                    $currentYear = date("Y");
                                                    for ($i = $currentYear; $i >= $startYear; $i--): ?>
                                                        <option value="<?php echo $i; ?>" <?php echo $i == $selectedYear ? 'selected' : ''; ?>>
                                                            <?php echo $i; ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>

                                                <label for="month">Month:</label>
                                                <select name="month" id="month" onchange="document.getElementById('salesForm').submit();">
                                                    <option value="0" <?php echo $selectedMonth == 0 ? 'selected' : ''; ?>>All</option>
                                                    <?php for ($m = 1; $m <= 12; $m++): ?>
                                                        <option value="<?php echo $m; ?>" <?php echo $m == $selectedMonth ? 'selected' : ''; ?>>
                                                            <?php echo date("F", mktime(0, 0, 0, $m, 1)); ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>








                    <div class="table table-product" id="table-product">
                        <table class="cat">
                            <tr class="tableheader">
                                <td style="text-align: center;">Category</td>
                                <td style="text-align: center;">View</td> 
                            </tr>

                            <?php foreach ($categories as $category) : ?>
                                <tr >
                                    <td  style="text-align: center;">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="variants.php" method="get" style="margin: 0;">
                                            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                            <button type="submit" class="view-button">
                                                View
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                    <div class="table table-historyProduct">
                        <table>
                            <tr class="tableheader">
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
                            <?php foreach ($productHistory as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($item['category_name'])))); ?></td>

                                    <td><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($item['product_name'])))); ?></td>

                                    <td><?php echo htmlspecialchars($item['variant_size']); ?></td>
                                    <td><?php echo htmlspecialchars($item['variant_color']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($item['variant_price']); ?></td>
                                    <td><?php echo htmlspecialchars($item['supplier_name']); ?></td>

                                    <td><?php echo htmlspecialchars(date('F-d-Y g:i A', strtotime($item['order_date']))); ?></td>

                                    <td><?php echo htmlspecialchars($item['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>

                </div>
            </div>
            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>
    </div>
    <script src="../../static/script/script.js"></script>

    <script>
        function redirectToPrintPage() {
            const year = document.getElementById('year').value;
            const month = document.getElementById('month').value;

            window.open(`../Print_Table/tablePrintInvHist.php?year=${year}&month=${month}`, '_blank');
        }


        var rows = document.querySelectorAll('.category-row');


        rows.forEach(function(row) {
            row.addEventListener('click', function() {

                var url = this.getAttribute('data-url');

                window.location.href = url;
            });
        });



        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('table tr:not(.tableheader)');

            rows.forEach(row => {

                const cells = row.querySelectorAll('td');
                let matchFound = false;

                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchInput)) {
                        matchFound = true;
                    }
                });


                row.style.display = matchFound ? '' : 'none';
            });


            const currentFilter = document.querySelector('input[name="categoryFilter"]:checked').value;
            filterCategories(currentFilter);
        }


        function clearSearch() {

            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';


            const searchContainer = document.getElementById('searchinp');
            searchContainer.style.display = 'none';

            searchTable();
            filterStock('all');
        }

        function searchToggle() {
            const searchInput = document.getElementById('searchInput');
            const searchContainer = document.getElementById('searchinp');

            if (searchContainer.style.display === 'flex') {

                searchContainer.style.display = 'none';
                searchInput.value = '';
                searchTable();
            } else {

                searchContainer.style.display = 'flex';
                searchInput.focus();
            }
        }


        function togglePrintIcon() {
            const printIcon = document.getElementById('printIcon');
            const historyRadioButton = document.getElementById('inventoryHistoryOfTheProducts');

            printIcon.style.display = historyRadioButton.checked ? 'inline-block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {

            togglePrintIcon();

            document.getElementById('inventoryProducts').addEventListener('change', togglePrintIcon);
            document.getElementById('inventoryHistoryOfTheProducts').addEventListener('change', togglePrintIcon);
        });

        var rows = document.querySelectorAll('.category-row');
        rows.forEach(function(row) {
            row.addEventListener('click', function() {
                var url = this.getAttribute('data-url');
                window.location.href = url;
            });
        });

        function toggleFilter() {
            const filterSales = document.getElementById('filterSales');
            filterSales.style.display = filterSales.style.display === 'none' ? 'flex' : 'none';
        }

        function toggleIcons() {
            const printIcon = document.getElementById('printIcon');
            const filterIcon = document.getElementById('filterIcon');
            const historyRadioButton = document.getElementById('inventoryHistoryOfTheProducts');

            const showIcons = historyRadioButton.checked;
            printIcon.style.display = showIcons ? 'inline-block' : 'none';
            filterIcon.style.display = showIcons ? 'inline-block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleIcons();
            document.getElementById('inventoryProducts').addEventListener('change', toggleIcons);
            document.getElementById('inventoryHistoryOfTheProducts').addEventListener('change', toggleIcons);
        });


        function updateViewInput() {
            const viewInput = document.getElementById('viewInput');
            const historyRadioButton = document.getElementById('inventoryHistoryOfTheProducts');
            viewInput.value = historyRadioButton.checked ? 'history' : 'products';
        }

        document.getElementById('inventoryProducts').addEventListener('change', updateViewInput);
        document.getElementById('inventoryHistoryOfTheProducts').addEventListener('change', updateViewInput);
    </script>
</body>

</html>