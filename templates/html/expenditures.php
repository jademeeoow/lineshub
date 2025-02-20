<?php

include_once "../../php/expenditures.php"




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenditures</title>
    <link rel="stylesheet" href="../../static/style/dashboard.css">
    <link rel="stylesheet" href="../../static/style/expenditures.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>
    .exp-table tr.no-border-row td {
        border-top: none;
    }

    .exp-table td,
    .exp-table th {
        border: 1px solid #ccc;
        /* Keep borders for other rows */
    }

    .exp-table tr.totals-row td {
        border-top: 2px solid #333;
        /* Stronger border for total row */
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
                    <h1>EXPENDITURES</h1>
                </div>
                <div class="marjcontent">
                    <div class="btnexp">
                        <button onclick="openAddExp()">Add Expenses</button>
                    </div>



                    <div class="aaaa">
                        <div class="filterCon">
                            <div id="h3s" style="font-weight: bold;">

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
                                <input type="text" name="" id="searchInput" spellcheck="false">
                                <i class="fas fa-times" onclick="cancelSearch()"></i>
                            </div>


                            <div class="filwrap">

                                <i class="fas fa-filter" onclick="toggleFilter()"></i>
                                <i class="fas fa-print" onclick="redirectToPrintPage()" target="_blank"></i>
                                <div class="filterSales" id="filterSales" style="display: none;">
                                    <div class="sales-filter">
                                        <h2>View Data by Month</h2>
                                        <form method="GET" action="expenditures.php" id="salesForm">
                                            <label for="year">Year:</label>
                                            <select name="year" id="year" onchange="document.getElementById('salesForm').submit();">
                                                <option value="all" <?php echo ($selectedYear == 'all') ? 'selected' : ''; ?>>All</option>
                                                <?php
                                                $startYear = 2025;
                                                $currentYear = date("Y");
                                                for ($i = $currentYear; $i >= $startYear; $i--): ?>
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $selectedYear) ? 'selected' : ''; ?>>
                                                        <?php echo $i; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>

                                            <label for="month">Month:</label>
                                            <select name="month" id="month" onchange="document.getElementById('salesForm').submit();">
                                                <option value="0" <?php echo ($selectedMonth == 0) ? 'selected' : ''; ?>>All</option>
                                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                                    <option value="<?php echo $m; ?>" <?php echo ($m == $selectedMonth) ? 'selected' : ''; ?>>
                                                        <?php echo date("F", mktime(0, 0, 0, $m, 1)); ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </form>
                                    </div>




                                </div>
                            </div>


                        </div>




                        <div class="exp-table">
                            <table>
                                <tr class="tableheader">
                                    <td>Date</td>
                                    <td>Capital Cost Breakdown</td>
                                    <td>Capital Cost</td>
                                    <td>Electricity Cost Breakdown</td>
                                    <td>Electricity Cost</td>
                                    <td>Maintenance Cost Breakdown</td>
                                    <td>Maintenance Cost</td>
                                    <td>Logistics Cost Breakdown</td>
                                    <td>Logistics Cost</td>
                                    <td>Total Amount</td>
                                    <td>Edit</td>
                                    <td>Delete</td>
                                </tr>

                                <?php if (!empty($expenditures)): ?>
                                    <?php
                                    $totalCapital = $totalElectricity = $totalMaintenance = $totalLogistics = $grandTotal = 0;

                                    foreach ($expenditures as $expenditure):
                                        $date = date('F Y', strtotime($expenditure['date']));


                                        $capital_breakdown = $expenditure['capital_breakdown'];
                                        $electricity_breakdown = $expenditure['electricity_breakdown'];
                                        $maintenance_breakdown = $expenditure['maintenance_breakdown'];
                                        $logistics_breakdown = $expenditure['logistics_breakdown'];

                                        $maxRows = max(count($capital_breakdown), count($electricity_breakdown), count($maintenance_breakdown), count($logistics_breakdown));

                                        $totalCapital += array_sum(array_column($capital_breakdown, 'amount'));
                                        $totalElectricity += array_sum(array_column($electricity_breakdown, 'amount'));
                                        $totalMaintenance += array_sum(array_column($maintenance_breakdown, 'amount'));
                                        $totalLogistics += array_sum(array_column($logistics_breakdown, 'amount'));
                                        $grandTotal += $expenditure['total_amount'];
                                    ?>
                                        <?php for ($i = 0; $i < $maxRows; $i++): ?>
                                            <tr class="<?php echo $i === 0 ? '' : 'no-border-row'; ?>">
                                                <?php if ($i === 0): ?>
                                                    <td rowspan="<?php echo $maxRows; ?>"><?php echo htmlspecialchars($date); ?></td>
                                                <?php endif; ?>

                                                <td><?php echo htmlspecialchars($capital_breakdown[$i]['description'] ?? ''); ?></td>
                                                <td><?php echo isset($capital_breakdown[$i]['amount']) ? '₱' . number_format($capital_breakdown[$i]['amount'], 2) : ''; ?></td>

                                                <td><?php echo htmlspecialchars($electricity_breakdown[$i]['description'] ?? ''); ?></td>
                                                <td><?php echo isset($electricity_breakdown[$i]['amount']) ?     '₱' . number_format($electricity_breakdown[$i]['amount'], 2) : ''; ?></td>

                                                <td><?php echo htmlspecialchars($maintenance_breakdown[$i]['description'] ?? ''); ?></td>
                                                <td><?php echo isset($maintenance_breakdown[$i]['amount']) ? '₱' . number_format($maintenance_breakdown[$i]['amount'], 2) : ''; ?></td>

                                                <td><?php echo htmlspecialchars($logistics_breakdown[$i]['description'] ?? ''); ?></td>
                                                <td><?php echo isset($logistics_breakdown[$i]['amount']) ? '₱' . number_format($logistics_breakdown[$i]['amount'], 2) : ''; ?></td>

                                                <?php if ($i === 0): ?>
                                                    <td rowspan="<?php echo $maxRows; ?>"><?php echo '₱' . number_format($expenditure['total_amount'], 2); ?></td>
                                                    <td rowspan="<?php echo $maxRows; ?>">
                                                        <button onclick="populateExpenditureEditForm(<?php echo $expenditure['expenditure_id']; ?>)">Edit</button>
                                                    </td>
                                                    <td rowspan="<?php echo $maxRows; ?>">
                                                        <button onclick="openDeleteModal(<?php echo $expenditure['expenditure_id']; ?>, '<?php echo htmlspecialchars($date); ?>')">Delete</button>

                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endforeach; ?>

                                    <tr class="totals-row">
                                        <td><strong>Total</strong></td>
                                        <td colspan="1"></td>
                                        <td><strong>₱<?php echo number_format($totalCapital, 2); ?></strong></td>
                                        <td colspan="1"></td>
                                        <td><strong>₱<?php echo number_format($totalElectricity, 2); ?></strong></td>
                                        <td colspan="1"></td>
                                        <td><strong>₱<?php echo number_format($totalMaintenance, 2); ?></strong></td>
                                        <td colspan="1"></td>
                                        <td><strong>₱<?php echo number_format($totalLogistics, 2); ?></strong></td>
                                        <td><strong>₱<?php echo number_format($grandTotal, 2); ?></strong></td>
                                        <td colspan="2"></td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12">No expenditures found</td>
                                    </tr>
                                <?php endif; ?>

                            </table>
                        </div>






                    </div>


                </div>

                <div class="addExpenceContainer" id="addExpenceContainer">
                    <div class="conexp">
                        <div class="marjOption">
                            <div class="addMonthTitle">
                                <p>Adding Expenses for
                                    <span id="addMonthText"></span>
                                </p>
                            </div>
                            <div class="addTitle">
                                <p>Add Expenses</p>
                                <i class="fas fa-times" onclick="closeAddExp()"></i>
                            </div>
                            <form action="expenditures.php" method="POST" id="expenseFOrm">

                                <input type="hidden" name="selected_year" id="selectedYearInput" value="<?php echo $selectedYear; ?>">
                                <input type="hidden" name="selected_month" id="selectedMonthInput" value="<?php echo $selectedMonth; ?>">
                                <div class="axs">
                                    <div class="topCost">
                                        <!-- Capital Cost -->
                                        <div class="captCost cost">
                                            <div class="costTitle">
                                                <p>Capital Cost</p>
                                            </div>
                                            <div class="capitalCostBreakdown CB" id="capitalCostBreakdown">
                                                <div class="wrapInpExp">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="addCost">
                                                <p onclick="addCapitalBreakdown()">Add Cost +</p>
                                                <p>Total: <a id="capitalTotal">0.00</a></p>
                                            </div>
                                        </div>

                                        <!-- Electricity Cost -->
                                        <div class="ElectCost cost">
                                            <div class="costTitle">
                                                <p>Electricity Cost</p>
                                            </div>
                                            <div class="electricityCostBreakdown CB" id="electricityCostBreakdown">
                                                <div class="wrapInpExp">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="addCost">
                                                <p onclick="addElectricityBreakdown()">Add Cost +</p>
                                                <p>Total: <a id="electricityTotal">0.00</a></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bottomCost">
                                        <!-- Maintenance Cost -->
                                        <div class="MainCost cost">
                                            <div class="costTitle">
                                                <p>Maintenance Cost</p>
                                            </div>
                                            <div class="maintenanceCostBreakdown CB" id="maintenanceCostBreakdown">
                                                <div class="wrapInpExp">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="addCost">
                                                <p onclick="addMaintenanceBreakdown()">Add Cost +</p>
                                                <p>Total: <a id="maintenanceTotal">0.00</a></p>
                                            </div>
                                        </div>

                                        <!-- Logistics Cost -->
                                        <div class="logisCost cost">
                                            <div class="costTitle">
                                                <p>Logistics Cost</p>
                                            </div>
                                            <div class="logisticsCostBreakdown CB" id="logisticsCostBreakdown">
                                                <div class="wrapInpExp">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="addCost">
                                                <p onclick="addLogisticsBreakdown()">Add Cost +</p>
                                                <p>Total: <a id="logisticsTotal">0.00</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="addBtnExp">
                                    <button type="submit" name="add_expenditure" style="margin: 10px;">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="addExpenceContainer" id="editExpenceContainer" style="display: none;">
                <div class="conexp">
                    <div class="marjOption">

                        <div class="editMonthTitle">
                            <p>Editing for the month of
                                <?php
                                $monthName = date("F", mktime(0, 0, 0, $selectedMonth, 10));
                                echo $monthName;
                                ?>
                            </p>
                        </div>
                        <div class="addTitle">
                            <p>Edit Expenses</p>
                            <i class="fas fa-times" onclick="closeEditExp()"></i>
                        </div>
                        <form action="expenditures.php" method="POST" id="editExpenseForm">
                            <!-- Hidden input to store the expenditure ID being edited -->
                            <input type="hidden" name="selected_year" id="editSelectedYearInput" value="<?php echo $selectedYear; ?>">
                            <input type="hidden" name="selected_month" id="editSelectedMonthInput" value="<?php echo $selectedMonth; ?>">

                            <input type="hidden" name="edit_expenditure_id" id="edit_expenditureId">



                            <div class="axs">
                                <div class="topCost">
                                    <!-- Capital Cost -->
                                    <div class="captCost cost">
                                        <div class="costTitle">
                                            <p>Capital Cost</p>
                                        </div>
                                        <div class="capitalCostBreakdown CB" id="edit_capital_descBreakdown">
                                            <div class="wrapInpExp">
                                                <div class="parexptext">
                                                    <label for="capital">Capital Cost</label>
                                                    <div class="inpexptext">
                                                        <input type="text" name="edit_capital_desc[]" placeholder="Description Cost">
                                                    </div>
                                                </div>
                                                <div class="parexp">
                                                    <label for="capital_amount">Amount</label>
                                                    <div class="inpexp">
                                                        <input type="number" name="edit_capital_amount[]" step="0.01" placeholder="0.00" class="editCapitalCost">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="addCost">
                                            <p style="background-color: transparent;"></p>
                                            <p>Total: <span id="capitalTotalEdit">₱ 0.00</span></p>
                                        </div>
                                    </div>

                                    <!-- Electricity Cost -->
                                    <div class="ElectCost cost">
                                        <div class="costTitle">
                                            <p>Electricity Cost</p>
                                        </div>
                                        <div class="electricityCostBreakdown CB" id="edit_electricity_descBreakdown">
                                            <div class="wrapInpExp">
                                                <div class="parexptext">
                                                    <label for="electricity">Electricity Cost</label>
                                                    <div class="inpexptext">
                                                        <input type="text" name="edit_electricity_desc[]" placeholder="Description Cost">
                                                    </div>
                                                </div>
                                                <div class="parexp">
                                                    <label for="electricity_amount">Amount</label>
                                                    <div class="inpexp">
                                                        <input type="number" name="edit_electricity_amount[]" step="0.01" placeholder="0.00" class="editElectricityCost">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="addCost">
                                            <p style="background-color: transparent;"></p>
                                            <p>Total: <span id="electricityTotalEdit">₱ 0.00</span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bottomCost">
                                    <!-- Maintenance Cost -->
                                    <div class="MainCost cost">
                                        <div class="costTitle">
                                            <p>Maintenance Cost</p>
                                        </div>
                                        <div class="maintenanceCostBreakdown CB" id="edit_maintenance_descBreakdown">
                                            <div class="wrapInpExp">
                                                <div class="parexptext">
                                                    <label for="maintenance">Maintenance Cost</label>
                                                    <div class="inpexptext">
                                                        <input type="text" name="edit_maintenance_desc[]" placeholder="Description Cost">
                                                    </div>
                                                </div>
                                                <div class="parexp">
                                                    <label for="maintenance_amount">Amount</label>
                                                    <div class="inpexp">
                                                        <input type="number" name="edit_maintenance_amount[]" step="0.01" placeholder="0.00" class="editMaintenanceCost">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="addCost">
                                            <p style="background-color: transparent;"></p>
                                            <p>Total: <span id="maintenanceTotalEdit">₱ 0.00</span></p>
                                        </div>
                                    </div>

                                    <!-- Logistics Cost -->
                                    <div class="logisCost cost">
                                        <div class="costTitle">
                                            <p>Logistics Cost</p>
                                        </div>
                                        <div class="logisticsCostBreakdown CB" id="edit_logistics_descBreakdown">
                                            <div class="wrapInpExp">
                                                <div class="parexptext">
                                                    <label for="logistics">Logistics Cost</label>
                                                    <div class="inpexptext">
                                                        <input type="text" name="edit_logistics_desc[]" placeholder="Description Cost">
                                                    </div>
                                                </div>
                                                <div class="parexp">
                                                    <label for="logistics_amount">Amount</label>
                                                    <div class="inpexp">
                                                        <input type="number" name="edit_logistics_amount[]" step="0.01" placeholder="0.00" class="editLogisticsCost">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="addCost">
                                            <p style="background-color: transparent;"></p>
                                            <p>Total: <span id="logisticsTotalEdit">₱ 0.00</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="addBtnExp">
                                <button type="submit" name="save_edit_expenditure" style="margin: 10px;">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>


        <div id="customWarningModal" class="modal">
            <div class="modal-content warning">
                <span class="close" onclick="closeCustomWarningModal()">&times;</span>
                <p id="customWarningMessage"></p>
            </div>
        </div>








        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('successModal')">&times;</span>
                <p id="successMessage"></p>
            </div>
        </div>

        <div id="errorModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('errorModal')">&times;</span>
                <p id="errorMessage"></p>
            </div>
        </div>

        <div id="deleteModal" class="modal" style="display:none;">
            <div class="modal-content">
                <p>Are you sure you want to delete all expenditures from <span id="expenditureIdText"></span>?</p>
                <form action="expenditures.php" method="POST">
                    <input type="hidden" name="delete_expenditure_id" id="deleteExpenditureId">
                    <button class="yellowButton" type="submit" name="delete_expenditure">Yes</button>
                    <button type="button" onclick="closeDeleteModal()">No</button>
                </form>
            </div>
        </div>



        <script src="../../static/script/script.js"></script>
        <script src="../../static/script/expenditures.js"></script>

        <script>
            function redirectToPrintPage() {
                const year = document.getElementById('year').value;
                const month = document.getElementById('month').value;
                window.open(`../Print_Table/tablePrintExpenditures.php?year=${year}&month=${month}`, '_blank');
            }

            document.addEventListener("DOMContentLoaded", function() {
                console.log("DOMContentLoaded event triggered");

                <?php
                if (isset($_SESSION['message'])) {
                    echo "console.log('Success message detected');";
                    echo "document.getElementById('successMessage').innerText = '" . $_SESSION['message'] . "';";
                    echo "document.getElementById('successModal').style.display = 'block';";
                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['message2']) && !empty($_SESSION['message2'])) {
                    echo "console.log('Error message detected');";
                    echo "document.getElementById('errorModal').style.display = 'block';";
                    echo "document.getElementById('errorMessage').innerHTML = '" . implode("<br>", $_SESSION['message2']) . "';";
                    unset($_SESSION['message2']);
                }
                ?>


                window.onclick = function(event) {
                    const modals = ['successModal', 'errorModal'];
                    modals.forEach(modalId => {
                        const modal = document.getElementById(modalId);
                        if (event.target == modal) {
                            closeModal(modalId);
                        }
                    });
                };
            });


            function populateExpenditureEditForm(expenditureId) {
                fetch(`../../php/get_expenditure.php?expenditure_id=${expenditureId}`)
                    .then(response => {
                        if (!response.ok) {
                            console.error('Failed to fetch expenditure data:', response.statusText);
                            throw new Error('Failed to fetch expenditure data.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Fetched data:', data);

                        if (data.status === 'success' && data.expenditure) {
                            document.getElementById('edit_expenditureId').value = data.expenditure.expenditure_id;


                            const expenditureDate = new Date(data.expenditure.date);
                            const monthName = expenditureDate.toLocaleString('default', {
                                month: 'long'
                            });
                            const year = expenditureDate.getFullYear();


                            document.querySelector('.editMonthTitle p').textContent = `Editing for the month of ${monthName} ${year}`;


                            populateEditFields(data.expenditure.capital_breakdown, 'edit_capital_desc[]', 'edit_capital_amount[]', 'edit_capital_id[]');
                            populateEditFields(data.expenditure.electricity_breakdown, 'edit_electricity_desc[]', 'edit_electricity_amount[]', 'edit_electricity_id[]');
                            populateEditFields(data.expenditure.maintenance_breakdown, 'edit_maintenance_desc[]', 'edit_maintenance_amount[]', 'edit_maintenance_id[]');
                            populateEditFields(data.expenditure.logistics_breakdown, 'edit_logistics_desc[]', 'edit_logistics_amount[]', 'edit_logistics_id[]');

                            initializeEditCalculations();

                            openEditExp();
                        } else {
                            console.error('Error in response data:', data);
                            alert('Error fetching expenditure data: ' + (data.message || 'Invalid response'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while fetching the expenditure data.');
                    });
            }


            function openEditExp() {
                document.getElementById('editExpenceContainer').style.display = 'flex';
            }


            function closeEditExp() {
                document.getElementById('editExpenceContainer').style.display = 'none';
            }

            document.getElementById('editExpenseForm').addEventListener('submit', function(event) {

                const deleteFields = document.querySelectorAll('input[name^="delete_"]');
                deleteFields.forEach(field => {
                    console.log(`Delete field: ${field.name}, Value: ${field.value}`);
                });
            });


            function populateEditFields(breakdown, descFieldName, amountFieldName, idFieldName) {
                const containerId = descFieldName.split('[')[0] + 'Breakdown';
                const container = document.getElementById(containerId);

                container.innerHTML = '';

                breakdown.forEach(item => {
                    const newField = document.createElement('div');
                    newField.classList.add('wrapInpExp');

                    const uniqueId = item.id || '';
                    const isNewRow = !uniqueId;

                    newField.innerHTML = `
    <input type="hidden" name="${idFieldName}" value="${uniqueId}">
    <input  style = "width:15px;" type="hidden" name="delete_${idFieldName}[]" value="0" id="delete_${idFieldName}_${uniqueId}">

    <div class="parexptext">
        <label>Description</label>
        <div class="inpexptext">
            <input type="text" name="${descFieldName}" value="${item.description}" placeholder="Description Cost">
        </div>
    </div>

    <div class="parexp">
        <label>Amount</label>
        <div class="inpexp">
            <input type="number" name="${amountFieldName}" value="${item.amount}" step="0.01" placeholder="0.00" class="${amountFieldName.replace('[]', '')}" oninput="calculateTotal('${amountFieldName.replace('[]', '')}', '${descFieldName.split('[')[0]}TotalEdit')">
        </div>
    </div>

    <button type="button" class="clearyellowButton" onclick="clearBreakdownRow('${uniqueId}', '${idFieldName}')">
    <i class="fas fa-times"></i>
    <span class="tooltip">Remove</span>
</button>



`;


                    container.appendChild(newField);
                });
            }



            function initializeEditCalculations() {

                const costTypes = ['edit_capital_amount', 'edit_electricity_amount', 'edit_maintenance_amount', 'edit_logistics_amount'];


                costTypes.forEach(costType => {
                    const inputs = document.querySelectorAll(`.${costType}`);
                    inputs.forEach(input => {
                        input.addEventListener('input', () => calculateTotal(costType, `${costType.split('_')[1]}TotalEdit`));
                    });


                    calculateTotal(costType, `${costType.split('_')[1]}TotalEdit`);
                });
            }

            function calculateTotal(inputClass, totalElementId) {

                const inputs = document.querySelectorAll(`.${inputClass}`);
                let total = 0;


                inputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });


                const totalElement = document.getElementById(totalElementId);
                if (totalElement) {
                    totalElement.textContent = `₱ ${total.toFixed(2)}`;
                }
            }


            function openDeleteModal(expenditureId, date) {
                document.getElementById("deleteExpenditureId").value = expenditureId;
                document.getElementById("expenditureIdText").textContent = date;
                document.getElementById("deleteModal").style.display = "block";
            }

            function clearBreakdownRow(uniqueId, idFieldName) {
                const deleteFlagField = document.getElementById(`delete_${idFieldName}_${uniqueId}`);

                if (deleteFlagField) {
                    deleteFlagField.value = "1";
                    console.log(`Delete flag set for ${idFieldName} with unique ID ${uniqueId}`);
                } else {
                    console.log(`Delete flag field not found for unique ID: ${uniqueId}`);
                }


                const rowContainer = deleteFlagField.closest('.wrapInpExp');
                const descriptionField = rowContainer.querySelector(`input[name="${idFieldName.replace('id', 'desc')}"]`);
                const amountField = rowContainer.querySelector(`input[name="${idFieldName.replace('id', 'amount')}"]`);

                if (descriptionField) descriptionField.value = '';
                if (amountField) amountField.value = '';

                console.log(`Row with unique ID ${uniqueId} cleared for deletion in ${idFieldName}.`);
            }


            function openAddExp() {

                const selectedYear = document.getElementById('selectedYearInput').value;
                const selectedMonth = document.getElementById('selectedMonthInput').value;


                if (selectedMonth && selectedMonth !== "0") {
                    const monthName = new Date(selectedYear, selectedMonth - 1).toLocaleString('default', {
                        month: 'long'
                    });
                    document.getElementById('addMonthText').textContent = `${monthName} ${selectedYear}`;
                } else {
                    document.getElementById('addMonthText').textContent = "Please select a specific month";
                }

                document.getElementById("addExpenceContainer").style.display = "flex";
            }
        </script>
</body>

</html>