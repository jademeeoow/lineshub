<?php

include_once "../../php/cancelled.php";

$totalOrdersAmount = 0;


foreach ($cancelledOrders as $order) {
    $totalOrdersAmount += $order['order']['total_amount'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelled Orders</title>
    <link rel="stylesheet" href="../../static/style/orders.css">
    <link rel="stylesheet" href="../../static/style/highlight.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<body>
    <div class="whole">
        <main-header data-image-path="<?php echo $image_path; ?>"></main-header>
        <div class="con">
            <?php

            include_once  "sidemenu.php";

            ?>


            <!-- END OF SIDEMENU -->

            <div class="content">
                <div class="title">
                    <h1>CANCELLED ORDERS</h1>
                </div>
                <div class="marjcontent">
                    <div class="addOrders">
                        <button onclick="openAddOrders()">Add Orders</button>
                    </div>

                    <div class="contool-table">
                        <div class="tabletag">
                            <div class="list" id="list">
                                <p>List Of Order Reports</p>
                            </div>
                            <div class="searchinp" id="searchinp">
                                <input type="text" name="" id="searchInput" placeholder="Search.." spellcheck="false">
                                <i class="fas fa-times" onclick="cancelSearch()"></i>
                            </div>
                        </div>
                        <div class="tabletool">

                            <div class="n">
                                <i class="fas fa-print printicon" onclick="redirectToPrintPage()" target="_blank"></i>
                            </div>

                            <div class="n">
                                <i class="fas fa-search searchicon" onclick="searchToggle()"></i>
                            </div>


                            <div class="n">
                                <div class="calendar-filter-container">
                                    <i class="fas fa-calendar calendar-icon" onclick="filterCalendarShow()"></i>
                                    <div class="filterCalendar">
                                        <div class="top">
                                            <p>Filter by Delivery Date</p>
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
                                </div>
                            </div>
                            <div class="n">
                                <i class="fas fa-filter" onclick="filterColumnShow()"></i>
                                <div class="filterColumn">
                                    <div class="top">
                                        <p>Filter Column</p>
                                        <i class="fas fa-times" onclick="filterColumnHide()"></i>
                                    </div>
                                    <div class="marjcol">
                                        <div class="colWrap" style="display: none;">
                                            <div class="in">
                                                <input type="radio" name="filterPendingAsc" id="ascending" checked>
                                                <label for="ascending">Ascending</label>
                                            </div>
                                            <div class="in">
                                                <input type="radio" name="filterPendingAsc" id="descending">
                                                <label for="descending">Descending</label>
                                            </div>
                                        </div>
                                        <div class="colWrap">
                                            <div class="in">
                                                <input type="radio" name="filterPendingReg" id="all" checked>
                                                <label for="all">All</label>
                                            </div>
                                            <div class="in">
                                                <input type="radio" name="filterPendingReg" id="regular">
                                                <label for="regular">Regular</label>
                                            </div>
                                            <div class="in">
                                                <input type="radio" name="filterPendingReg" id="rush">
                                                <label for="rush">Rush</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table table-pending">
                        <table>
                            <tr class="tableheader">
                                <td>Select</td>

                                <td>Order ID</td>
                                <td>Company Name</td>
                                <td>Customer Name</td>
                                <td style="display: none;">Phone Number</td>
                                <td style="display: none;">House No. & Street Address</td>
                                <td style="display: none;">Barangay</td>
                                <td style="display: none;">Landmark</td>

                                <td style="display: none;">Variant Color</td>
                                <td style="display: none;">Variant Size</td>

                                <td>Regular/Rush</td>
                                <td style="display: none;">Delivery/Pick-up</td>
                                <td style="display: none;">Month</td>
                                <td style="display: none;">Date</td>
                                <td style="display: none;">Year</td>
                                <td>Delivery/Pick-up Date</td>
                                <td>Retrieve</td>
                                <td>View</td>
                                <td>Print</td>
                            </tr>
                            <?php if (empty($cancelledOrders)): ?>
                                <tr>
                                    <td colspan="17">No cancelled orders.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($cancelledOrders as $order): ?>
                                    <tr data-order-id="<?php echo htmlspecialchars($order['order']['order_id']); ?>">
                                        <td>
                                            <i class="far fa-square select-icon"
                                                data-order-id="<?php echo htmlspecialchars($order['order']['order_id']); ?>"
                                                onclick="toggleSelectOrder(this)"></i>
                                        </td>
                                        <td><?php echo htmlspecialchars($order['order']['order_id']); ?></td>
                                        <td><?php echo htmlspecialchars($order['customer']['company_name'] ?? 'None'); ?></td>
                                        <td><?php echo htmlspecialchars($order['customer']['first_name'] . ' ' . $order['customer']['last_name']); ?></td>
                                        <td style="display: none;"><?php echo htmlspecialchars($order['customer']['phone_number']); ?></td>
                                        <td style="display: none;"><?php echo htmlspecialchars($order['customer']['house_no'] . ' ' . $order['customer']['street_address']); ?></td>
                                        <td style="display: none;"><?php echo htmlspecialchars($order['customer']['barangay']); ?></td>
                                        <td style="display: none;"><?php echo htmlspecialchars($order['customer']['landmark']); ?></td>

                                        <td style="display: none;">
                                            <?php foreach ($order['order']['items'] as $item): ?>
                                                <?php echo htmlspecialchars($item['variant_color']); ?><br>
                                            <?php endforeach; ?>
                                        </td>
                                        <td style="display: none;">
                                            <?php foreach ($order['order']['items'] as $item): ?>
                                                <?php echo htmlspecialchars($item['variant_size']); ?><br>
                                            <?php endforeach; ?>
                                        </td>


                                        <td><?php echo htmlspecialchars($order['order']['order_type']); ?></td>
                                        <td style="display: none;"><?php echo htmlspecialchars($order['order']['delivery_method']); ?></td>
                                        <td style="display: none;"><?php echo date('F', strtotime($order['order']['delivery_date'])); ?></td>
                                        <td style="display: none;"><?php echo date('d', strtotime($order['order']['delivery_date'])); ?></td>
                                        <td style="display: none;"><?php echo date('Y', strtotime($order['order']['delivery_date'])); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($order['order']['delivery_date'])); ?></td>

                                        <td>
                                            <button onclick="showConfirmModal('<?php echo htmlspecialchars($order['order']['order_id']); ?>', 'Retrieve'); event.stopPropagation();">Retrieve</button>
                                        </td>

                                        <td>
                                            <i class="fas fa-eye clickable-eye" onclick="redirectToSummary('<?php echo $order['order']['order_id']; ?>'); event.stopPropagation();"></i>
                                        </td>
                                        <td>
                                            <i class="fa-solid fa-print" onclick="populatePrintForm('<?php echo htmlspecialchars($order['order']['order_id']); ?>')"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <button class="tableButton" id="setToPendingButton" onclick="updateSelectedOrdersStatus('Pending')">Retrieve</button>
                            <?php endif; ?>
                        </table>
                        
                    </div>
                    <add-orders-inner class="tabb"></add-orders-inner>

                    <div class="printContainer" id="printContainer" style="display: none; ">
                        <div class="mainPrint">
                            <div class="marginWrap">
                                <div class="printBtn">
                                    <div class="wn">
                                        <img src="../../static/images/logolines.jpg" alt="">
                                        <p>Lines Printing Services</p>
                                    </div>
                                    <button class="yellowButton" onclick="printnow()">Print</button>
                                </div>
                                <div class="ct">

                                    <div class="customerDetails" style="width: 100%;">
                                        <div class="zl">
                                            <p>Order ID: </p><span id="printOrderID"></span>
                                        </div>

                                        <div class="zl">
                                            <p>Delivery Date: </p><span id="printDeliveryDate"></span>
                                        </div>
                                        <div class="zl">
                                            <p>Order: </p><span id="printOrderType"></span>
                                        </div>
                                        <div class="zl">
                                            <p>Instruction: </p><span id="printAdditionalInstructions"></span>
                                        </div>

                                        <div class="zl">
                                            <p>Deliver Or Pickup </p><span id="printDeliveryorPickup"></span>
                                        </div>

                                        <div class="zl">
                                            <p>Status : </p><span id="printStatus"></span>
                                        </div>







                                    </div>

                                    <div class="customerDetails" style="width: 100%;">
                                        <div class="zl">
                                            <p>Company Name: </p><span id="printCompanyName"></span>
                                        </div>
                                        <div class="zl">
                                            <p>Customer Name: </p><span id="printCustomerName"></span>
                                        </div>
                                        <div class="zl">
                                            <p>Phone number: </p><span id="printPhoneNumber"></span>
                                        </div>
                                        <div class="zl">
                                            <p>House No, Street Address: </p><span id="printHouseNoStreet"></span>
                                        </div>
                                        <div class="zl">
                                            <p>Barangay: </p><span id="printBarangay"></span>
                                        </div>
                                        <div class="zl">
                                            <p>Landmark: </p><span id="printLandmark"></span>
                                        </div>

                                    </div>
                                </div>

                                <div class="orderDetailsPrint">
                                    <div class="oD">
                                        <p>Order Details</p>
                                    </div>


                                    <div class="tableOrderDetails">
                                        <table id="printOrderItems">
                                            <tr class="tableheader">
                                                <td>Product Name</td>
                                                <td>Color</td>
                                                <td>Size</td>
                                                <td>Qty.</td>
                                                <td>Price</td>
                                                <td>Sum</td>

                                            </tr>


                                        </table>
                                    </div>
                                </div>


                                <div class="orderFees">

                                    <div class="zl">
                                        <p> Discount (Fees Not Included in the discount): </p><span id="printDiscount"></span>
                                    </div>
                                    <div class="zl">
                                        <p>Rush Fee: </p><span id="printRushFee"></span>
                                    </div>
                                    <div class="zl">
                                        <p>Customization Fee: </p><span id="printCustomizationFee"></span>
                                    </div>
                                    <div class="zl">
                                        <p>Delivery Fee: </p><span id="printDeliveryFee"></span>
                                    </div>

                                    <div class="zl">
                                        <p>Dowpayment: </p><span id="printDownpayment"></span>
                                    </div>

                                    <div class="zl">
                                        <p style="font-weight: bold; font-size:17px;">Total Amount to Pay: </p><span id="printTotalAmount"></span>
                                    </div>
                                </div>

                                <div class="contactDetails">
                                    <p>E Locson Drive, Talon-Talon, Zamboanga City, Zamboanga Del Sur</p>
                                    <p>Call us at 0917 676 5010 / 0917 676 5011</p>
                                    <p>linesprintingservices@gmail.com | Lines Hub (Facebook)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>
    </div>

    <div id="messageModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMessage"></p>
            <button class="yellowButton" id="redirectToOrders" onclick="redirectToSalesOrders()">Go to Orders</button>
        </div>
    </div>
    </div>



    

    <div id="confirmModal" class="modal">
        <div class="modal-content">

            <p id="confirmMessage">Are you sure you want to do this?</p>
            <button class="yellowButton" id="confirmYesBtn">Yes</button>
            <button onclick="closeConfirmModal()">No</button>
        </div>
    </div>


    <div id="statusModal" class="modal">
        <div class="modal-content">
            <p id="statusMessage"></p>
            <button class="yellowButton" onclick="closeStatusModal()">OK</button>
        </div>
    </div>
    <script src="../../static/script/script.js"></script>
    <script src="../../static/script/printfunction.js"></script>
    <script>
        function redirectToPrintPage() {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;
            let url = '../Print_Table/tablePrintCancelled.php';


            if (fromDate || toDate) {
                url += '?';
                if (fromDate) url += `fromDate=${encodeURIComponent(fromDate)}&`;
                if (toDate) url += `toDate=${encodeURIComponent(toDate)}`;
            }

            window.open(url, '_blank');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('messageModal');
            const span = document.querySelector('.close');
            const messageElement = document.getElementById('modalMessage');


            function showModal(message) {
                messageElement.textContent = message;
                modal.style.display = 'block';
            }


            span.onclick = function() {
                modal.style.display = 'none';
            }

            function closeConfirmModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }


        function closeStatusModal() {
            document.getElementById('statusModal').style.display = 'none';
        }

            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            }


            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            const message2 = urlParams.get('message2');

            if (message) {
                showModal(message);
            } else if (message2) {
                showModal(message2);
            }
        });


        function showConfirmModal(orderId, action) {
            currentOrderId = orderId;
            currentAction = action;
            document.getElementById('confirmMessage').textContent = `Are you sure you want to ${action} this order?`;
            document.getElementById('confirmModal').style.display = 'block';
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }



        document.querySelectorAll('input[name="filterPendingAsc"], input[name="filterPendingReg"]').forEach(input => {
            input.addEventListener('change', filterTable);
        });

        document.getElementById('confirmYesBtn').addEventListener('click', function() {
    if (currentOrderId) {
        fetch('../../php/update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                order_id: currentOrderId,
                status: 'Pending',
                admin_id: <?php echo json_encode($_SESSION['admin_id']); ?>
            })
        })
        .then(response => response.json())
        .then(data => {
            let message = '';
            if (data.success) {
                message = 'Order status updated to Pending successfully.';
            } else {
                message = 'Error updating order status: ' + data.error;
            }

   
            document.getElementById('statusMessage').textContent = message;
            document.getElementById('statusModal').style.display = 'block';

            setTimeout(() => {
                location.reload();
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('statusMessage').textContent = 'An error occurred while updating the order status.';
            document.getElementById('statusModal').style.display = 'block';
        });
    }
    closeConfirmModal();
});







        function filterTable() {
            const dueFilterOption = document.querySelector('input[name="dueFilter"]:checked')?.value || 'all';
            const regRushFilterOption = document.querySelector('input[name="filterPendingReg"]:checked')?.id || 'all';

            const tableRows = document.querySelectorAll('.table-pending table tr:not(.tableheader)');
            const today = new Date();


            tableRows.forEach(row => {
                const deliveryDateCell = row.querySelector('td:nth-child(18)');
                const rushRegularCell = row.querySelector('td:nth-child(11)');

                if (!deliveryDateCell || !rushRegularCell) return;

                const deliveryDate = new Date(deliveryDateCell.textContent.trim());
                const orderType = rushRegularCell.textContent.trim().toLowerCase();
                let showRow = true;


                if (dueFilterOption === 'pastDue' && deliveryDate >= today) {
                    showRow = false;
                } else if (dueFilterOption === 'almostDue') {
                    const oneDayBefore = new Date(today);
                    oneDayBefore.setDate(oneDayBefore.getDate() + 1);

                    if (deliveryDate.toDateString() !== oneDayBefore.toDateString()) {
                        showRow = false;
                    }
                }


                if (regRushFilterOption !== 'all' && regRushFilterOption !== orderType) {
                    showRow = false;
                }


                row.style.display = showRow ? '' : 'none';
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const searchContainer = document.getElementById('searchinp');
            const searchInput = document.getElementById('searchInput');
            const listHeader = document.getElementById('list');
            const tableRows = document.querySelectorAll('.table-pending table tr:not(.tableheader)');


            function searchTable() {
                const searchQuery = searchInput.value.toLowerCase().trim();

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(searchQuery) ? '' : 'none';
                });
            }


            function clearSearch() {
                searchInput.value = '';
                tableRows.forEach(row => row.style.display = '');
            }

            function toggleSearch() {
                if (searchContainer.style.display === 'flex') {

                    searchContainer.style.display = 'none';
                    listHeader.style.display = 'block';
                    clearSearch();
                } else {

                    searchContainer.style.display = 'flex';
                    listHeader.style.display = 'none';
                    searchInput.focus();
                }
            }


            function cancelSearch() {
                searchContainer.style.display = 'none';
                listHeader.style.display = 'block';
                clearSearch();
            }


            searchInput.addEventListener('input', searchTable);
            document.querySelector('.fa-times').addEventListener('click', cancelSearch);
            document.querySelector('.searchicon').addEventListener('click', toggleSearch);


            searchContainer.style.display = 'none';
            listHeader.style.display = 'block';
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

                    const columnsInRow = row.querySelectorAll(".filterCalender");
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
            const tableRows = document.querySelectorAll('.table-pending table tr:not(.tableheader)');
            const resetButton = document.getElementById('resetButton');

            function parseDate(dateString) {
                const parsedDate = new Date(dateString);
                if (isNaN(parsedDate)) return null;
                parsedDate.setHours(0, 0, 0, 0);
                return parsedDate;
            }


            function filterTableByDate() {
                const fromDate = parseDate(fromDateInput.value);
                const toDate = parseDate(toDateInput.value);

                if (!fromDate || !toDate) return;

                tableRows.forEach(row => {
                    const deliveryDateCell = row.querySelector('td:nth-last-child(4)');

                    if (!deliveryDateCell) return;

                    const deliveryDate = parseDate(deliveryDateCell.textContent.trim());
                    let showRow = true;

                    if (deliveryDate < fromDate || deliveryDate > toDate) {
                        showRow = false;
                    }

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


        
        let selectedOrderIds = [];


        function toggleSelectOrder(icon) {
            const orderId = icon.getAttribute('data-order-id');

            if (selectedOrderIds.includes(orderId)) {
                selectedOrderIds = selectedOrderIds.filter(id => id !== orderId);
                icon.classList.replace('fa-check-square', 'fa-square');
            } else {
                selectedOrderIds.push(orderId);
                icon.classList.replace('fa-square', 'fa-check-square');
            }


            toggleStatusButtons();
        }




        function toggleStatusButtons() {
            const setToReceivedButton = document.getElementById('setToPendingButton');

            if (selectedOrderIds.length > 0) {
                setToReceivedButton.style.display = 'inline-block';
            } else {
                setToReceivedButton.style.display = 'none';
            }
        }


        function updateSelectedOrdersStatus(status) {
            if (selectedOrderIds.length === 0) {
                alert('Please select at least one order to update the status.');
                return;
            }

            document.getElementById('confirmMessage').textContent = `Are you sure you want to set the status to "${status}" for the selected orders?`;
            document.getElementById('confirmYesBtn').onclick = function() {
                fetch('../../php/update_multiple_order_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            order_ids: selectedOrderIds,
                            status: status,
                            admin_id: <?php echo json_encode($_SESSION['admin_id']); ?>
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        let message = '';


                        if (data.success && data.success_message) {
                            message += data.success_message + '\n';
                        }


                        if (data.error_message) {
                            message += data.error_message;
                        }

                        document.getElementById('statusMessage').textContent = message.trim();
                        document.getElementById('statusModal').style.display = 'block';

                        if (data.success) {
                            setTimeout(() => location.reload(), 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('statusMessage').textContent = 'Error updating order statuses.';
                        document.getElementById('statusModal').style.display = 'block';
                    });

                closeConfirmModal();
            };

            document.getElementById('confirmModal').style.display = 'block';
        }


        document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('order_id'); 

    if (orderId) {
        highlightOrder(orderId);
    }
});

function highlightOrder(orderId) {
    console.log(`Highlighting order ID: ${orderId}`);

    const row = document.querySelector(`tr[data-order-id="${orderId}"]`);

    if (row) {
        console.log(`Row found for order ID: ${orderId}`); 
  
        row.classList.add('highlighted-item');

 
        setTimeout(() => {
            row.classList.remove('highlighted-item');
        },5000);
    } else {
        console.error(`Order with ID ${orderId} not found.`); 
    }
}


    </script>
</body>

</html>