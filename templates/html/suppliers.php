<?php

include_once    "../../php/suppliers.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Info</title>
    <link rel="stylesheet" href="../../static/style/suppliers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>
    .filter-section {
        margin-bottom: 15px;
    }

    .filter-section label {
        margin-right: 10px;
        font-weight: bold;
    }

    .filter-section select {
        padding: 5px;
        border-radius: 5px;
    }
</style>


<body>
    <div class="whole">
        <main-header data-image-path="<?php echo $image_path; ?>" data-role="<?php echo $_SESSION['role']; ?>"></main-header>
        <div class="con">

            <?php include_once "sidemenu.php"; ?>


            <div class="content">
                <div class="title">
                    <h1>Supplier Information</h1>
                </div>
                <div class="marjcontent">
                    <div class="addAccount" style="margin-bottom: 20px;">
                        <button onclick="toggleAddSupplierForm()">Add Supplier</button>
                    </div>

                    <div class="aaaa">
                        <div class="filterCon">
                            <div id="h3s">

                            </div>


                            <div class="searchinp" id="searchinp" style="display: none;">
                                <input type="text" id="searchInput" placeholder="Search..." spellcheck="false">
                                <i class="fas fa-times" onclick="cancelSearch()"></i>
                            </div>


                            <div class="filwrap">

                                <i class="fas fa-filter" onclick="toggleFilter()"></i>

                                <div class="filterSales" id="filterBusinesstype" style="display: none;">
                                    <div class="businesstype-filter">
                                        <div class="filter-box">
                                            <h2 class="filter-title">Filter by Business Type</h2>
                                            <div class="filter-content">
                                                <label for="businessTypeFilter">Select Type:</label>
                                                <select id="businessTypeFilter" onchange="filterTable()">
                                                    <option value="all">All</option>
                                                    <option value="manufacturer">Manufacturer</option>
                                                    <option value="distributor">Distributor</option>
                                                    <option value="wholesaler">Wholesaler</option>
                                                    <option value="retailer">Retailer</option>
                                                    <option value="supplier">Supplier</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <i class="fas fa-search" onclick="toggleSearch()"></i>
                                <i class="fas fa-print" onclick="redirectToPrintPage()" target="_blank"></i>

                            </div>
                        </div>
                    </div>





                    <!-- Supplier Table -->



                    <div class="table-account table-account-superAdmin">

                        <table id="supplierTable">
                            <tr class="tableheader">
                                <td>Company Name</td>
                                <td>Contact Person</td>
                                <td>Email</td>
                                <td>Phone Number</td>
                                <td>Business Type</td>
                                <td>Products</td>
                                <td>Action</td>
                                <td style="display: none;">Delete</td>
                            </tr>
                            <?php foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($supplier['company_name'])))); ?></td>
                                    <td><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($supplier['contact_person'])))); ?></td>

                                    <td><?php echo htmlspecialchars($supplier['email']); ?></td>
                                    <td><?php echo htmlspecialchars($supplier['phone_number']); ?></td>
                                    <td><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($supplier['business_type'])))); ?></td>
                                    <td>
                                        <button onclick="viewSupplierProducts(<?php echo htmlspecialchars($supplier['supplier_id']); ?>)">
                                            View
                                        </button>
                                    </td>

                                    <td>
                                        <button onclick='editSupplier(<?php echo json_encode($supplier); ?>)'>Edit</button>
                                        <button onclick="openDeleteConfirmModal(<?php echo htmlspecialchars($supplier['supplier_id']); ?>)">Delete</button>

                                    </td>
                                    <td style="display: none;">
                                        <button onclick="openDeleteConfirmModal(<?php echo htmlspecialchars($supplier['supplier_id']); ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>




                <!-- Add Supplier Form -->
                <form action="suppliers.php" method="POST" enctype="multipart/form-data">
                    <div class="add-account" id="add-supplier" style="display: none;">
                        <div class="edit-con">
                            <div class="marjcontent-edit">
                                <div class="tag-edit-account">
                                    <p>Add Supplier</p>
                                    <i class="fas fa-times" onclick="toggleAddSupplierForm()"></i>
                                </div>

                                <!-- Supplier Information Fields -->
                                <div class="garpar">
                                    <label for="supplierName">Company Name</label>
                                    <div class="gar">
                                        <input type="text" name="supplierName" id="supplierName">
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="contactPerson">Contact Person <span class="spanner">*</span></label>
                                    <div class="gar">
                                        <input type="text" name="contactPerson" id="contactPerson" required>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="email">Email</label>
                                    <div class="gar">
                                        <input type="email" name="email" id="email">
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="phoneNumber">Phone Number <span class="spanner">*</span></label>
                                    <div class="gar">
                                        <input type="text" name="phoneNumber" id="phoneNumber" required>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="address">Address <span class="spanner">*</span></label>
                                    <div class="gar">
                                        <input type="text" name="address" id="address" required>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="businessType">Business Type <span class="spanner">*</span></label>
                                    <div class="gar">
                                        <select name="businessType" id="businessType" required>
                                            <option value="manufacturer">Manufacturer</option>
                                            <option value="distributor">Distributor</option>
                                            <option value="wholesaler">Wholesaler</option>
                                            <option value="retailer">Retailer</option>
                                            <option value="supplier">Supplier</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label>Products Provided <span class="spanner">*</span></label>
                                    <div class="gar" id="productsProvidedContainer">
                                        <div class="product-input">
                                            <input type="text" name="productsProvided[]" placeholder="Enter product" required>
                                            <button type="button" class="add-product-btn" onclick="addProductInput()">+</button>
                                            <button type="button" class="remove-product-btn" onclick="removeProductInput(this)" style="display: none;">-</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-edit">
                                    <button type="submit">Save Supplier</button>
                                    <button type="reset">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Edit Supplier Form -->
                <form action="suppliers.php" method="POST" enctype="multipart/form-data">
                    <div class="add-account" id="edit-supplier" style="display: none;">
                        <div class="edit-con">
                            <div class="marjcontent-edit">
                                <div class="tag-edit-account">
                                    <p>Edit Supplier</p>
                                    <i class="fas fa-times" onclick="toggleEditSupplierForm()"></i>
                                </div>


                                <input type="hidden" name="supplierId" id="editSupplierId">

                                <div class="garpar">
                                    <label for="editSupplierName">Company Name</label>
                                    <div class="gar">
                                        <input type="text" name="editSupplierName" id="editSupplierName">
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="editContactPerson">Contact Person</label>
                                    <div class="gar">
                                        <input type="text" name="editContactPerson" id="editContactPerson" required>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="editEmail">Email</label>
                                    <div class="gar">
                                        <input type="email" name="editEmail" id="editEmail">
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="editPhoneNumber">Phone Number </label>
                                    <div class="gar">
                                        <input type="text" name="editPhoneNumber" id="editPhoneNumber" required>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="editAddress">Address</label>
                                    <div class="gar">
                                        <input type="text" name="editAddress" id="editAddress" required>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label for="editBusinessType">Business Type</label>
                                    <div class="gar">
                                        <select name="editBusinessType" id="editBusinessType" required>
                                            <option value="manufacturer">Manufacturer</option>
                                            <option value="distributor">Distributor</option>
                                            <option value="wholesaler">Wholesaler</option>
                                            <option value="retailer">Retailer</option>
                                            <option value="supplier">Supplier</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="garpar">
                                    <label>Products Provided</label>
                                    <div class="gar" name="editProductsProvidedContainer" id="editProductsProvidedContainer" style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">

                                    </div>
                                </div>

                                <div class="btn-edit">
                                    <button type="submit" style="background-color: #ffcc00;">Update</button>
                                    <button type="reset" onclick="toggleEditSupplierForm()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>













                <!-- Modals -->
                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('successModal')">&times;</span>
                        <p id="successMessage"></p>
                    </div>
                </div>

                <div id="errorModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeErrorModal()">&times;</span>
                        <p id="errorMessage"></p>
                    </div>
                </div>

                <div id="deleteConfirmModal" class="modal" style="display:none;">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('deleteConfirmModal')">&times;</span>
                        <p>Are you sure you want to delete this category?</p>
                        <button id="confirmDeleteButton">CONFIRM</button>
                        <button id="cancel" onclick="closeModal('deleteConfirmModal')">CANCEL</button>
                    </div>
                </div>
            </div>




            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>
    </div>
    </div>





    <script src="../../static/script/script.js"></script>

    <script>
        function redirectToPrintPage() {
            window.open('../Print_Table/tablePrintSupplier.php', '_blank');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        document.addEventListener("DOMContentLoaded", function() {
            const successMessage = "<?php echo isset($_SESSION['success']) ? addslashes($_SESSION['success']) : ''; ?>";
            const errorMessage = "<?php echo isset($_SESSION['message2']) ? addslashes($_SESSION['message2']) : ''; ?>";


            if (successMessage) {
                document.getElementById('successMessage').innerText = successMessage;
                document.getElementById('successModal').style.display = 'block';
                <?php unset($_SESSION['success']); ?>
            }


            if (errorMessage) {
                document.getElementById('errorMessage').innerText = errorMessage;
                document.getElementById('errorModal').style.display = 'block';
                <?php unset($_SESSION['message2']); ?>
            }
        });



        function toggleAddSupplierForm() {
            const supplierForm = document.getElementById("add-supplier");


            supplierForm.style.display = supplierForm.style.display === "flex" ? "none" : "flex";


            if (supplierForm.style.display === "none") {
                resetAddSupplierForm();
            }
        }


        function resetAddSupplierForm() {

            document.getElementById("supplierName").value = '';
            document.getElementById("contactPerson").value = '';
            document.getElementById("email").value = '';
            document.getElementById("phoneNumber").value = '';
            document.getElementById("address").value = '';
            document.getElementById("businessType").selectedIndex = 0;


            const productsContainer = document.getElementById('productsProvidedContainer');
            productsContainer.innerHTML = '';

            addProductInput();
        }

        function addProductInput() {
            const container = document.getElementById('productsProvidedContainer');
            const newProductInput = document.createElement('div');
            newProductInput.className = 'product-input';

            newProductInput.innerHTML = `
        <input type="text" name="productsProvided[]" placeholder="Enter product" >
        <button type="button" class="add-product-btn" onclick="addProductInput()">+</button>
        <button type="button" class="remove-product-btn" onclick="removeProductInput(this)">-</button>
    `;

            container.appendChild(newProductInput);


            updateButtonVisibility(container);


            adjustContainerHeight2();
        }


        function removeProductInput(element) {
            const container = document.getElementById('productsProvidedContainer');
            container.removeChild(element.parentElement);


            updateButtonVisibility(container);


            adjustContainerHeight2();
        }




        function updateButtonVisibility(container) {
            const productInputs = container.querySelectorAll('.product-input');

            productInputs.forEach((input, index) => {
                const addButton = input.querySelector('.add-product-btn');
                const removeButton = input.querySelector('.remove-product-btn');


                addButton.style.display = index === productInputs.length - 1 ? 'inline-block' : 'none';


                removeButton.style.display = productInputs.length > 1 ? 'inline-block' : 'none';
            });
        }





        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById('productsProvidedContainer').children.length === 0) {
                addProductInput();
            }
        });

        function adjustContainerHeight2() {
            const container = document.getElementById('productsProvidedContainer');
            container.style.height = 'auto';
        }


        function toggleEditSupplierForm() {
            const editForm = document.getElementById('edit-supplier');
            editForm.style.display = editForm.style.display === 'none' || editForm.style.display === '' ? 'flex' : 'none';
        }

        function editSupplier(supplier) {

            document.getElementById('editSupplierId').value = supplier.supplier_id;
            document.getElementById('editSupplierName').value = supplier.company_name;
            document.getElementById('editContactPerson').value = supplier.contact_person;
            document.getElementById('editEmail').value = supplier.email;
            document.getElementById('editPhoneNumber').value = supplier.phone_number;
            document.getElementById('editAddress').value = supplier.address;
            document.getElementById('editBusinessType').value = supplier.business_type;


            const editProductsContainer = document.getElementById('editProductsProvidedContainer');
            editProductsContainer.innerHTML = '';

            const productsArray = supplier.products ? supplier.products.split(', ') : [];
            productsArray.forEach((product, index) => {
                const productInput = document.createElement('div');
                productInput.className = 'product-input';
                productInput.innerHTML = `
            <input type="text" name="editproductsProvided[]" value="${product}" >
            <button type="button" class="add-product-btn" onclick="addProductInputToEdit()">+</button>
            <button type="button" class="remove-product-btn" onclick="removeProductInput(this)">-</button>
        `;
                editProductsContainer.appendChild(productInput);
            });


            addProductInputToEdit();


            updateButtonVisibility(editProductsContainer);
            adjustContainerHeight('editProductsProvidedContainer');


            toggleEditSupplierForm();
        }

        function addProductInputToEdit() {
            const container = document.getElementById('editProductsProvidedContainer');
            const newProductInput = document.createElement('div');
            newProductInput.className = 'product-input';
            newProductInput.innerHTML = `
        <input type="text" name="editproductsProvided[]" placeholder="Enter product" >
        <button type="button" class="add-product-btn" onclick="addProductInputToEdit()">+</button>
        <button type="button" class="remove-product-btn" onclick="removeProductInput(this)">-</button>
    `;
            container.appendChild(newProductInput);

            updateButtonVisibility(container);


            adjustContainerHeight('editProductsProvidedContainer');
        }

        function removeProductInput(element) {
            const container = element.parentElement.parentElement;
            container.removeChild(element.parentElement);

            updateButtonVisibility(container);


            adjustContainerHeight('editProductsProvidedContainer');
        }

        function updateButtonVisibility(container) {
            const productInputs = container.querySelectorAll('.product-input');

            productInputs.forEach((input, index) => {
                const addButton = input.querySelector('.add-product-btn');
                const removeButton = input.querySelector('.remove-product-btn');

                addButton.style.display = index === productInputs.length - 1 ? 'inline-block' : 'none';


                removeButton.style.display = productInputs.length > 1 ? 'inline-block' : 'none';
            });
        }

        function adjustContainerHeight(containerId) {
            const container = document.getElementById('editProductsProvidedContainer');
            container.style.height = 'auto';
        }



        function toggleFilter() {
            const filterSales = document.getElementById('filterBusinesstype');
            if (filterSales.style.display === 'none') {
                filterSales.style.display = 'flex';
            } else {
                filterSales.style.display = 'none';
            }
        }


        function filterByBusinessType() {
            const filter = document.getElementById('businessTypeFilter').value.toLowerCase();
            const rows = document.querySelectorAll('.supplier-row');

            rows.forEach(row => {
                const businessType = row.getAttribute('data-business-type').toLowerCase();
                row.style.display = (filter === 'all' || businessType === filter) ? '' : 'none';
            });
        }


        function toggleSearch() {
            const h3s = document.getElementById('h3s');
            const searchInp = document.getElementById('searchinp');
            const searchInputField = document.getElementById('searchInput');

            if (h3s.style.display === 'none') {
                h3s.style.display = 'block';
                searchInp.style.display = 'none';
                clearSearch();
            } else {
                h3s.style.display = 'none';
                searchInp.style.display = 'flex';




                searchInputField.focus();
            }
        }


        function cancelSearch() {
            const h3s = document.getElementById('h3s');
            const searchinp = document.getElementById('searchinp');

            if (h3s.style.display === 'none') {
                h3s.style.display = 'block';
                searchinp.style.display = 'none';

                clearSearch();

            } else {
                h3s.style.display = 'none';
                searchinp.style.display = 'flex';
            }
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




        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('businessTypeFilter').value = 'all';
            filterByBusinessType();
        });





        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('businessTypeFilter').value = 'all';
            filterTable();


            document.getElementById('searchInput').addEventListener('input', filterTable);
        });


        function filterTable() {
            const filter = document.getElementById('businessTypeFilter').value.toLowerCase();
            const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
            const rows = document.querySelectorAll('#supplierTable tr:not(.tableheader)');

            rows.forEach(row => {
                const businessType = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const rowText = row.textContent.toLowerCase();


                const matchesFilter = (filter === 'all' || businessType === filter);
                const matchesSearch = searchInput === '' || rowText.includes(searchInput);


                if (matchesFilter && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }


        function clearSearch() {
            document.getElementById('searchInput').value = '';
            filterTable();
        }


        function toggleFilter() {
            const filterElement = document.getElementById('filterBusinesstype');
            filterElement.style.display = filterElement.style.display === 'none' ? 'block' : 'none';
        }


        let deleteSupplierId = null;

        function openDeleteConfirmModal(supplierId) {
            deleteSupplierId = supplierId;
            document.getElementById('deleteConfirmModal').style.display = 'block';
        }


        function confirmDeleteSupplier() {
            if (deleteSupplierId !== null) {

                window.location.href = 'suppliers.php?delete_supplier=' + deleteSupplierId;
            }
            closeModal('deleteConfirmModal');
        }


        document.getElementById('confirmDeleteButton').addEventListener('click', confirmDeleteSupplier);

        document.querySelectorAll('.table button').forEach(button => {
            button.addEventListener('click', function() {
                if (this.textContent === 'Delete') {
                    const supplierId = this.closest('tr').dataset.supplierId;
                    openDeleteConfirmModal(supplierId);
                }
            });
        });

        function handleSupplierFormSubmission(event) {
            const productsProvidedInputs = document.querySelectorAll('.product-input input');

            const hasEmptyProducts = [...productsProvidedInputs].some(input => input.value.trim() === '');
            if (hasEmptyProducts) {
                productsProvidedInputs.forEach(input => {
                    if (input.value.trim() === '') {
                        input.value = 'None';
                    }
                });
            }


            document.getElementById('supplierForm').submit();
        }

        function viewSupplierProducts(supplierId) {
            window.location.href = 'supplier_products.php?supplier_id=' + supplierId;
        }
    </script>
</body>

</html>