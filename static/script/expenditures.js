
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function() {
    initializeCalculations();
});


function initializeCalculations() {
    addEventListenersToInputs('capitalCost', 'capitalTotal');
    addEventListenersToInputs('electricityCost', 'electricityTotal');
    addEventListenersToInputs('maintenanceCost', 'maintenanceTotal');
    addEventListenersToInputs('logisticsCost', 'logisticsTotal');
}


function addEventListenersToInputs(inputClass, totalElementId) {
    const inputs = document.querySelectorAll(`.${inputClass}`);
    inputs.forEach(input => {
        input.addEventListener('input', () => calculateTotal(inputClass, totalElementId));
    });
    calculateTotal(inputClass, totalElementId);
}


function calculateTotal(inputClass, totalElementId) {
    const inputs = document.querySelectorAll(`.${inputClass}`);
    let total = 0;
    inputs.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
    });
    document.getElementById(totalElementId).textContent = `₱ ${total.toFixed(2)}`;
}



function addCapitalBreakdown() {
    const container = document.getElementById("capitalCostBreakdown");
    const newEntry = document.createElement("div");
    newEntry.classList.add("wrapInpExp");
    newEntry.innerHTML = `
<div class="parexptext">
<label for="capital">Capital Cost</label>
<div class="inpexptext">
    <input type="text" name="capital_desc[]" placeholder="Description Cost">
</div>
</div>
<div class="parexp">
<label for="capital_amount">Amount</label>
<div class="inpexp">
    <input type="number" name="capital_amount[]" step="0.01" placeholder="0.00" class="capitalCost">
</div>
</div>`;
    container.appendChild(newEntry);


    newEntry.querySelector('.capitalCost').addEventListener('input', () => calculateTotal('capitalCost', 'capitalTotal'));
    calculateTotal('capitalCost', 'capitalTotal');
}

function addElectricityBreakdown() {
    const container = document.getElementById("electricityCostBreakdown");
    const newEntry = document.createElement("div");
    newEntry.classList.add("wrapInpExp");
    newEntry.innerHTML = `
<div class="parexptext">
<label for="electricity">Electricity Cost</label>
<div class="inpexptext">
    <input type="text" name="electricity_desc[]" placeholder="Description Cost">
</div>
</div>
<div class="parexp">
<label for="electricity_amount">Amount</label>
<div class="inpexp">
    <input type="number" name="electricity_amount[]" step="0.01" placeholder="0.00" class="electricityCost">
</div>
</div>`;
    container.appendChild(newEntry);


    newEntry.querySelector('.electricityCost').addEventListener('input', () => calculateTotal('electricityCost', 'electricityTotal'));
    calculateTotal('electricityCost', 'electricityTotal');
    n
}

function addMaintenanceBreakdown() {
    const container = document.getElementById("maintenanceCostBreakdown");
    const newEntry = document.createElement("div");
    newEntry.classList.add("wrapInpExp");
    newEntry.innerHTML = `
<div class="parexptext">
<label for="maintenance">Maintenance Cost</label>
<div class="inpexptext">
    <input type="text" name="maintenance_desc[]" placeholder="Description Cost">
</div>
</div>
<div class="parexp">
<label for="maintenance_amount">Amount</label>
<div class="inpexp">
    <input type="number" name="maintenance_amount[]" step="0.01" placeholder="0.00" class="maintenanceCost">
</div>
</div>`;
    container.appendChild(newEntry);

    newEntry.querySelector('.maintenanceCost').addEventListener('input', () => calculateTotal('maintenanceCost', 'maintenanceTotal'));
    calculateTotal('maintenanceCost', 'maintenanceTotal');
}

function addLogisticsBreakdown() {
    const container = document.getElementById("logisticsCostBreakdown");
    const newEntry = document.createElement("div");
    newEntry.classList.add("wrapInpExp");
    newEntry.innerHTML = `
<div class="parexptext">
<label for="logistics">Logistics Cost</label>
<div class="inpexptext">
    <input type="text" name="logistics_desc[]" placeholder="Description Cost">
</div>
</div>
<div class="parexp">
<label for="logistics_amount">Amount</label>
<div class="inpexp">
    <input type="number" name="logistics_amount[]" step="0.01" placeholder="0.00" class="logisticsCost">
</div>
</div>`;
    container.appendChild(newEntry);


    newEntry.querySelector('.logisticsCost').addEventListener('input', () => calculateTotal('logisticsCost', 'logisticsTotal'));
    calculateTotal('logisticsCost', 'logisticsTotal');
}

function openAddExp() {
    const selectedYear = parseInt(document.getElementById('year').value);
    const selectedMonth = parseInt(document.getElementById('month').value); 
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;

    // Check if "Entire Year" is selected
    if (selectedMonth === 0) {
        showCustomWarningModal("You cannot add expenses for the entire year. Please select a specific month.");
        return; // Exit the function
    }

 
    if (selectedYear < currentYear || (selectedYear === currentYear && selectedMonth <= currentMonth)) {
        document.getElementById('addExpenceContainer').style.display = 'flex';
        document.getElementById('selectedYearInput').value = selectedYear;
        document.getElementById('selectedMonthInput').value = selectedMonth;
    } else {
       
        showCustomWarningModal("You cannot add expenses for future months.");
    }
}


function showCustomWarningModal(message) {
    const modal = document.getElementById('customWarningModal');
    const messageElem = document.getElementById('customWarningMessage');
    messageElem.textContent = message;
    modal.style.display = 'block';
}

function closeCustomWarningModal() {
    document.getElementById('customWarningModal').style.display = 'none';
}

// Close modal if user clicks outside it
window.onclick = function(event) {
    const modal = document.getElementById('customWarningModal');
    if (event.target == modal) {
        closeCustomWarningModal();
    }
}
function closeAddExp() {
    document.getElementById('addExpenceContainer').style.display = 'none';
}

function toggleFilter() {
    const filterSales = document.getElementById('filterSales');
    if (filterSales.style.display === 'none') {
        filterSales.style.display = 'flex';
    } else {
        filterSales.style.display = 'none';
    }
}
function openDeleteModal(expenditureId) {
document.getElementById('deleteExpenditureId').value = expenditureId;
document.getElementById('expenditureIdText').innerText = expenditureId;
document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
document.getElementById('deleteModal').style.display = 'none';
}
