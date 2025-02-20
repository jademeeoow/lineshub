<?php

include_once "../../php/pending.php";


$totalOrdersAmount = 0;


foreach ($pendingOrders as $order) {
    $totalOrdersAmount += $order['order']['total_amount'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
    <link rel="stylesheet" href="../../static/style/orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>


</style>

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
                    <h1>PENDING ORDERS</h1>
                </div>
                <div class="marjcontent">
                    <div class="addOrders">
                        <button class="yellowButton" onclick="openAddOrders()">Add Orders</button>
                    </div>

                    <div class="contool-table">
                        <div class="tabletag">
                            <div class="list" id="list">
                                <p>List Of Order Reports</p>
                            </div>
                            <div class="searchinp" id="searchinp">
                                <input type="text" name="" id="" placeholder="Search.." spellcheck="false">
                                <i class="fas fa-times" onclick="cancelSearch()"></i>
                            </div>

                        </div>

                        <div class="tabletool">
                            <div class="n">
                                <i class="fas fa-print printicon" onclick="printTable()"></i>
                            </div>
                            <div class="n">
                                <i class="fas fa-search searchicon" onclick="searchtoggle()"></i>

                            </div>

                            

                            <div class="n">
                                <i class="fas fa-filter" onclick="filterColumnShow()"></i>

                                <div class="filterColumn">
                                    <div class="top">
                                        <p>Filter Column</p>
                                        <i class="fas fa-times" onclick="filterColumnHide()"></i>
                                    </div>



                                    <div class="marjcol">
                                        <div class="colWrap" style="font-size: 15px;">
                                        <div class="in">
                                                <input type="radio" name="dueFilter" id="all" value="all" checked>
                                                <label for="all">All</label>
                                            </div>
                                            <div class="in">
                                                <input type="radio" name="dueFilter" id="pastDue" value="pastDue">
                                                <label for="pastDue">Past Due</label>
                                            </div>
                                            <div class="in">
                                                <input type="radio" name="dueFilter" id="almostDue" value="almostDue">
                                                <label for="almostDue">Almost Due</label>
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
                                <td>View</td>
                                <td>Print</td>
                                <td>Order ID</td>
                                <td>Company Name</td>
                                <td>Customer Name</td>
                                <td style="display: none;">Phone Number</td>
                                <td style="display: none;">House No. & Street Address</td>
                                <td style="display: none;">Barangay</td>
                                <td style="display: none;">Landmark</td>
                                <td>Product</td>
                                <td style="display: none;">Variant Color</td>
                                <td style="display: none;">Variant Size</td>
                                <td style="display: none;">Quantity</td>
                                <td>Regular/Rush</td>
                                <td style="display: none;">Delivery/Pick-up</td>
                                <td style="display: none;">Month</td>
                                <td style="display: none;">Date</td>
                                <td style="display: none;">Year</td>
                                <td>Delivery/Pick-up Date</td>
                                <td>Ready to be Delivered</td>
                                <td>Cancel</td>
                            </tr>
                            <?php foreach ($pendingOrders as $order_id => $order) : ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-eye clickable-eye" onclick="redirectToSummary('<?php echo $order['order']['order_id']; ?>'); event.stopPropagation();"></i>
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-circle-down" onclick="populatePrintForm('<?php echo htmlspecialchars($order['order']['order_id']); ?>'); event.stopPropagation();"></i>
                                    </td>

                                    <td><?php echo htmlspecialchars($order['order']['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer']['company_name'] ?? 'None'); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer']['first_name'] . ' ' . $order['customer']['last_name']); ?></td>
                                    <td style="display: none;"><?php echo htmlspecialchars($order['customer']['phone_number']); ?></td>
                                    <td style="display: none;"><?php echo htmlspecialchars($order['customer']['house_no'] . ', ' . $order['customer']['street_address']); ?></td>
                                    <td style="display: none;"><?php echo htmlspecialchars($order['customer']['barangay']); ?></td>
                                    <td style="display: none;"><?php echo htmlspecialchars($order['customer']['landmark']); ?></td>
                                    <td class="tdprod">
                                        <?php foreach ($order['order']['items'] as $item) : ?>
                                            <?php echo htmlspecialchars($item['product_name']); ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="display: none;">
                                        <?php foreach ($order['order']['items'] as $item) : ?>
                                            <?php echo htmlspecialchars($item['variant_color'] ?: ''); ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="display: none;">
                                        <?php foreach ($order['order']['items'] as $item) : ?>
                                            <?php echo htmlspecialchars($item['variant_size'] ?: ''); ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td style="display: none;">
                                        <?php foreach ($order['order']['items'] as $item) : ?>
                                            <?php echo htmlspecialchars($item['quantity']); ?><br>
                                        <?php endforeach; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($order['order']['rush_fee'] > 0 ? 'Rush' : 'Regular'); ?></td>
                                    <td style="display: none;"><?php echo htmlspecialchars($order['order']['delivery_method']); ?></td>
                                    <td style="display: none;"><?php echo date('F', strtotime($order['order']['delivery_Date'])); ?></td>
                                    <td style="display: none;"><?php echo date('d', strtotime($order['order']['created_at'])); ?></td>
                                    <td style="display: none;"><?php echo date('Y', strtotime($order['order']['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($order['order']['delivery_date']); ?></td>
                                    <td>
                                        <button onclick="showConfirmModal('<?php echo htmlspecialchars($order['order']['order_id']); ?>', 'To Deliver'); event.stopPropagation();">To Deliver</button>
                                    </td>
                                    <td>
                                        <button onclick="showConfirmModal('<?php echo htmlspecialchars($order['order']['order_id']); ?>', 'cancel'); event.stopPropagation();">Cancel</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
            <button  class="yellowButton"  id="redirectToOrders" onclick="redirectToSalesOrders()">Go to Orders</button>
        </div>
    </div>



    <div id="confirmModal" class="modal">
        <div class="modal-content">

            <p id="confirmMessage">Are you sure you want to do this?</p>
            <button class="yellowButton" id="confirmYesBtn">Yes</button>
            <button onclick="closeConfirmModal()">No</button>
        </div>
    </div>


    <div id="statusModal" class="modal" style="display:none;">
        <div class="modal-content">
            <p id="statusMessage"></p>
            <button class="yellowButton" onclick="closeStatusModal()">OK</button>

        </div>
    </div>


    <script src="../../static/script/script.js"></script>
    <script src="../../static/script/printfunction.js"></script>
    <script>
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
                clearMessageParams();
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

        function clearMessageParams() {
    const url = new URL(window.location);
    const params = url.searchParams;

    
    params.delete('message');
    params.delete('message2');

  
    window.history.replaceState(null, '', url.pathname + '?' + params.toString());
}



        let currentOrderId = null;
        let currentAction = null;

        function showConfirmModal(orderId, action) {
            currentOrderId = orderId;
            currentAction = action;
            document.getElementById('confirmMessage').textContent = `Are you sure you want to ${action} this order?`;
            document.getElementById('confirmModal').style.display = 'block';
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        function showStatusModal(message, reload = false) {
            document.getElementById('statusMessage').textContent = message;
            document.getElementById('statusModal').style.display = 'block';

            if (reload) {
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        }

        function closeStatusModal() {
            document.getElementById('statusModal').style.display = 'none';
        }

        document.getElementById('confirmYesBtn').addEventListener('click', function() {
            if (currentAction && currentOrderId) {

                const status = currentAction === 'To Deliver' ? 'To Deliver' : 'Cancelled';
                fetch('../../php/update_order_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: currentOrderId,
                            status: status,
                            admin_id: <?php echo json_encode($_SESSION['admin_id']); ?>
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showStatusModal('Order status updated successfully.', true);
                        } else {
                            showStatusModal('Error updating order status: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showStatusModal('Error updating order status.');
                    });
            }
            closeConfirmModal();
        });



        function printTable() {
            const printContent = document.querySelector('.table-pending').outerHTML;
            const originalContent = document.body.innerHTML;


            const printWindow = window.open('', '', 'width=800,height=600');

            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Table</title>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        table, th, td {
                            border: 1px solid black;
                        }
                        th, td {
                            padding: 10px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `);

            // Close the document and trigger the print dialog
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }



        function searchTable() {
            const searchInput = document.getElementById('searchinp').querySelector('input').value.toLowerCase().trim();
            const tableRows = document.querySelectorAll('.table-pending table tr:not(.tableheader)');


            tableRows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let found = false;


                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(searchInput)) {
                        found = true;
                        break;
                    }
                }


                row.style.display = found ? '' : 'none';
            });
        }

        document.getElementById('searchinp').querySelector('input').addEventListener('input', searchTable);







        document.querySelectorAll('input[name="dueFilter"]').forEach(input => {
            input.addEventListener('change', filterTableByDue);
        });

        function filterTableByDue() {
            const filterOption = document.querySelector('input[name="dueFilter"]:checked').value;
            const tableRows = document.querySelectorAll('.table-pending table tr:not(.tableheader)');
            const today = new Date();

            tableRows.forEach(row => {
                const deliveryDateCell = row.querySelector('td:nth-child(19)');
                if (!deliveryDateCell) return;

                const deliveryDate = new Date(deliveryDateCell.textContent.trim());
                let showRow = false;

                if (filterOption === 'pastDue') {

                    if (deliveryDate < today) {
                        showRow = true;
                    }
                } else if (filterOption === 'almostDue') {

                    const oneDayBefore = new Date(today);
                    oneDayBefore.setDate(oneDayBefore.getDate() + 1);
                    if (deliveryDate.toDateString() === oneDayBefore.toDateString()) {
                        showRow = true;
                    }
                } else {

                    showRow = true;
                }


                row.style.display = showRow ? '' : 'none';
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
           
            document.querySelectorAll('input[name="dueFilter"]').forEach(input => {
                input.addEventListener('change', filterTable);
            });

     
            document.querySelectorAll('input[name="filterPendingReg"]').forEach(input => {
                input.addEventListener('change', filterTable);
            });

            function filterTable() {
                const dueFilterOption = document.querySelector('input[name="dueFilter"]:checked').value;
                const regRushFilterOption = document.querySelector('input[name="filterPendingReg"]:checked').id;

                const tableRows = document.querySelectorAll('.table-pending table tr:not(.tableheader)');
                const today = new Date();

                tableRows.forEach(row => {
                    const deliveryDateCell = row.querySelector('td:nth-child(19)');
                    const rushRegularCell = row.querySelector('td:nth-child(14)'); 

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
        });
    </script>
</body>

</html>