<?php

include_once "../../php/order_summary.php";




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link rel="stylesheet" href="../../static/style/summary.css">
    <link rel="stylesheet" href="../../static/style/orders.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>
    .notification {
        position: sticky;
        top: 2rem;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fefefe;
        color: green;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        text-align: center;
        z-index: 1000;
        display: none;
        animation: fadeInOut 3s ease-in-out;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
        word-wrap: break-word;
    }









    @keyframes fadeInOut {
        0% {
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>






<body>
    <div class="whole">
        <main-header data-image-path="<?php echo $image_path; ?>"></main-header>
        <div class="con">
            <?php include_once  "sidemenu.php"; ?>


            <div class="content">
                <div class="title">
                    <h1>SUMMARY OF ORDER</h1>
                </div>
                <div class="marjcontent">

                    <div class="button1">
                        <button onclick="goBack()">Back</button>

                    </div>

                    <div class="button2">

                        <button onclick="editOrdersSummary()">Edit</button>

                    </div>

                    <div class="summary-container">
                        <?php if (!empty($pendingOrders)): ?>
                            <?php foreach ($pendingOrders as $order): ?>
                                <div class="customer-info">
                                    <div class="section-title">Customer Information</div>
                                    <div class="info-row">
                                        <span class="info-label">Order ID:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['order']['order_id'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Company Name:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['customer']['company_name'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Customer Name:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['customer']['first_name'] . ' ' . $order['customer']['last_name']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Phone Number:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['customer']['phone_number'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Address:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['customer']['house_no'] . ', ' . $order['customer']['street_address']); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Barangay:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['customer']['barangay'] ?? 'N/A'); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Landmark:</span>
                                        <span class="info-value"><?php echo htmlspecialchars($order['customer']['landmark'] ?? 'N/A'); ?></span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">Order Status:</span>
                                        <span id="orderStatus" style="font-weight: bold;" class="info-value"><?php echo htmlspecialchars($order['order']['status']); ?></span>
                                    </div>
                                </div>


                                <!-- Order Items -->
                                <div class="order-items">
                                    <div class="section-title">Purchased Items</div>
                                    <table class="table-summary">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Variant Color</th>
                                                <th>Variant Size</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $productTotal = 0;
                                            foreach ($order['order']['items'] as $item):
                                                $itemTotal = ($item['unit_price'] ?? 0) * $item['quantity'];
                                                $productTotal += $itemTotal;
                                            ?>
                                                <tr>


                                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($item['variant_color'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($item['variant_size'] ?? ''); ?></td>
                                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                                    <td>₱<?php echo number_format($item['unit_price'] ?? 0, 2); ?></td>
                                                    <td>₱<?php echo number_format($itemTotal, 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr class="total-row">
                                                <td colspan="5">Total Amount:</td>
                                                <td>₱<?php echo number_format($productTotal, 2); ?></td> <!-- Use product total -->
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>



                                <div class="fees-charges">
                                    <div class="section-title">Billing Details</div>
                                    <div class="info-row">
                                        <span class="info-label">Payment Method:</span>
                                        <span style="font-weight: bold;" class="info-value"><?php echo htmlspecialchars($order['order']['payment_mode'] ?? 'N/A'); ?></span>
                                    </div>
                                   

                                    <div class="info-row">
                                        <span class="info-label">Rush Fee:</span>
                                        <span class="info-value">₱<?php echo number_format($order['order']['rush_fee'] ?? 0, 2); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Customization Fee:</span>
                                        <span class="info-value">₱<?php echo number_format($order['order']['customization_fee'] ?? 0, 2); ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Delivery Fee:</span>
                                        <span class="info-value">₱<?php echo number_format($order['order']['delivery_fee'] ?? 0, 2); ?></span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">Discount:</span>
                                        <span class="info-value">-₱<?php echo number_format($order['order']['discount'] ?? 0, 2); ?></span>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label">Downpayment:</span>
                                        <span class="info-value">-₱<?php echo number_format($order['order']['downpayment'] ?? 0, 2); ?></span>
                                    </div>

                                    <div class="total-amount-pay">
                                        Total Amount to Pay: ₱<?php echo number_format($order['order']['total_amount'], 2); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-data">No orders found.</div>
                        <?php endif; ?>
                    </div>
                </div>
                <add-orders-inner class="tabb"></add-orders-inner>
            </div>




            <div id="successModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('successModal')">&times;</span>
                    <p id="successMessage"></p>
                </div>
            </div>

            <!-- Error Modal -->
            <div id="errorModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('errorModal')">&times;</span>
                    <p id="errorMessage"></p>
                </div>
            </div>





            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>

    </div>
    <div class="containerOverlay" id="containerOverlay">
        <form id="editOrderForm" action="../../php/edit_order.php" method="POST">

            <div id="notification" class="notification"></div>



            <div class="mlz" id="mlz">

                <input type="hidden" name="order_id" id="orderIDEdit" value="<?php echo htmlspecialchars($orderData['order']['order_id'] ?? ''); ?>">
                <div class="formAddOrders" id="formAddOrdersEdit">
                    <div class="marginWrap">
                        <div class="addTitle">
                            <p>Edit Orders</p>
                            <i class="fas fa-times" onclick="closeAddOrdersEdit()"></i>
                        </div>
                        <div class="customerDetails detailsCon">
                            <div class="gl">
                                <div class="topText">
                                    <p>Customer Details</p>
                                </div>
                                <div class="hj">
                                    <div class="parexp">
                                        <label for="CompanyName">Company Name</label>
                                        <div class="inpexp">
                                            <input type="text" name="companyName" id="CompanyNameEdit" value="<?php echo htmlspecialchars($orderData['customer']['company_name'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="parexp">
                                        <label for="firstName">First Name <span>*</span></label>
                                        <div class="inpexp">
                                            <input type="text" name="firstName" id="firstNameEdit" required value="<?php echo htmlspecialchars($orderData['customer']['first_name'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="parexp">
                                        <label for="lastName">Last Name <span>*</span></label>
                                        <div class="inpexp">
                                            <input type="text" name="lastName" id="lastNameEdit" required value="<?php echo htmlspecialchars($orderData['customer']['last_name'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="parexp">
                                        <label for="phoneNumber">Phone/Telephone Number <span>*</span></label>
                                        <div class="inpexp">
                                            <input type="text" name="phoneNumber" id="phoneNumberEdit" required value="<?php echo htmlspecialchars($orderData['customer']['phone_number'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Details Section -->
                            <div class="gl">
                                <div class="topText">
                                    <p>Order Details</p>
                                </div>
                                <div class="hj">
                                    <div class="parexp">
                                        <label for="additionalInstructions">Additional Instructions</label>
                                        <div class="inpexp">
                                            <input type="text" name="additionalInstructions" id="additionalInstructionsEdit" value="<?php echo htmlspecialchars($orderData['order']['additional_instructions'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="delivery">
                                    <p>Pick up or Delivery</p>
                                    <div class="md">
                                        <div class="hs">
                                            <input type="radio" name="delivery_method" id="DeliveryEdit" value="Delivery" <?php echo (isset($orderData['order']['delivery_method']) && $orderData['order']['delivery_method'] === 'Delivery') ? 'checked' : ''; ?>>
                                            <label for="Delivery">Delivery</label>
                                        </div>
                                        <div class="hs">
                                            <input type="radio" name="delivery_method" id="PickupEdit" value="Pickup" <?php echo (isset($orderData['order']['delivery_method']) && $orderData['order']['delivery_method'] === 'Pickup') ? 'checked' : ''; ?>>
                                            <label for="Pickup">Pick-up</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="hj">
                                    <div class="parexp">
                                        <label for="deliveryDate">Delivery Date</label>
                                        <div class="inpexp">
                                            <input
                                                type="date"
                                                name="deliveryDate"
                                                id="deliveryDateEdit"
                                                value="<?php echo htmlspecialchars($orderData['order']['delivery_date'] ?? ''); ?>"
                                                min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Details Section -->
                            <div class="gl">
                                <div class="topText">
                                    <p>Address Details</p>
                                </div>
                                <div class="hj">
                                    <div class="parexp">
                                        <label for="houseNo">House/Building No.</label>
                                        <div class="inpexp">
                                            <input type="text" name="houseNo" id="houseNoEdit" value="<?php echo htmlspecialchars($orderData['customer']['house_no'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="parexp">
                                        <label for="streetAddress">Street Address <span>*</span></label>
                                        <div class="inpexp">
                                            <input type="text" name="streetAddress" id="streetAddressEdit" required value="<?php echo htmlspecialchars($orderData['customer']['street_address'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="parexp">
                                        <label for="barangay">Barangay <span>*</span></label>
                                        <div class="inpexp">
                                            <input type="text" name="barangay" id="barangayEdit" required value="<?php echo htmlspecialchars($orderData['customer']['barangay'] ?? ''); ?>">
                                        </div>
                                    </div>
                                    <div class="parexp">
                                        <label for="landmark">Landmark</label>
                                        <div class="inpexp">
                                            <input type="text" name="landmark" id="landmarkEdit" value="<?php echo htmlspecialchars($orderData['customer']['landmark'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gl">
                                <button type="button" onclick="toNextPageEdit(event)">Next</button>
                            </div>
                        </div>
                        <div class="gl" style="display:none">
                            <div class="topText">
                                <p>Payment</p>
                            </div>
                            <div class="hj">
                                <p class="total" name="total_price">Total Amount: ₱ <span id="totalAmountTopEdit">00.00</span></p>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="nextPage" id="nextPageEdit" style="margin-top:50px;">
                    <div class="mz">
                        <div class="formListofOrders">
                            <div class="bv">
                                <button type="button" onclick="toPreviousPageEdit(event)">Back</button>
                                <p>
                                    List Of Orders
                                </p>
                                <div class="lk">
                                    <p>Item Amount: ₱ <span id="totalAmountListEdit" name="total_price">00.00</span></p>
                                </div>


                                <input type="hidden" id="hiddenItemIDs" name="item_ids">
                                <input type="hidden" id="hiddenOrderItemIDs" name="order_item_ids"> <!-- New hidden input -->
                                <input type="hidden" id="hiddenVariantIDEdit" name="VariantID">
                                <input type="hidden" id="hiddenProductNameEdit" name="ProductName">
                                <input type="hidden" id="hiddenColorEdit" name="Color">
                                <input type="hidden" id="hiddenSizeEdit" name="Size">
                                <input type="hidden" id="hiddenQuantityEdit" name="Quantity">
                                <input type="hidden" id="hiddenUnitPriceEdit" name="unitPrice">
                                <input type="hidden" name="total_amount" id="totalAmountInputEdit">


                            </div>

                            <div class="listOrderTable" id="listOrderTableEdit">
                                <table>
                                    <thead>
                                        <tr class="tableheader">
                                            <td class="listProductName">Product Name</td>
                                            <td class="liss">Color</td>
                                            <td class="liss">Size</td>
                                            <td class="liss">Qty</td>
                                            <td class="liss">Price</td>
                                            <td class="listo">Remove</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($orderData && !empty($orderData['order']['items'])): ?>
                                            <?php foreach ($orderData['order']['items'] as $item): ?>
                                                <tr data-order-item-id="<?php echo htmlspecialchars($item['order_item_id'] ?? ''); ?>"
                                                    data-variant-id="<?php echo htmlspecialchars($item['variant_id']); ?>">
                                                    <td class="listProductName"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                                    <td class="liss"><?php echo htmlspecialchars($item['variant_color'] ?? ''); ?></td>
                                                    <td class="liss"><?php echo htmlspecialchars($item['variant_size'] ?? ''); ?></td>
                                                    <td class="liss">
                                                        <input type="number" value="<?php echo $item['quantity']; ?>" min="1"
                                                            class="quantityEdit"
                                                            id="quantity_<?php echo htmlspecialchars($item['variant_id']); ?>"
                                                            data-price="<?php echo $item['unit_price']; ?>"
                                                            onchange="handleQuantityChange(this);"
                                                            oninput="handleQuantityChange(this);">
                                                        <!-- Hidden input for order_item_id -->
                                                        <input type="hidden" class="orderItemId" value="<?php echo htmlspecialchars($item['order_item_id'] ?? ''); ?>">
                                                    </td>
                                                    <td class="liss">₱<?php echo number_format($item['unit_price'], 2); ?></td>
                                                    <td class="listo">
                                                        <button type="button" onclick="removeItem(this);">Remove</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center;">No items found for this order.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="fz">

                            <p>Regular or Rush</p>
                            <div class="radioBtnRR">

                                <input type="hidden" name="order_type" id="orderTypeHidden" value="<?php echo htmlspecialchars($orderData['order']['order_type'] ?? 'Regular'); ?>">

                                <div>
                                    <div style="display:flex;">
                                        <input type="radio" name="RRedit" id="RegularEdit" value="Regular"
                                            <?php echo ($orderData && $orderData['order']['order_type'] === 'Regular') ? 'checked' : ''; ?>>
                                        <label for="RegularEdit">Regular</label>
                                    </div>
                                    <div style="display:flex;">
                                        <input type="radio" name="RRedit" id="RushEdit" value="Rush"
                                            <?php echo ($orderData && $orderData['order']['order_type'] === 'Rush') ? 'checked' : ''; ?>>
                                        <label for="RushEdit">Rush</label>
                                    </div>

                                </div>
                                <div class="parForRushEdit" id="parForRushEdit" style="display:flex  " <?php echo ($orderData && $orderData['order']['order_type'] === 'Rush') ? 'block' : 'none'; ?>;">
                                    <label for="RushInputEdit" id="rushLabelEdit">Rush Fee</label>
                                    <div class="inpexp">
                                        <input type="number" name="RushInputEdit" id="RushInputEdit"
                                            value="<?php echo $orderData['order']['rush_fee'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="sf">

                                <div class="parexp0">
                                    <label for="PaymentMethodEdit">Payment Method</label>
                                    <div class="inpexp">
                                        <select name="paymentMode" id="PaymentMethodEdit">
                                            <option value="" disabled>Select Payment Method</option>
                                            <option value="Cash"
                                                <?php echo isset($orderData['order']['payment_mode']) && $orderData['order']['payment_mode'] == 'Cash' ? 'selected' : ''; ?>>
                                                Cash
                                            </option>
                                            <option value="Gcash"
                                                <?php echo isset($orderData['order']['payment_mode']) && $orderData['order']['payment_mode'] == 'Gcash' ? 'selected' : ''; ?>>
                                                Online (Gcash)
                                            </option>
                                            <option value="Paymaya"
                                                <?php echo isset($orderData['order']['payment_mode']) && $orderData['order']['payment_mode'] == 'Paymaya' ? 'selected' : ''; ?>>
                                                Online (Paymaya)
                                            </option>
                                            <option value="Online Banking"
                                                <?php echo isset($orderData['order']['payment_mode']) && $orderData['order']['payment_mode'] == 'Online Banking' ? 'selected' : ''; ?>>
                                                Online Banking
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="parexp1">
                                    <label for="CustomizationEdit">Customization Fee</label>
                                    <div class="inpexp">
                                        <input type="number" name="Customization" id="CustomizationEdit"
                                            value="<?php echo $orderData['order']['customization_fee'] ?? ''; ?>">
                                    </div>
                                </div>

                                <div class="parex4" id="deliveryFeeSectionEdit">
                                    <label for="DeliveryFeeEdit" id="deliveryFeeLabelEdit">Delivery Fee</label>
                                    <div class="inpexp">
                                        <input type="number" name="DeliveryFee" id="DeliveryFeeEdit"
                                            value="<?php echo $orderData['order']['delivery_fee'] ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="parexp2">
                                    <label for="Discount">Discount</label>
                                    <div class="inpexp">
                                        <input type="text" name="Discount" id="DiscountEdit"
                                            value="<?php echo $orderData['order']['discount'] ?? ''; ?>">
                                        <input type="hidden" id="rawDiscountValue" name="rawDiscountValue"
                                            value="<?php echo $orderData['order']['discount'] ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="parexp3">
                                    <label for="DownpaymentEdit">Downpayment</label>
                                    <div class="inpexp">
                                        <input type="number" name="Downpayment" id="DownpaymentEdit"
                                            value="<?php echo $orderData['order']['downpayment'] ?? ''; ?>">
                                    </div>
                                </div>

                            </div>



                            <div class="lk" style="margin-top:10px;">
                                <p>Total Amount: ₱ <span id="totalAmountBottomEdit" name="total_price">00.00</span></p>
                            </div>

                            <button type="submit" id="submitOrdersEdit" style="margin-top:10px;">SUBMIT ORDERS</button>

                        </div>



                    </div>










                    <div class="vw">
                        <div class="parexp searchPro">
                            <label for="searchPro">Search Products</label>
                            <div class="inpexp">
                                <input type="text" name="searchPro" id="searchProEdit">
                            </div>
                        </div>

                        <div class="productAdd" id="productAddEdit">

                        </div>

                    </div>
        </form>
    </div>











    <script src="../../static/script/script.js"></script>
    <script>
      function goBack() {
 
    const statusElement = document.getElementById('orderStatus');
    if (!statusElement) {
        console.error("Order status element not found!");
        return;
    }

    const status = statusElement.textContent.trim().toLowerCase();


    let targetPage = 'order_summary.php'; 
    switch (status) {
        case 'pending':
            targetPage = 'pending.php';
            break;
        case 'to deliver':
            targetPage = 'todeliver.php';
            break;
        case 'delivered':
            targetPage = 'received.php';
            break;
        case 'cancelled':
            targetPage = 'cancelled.php';
            break;
        case 'returned':
            targetPage = 'returned.php';
            break;
        default:
            console.error("Unknown status:", status);
            return; 
    }


    window.location.href = targetPage;
}



        function getUrlParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        function showModal(modalId, message) {
            const modal = document.getElementById(modalId);
            const messageElement = modal.querySelector('p');

            if (modal && messageElement) {
                messageElement.textContent = message;
                modal.style.display = 'block';
            }
        }

        function closeModal(modalId, param) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';

                
                if (param) {
                    removeUrlParam(param);
                }
            }
        }


        function removeUrlParam(param) {

            const url = new URL(window.location);
            url.searchParams.delete(param);
            window.history.replaceState({}, document.title, url);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = getUrlParam('message');
            const errorMessage = getUrlParam('message2');

            if (successMessage) {
                showModal('successModal', successMessage);

                removeUrlParam('message');
            } else if (errorMessage) {
                showModal('errorModal', errorMessage);

                removeUrlParam('message2');
            }
        });
    </script>

    <script>
        function editOrdersSummary() {
            const containerOverlay = document.getElementById('containerOverlay');

            containerOverlay.style.display = 'flex';
        }

        function backSummary() {
            const containerOverlay = document.getElementById('containerOverlay');

            containerOverlay.style.display = 'none';
        }

        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM fully loaded and parsed, initializing event listeners...");
            const rushRadio = document.getElementById("RushEdit");
            const regularRadio = document.getElementById("RegularEdit");
            const orderTypeHidden = document.getElementById("orderTypeHidden");
            const parForRush = document.getElementById("parForRushEdit");
            const rushInputEdit = document.getElementById("RushInputEdit");

            function rush() {
                if (rushRadio.checked) {
                    orderTypeHidden.value = "Rush";
                    parForRush.classList.add("show");
                } else if (regularRadio.checked) {
                    orderTypeHidden.value = "Regular";
                    parForRush.classList.remove("show");
                    rushInputEdit.value = '';
                    rushInputEdit.dispatchEvent(new Event('input'));
                }
            }


            rush();


            rushRadio.addEventListener("change", rush);
            regularRadio.addEventListener("change", rush);
        });






        function toNextPageEdit(event) {
            if (event) {
                event.preventDefault();
            }
            const nextPageEdit = document.getElementById("nextPageEdit");
            const formAddOrdersEdit = document.getElementById("formAddOrdersEdit");

            if (formAddOrdersEdit && nextPageEdit) {

                formAddOrdersEdit.style.display = "none";

                nextPageEdit.style.display = "block";
            } else {
                console.error("Element(s) not found: check the IDs and ensure they match.");
            }
        }

        function toPreviousPageEdit(event) {
            if (event) {
                event.preventDefault();
            }

            const nextPageEdit = document.getElementById("nextPageEdit");
            const formAddOrdersEdit = document.getElementById("formAddOrdersEdit");

            if (formAddOrdersEdit && nextPageEdit) {



                nextPageEdit.style.display = "none";
                formAddOrdersEdit.style.display = "block";
            } else {
                console.error("Element(s) not found: check the IDs and ensure they match.");
            }
        }



        function closeAddOrdersEdit() {
            const containerOverlay = document.getElementById("containerOverlay");


            location.reload()

            if (containerOverlay) {

                containerOverlay.style.display = 'none';
                console.log("Closing the edit form and restoring initial data...");
            }
        }














        //

        function toggleDeliveryFee(isDelivery) {

            const deliveryFeeSection = document.querySelector("#deliveryFeeSectionEdit");
            const deliveryFeeLabel = document.querySelector("#deliveryFeeLabelEdit");
            const deliveryFeeInput = document.querySelector("#DeliveryFeeEdit");

            if (deliveryFeeSection && deliveryFeeLabel && deliveryFeeInput) {

                if (isDelivery) {
                    deliveryFeeSection.style.display = "block";
                    deliveryFeeLabel.style.display = "block";
                } else {

                    deliveryFeeSection.style.display = "none";
                    deliveryFeeLabel.style.display = "none";
                    deliveryFeeInput.value = "";
                }


                updateTotalAmount();
            } else {
                console.error("Delivery fee elements not found");
            }
        }



        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM fully loaded and parsed, initializing event listeners...");

            fetchProducts();


            function fetchProducts() {
                fetch("../../php/fetchvariants.php")
                    .then(response => response.json())
                    .then(data => displayProducts(data))
                    .catch(error => console.error('Error fetching products:', error));
            }

            function displayProducts(products) {
                const productContainer = document.getElementById("productAddEdit");
                productContainer.innerHTML = "";

                if (!products || products.length === 0) {
                    productContainer.innerHTML = "<p>No products available.</p>";
                    return;
                }

                products.sort((a, b) => {
                    const nameA = a.product_name ? a.product_name.toLowerCase() : "";
                    const nameB = b.product_name ? b.product_name.toLowerCase() : "";
                    return nameA.localeCompare(nameB);
                });

                products.forEach(product => {
                    const productName = product.product_name || "N/A";
                    const category = product.category_name || "N/A";
                    const subCategory = product.sub_category_name || "None";
                    const productImage = "../../static/images/logolines.jpg";

                    const productElement = document.createElement("div");
                    productElement.classList.add("conPro");

                    let variantsHtml = "";
                    product.variants.forEach(variant => {
                        const variantColor = variant.variant_color || "N/A";
                        const variantSize = variant.variant_size || "N/A";
                        const variantPrice = variant.variant_price ? parseFloat(variant.variant_price).toFixed(2) : "N/A";
                        const variantStock = variant.variant_stock < 0 ? 0 : variant.variant_stock;

                        variantsHtml += `
                <div class="variantItem">
                    <span>${variantColor} (${variantSize} Size) (${variantStock} pcs)</span>
                    <button type="button" class="add-button" 
                        onclick="addProductToOrder(${variant.variant_id}, '${productName}', '${variantColor}', '${variantSize}', ${variant.variant_price})">
                        Add
                    </button>
                </div>
            `;
                    });

                    productElement.innerHTML = `
            <div class="productDetails">
                <div class="proImage">
                    <img src="${productImage}" alt="${productName}">
                </div>
                <div class="proName">
                    <h4>${productName}</h4>
                    <p>Category: ${category}</p>
                    <p>Sub-Category: ${subCategory}</p>
                </div>
            </div>
            <div class="colorAdd">
                ${variantsHtml}
            </div>
        `;

                    productContainer.appendChild(productElement);
                });
            }

        });


        document.addEventListener("DOMContentLoaded", function() {


            let newItemCounter = 1;

            console.log("DOM fully loaded and parsed, initializing event listeners...");;
            initializeTotalAmount();
            initializeHiddenInputs();

            function showNotification(message, duration = 3000) {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.textContent = message;
                    notification.style.display = 'block';

                    // Hide the notification after the specified duration
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, duration);
                }
            }

            // Modify the addProductToOrder function to include the dynamic notification
            window.addProductToOrder = function(variantId, productName, variantColor, variantSize, variantPrice) {
                const listOrderTableBody = document.querySelector("#listOrderTableEdit tbody");

                if (!listOrderTableBody) {
                    console.error("Table body not found in #listOrderTableEdit");
                    return;
                }

                let existingRow = null;
                const rows = Array.from(listOrderTableBody.querySelectorAll("tr"));

                for (let row of rows) {
                    const currentVariantId = row.dataset.variantId;
                    const currentProductName = row.querySelector(".listProductName").textContent.trim();
                    const currentColor = row.querySelector(".liss:nth-child(2)").textContent.trim();
                    const currentSize = row.querySelector(".liss:nth-child(3)").textContent.trim();

                    if (currentVariantId === variantId.toString() &&
                        currentProductName === productName &&
                        currentColor === variantColor &&
                        currentSize === variantSize) {
                        existingRow = row;
                        break;
                    }
                }

                if (existingRow) {
                    // Increment the quantity if the product already exists in the order
                    const quantityInput = existingRow.querySelector(".quantityEdit");
                    if (quantityInput) {
                        const currentQuantity = parseInt(quantityInput.value, 10);
                        const newQuantity = currentQuantity + 1;
                        quantityInput.value = newQuantity;
                        quantityInput.dispatchEvent(new Event('input'));


                        showNotification(`${productName} (${variantColor}, ${variantSize}) quantity increased to ${newQuantity}`);


                        if (newQuantity <= 0) {
                            showWarning(`${productName} (${variantColor}, ${variantSize}) has 0 quantity, but you can still proceed.`);
                        }
                    }
                } else {
                    // Add a new row if the product is not in the order
                    const newRow = document.createElement("tr");
                    newRow.dataset.variantId = variantId;
                    newRow.dataset.itemId = `new_${newItemCounter++}`;

                    newRow.innerHTML = `
            <td class="listProductName">${productName}</td>
            <td class="liss">${variantColor}</td>
            <td class="liss">${variantSize}</td>
            <td class="liss">
                <input type="number" value="1" min="1" class="quantityEdit" id="quantity_${variantId}" 
                    data-price="${variantPrice}" 
                    onchange="handleQuantityChange(this);" 
                    oninput="handleQuantityChange(this);">
            </td>
            <td class="liss">₱${parseFloat(variantPrice).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td class="listo">
                <button type="button" class="remove-button" 
                    onclick="removeItem(this);">Remove</button>
            </td>
        `;

                    listOrderTableBody.appendChild(newRow);


                    showNotification(`${productName} (${variantColor}, ${variantSize}) added to the order`);
                }

                updateTotalAmount();
                updateHiddenInputs();
            };


            window.handleQuantityChange = function(element) {
                if (parseInt(element.value, 10) <= 0) {
                    element.value = 0;
                    showWarning("Product quantity is 0, but you can still proceed with the order.");
                }

                updateTotalAmount();
                updateHiddenInputs();
            };


            function updateTotalAmount() {
                let productTotal = 0;
                const rows = document.querySelectorAll("#listOrderTableEdit tbody tr");


                rows.forEach(row => {
                    const quantityInput = row.querySelector(".quantityEdit");
                    const price = parseFloat(quantityInput.dataset.price);
                    const quantity = parseInt(quantityInput.value, 10);
                    productTotal += price * quantity;
                });


                const discountInput = document.getElementById("DiscountEdit").value.trim();
                let discount = 0;
                if (discountInput.includes('%')) {
                    const percentage = parseFloat(discountInput.replace('%', '')) || 0;
                    discount = (productTotal * percentage) / 100;
                } else {
                    discount = parseFloat(discountInput) || 0;
                }

                let discountedTotal = productTotal - discount;
                if (discountedTotal < 0) discountedTotal = 0;


                const rushFee = parseFloat(document.getElementById("RushInputEdit").value) || 0;
                const customizationFee = parseFloat(document.getElementById("CustomizationEdit").value) || 0;
                const deliveryFee = parseFloat(document.getElementById("DeliveryFeeEdit").value) || 0;


                document.getElementById("RushInputEdit").value = rushFee.toFixed();
                document.getElementById("CustomizationEdit").value = customizationFee.toFixed();
                document.getElementById("DeliveryFeeEdit").value = deliveryFee.toFixed();

                let netTotal = discountedTotal + rushFee + customizationFee + deliveryFee;


                let downpayment = parseFloat(document.getElementById("DownpaymentEdit").value) || 0;
                if (downpayment > netTotal) {
                    downpayment = netTotal;
                    document.getElementById("DownpaymentEdit").value = downpayment.toFixed();
                }

                let finalTotal = netTotal - downpayment;


                document.getElementById("totalAmountListEdit").textContent = productTotal.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                document.getElementById("totalAmountBottomEdit").textContent = finalTotal.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });


                document.getElementById("totalAmountInputEdit").value = finalTotal.toFixed(2);
            }

            window.removeItem = function(button) {
                const row = button.closest('tr');
                if (row) {
                    row.remove();
                    updateTotalAmount();
                    updateHiddenInputs();
                }
            };

            function updateHiddenInputs() {
                const rows = document.querySelectorAll("#listOrderTableEdit tbody tr");
                let itemIds = [];
                let orderItemIds = [];
                let variantIds = [];
                let productNames = [];
                let colors = [];
                let sizes = [];
                let quantities = [];
                let unitPrices = [];

                rows.forEach(row => {
                    const itemId = row.getAttribute("data-order-item-id") || "";
                    const orderItemId = row.querySelector(".orderItemId") ? row.querySelector(".orderItemId").value : "";
                    const variantId = row.getAttribute("data-variant-id") || "";
                    const productName = row.querySelector(".listProductName").textContent.trim();
                    const color = row.querySelector(".liss:nth-child(2)").textContent.trim();
                    const size = row.querySelector(".liss:nth-child(3)").textContent.trim();
                    const quantity = row.querySelector(".quantityEdit").value;
                    const unitPrice = row.querySelector(".quantityEdit").dataset.price;

                    if (variantId && productName) { // Ensure non-empty values
                        itemIds.push(itemId);
                        orderItemIds.push(orderItemId);
                        variantIds.push(variantId);
                        productNames.push(productName);
                        colors.push(color);
                        sizes.push(size);
                        quantities.push(quantity);
                        unitPrices.push(unitPrice);
                    }
                });

                // Update the hidden input fields
                document.getElementById("hiddenItemIDs").value = itemIds.join(",");
                document.getElementById("hiddenOrderItemIDs").value = orderItemIds.join(",");
                document.getElementById("hiddenVariantIDEdit").value = variantIds.join(",");
                document.getElementById("hiddenProductNameEdit").value = productNames.join(",");
                document.getElementById("hiddenColorEdit").value = colors.join(",");
                document.getElementById("hiddenSizeEdit").value = sizes.join(",");
                document.getElementById("hiddenQuantityEdit").value = quantities.join(",");
                document.getElementById("hiddenUnitPriceEdit").value = unitPrices.join(",");

                // Debug logs
                console.log('Hidden Inputs Updated:');
                console.log('Item IDs:', document.getElementById("hiddenItemIDs").value);
                console.log('Order Item IDs:', document.getElementById("hiddenOrderItemIDs").value);
                console.log('Variant IDs:', document.getElementById("hiddenVariantIDEdit").value);
                console.log('Product Names:', document.getElementById("hiddenProductNameEdit").value);
                console.log('Colors:', document.getElementById("hiddenColorEdit").value);
                console.log('Sizes:', document.getElementById("hiddenSizeEdit").value);
                console.log('Quantities:', document.getElementById("hiddenQuantityEdit").value);
                console.log('Unit Prices:', document.getElementById("hiddenUnitPriceEdit").value);
            }







            function initializeTotalAmount() {
                updateTotalAmount();
            }

            function initializeHiddenInputs() {
                updateHiddenInputs();
            }

            const feeInputs = [
                document.getElementById("RushInputEdit"),
                document.getElementById("CustomizationEdit"),
                document.getElementById("DiscountEdit"),
                document.getElementById("DownpaymentEdit"),
                document.getElementById("DeliveryFeeEdit")
            ];

            feeInputs.forEach(input => {
                if (input) {
                    input.addEventListener("input", function() {

                        if (parseFloat(input.value) < 0) {
                            input.value = 0;
                        }
                        updateTotalAmount();
                        updateHiddenInputs();
                    });
                }
            });

            updateTotalAmount();
            updateHiddenInputs();
        });
    </script>


</body>

</html