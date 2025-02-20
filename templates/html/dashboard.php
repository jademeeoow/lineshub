<?php


include_once "../../php/dashboard.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../static//style/dashboard.css">
    <link rel="stylesheet" href="../../static//style/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>
    .summary-cards {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
        padding: 1.7rem;
        gap: 1rem;
    }

    .sumcard {
        display: flex;
        gap: 1rem;
        flex-grow: 1;
    }

    .card {
        background-color: whitesmoke;
        border: 1px solid black;
        border-radius: 0.5rem;
        padding: 1rem;
        width: 33.33%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .card h3 {
        font-size: 1rem;
        margin: 0;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .card h3 i {
        font-size: 1.2em;
        margin-right: 5px;
    }

    .card p {
        font-size: 1.3em;
        margin: 5px 0 0;
        font-weight: bold;
        color: black;
    }
</style>

<body>
    <div class="notifTooltipCon">
        <p>hvjhvjhvjh</p>
    </div>
    <div class="whole">
        <main-header data-image-path="<?php echo htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8'); ?>" data-role="<?php echo htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8'); ?>" data-email="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?>"></main-header>

        <div class="con">



            <?php

            include_once  "sidemenu.php";

            ?>




            <div class="content">




                <div class="title">
                    <h1>DASHBOARD</h1>
                </div>


                <div class="summary-cards">

                    <div class="sumcard">
                        <div class="card">
                            <h3><i class="fas fa-calendar-day"></i> Due Today Orders</h3>
                            <p><?php echo $orderCounts['dueTodayOrders']; ?></p>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-spinner"></i> Pending Orders</h3>
                            <p><?php echo $orderCounts['pendingOrders']; ?></p>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-truck"></i> To Deliver Orders</h3>
                            <p><?php echo $orderCounts['toDeliverOrders']; ?></p>
                        </div>

                    </div>

                    <div class="sumcard">
                        <div class="card">
                            <h3><i class="fas fa-check-square"></i> Received Orders</h3>
                            <p><?php echo $orderCounts['receivedOrders']; ?></p>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-times-circle"></i> Cancelled Orders</h3>
                            <p><?php echo $orderCounts['cancelledOrders']; ?></p>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-reply"></i> Returned Orders</h3>
                            <p><?php echo $orderCounts['returnedOrders']; ?></p>
                        </div>
                    </div>

                </div>

                <div class="fortable">


                    <div class="marjtable">
                        <div class="contool-table">
                            <div class="tabletag">


                                <div class="list" id="list">
                                    <p>List Of Delivered Orders </p>
                                </div>
                                <div class="searchinp" id="searchinp">
                                    <input type="text" name="" id="searchInput" spellcheck="false">
                                    <i class="fas fa-times" onclick="cancelSearch()"></i>
                                </div>
                            </div>
                            <div class="tabletool">
                                <div class="n">
                                    <i class="fas fa-search searchicon" onclick="searchtoggle()"></i>
                                </div>

                                <div class="n">
                                    <i class="fas fa-columns" onclick="filterColumnShow()"></i>
                                    <div class="filterColumn">
                                        <div class="top">
                                            <p>Show Column</p>
                                            <i class="fas fa-times" onclick="filterColumnHide()"></i>
                                        </div>
                                        <div class="marjcol">
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="orderId">
                                                <label for="orderId">Order Id</label>
                                            </div>

                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="fullName" checked>
                                                <label for="fullName">Full Name</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="houseNo" checked>
                                                <label for="houseNo">House No.</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="streetAdd" checked>
                                                <label for="streetAdd">House No. & Street Address</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="barangay" checked>
                                                <label for="barangay">Barangay</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="landmark" checked>
                                                <label for="landmark">Landmark</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="orders" checked>
                                                <label for="orders">Orders</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="phoneNumber" checked>
                                                <label for="phoneNumber">Phone Number</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="totalAmount" checked>
                                                <label for="totalAmount">Total Amount</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="downpayment" checked>
                                                <label for="downpayment">Downpayment</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="regularRush" checked>
                                                <label for="regularRush">Regular / Rush</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="deliveryPickup" checked>
                                                <label for="deliveryPickup">Delivery / Pick-up</label>
                                            </div>

                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="instructions">
                                                <label for="instructions">Instructions</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="deliveryDatePickupDate" checked>
                                                <label for="deliveryDatePickupDate">Delivery Date / Pick-up Date</label>
                                            </div>
                                            <div class="columnsFilter">
                                                <input type="checkbox" name="f" id="otherStatus" checked>
                                                <label for="otherStatus">Other Status</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="table table-pending">
                            <table>
                                <tr class="tableheader">


                                    <td>Order ID</td>
                                    <td>Company Name</td>
                                    <td>Customer Name</td>
                                    <td style="display: none;">Phone Number</td>
                                    <td style="display: none;">House No. & Street Address</td>
                                    <td style="display: none;">Barangay</td>
                                    <td style="display: none;">Landmark</td>
                                    <td style="display: none;">Orders</td>
                                    <td style="display: none;">Variant Color</td>
                                    <td style="display: none;">Variant Size</td>
                                    <td style="display: none;">Quantity</td>
                                    <td>Regular/Rush</td>
                                    <td style="display: none;">Delivery/Pick-up</td>
                                    <td style="display: none;">Month</td>
                                    <td style="display: none;">Date</td>
                                    <td style="display: none;">Year</td>
                                    <td>Delivery/Pick-up Date</td>

                                </tr>
                                <?php if (empty($receivedOrders)): ?>
                                    <tr>
                                        <td colspan="18">No delivered orders.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($receivedOrders as $order): ?>
                                        <tr>







                                            <td><?php echo htmlspecialchars($order['order']['order_id']); ?></td>
                                            <td><?php echo htmlspecialchars($order['customer']['company_name'] ?? 'None'); ?></td>
                                            <td><?php echo htmlspecialchars($order['customer']['first_name'] . ' ' . $order['customer']['last_name']); ?></td>
                                            <td style="display: none;"><?php echo htmlspecialchars($order['customer']['phone_number']); ?></td>
                                            <td style="display: none;"><?php echo htmlspecialchars($order['customer']['house_no'] . ' ,' . $order['customer']['street_address']); ?></td>
                                            <td style="display: none;" d><?php echo htmlspecialchars($order['customer']['barangay']); ?></td>
                                            <td style="display: none;"><?php echo htmlspecialchars($order['customer']['landmark']); ?></td>
                                            <td style="display: none;" class="tdprod">
                                                <?php foreach ($order['order']['items'] as $item): ?>
                                                    <?php echo htmlspecialchars($item['product_name']); ?><br>
                                                <?php endforeach; ?>
                                            </td>
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
                                            <td style="display: none;">
                                                <?php foreach ($order['order']['items'] as $item): ?>
                                                    <?php echo htmlspecialchars($item['quantity']); ?><br>
                                                <?php endforeach; ?>
                                            </td>

                                            <td><?php echo htmlspecialchars($order['order']['order_type']); ?></td>
                                            <td style="display: none;"><?php echo htmlspecialchars($order['order']['delivery_method']); ?></td>
                                            <td style="display: none;"><?php echo date('F', strtotime($order['order']['delivery_date'])); ?></td>
                                            <td style="display: none;"><?php echo date('d', strtotime($order['order']['delivery_date'])); ?></td>
                                            <td style="display: none;"><?php echo date('Y', strtotime($order['order']['delivery_date'])); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($order['order']['delivery_date'])); ?></td>

                                        </tr>
                                    <?php endforeach; ?>

                                <?php endif; ?>
                            </table>

                        </div>


                    </div>
                </div>
            </div>
            <main-sidenotif class="side sidenotif" id="sidenotif"></main-sidenotif>
        </div>
    </div>
    <script src="../../static/script/script.js"></script>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {

            let input = document.getElementById('searchInput').value.toLowerCase();


            let table = document.querySelector('.table-pending table');
            let rows = table.getElementsByTagName('tr');


            for (let i = 1; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName('td');
                let match = false;


                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(input)) {
                        match = true;
                        break;
                    }
                }


                rows[i].style.display = match ? '' : 'none';
            }
        });


        function cancelSearch() {
            const input = document.getElementById('searchInput');
            input.value = '';
            const rows = document.querySelectorAll('.table-pending table tr');


            rows.forEach((row, index) => {
                if (index > 0) {
                    row.style.display = '';
                }
            });


            const searchInputContainer = input.closest('.searchinp');
            const listContainer = document.querySelector('.list');

            if (searchInputContainer && listContainer) {
                searchInputContainer.style.display = 'none';
                listContainer.style.display = 'block';
            }


            const searchIcon = document.querySelector('.searchicon');
            if (searchIcon) {
                searchIcon.style.backgroundColor = '';
            }
        }


        function searchtoggle() {
            const lists = document.querySelectorAll('.list');
            const searchInputs = document.querySelectorAll('.searchinp');
            const searchIcons = document.querySelectorAll('.searchicon');

            lists.forEach((list, index) => {
                const searchInput = searchInputs[index];
                const inputField = searchInput.querySelector('input');
                const searchIcon = searchIcons[index];

                if (searchInput.style.display === 'flex') {

                    searchInput.style.display = 'none';
                    list.style.display = 'block';
                    inputField.value = '';
                    cancelSearch()
                    searchIcon.style.backgroundColor = '';
                } else {

                    list.style.display = 'none';
                    searchInput.style.display = 'flex';
                    inputField.focus();
                    searchIcon.style.backgroundColor = '#FFC000';
                }
            });
        }
    </script>


</body>

</html>