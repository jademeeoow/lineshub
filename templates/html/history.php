<?php

include_once "../../php/history.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="../../static/style/dashboard.css">
    <link rel="stylesheet" href="../../static/style/orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>
    .history-table th, 
.history-table td {
    border: 1px solid #ccc;
  
}
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
                    <h1>HISTORY</h1>
                </div>
                <div class="marjcontent">
                    <div class="rbtn">
                        <div class="rbtn-admin">
                            <input type="radio" name="rbtnHistory" id="rbtn-button-transaction" checked>
                            <label for="rbtn-button-transaction">Transaction History</label>
                        </div>
                        <div class="rbtn-user">
                            <input type="radio" name="rbtnHistory" id="rbtn-button-login">
                            <label for="rbtn-button-login">Login History</label>
                        </div>
                    </div>


                    <div class="aaaa">
                        <div class="filterCon">
                            <div id="h3s">

                            </div>

                            <div class="searchinp" id="searchinp" style="display: none;">
                                <input type="text" name="" placeholder="Search.." id="searchInput" spellcheck="false" oninput="searchTable()">
                                <i class="fas fa-times" onclick="cancelSearch()"></i>
                            </div>
                            <div class="filwrap">
                                <i class="fas  fa-filter"  onclick="toggleFilter()" id="filterIcon"></i>
                                <div class="filterSales" id="filterSales" style="display: none;">
                                    <div class="sales-filter">
                                        <h2>View Data by Month</h2>
                                        <form method="GET" action="history.php" id="salesForm">
                                            <input type="hidden" name="view" id="viewInput" value="<?php echo $selectedView; ?>">



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

                                <div class="filterCalendar" style="display: none;">
                                    <div class="top">
                                        <p>Filter by  Date</p>
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
                                <i class="fas fa-print" onclick="redirectToPrintPage()" target="_blank" id="printTransIcon" style="display: none;"></i>
                                <i class="fas fa-print" onclick="redirectToPrintPage2()" target="_blank" id="printLoginIcon" style="display: none;"></i>
                            </div>

                        </div>
                    </div>







                    <div class="history-table history-table-transaction">
                        <table id="transactionTable">
                            <tr class="tableheader">
                                <td>Order ID</td>
                                <td>Customer Name</td>
                                <td style="display: none;">Product</td>
                                <td style="display: none;">Quantity</td>

                                <td>Status (Paid or Unpaid or Staggered)</td>
                                <td>Processed by</td>
                                <td>Date</td>
                                <td>Time</td>
                            </tr>

                            <?php foreach ($transactionHistory as $order_id => $order): ?>
                                <?php $row_count = count($order['products']); ?>
                                <tr class="first-row">
                                    <td rowspan="1"><?= htmlspecialchars($order_id); ?></td>
                                    <td rowspan="1"><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($order['customer_name'])))); ?></td>

                                    <td style="display: none;" rowspan="1">
                                        <?php foreach ($order['products'] as $product) : ?>
                                            <?= htmlspecialchars($product['product_name']); ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="display: none;" rowspan="1">
                                        <?php foreach ($order['products'] as $product) : ?>
                                            <?= htmlspecialchars($product['quantity']); ?><br>
                                        <?php endforeach; ?>
                                    </td>


                                    <td rowspan="1">
                                        <?php

                                        if ($order['status'] === 'Received') {

                                            echo 'Fully Paid';
                                        } elseif ($order['downpayment'] > 0 && $order['downpayment'] < $order['total_amount']) {

                                            echo 'Partially Paid';
                                        } elseif ($order['downpayment'] >= $order['total_amount']) {

                                            echo 'Fully Paid';
                                        } else {

                                            echo 'Unpaid';
                                        }
                                        ?>
                                    </td>

                                    </td>
                                    <td rowspan="1"><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($order['processed_by'])))); ?></td>

                                    <?php

                                    $dateTime = new DateTime($order['created_at']);
                                    $date = $dateTime->format('F j, Y'); 
                                    $time = $dateTime->format('g:i A'); 
                                    ?>
                                    <td rowspan="1"><?= htmlspecialchars($date); ?></td>
                                    <td rowspan="1"><?= htmlspecialchars($time); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>


                    <div class="history-table history-table-login">
                        <table id="loginTable">
                            <tr class="tableheader">
                                <td>Admin Name</td>
                                <td>Login Date</td>
                                <td>Login Time</td>
                                <td style="display: none;">Logout Date</td>
                                <td style="display: none;">Logout Time</td>
                            </tr>

                            <?php
                            $loginHistory = fetchLoginHistory();
                            if (!empty($loginHistory)):
                                foreach ($loginHistory as $record):
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($record['first_name'])))); ?></td>

                                        <td><?= htmlspecialchars(date('F j, Y', strtotime($record['login_date']))); ?></td>
                                        <td><?= htmlspecialchars(date('g:i A', strtotime($record['last_login']))); ?></td>

                                        <td style="display: none;"><?= htmlspecialchars(formatDateTime($record['last_logout'])); ?></td>
                                        <td style="display: none;"><?= htmlspecialchars(formatDateTime($record['last_logout'])); ?></td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <tr>
                                    <td colspan="5">No login history found.</td>
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
            window.open(`../Print_Table/tablePrintTransHist.php?year=${year}&month=${month}`, '_blank');
        }

        function redirectToPrintPage2() {
            window.open('../Print_Table/tablePrintLoginHist.php', '_blank');
        }

        function togglePrintIcon() {
            const TransRadio = document.getElementById('rbtn-button-transaction');
            const LoginRadio = document.getElementById('rbtn-button-login');

            const printTransIcon = document.getElementById('printTransIcon');
            const printLoginIcon = document.getElementById('printLoginIcon');

            if (TransRadio.checked) {
                printTransIcon.style.display = 'inline-block';
                printLoginIcon.style.display = 'none';
            } else if (LoginRadio.checked) {
                printTransIcon.style.display = 'none';
                printLoginIcon.style.display = 'inline-block';
            }
        }

        window.onload = function() {
            togglePrintIcon();


            document.getElementById('rbtn-button-transaction').addEventListener('change', togglePrintIcon);
            document.getElementById('rbtn-button-login').addEventListener('change', togglePrintIcon);
        };

        document.addEventListener('DOMContentLoaded', function() {
            const transactionRadio = document.getElementById('rbtn-button-transaction');
            const loginRadio = document.getElementById('rbtn-button-login');
            const transactionTable = document.getElementById('transactionTable');
            const loginTable = document.getElementById('loginTable');
            const searchInput = document.getElementById('searchInput');
            const h3s = document.getElementById('h3s');
            const searchinp = document.getElementById('searchinp');


            transactionRadio.addEventListener('change', function() {
                if (this.checked) {
                    transactionTable.style.display = 'table';
                    loginTable.style.display = 'none';
                    clearSearch();
                }
            });

            loginRadio.addEventListener('change', function() {
                if (this.checked) {
                    transactionTable.style.display = 'none';
                    loginTable.style.display = 'table';
                    clearSearch();
                }
            });


            function toggleSearch() {
                if (searchinp.style.display === 'flex') {
                    h3s.style.display = 'block';
                    searchinp.style.display = 'none';
                    searchInput.value = '';
                    searchTable();
                } else {
                    h3s.style.display = 'none';
                    searchinp.style.display = 'flex';
                    searchInput.focus();
                }
            }


            function cancelSearch() {
                h3s.style.display = 'block';
                searchinp.style.display = 'none';
                searchInput.value = '';
                searchTable();
            }


            function searchTable() {
                const searchQuery = searchInput.value.toLowerCase();
                const activeTable = transactionTable.style.display !== 'none' ? transactionTable : loginTable;
                const rows = activeTable.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let matchFound = false;

                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().includes(searchQuery)) {
                            matchFound = true;
                            break;
                        }
                    }

                    rows[i].style.display = matchFound ? '' : 'none';
                }
            }


            searchInput.addEventListener('input', searchTable);
            document.querySelector('.fas.fa-search').addEventListener('click', toggleSearch);
            document.querySelector('.fas.fa-times').addEventListener('click', cancelSearch);
        });


        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';
            searchTable();
        }

        function toggleFilter() {
            const filterSales = document.getElementById('filterSales');
            filterSales.style.display = filterSales.style.display === 'none' ? 'flex' : 'none';
        }

        function toggleFilterVisibility() {
            const transRadio = document.getElementById('rbtn-button-transaction');
            const filterIcon = document.getElementById('filterIcon');
            const filterSales = document.getElementById('filterSales');

            if (transRadio.checked) {
                filterIcon.style.display = 'none';
                filterSales.style.display = 'none';
            } else {
                filterIcon.style.display = 'none';
                filterSales.style.display = 'none';
            }
        }

        window.onload = function() {
            togglePrintIcon();
            toggleFilterVisibility();

            document.getElementById('rbtn-button-transaction').addEventListener('change', () => {
                togglePrintIcon();
                toggleFilterVisibility();
            });
            document.getElementById('rbtn-button-login').addEventListener('change', () => {
                togglePrintIcon();
                toggleFilterVisibility();
            });
        };



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
    const transactionTableRows = document.querySelectorAll('#transactionTable tr:not(.tableheader)');
    const loginTableRows = document.querySelectorAll('#loginTable tr:not(.tableheader)');
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
            showAllRows();
            return;
        }

        if (document.getElementById('rbtn-button-transaction').checked) {
            filterTransactionTable(fromDate, toDate);
        } else if (document.getElementById('rbtn-button-login').checked) {
            filterLoginTable(fromDate, toDate);
        }
    }

    function filterTransactionTable(fromDate, toDate) {
        transactionTableRows.forEach(row => {
            const dateCell = row.querySelector('td:nth-child(7)'); 
            if (!dateCell) return;

            const transactionDate = parseDate(dateCell.textContent.trim());
            console.log('Transaction Date:', transactionDate);

            const showRow = transactionDate >= fromDate && transactionDate <= toDate;
            row.style.display = showRow ? '' : 'none';
        });
    }

    function filterLoginTable(fromDate, toDate) {
        loginTableRows.forEach(row => {
            const dateCell = row.querySelector('td:nth-child(2)');
            if (!dateCell) return;

            const loginDate = parseDate(dateCell.textContent.trim());
            console.log('Login Date:', loginDate);

            const showRow = loginDate >= fromDate && loginDate <= toDate;
            row.style.display = showRow ? '' : 'none';
        });
    }

    function showAllRows() {
        transactionTableRows.forEach(row => row.style.display = '');
        loginTableRows.forEach(row => row.style.display = '');
    }

    function resetDateFilter() {
        fromDateInput.value = '';
        toDateInput.value = '';
        showAllRows();
    }


    toDateInput.addEventListener('change', filterTableByDate);
    resetButton.addEventListener('click', resetDateFilter);
});

      
    </script>




</body>

</html>