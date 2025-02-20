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
            const deliveryDateCell = row.querySelector('td:nth-last-child(5)');
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

