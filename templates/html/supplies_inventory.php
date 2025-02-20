<?php

include_once "../../php/supplies_inventory.php"



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Supply Inventory</title>
    <link rel="stylesheet" href="../../static/style/product.css">

    <link rel="stylesheet" href="../../static/style/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>

#productRequestTable td {
        text-align: center;  
      
    }
.filterCalendar {
    position: absolute;
    top:50px;
    right: -20px;
    display: none;
    background-color: var(--clr-light);
    box-shadow: var(--shadow);
    z-index: 3;
    padding: 5px;
    width: 293.51px;


}

.yellowButton{
    font-weight: bolder;
    font-size: 1rem;
    cursor: pointer;
    background-color: var(--clr-main);
    padding: 0.8rem;
    transition: all 0.3s ease;
}







.filterCalendar .top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}



.filterCalendar .top i {
    cursor: pointer;

}

.filterCalendar label {
    font-size: 16.17px;
    margin-right: 10px;
}

.filterCalendar input[type="date"] {
    margin-bottom: 10px;
    padding: 8px;
    font-size: 0.9rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}
</style>

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
                    <h1> SUPPLY INVENTORY</h1>
                </div>
                <div class="marjcontent">
                    <div class="rbtn">
                        <div class="rbtn-admin">
                            <input type="radio" name="inventoryBtn" id="inventoryProducts" checked>
                            <label for="inventoryProducts">Products</label>
                        </div>
                        <div class="rbtn-user">
                            <input type="radio" name="inventoryBtn" id="inventoryHistoryOfTheProducts">
                            <label for="inventoryHistoryOfTheProducts">Supply Request</label>
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
                                <i class="fas fa-search searchicon" onclick="searchtoggle()"></i>

                            </div>

                            <div class="n">
                            <i class="fas fa-calendar calendar-icon" onclick="filterCalendarShow()"></i>
                            </div>
                            <div class="filwrap">
                                <i class="fas fa-filter" onclick="toggleFilter()" id="filterIcon" style="background-color: white;"></i>

                                <div class="filterSales" id="filterSales" style="display: none;">
                                    <div class="sales-filter">
                                        <h2>View Data by Month</h2>
                                        <form method="GET" action="supplies_inventory.php" id="salesForm">
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
                   

                    
                    <div class="filterCalendar" style="display: none;">
                                    <div class="top">
                                        <p>Filter by Request Date</p>
                                        <i class="fas fa-times" onclick="filterCalendarHide()"></i>
                                    </div>
                                    <div class="marjcol">
                                        <label for="fromDate">From:</label>
                                        <input type="date" id="fromDate" name="fromDate">
                                        <label for="toDate">To:</label>
                                        <input type="date" id="toDate" name="toDate">
                                        <button id="resetButton" style="font-size:0.8rem;" class="yellowButton" onclick="resetDateFilter()">Reset</button>
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
                                    <td style="text-align: center;">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="supplies_variants.php" method="get" style="margin: 0;">
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

                    <div class="table table-historyProduct" id="productRequestTable">
                        <table class="cat">
                            <tr class="tableheader">

                                <td>Product Name</td>
                                <td>Variant Color</td>
                                <td>Variant Size</td>
                                <td>Requested Quantity</td>
                               
                                <td>Request Date</td>
                                <td>Request Time</td>
                                <td>Requested By</td>
                            </tr>
                            <?php if (!empty($supplyRequests)) : ?>
                                <?php foreach ($supplyRequests as $request) : ?>
                                    <tr>

                                        <td><?php echo htmlspecialchars($request['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($request['variant_color']); ?></td>
                                        <td><?php echo htmlspecialchars($request['variant_size']); ?></td>
                                        <td><?php echo htmlspecialchars($request['requested_quantity']); ?></td>
                                      

                                        <td><?php echo date('F j, Y', strtotime($request['created_at'])); ?></td>
                                        <td><?php echo date('g:i A', strtotime($request['created_at'])); ?></td>
                                        <td><?php echo htmlspecialchars(ucwords(strtolower($request['admin_name']))); ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" style="text-align: center;">No supply requests found.</td>
                                </tr>
                            <?php endif; ?>
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


            window.open(`../Print_Table/tablePrintSuppInv.php?year=${year}&month=${month}`, '_blank');
        }


        var rows = document.querySelectorAll('.category-row');


        rows.forEach(function(row) {
            row.addEventListener('click', function() {

                var url = this.getAttribute('data-url');

                window.location.href = url;
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            const searchInp = document.getElementById('searchinp');
            const searchInputField = document.getElementById('searchInput');
            const productRows = document.querySelectorAll('#table-product tr:not(.tableheader)');
            const requestRows = document.querySelectorAll('#productRequestTable tr:not(.tableheader)');


            function searchtoggle() {
                if (searchInp.style.display === 'flex') {

                    searchInp.style.display = 'none';
                    clearSearch();
                } else {

                    searchInp.style.display = 'flex';
                    searchInputField.focus();
                }
            }


            function clearSearch() {

                const searchInput = document.getElementById('searchInput');
                searchInput.value = '';


                const searchContainer = document.getElementById('searchinp');
                searchContainer.style.display = 'none';

                searchInputField.value = '';
                searchTable();
            }


            function searchTable() {
                const searchQuery = searchInputField.value.toLowerCase();


                productRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let matchFound = Array.from(cells).some(cell =>
                        cell.textContent.toLowerCase().includes(searchQuery)
                    );
                    row.style.display = matchFound ? '' : 'none';
                });


                requestRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let matchFound = Array.from(cells).some(cell =>
                        cell.textContent.toLowerCase().includes(searchQuery)
                    );
                    row.style.display = matchFound ? '' : 'none';
                });
            }


            document.querySelector('.searchicon').addEventListener('click', searchtoggle);
            document.querySelector('.fa-times').addEventListener('click', clearSearch);
            searchInputField.addEventListener('input', searchTable);

        });


        document.addEventListener("DOMContentLoaded", function() {
            const printIcon = document.getElementById('printIcon');
            const productsRadioButton = document.getElementById('inventoryProducts');
            const productRequestRadioButton = document.getElementById('inventoryHistoryOfTheProducts');

            function togglePrintIcon() {
                printIcon.style.display = productRequestRadioButton.checked ? 'inline-block' : 'none';
            }


            togglePrintIcon();


            productsRadioButton.addEventListener('change', togglePrintIcon);
            productRequestRadioButton.addEventListener('change', togglePrintIcon);
        });



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
        })

        function toggleFilter() {
            const filterSales = document.getElementById('filterSales');
            filterSales.style.display = filterSales.style.display === 'none' ? 'flex' : 'none';
        }



        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const view = urlParams.get('view');
            const printIcon = document.getElementById('printIcon');
            const filterIcon = document.getElementById('filterIcon');
            const filterSales = document.getElementById('filterSales');
            const productsRadioButton = document.getElementById('inventoryProducts');
            const productRequestRadioButton = document.getElementById('inventoryHistoryOfTheProducts');
            const productRequestTable = document.getElementById('productRequestTable');
            const productTable = document.getElementById('table-product');


            function toggleIcons() {
                const showIcons = productRequestRadioButton.checked || view === 'history';


                printIcon.style.display = showIcons ? 'inline-block' : 'none';
                filterIcon.style.display = showIcons ? 'inline-block' : 'none';


                filterSales.style.display = 'none';


                productRequestTable.style.display = showIcons ? 'table' : 'none';
                productTable.style.display = !showIcons ? 'table' : 'none';
            }


            if (view === 'history') {
                productRequestRadioButton.checked = true;
            }


            toggleIcons();


            productsRadioButton.addEventListener('change', toggleIcons);
            productRequestRadioButton.addEventListener('change', toggleIcons);
        });

        function toggleFilter() {
            const filterSales = document.getElementById('filterSales');
            filterSales.style.display = filterSales.style.display === 'none' ? 'flex' : 'none';
        }


        function filterCalendarShow() {
            const filterColumns = document.querySelectorAll(".filterCalendar");
            filterColumns.forEach(function(column) {
                column.style.display = "block";
            });
        }


        function filterCalendarHide() {
            const filterColumns = document.querySelectorAll(".filterCalendar");
            filterColumns.forEach(function(column) {
                column.style.display = "none";

                const row = column.closest("tr");
                if (row) {

                    const columnsInRow = row.querySelectorAll(".filterCalendar");
                    const allColumnsHidden = Array.from(columnsInRow).every(col => col.style.display === "none");
                    if (allColumnsHidden) {
                        row.style.display = "none";
                    }
                }
            });
        }


        
        document.addEventListener('DOMContentLoaded', function() {
            const fromDateInput = document.getElementById('fromDate');
            const toDateInput = document.getElementById('toDate');
            const tableRows = document.querySelectorAll('#productRequestTable table tr:not(.tableheader)');

            const resetButton = document.getElementById('resetButton');

            function parseDate(dateString) {
                const parsedDate = new Date(dateString);
                if (isNaN(parsedDate)) {
                    console.error('Invalid date string:', dateString);
                    return null;
                }
                parsedDate.setHours(0, 0, 0, 0);
                return parsedDate;
            }


            function filterTableByDate() {
                const fromDate = parseDate(fromDateInput.value);
                const toDate = parseDate(toDateInput.value);

                console.log('From Date:', fromDate);
                console.log('To Date:', toDate);

                if (!fromDate || !toDate) {
                    tableRows.forEach(row => (row.style.display = ''));
                    return;
                }

                tableRows.forEach(row => {
                    const deliveryDateCell = row.querySelector('td:nth-child(5)');
                    if (!deliveryDateCell) return;

                    const deliveryDate = parseDate(deliveryDateCell.textContent.trim());
                    console.log('Delivery Date:', deliveryDate);

                    const showRow = deliveryDate >= fromDate && deliveryDate <= toDate;
                    row.style.display = showRow ? '' : 'none';
                });
            }





            function resetDateFilter() {
                fromDateInput.value = '';
                toDateInput.value = '';

                tableRows.forEach(row => {
                    row.style.display = '';
                });
            }


            toDateInput.addEventListener('change', filterTableByDate);
            resetButton.addEventListener('click', resetDateFilter);
        });

        document.addEventListener('DOMContentLoaded', function () {
        const calendarIcon = document.querySelector('.calendar-icon');
        const productsRadioButton = document.getElementById('inventoryProducts');
        const supplyRequestRadioButton = document.getElementById('inventoryHistoryOfTheProducts');

        function toggleCalendarIcon() {
    
            if (productsRadioButton.checked) {
                calendarIcon.style.display = 'none';
            } else {
                calendarIcon.style.display = 'inline-block';
            }
        }

 
        toggleCalendarIcon();

    
        productsRadioButton.addEventListener('change', toggleCalendarIcon);
        supplyRequestRadioButton.addEventListener('change', toggleCalendarIcon);
    });
    </script>
</body>

</html>