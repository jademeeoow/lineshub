// Add event listener for closing the print container when clicked outside of it
document.getElementById('printContainer').addEventListener('click', function(event) {
    const mainPrint = document.querySelector('.mainPrint');
    if (!mainPrint.contains(event.target)) {
        this.style.display = 'none';
    }
});







// Function to populate the print form with order data
function populatePrintForm(orderId) {
    document.getElementById('printContainer').style.display = 'flex';

    // Fetch order details
    fetch(`../../php/get_order_details.php?order_id=${orderId}`)
    
        .then(response => response.json())
        .then(data => {
            console.log('API Response:', data);

            if (data.customer && data.order) {
                // Populate customer and order details
                document.getElementById('printCustomerName').innerText = `${data.customer.first_name} ${data.customer.last_name}`;
                document.getElementById('printPhoneNumber').innerText = data.customer.phone_number;
                document.getElementById('printHouseNoStreet').innerText = `${data.customer.house_no}, ${data.customer.street_address}`;
                document.getElementById('printBarangay').innerText = data.customer.barangay;
                document.getElementById('printLandmark').innerText = data.customer.landmark || 'None';
                document.getElementById('printOrderID').innerText = data.order.order_id;
                document.getElementById('printDeliveryDate').innerText = data.order.delivery_date;
                document.getElementById('printOrderType').innerText = data.order.order_type;
                document.getElementById('printAdditionalInstructions').innerText = data.order.additional_instructions || 'None';
                document.getElementById('printDeliveryorPickup').innerText = data.order.delivery_method || 'Not specified';
                document.getElementById('printCompanyName').innerText = data.customer.company_name || 'None';
                document.getElementById('printStatus').innerText = data.order.status;

                // Populate fees and calculate total amount
                document.getElementById('printDiscount').innerText = data.order.discount;
                document.getElementById('printRushFee').innerText = `₱${parseFloat(data.order.rush_fee).toFixed(2)}`;
                document.getElementById('printCustomizationFee').innerText = `₱${parseFloat(data.order.customization_fee).toFixed(2)}`;
                document.getElementById('printDeliveryFee').innerText = `₱${parseFloat(data.order.delivery_fee).toFixed(2)}`;
                document.getElementById('printDownpayment').innerText = `₱${parseFloat(data.order.downpayment).toFixed(2)}`;

                // Calculate total amount with discount and fees
                let baseTotal = data.items.reduce((sum, item) => sum + (parseFloat(item.unit_price) * parseInt(item.quantity)), 0);
                let discountValue = data.order.discount.includes('%')
                    ? baseTotal * (parseFloat(data.order.discount.replace('%', '')) / 100)
                    : parseFloat(data.order.discount);

                let totalAmount = baseTotal - discountValue + parseFloat(data.order.rush_fee) +
                    parseFloat(data.order.customization_fee) + parseFloat(data.order.delivery_fee) -
                    parseFloat(data.order.downpayment);
                document.getElementById('printTotalAmount').innerText = `₱${totalAmount.toFixed(2)}`;

                // Populate order items table
                const printOrderItemsTable = document.getElementById('printOrderItems');
                printOrderItemsTable.querySelectorAll('tr:not(.tableheader)').forEach(row => row.remove());

                let totalSum = 0;

                if (Array.isArray(data.items) && data.items.length > 0) {
                    data.items.forEach(item => {
                        const unitPrice = parseFloat(item.unit_price);
                        const color = item.variant_color || "Not specified";
                        const size = item.variant_size || "Not specified";
                        const quantity = parseInt(item.quantity);
                        const itemTotal = unitPrice * quantity;
                        totalSum += itemTotal;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.product_name}</td>
                            <td>${color}</td>
                            <td>${size}</td>
                            <td>${quantity}</td>
                            <td>₱${unitPrice.toFixed(2)}</td>
                            <td>₱${itemTotal.toFixed(2)}</td>
                        `;
                        printOrderItemsTable.appendChild(row);
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="6">No items found</td>';
                    printOrderItemsTable.appendChild(row);
                }

                const totalRow = document.createElement('tr');
                totalRow.innerHTML = `
                    <td colspan="4" style="font-weight: bold;">Total Product Amount</td>
                    <td colspan="2" style="font-weight: bold;">₱${totalSum.toFixed(2)}</td>
                `;
                printOrderItemsTable.appendChild(totalRow);
            } else {
                console.error('Unexpected data structure:', data);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
}

// Call the function to apply responsive styles on load
