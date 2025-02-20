<?php

include_once "../../php/sales.php";



$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : date("m");

$overallTotalSales = fetchOverallTotalSales($selectedYear, $selectedMonth);
$monthlySalesData = fetchSalesForMonth($selectedYear, $selectedMonth);
$monthlyOrdersData = fetchPaidAndUnderpaidOrdersForMonth($selectedYear, $selectedMonth);
$selectedView = isset($_GET['view']) ? $_GET['view'] : 'Sales';


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Orders</title>
    <link rel="stylesheet" href="../../static/style/dashboard.css">
    <link rel="stylesheet" href="../../static/style/orders.css">
    <link rel="stylesheet" href="../../static/style/sales.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>
<style>







</style>

<body>
    <div class="whole">
        <main-header data-image-path="<?php echo $image_path; ?>" data-role="<?php echo $_SESSION['role']; ?>"></main-header>
        <div class="con">

            <?php

            include_once  "sidemenu.php";

            ?>


            <!-- END OF SIDEMENU -->


            <div class="content">
                <div class="title">
                    <h1>SALES & ORDERS</h1>
                </div>

                <div class="marjcontent">
                    <div class="totalsales" id="netSalesContainer">
                        <p>Net Sales: ₱<a><?php echo number_format($overallTotalSales, 2); ?></a></p>
                    </div>

                    <div class="rbtn">
                        <div class="rbtn-admin">
                            <input type="radio" name="dataBtn" id="Sales" <?php echo $selectedView == 'Sales' ? 'checked' : ''; ?>>
                            <label for="Sales">Sales</label>
                        </div>
                        <div class="rbtn-user">
                            <input type="radio" name="dataBtn" id="Orders" <?php echo $selectedView == 'Orders' ? 'checked' : ''; ?>>
                            <label for="Orders">Orders</label>
                        </div>
                    </div>

                    <div class="aaaa">
                        <div class="filterCon">
                            <div id="h3s">
                                <?php
                                if ($selectedMonth == 0) {

                                    echo "Viewing Data for Entire Year $selectedYear";
                                } else {

                                    $monthName = date("F", mktime(0, 0, 0, $selectedMonth, 1));
                                    echo "Viewing Data for $monthName $selectedYear";
                                }
                                ?>
                            </div>

                            <div class="searchinp" id="searchinp" style="display: none;">
                                <input type="text" name="" placeholder="Search.." id="searchInput" spellcheck="false">
                                <i class="fas fa-times" onclick="cancelSearch()"></i>
                            </div>
                            <div class="filwrap">
                                <i class="fas fa-filter" onclick="toggleFilter()"></i>
                                <div class="filterSales" id="filterSales" style="display: none;">
                                    <div class="sales-filter">
                                        <h2>View Data by Month</h2>
                                        <form method="GET" action="sales.php" id="salesForm">
                                            <input type="hidden" name="view" id="viewInput" value="<?php echo isset($_GET['view']) ? $_GET['view'] : 'Sales'; ?>">

                                            <label for="year">Year:</label>
                                            <select name="year" id="year" onchange="document.getElementById('salesForm').submit();">
                                                <?php
                                                $startYear = 2025;
                                                $currentYear = date("Y");
                                                $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : $currentYear;
                                                for ($i = $currentYear; $i >= $startYear; $i--) : ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $selectedYear) ? 'selected' : ''; ?>>
                                                        <?php echo $i; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>

                                            <label for="month">Month:</label>
                                            <select name="month" id="month" onchange="document.getElementById('salesForm').submit();">
                                                <?php
                                                $selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : date("n");
                                                for ($m = 1; $m <= 12; $m++) : ?>
                                                    <option value="<?php echo $m; ?>" <?php echo ($m == $selectedMonth) ? 'selected' : ''; ?>>
                                                        <?php echo date("F", mktime(0, 0, 0, $m, 1)); ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </form>
                                    </div>



                                    <div class="filterOrders" id="filterOrders">
                                        <div>
                                            <input type="radio" name="filterOrders" id="allorders" checked>
                                            <label for="allorders">All</label>
                                        </div>

                                        <div>
                                            <input type="radio" name="filterOrders" id="ounpaid">
                                            <label for="ounpaid"> Unpaid</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="filterOrders" id="fopaid">
                                            <label for="fopaid"> Fully Paid</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="filterOrders" id="founpaid">
                                            <label for="founpaid">Partially Paid</label>
                                        </div>

                                    </div>
                                </div>



                                <div class="filterCalendar" style="display: none;">
                                    <div class="top">
                                        <p id="filterTitle">Filter by Date</p>
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

                                <i class="fas fa-calendar calendar-icon" onclick="filterCalendarShow()"></i>

                                <i class="fas fa-search" onclick="toggleSearch()"></i>

                                <i class="fas fa-print" onclick="redirectToPrintPage()" target="_blank" id="printSalesIcon" style="display: none;"></i>
                                <i class="fas fa-print" onclick="redirectToPrintPage2()" target="_blank" id="printOrdersIcon" style="display: none;"></i>

                            </div>
                        </div>


                        <!-- Sales Table -->
                        <div class="sales-table" id="tableForSales">
                            <table>
                                <tr class="tableheader">
                                <td>Category</td>
                                    <td>Product Name</td>
                                 
                                    <td>Quantity Sold</td>
                                    <td>Total Sales w/o Discount</td>
                                    <td style="display: none;">Order Date</td>
                                </tr>
                                <?php if (!empty($monthlySalesData)) : ?>
                                    <?php foreach ($monthlySalesData as $data) : ?>
                                        <tr>
                                        <td><?php echo htmlspecialchars($data['category']); ?></td>
                                            <td><?php echo htmlspecialchars($data['product_name']); ?></td>
                                           
                                            <td><?php echo htmlspecialchars($data['total_quantity']); ?></td>
                                            <td>₱<?php echo number_format($data['total_sales'], 2); ?></td>
                                            <td style="display: none;"><?php echo date("F d, Y", strtotime($data['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5">No sales data found for this month</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>


                        <!-- ordertable -->

                        <div class="sales-table" style="cursor:pointer;" id="tableForOrders" style="display: none;">
                            <table>
                                <tr class="tableheader">
                                    <td>Order ID</td>
                                    <td>Customer Name</td>
                                    <td>Order Date</td>
                                    <td>Delivery Date</td>
                                    <td>Item Price</td>
                                    <td>Rush Fee</td>
                                    <td>Customization Fee</td>
                                    <td>Delivery Fee</td>
                                    <td>Discount</td>
                                    <td>Downpayment</td>
                                    <td>Net Balance</td>
                                    <td>Payment Method</td>
                                    <td>Status</td>
                                    <td>Payment Status</td>

                                </tr>
                                <?php if (!empty($monthlyOrdersData)) : ?>
                                    <?php foreach ($monthlyOrdersData as $order) : ?>

                                        <?php
                                        $paymentStatus = "Unpaid";


                                        if (strtolower($order['status']) === 'delivered') {
                                            $totalPaid = $order['total_balance'];
                                            $remainingBalance = 0;
                                            $paymentStatus = " Fully Paid";
                                        } else {
                                            $totalPaid = $order['downpayment'];
                                            $remainingBalance = $order['remaining_balance'];


                                            if ($totalPaid >= $order['total_balance']) {
                                                $paymentStatus = "Paid";
                                            } elseif ($totalPaid > 0) {
                                                $paymentStatus = "Partially Paid";
                                            } else {
                                                $paymentStatus = "Unpaid";
                                            }
                                        }
                                        ?>

                                        <tr
                                            data-order-id="<?php echo htmlspecialchars($order['order_id']); ?>"
                                            data-status="<?php echo strtolower(htmlspecialchars($order['status'])); ?>"
                                            ondblclick="redirectToOrder(this)">

                                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                            <td><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></td>
                                            <td><?php echo date("F-d-Y", strtotime($order['created_at'])); ?></td>
                                            <td><?php echo date("F-d-Y", strtotime($order['delivery_date'])); ?></td>
                                            <td>₱<?php echo number_format($order['base_price'], 2); ?></td>
                                            <td>₱<?php echo number_format($order['rush_fee'], 2); ?></td>
                                            <td>₱<?php echo number_format($order['customization_fee'], 2); ?></td>
                                            <td>₱<?php echo number_format($order['delivery_fee'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($order['discount']); ?></td>
                                            <td>₱<?php echo number_format($order['downpayment'], 2); ?></td>
                                            <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($order['payment_mode']); ?></td>

                                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                                            <td><?php echo htmlspecialchars($paymentStatus); ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="14">No orders found for this month</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>
    </div>

    <script src="../../static/script/script.js"></script>

    <script>
        function redirectToPrintPage() {
            const selectedYear = document.getElementById('year').value;
            const selectedMonth = document.getElementById('month').value;
            const overallTotalSales = <?php echo json_encode(number_format($overallTotalSales, 2)); ?>;
            const monthlySalesData = <?php echo json_encode($monthlySalesData); ?>;

            const encodedSalesData = encodeURIComponent(JSON.stringify(monthlySalesData));
            window.open(`../Print_Table/tablePrintSales.php?year=${selectedYear}&month=${selectedMonth}&overallTotalSales=${overallTotalSales}&salesData=${encodedSalesData}`, '_blank');
        }


        function redirectToPrintPage2() {
            const selectedYear = document.getElementById('year').value;
            const selectedMonth = document.getElementById('month').value;
            const monthlyOrdersData = <?php echo json_encode($monthlyOrdersData); ?>;

            const encodedOrdersData = encodeURIComponent(JSON.stringify(monthlyOrdersData));
            window.open(`../Print_Table/tablePrintOrders.php?year=${selectedYear}&month=${selectedMonth}&ordersData=${encodedOrdersData}`, '_blank');
        }



        function togglePrintIcon() {
            const salesRadio = document.getElementById('Sales');
            const ordersRadio = document.getElementById('Orders');

            const printSalesIcon = document.getElementById('printSalesIcon');
            const printOrdersIcon = document.getElementById('printOrdersIcon');

            if (salesRadio.checked) {
                printSalesIcon.style.display = 'inline-block';
                printOrdersIcon.style.display = 'none';
            } else if (ordersRadio.checked) {
                printSalesIcon.style.display = 'none';
                printOrdersIcon.style.display = 'inline-block';
            }
        }


        window.onload = function() {
            togglePrintIcon();


            document.getElementById('Sales').addEventListener('change', togglePrintIcon);
            document.getElementById('Orders').addEventListener('change', togglePrintIcon);
        };


        document.getElementById('year').addEventListener('change', function() {
            updateViewInput();
            document.getElementById('salesForm').submit();
        });

        document.getElementById('month').addEventListener('change', function() {
            updateViewInput();
            document.getElementById('salesForm').submit();
        });

        function updateViewInput() {
            const salesRadio = document.getElementById('Sales');
            const ordersRadio = document.getElementById('Orders');
            const viewInput = document.getElementById('viewInput');



            if (salesRadio.checked) {
                viewInput.value = 'Sales';
            } else if (ordersRadio.checked) {
                viewInput.value = 'Orders';
            }
        }


        const salesRadio = document.getElementById('Sales');
        const ordersRadio = document.getElementById('Orders');
        const tableForSales = document.getElementById('tableForSales');
        const tableForOrders = document.getElementById('tableForOrders');

        const filterOrders = document.getElementById('filterOrders');
        const salesH3 = document.getElementById('salesH3');
        const ordersH3 = document.getElementById('ordersH3');

        salesRadio.addEventListener('change', function() {


            if (this.checked) {
                tableForSales.style.display = 'block';
                tableForOrders.style.display = 'none';
                filterOrders.style.display = 'none';
                updateViewInput();
            }
        });



        ordersRadio.addEventListener('change', function() {
            if (this.checked) {
                tableForSales.style.display = 'none';
                tableForOrders.style.display = 'block';
                filterOrders.style.display = 'flex';
                updateViewInput();
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            if (salesRadio.checked) {
                tableForSales.style.display = 'block';
                tableForOrders.style.display = 'none';
                filterOrders.style.display = 'none';
            } else if (ordersRadio.checked) {
                tableForSales.style.display = 'none';
                tableForOrders.style.display = 'block';
                filterOrders.style.display = 'flex';
            }


            filterAndSearchData();
        });
    </script>
    <script>
        function toggleFilter() {
            const filterSales = document.getElementById('filterSales');
            if (filterSales.style.display === 'none') {
                filterSales.style.display = 'flex';
            } else {
                filterSales.style.display = 'none';
            }
        }






        function toggleSearch() {
            const h3s = document.getElementById('h3s');
            const searchinp = document.getElementById('searchinp');
            const searchInputField = document.getElementById('searchInput');


            if (searchinp.style.display === 'flex') {
                searchinp.style.display = 'none';
                h3s.style.display = 'block';
                clearSearch();
            } else {
                searchinp.style.display = 'flex';
                h3s.style.display = 'none';
                searchInputField.focus();
            }
        }

        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';


            const allOrdersRadio = document.getElementById('allorders');
            allOrdersRadio.checked = true;


            const orderRows = document.querySelectorAll('#tableForOrders tr:not(.tableheader)');
            orderRows.forEach(row => row.style.display = '');

            const salesRows = document.querySelectorAll('#tableForSales tr:not(.tableheader)');
            salesRows.forEach(row => row.style.display = '');
        }

        function filterAndSearchOrders() {
            const searchQuery = document.getElementById('searchInput').value.toLowerCase().trim();
            const allOrdersRadio = document.getElementById('allorders').checked;
            const paidOrdersRadio = document.getElementById('fopaid').checked;
            const unpaidOrdersRadio = document.getElementById('founpaid').checked;
            const ounpaidOrdersRadio = document.getElementById('ounpaid').checked;

            const tableRows = document.querySelectorAll('#tableForOrders tr:not(.tableheader)');

            tableRows.forEach(row => {
                const paymentStatus = row.querySelector('td:nth-child(14)').textContent.trim();
                const customerName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const orderId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();

                let matchesFilter = false;
                let matchesSearch = false;


                if (allOrdersRadio) {
                    matchesFilter = true;
                } else if (paidOrdersRadio && paymentStatus === 'Fully Paid') {
                    matchesFilter = true;
                } else if (unpaidOrdersRadio && paymentStatus === 'Partially Paid') {
                    matchesFilter = true;

                } else if (ounpaidOrdersRadio && paymentStatus === 'Unpaid') {
                    matchesFilter = true;
                }




                if (customerName.includes(searchQuery) || orderId.includes(searchQuery)) {
                    matchesSearch = true;
                }


                if (matchesFilter && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterAndSearchSales() {
            const searchQuery = document.getElementById('searchInput').value.toLowerCase().trim();

            const salesRows = document.querySelectorAll('#tableForSales tr:not(.tableheader)');

            salesRows.forEach(row => {



                const productName = row.querySelector('td:nth-child(1)').textContent.toLowerCase().trim().replace(/\s+/g, ' ');
                const category = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim().replace(/\s+/g, ' ');

                const normalizedSearchQuery = searchQuery.replace(/\s+/g, ' ');

                let matchesSearch = false;

                if (productName.includes(normalizedSearchQuery) || category.includes(normalizedSearchQuery)) {
                    matchesSearch = true;
                }

                row.style.display = matchesSearch ? '' : 'none';
            });
        }


        function filterAndSearchData() {
            if (salesRadio.checked) {
                filterAndSearchSales();
            } else if (ordersRadio.checked) {
                filterAndSearchOrders();
            }
        }

        function cancelSearch() {
            const h3s = document.getElementById('h3s');
            const searchinp = document.getElementById('searchinp');


            if (h3s.style.display === 'none') {
                h3s.style.display = 'block';
                searchinp.style.display = 'none';
            } else {
                h3s.style.display = 'none';
                searchinp.style.display = 'flex';
            }

            clearSearch();
        }


        document.addEventListener('DOMContentLoaded', function() {
            const allOrdersRadio = document.getElementById('allorders');
            const paidOrdersRadio = document.getElementById('fopaid');
            const unpaidOrdersRadio = document.getElementById('founpaid');
            const ounpaidOrdersRadio = document.getElementById('ounpaid');
            const searchInput = document.getElementById('searchInput');

            allOrdersRadio.addEventListener('change', filterAndSearchOrders);
            paidOrdersRadio.addEventListener('change', filterAndSearchOrders);
            ounpaidOrdersRadio.addEventListener('change', filterAndSearchOrders);
            unpaidOrdersRadio.addEventListener('change', filterAndSearchOrders);
            searchInput.addEventListener('input', filterAndSearchData);


            filterAndSearchData();
        });



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
            const salesRadio = document.getElementById('Sales');
            const ordersRadio = document.getElementById('Orders');


            toggleCalendarIconVisibility();


            salesRadio.addEventListener('change', toggleCalendarIconVisibility);
            ordersRadio.addEventListener('change', toggleCalendarIconVisibility);
        });






        document.addEventListener('DOMContentLoaded', function() {
            const fromDateInput = document.getElementById('fromDate');
            const toDateInput = document.getElementById('toDate');
            const resetButton = document.getElementById('resetButton');
            const filterTitle = document.querySelector('.filterCalendar .top p');
            const salesRadio = document.getElementById('Sales');
            const ordersRadio = document.getElementById('Orders');
            const netSalesElement = document.querySelector('.totalsales a');

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

                // Ensure both dates are selected before proceeding
                if (!fromDate || !toDate) {
                    return;
                }

                const adjustedToDate = new Date(toDate);
                adjustedToDate.setHours(23, 59, 59, 999);

                if (salesRadio.checked) {
                    document.querySelectorAll('#tableForSales tr:not(.tableheader)').forEach(row => {
                        const salesDateCell = row.querySelector('td:nth-child(5)');
                        if (!salesDateCell) return;
                        const salesDate = parseDate(salesDateCell.textContent.trim());

                        const showRow = salesDate >= fromDate && salesDate <= adjustedToDate;
                        row.style.display = showRow ? '' : 'none';
                    });
                } else if (ordersRadio.checked) {
                    document.querySelectorAll('#tableForOrders tr:not(.tableheader)').forEach(row => {
                        const deliveryDateCell = row.querySelector('td:nth-child(4)');
                        if (!deliveryDateCell) return;
                        const deliveryDate = parseDate(deliveryDateCell.textContent.trim());

                        const showRow = deliveryDate >= fromDate && deliveryDate <= adjustedToDate;
                        row.style.display = showRow ? '' : 'none';
                    });
                }

                updateNetSales(fromDateInput.value, toDateInput.value);
            }

            function updateNetSales(fromDate, toDate) {
                if (!fromDate || !toDate) {
                    return;
                }

                fetch(`sales.php?fromDate=${fromDate}&toDate=${toDate}&view=${salesRadio.checked ? 'Sales' : 'Orders'}`)
                    .then(response => response.json())
                    .then(data => {
                        const totalSales = parseFloat(data.overallTotalSales);
                        netSalesElement.textContent = `${new Intl.NumberFormat('en-PH', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(totalSales)}`;
                    })
                    .catch(error => console.error('Error fetching net sales:', error));
            }

            function resetDateFilter() {
                fromDateInput.value = '';
                toDateInput.value = '';
                document.querySelectorAll('tr').forEach(row => row.style.display = '');
                updateNetSales('all', 'all');
            }

            function updateFilterTitle() {
                filterTitle.textContent = salesRadio.checked ? 'Filter by Date' : 'Filter by Delivery Date';
            }

            fromDateInput.addEventListener('change', filterTableByDate);
            toDateInput.addEventListener('change', filterTableByDate);
            resetButton.addEventListener('click', resetDateFilter);

            salesRadio.addEventListener('change', updateFilterTitle);
            ordersRadio.addEventListener('change', updateFilterTitle);

            updateFilterTitle();
        });



        function redirectToOrder(row) {
            const orderId = row.getAttribute('data-order-id');
            const status = row.getAttribute('data-status');
            let targetFile = '';


            switch (status) {
                case 'pending':
                    targetFile = 'pending.php';
                    break;
                case 'to deliver':
                    targetFile = 'todeliver.php';
                    break;
                case 'delivered':

                    targetFile = 'received.php';
                    break;
                case 'cancelled':
                    targetFile = 'cancelled.php';
                    break;
                case 'returned':
                    targetFile = 'returned.php';
                    break;
                default:
                    alert('Unknown order status.');
                    return;
            }


            row.classList.add('highlighted-item');


            setTimeout(() => {
                window.location.href = `/templates/html/${targetFile}?order_id=${orderId}`;
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            const salesRadio = document.getElementById('Sales');
            const ordersRadio = document.getElementById('Orders');
            const filterTitle = document.getElementById('filterTitle');

            function updateFilterTitle() {
                if (salesRadio.checked) {
                    filterTitle.textContent = "Filter by Date";
                } else if (ordersRadio.checked) {
                    filterTitle.textContent = "Filter by Delivery Date";
                }
            }

            salesRadio.addEventListener('change', updateFilterTitle);
            ordersRadio.addEventListener('change', updateFilterTitle);

            updateFilterTitle();
        });


        document.addEventListener('DOMContentLoaded', function() {
            const salesRadio = document.getElementById('Sales');
            const ordersRadio = document.getElementById('Orders');
            const netSalesContainer = document.getElementById('netSalesContainer');

            function toggleNetSalesVisibility() {
                if (salesRadio.checked) {
                    netSalesContainer.style.display = 'flex';
                } else if (ordersRadio.checked) {
                    netSalesContainer.style.display = 'none';
                }
            }

            salesRadio.addEventListener('change', toggleNetSalesVisibility);
            ordersRadio.addEventListener('change', toggleNetSalesVisibility);

            toggleNetSalesVisibility();
        });
    </script>
</body>

</html>