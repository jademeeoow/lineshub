    <?php
    include_once "../../php/addacc.php";
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account</title>
        <link rel="stylesheet" href="../../static/style/dashboard.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
    </head>

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
                        <h1>ACCOUNT</h1>
                    </div>
                    <div class="marjcontent">
                        <div class="addAccount">
                            <button onclick="addToggleOpen()">Add SuperAdmin / Admin</button>
                        </div>
                        <div class="rbtn-con">
                            <div class="rbtn-admin">
                                <input type="radio" name="rbtnAccount" id="rbtn-button-all" checked onchange="filterTable('all')">
                                <label for="rbtn-button-all">All</label>
                            </div>

                            <div class="rbtn-user">
                                <input type="radio" name="rbtnAccount" id="rbtn-button-superadmin" onchange="filterTable('super_admin')">
                                <label for="rbtn-button-superadmin">Super Admin</label>
                            </div>
                            <div class="rbtn-user">
                                <input type="radio" name="rbtnAccount" id="rbtn-button-clerk" onchange="filterTable('clerk')">
                                <label for="rbtn-button-clerk">Clerk</label>
                            </div>
                            <div class="rbtn-user">
                                <input type="radio" name="rbtnAccount" id="rbtn-button-cashier" onchange="filterTable('cashier')">
                                <label for="rbtn-button-cashier">Cashier</label>
                            </div>
                            <div class="rbtn-user">
                                <input type="radio" name="rbtnAccount" id="rbtn-button-staff" onchange="filterTable('staff')">
                                <label for="rbtn-button-staff">Staff</label>
                            </div>
                        </div>




                        <div class="contool-table">
                            <div class="tabletag">
                                <div class="list" id="list">

                                </div>
                                <div class="searchinp" id="searchinp">
                                    <input type="text" id="searchInput" placeholder="Search.." oninput="searchTable()">
                                    <i class="fas fa-times" onclick="clearSearch()"></i>
                                </div>

                            </div>

                            <div class="tabletool">


                                <div class="n">
                                    <i class="fas fa-search searchicon" onclick="searchtoggle()"></i>

                                </div>

                                <div class="n" style="display: none;">
                                    <i class="fas fa-filter" onclick="filterColumnShow()"></i>

                                    <div class="filterColumn">
                                        <div class="top">
                                            <p>Filter Column</p>
                                            <i class="fas fa-times" onclick="filterColumnHide()"></i>
                                        </div>
                                        <div class="marjcol">
                                            <div class="colWrap">
                                                <div class="in">
                                                    <input type="radio" name="categoryFilter" id="filterAll" onclick="filterCategories('all')" checked>
                                                    <label for="filterAll">All</label>
                                                </div>
                                                <div class="in">
                                                    <input type="radio" name="categoryFilter" id="filterWithSubcategory" onclick="filterCategories('with')">
                                                    <label for="filterWithSubcategory">With Subcategory</label>
                                                </div>
                                                <div class="in">
                                                    <input type="radio" name="categoryFilter" id="filterWithoutSubcategory" onclick="filterCategories('without')">
                                                    <label for="filterWithoutSubcategory">Without Subcategory</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-account table-account-superAdmin">

                            <table id="adminTable">
                                <tr class="tableheader">
                                    <td>Image</td>
                                    <td>Email</td>

                                    <td>First Name</td>
                                    <td>Last Name</td>
                                    <td>Phone Number</td>
                                    <td>Role</td>
                                    <td>Edit</td>
                                </tr>
                                <?php foreach ($admins as $admin) : ?>
                                    <tr class="<?php echo $admin['role']; ?>">
                                        <td><img src="<?php echo $admin['image_path']; ?>" alt=""></td>
                                        <td><?php echo $admin['email']; ?></td>

                                        <td><?php echo htmlspecialchars(ucwords(strtolower(html_entity_decode($admin['first_name'])))); ?></td>
                                        <td><?php echo htmlspecialchars(ucwords(strtolower(html_entity_decode($admin['last_name'])))); ?></td>

                                        <td><?php echo $admin['phone_number']; ?></td>
                                        <td><?php echo str_replace('Super_admin', 'Super Admin', ucfirst($admin['role'])); ?></td>

                                        <td><button onclick="populateEditForm(<?php echo htmlspecialchars(json_encode($admin)); ?>)">Edit</button></td>

                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>

                    <!-- Edit Account Form -->

                    <form action="account.php" method="POST" enctype="multipart/form-data">
                        <div class="edit-account" id="edit-account">
                            <div class="edit-con">
                                <div class="marjcontent-edit">
                                    <div class="tag-edit-account">
                                        <p>Edit Account</p>
                                        <i class="fas fa-times" onclick="editToggleClose()"></i>
                                    </div>
                                    <div class="picture-edit">
                                        <div class="img-editAccount">
                                            <img id="uploadedImage" src="../../static/images/logolines.jpg" alt="">
                                        </div>
                                        <div class="choose-edit">
                                            <input type="file" id="uploadInput" name="image" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                    </div>

                                    <input type="hidden" name="adminId" id="adminIdEdit" value="">
                                    <div class="garpar">
                                        <label for="emailEdit">Email</label>
                                        <div class="gar">
                                            <input type="email" name="email" id="emailEdit" value="" required>
                                        </div>
                                    </div>

                                    <div class="garpar">
                                        <label for="firstNameEdit">First Name</label>
                                        <div class="gar">
                                            <input type="text" name="firstName" id="firstNameEdit" value="" required>
                                        </div>
                                    </div>

                                    <div class="garpar">
                                        <label for="lastNameEdit">Last Name</label>
                                        <div class="gar">
                                            <input type="text" name="lastName" id="lastNameEdit" value="" required>
                                        </div>
                                    </div>

                                    <div class="garpar">
                                        <label for="phoneNumberEdit">Phone Number</label>
                                        <div class="gar">
                                            <input type="number" name="phoneNumber" id="phoneNumberEdit" value="" required>
                                        </div>
                                    </div>

                                    <div class="garpar">
                                        <label for="roleEdit">Role</label>
                                        <div class="gar">
                                            <select name="role" id="roleEdit" required>
                                                <option value="super_admin">Super Admin</option>
                                                <option value="clerk">Clerk</option>
                                                <option value="cashier">Cashier</option>
                                                <option value="staff">Staff</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="garpar" id="setgarparEdit">
                                        <label>Set Access to</label>
                                        <div class="setgar">
                                            <div>
                                                <input type="checkbox" name="setAccessSalesEdit" id="setAccessSalesEdit"
                                                    <?php echo ($permissions['sales_nav'] == 1) ? 'checked' : ''; ?>>
                                                <label for="setAccessSalesEdit">Sales</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="setAccessProductsEdit" id="setAccessProductsEdit"
                                                    <?php echo ($permissions['product_nav'] == 1) ? 'checked' : ''; ?>>
                                                <label for="setAccessProductsEdit">Products</label>
                                            </div>


                                            <div>
                                                <input type="checkbox" name="setAccessSuppliesEdit" id="setAccessSuppliesEdit">
                                                <?php echo ($permissions['supplies_nav'] == 1) ? 'checked' : ''; ?>
                                                <label for="setAccessSupplies">Suppliies</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="setAccessOrdersEdit" id="setAccessOrdersEdit"
                                                    <?php echo ($permissions['order_nav'] == 1) ? 'checked' : ''; ?>>
                                                <label for="setAccessOrdersEdit">Orders</label>
                                            </div>





                                            <div>
                                                <input type="checkbox" name="setAccessAccountEdit" id="setAccessAccountEdit">
                                                <label for="setAccessAccountEdit">Account</label>
                                            </div>




                                        </div>
                                    </div>

                                    <div class="btn-edit">
                                        <button type="submit" id="editButton">Update</button>
                                        <button type="reset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <!-- Add Account Form -->
                    <form action="account.php" method="POST" enctype="multipart/form-data">
                        <div class="add-account" id="add-account">
                            <div class="edit-con">
                                <div class="marjcontent-edit">
                                    <div class="tag-edit-account">
                                        <p>Add Account</p>
                                        <i class="fas fa-times" onclick="addToggleClose()"></i>
                                    </div>

                                    <div class="picture-edit">
                                        <div class="img-editAccount">
                                            <img id="uploadedImageAdd" src="../../static/images/logolines.jpg" alt="">
                                        </div>
                                        <div class="choose-edit">
                                            <input type="file" id="uploadInputAdd" name="image" accept="image/*" onchange="previewImageAdd(event)">
                                        </div>
                                    </div>
                                    <div class="garpar">
                                        <label for="emailAdd">Email</label>
                                        <div class="gar">
                                            <input type="email" name="email" id="emailAdd" required>
                                        </div>
                                    </div>

                                    <div class="garpar">
                                        <label for="firstNameAdd">First Name</label>
                                        <div class="gar">
                                            <input type="text" name="firstName" id="firstNameAdd" required>
                                        </div>
                                    </div>
                                    <div class="garpar">
                                        <label for="lastNameAdd">Last Name</label>
                                        <div class="gar">
                                            <input type="text" name="lastName" id="lastNameAdd" required>
                                        </div>
                                    </div>
                                    <div class="garpar">
                                        <label for="phoneNumberAdd">Phone Number</label>
                                        <div class="gar">
                                            <input type="number" name="phoneNumber" id="phoneNumberAdd" required>
                                        </div>
                                    </div>
                                    <div class="garpar">
                                        <label for="passwordAdd">Password</label>
                                        <div class="gar">
                                            <input type="password" name="password" id="passwordAdd" required>
                                        </div>
                                    </div>
                                    <div class="garpar">
                                        <label for="confirmPasswordAdd">Confirm Password</label>
                                        <div class="gar">
                                            <input type="password" name="confirmPassword" id="confirmPasswordAdd" required>
                                        </div>
                                        <div id="passwordMatchStatusAdd" style="color: red;"></div>
                                    </div>
                                    <div class="garpar">
                                        <label for="roleAdd">Role</label>
                                        <div class="gar">
                                            <select name="role" id="roleAdd" required>
                                                <option value="super_admin">Super Admin</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Clerk">Clerk</option>
                                                <option value="Cashier">Cashier</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- set access -->
                                    <div class="garpar" id="setgarpar">
                                        <label>Set Access to</label>
                                        <div class="setgar">
                                            <div>
                                                <input type="checkbox" name="setAccessSales" id="setAccessSales">
                                                <label for="setAccessSales">Sales</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="setAccessProducts" id="setAccessProducts">
                                                <label for="setAccessProducts">Products</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="setAccessOrders" id="setAccessOrders">
                                                <label for="setAccessOrders">Orders</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="setAccessAccount" id="setAccessAccount">
                                                <label for="setAccessAccount">Account</label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="setAccessSupplies" id="setAccessSupplies">
                                                <label for="setAccessSupplies">Supplies</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-edit">
                                        <button type="submit">Submit</button>
                                        <button type="reset">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

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
                </div>

                <main-sidenotif class="side sidenotif"></main-sidenotif>
            </div>
        </div>

        <script src="../../static/script/script.js">
        </script>

        <script>
            function closeModal(modalId) {
                document.getElementById(modalId).style.display = 'none';
            }

            window.addEventListener('click', function(event) {
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    if (event.target === modal) {
                        closeModal(modal.id);
                    }
                });
            });

            function closeErrorModal() {
                document.getElementById('errorModal').style.display = 'none';
            }

            function filterTable(role) {
                const tableRows = document.querySelectorAll('#adminTable tr');
                tableRows.forEach((row, index) => {
                    if (index === 0) return;
                    if (role === 'all' || row.classList.contains(role)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            document.addEventListener("DOMContentLoaded", function() {
                <?php
                if (isset($_SESSION['success'])) {
                    echo "document.getElementById('successMessage').innerText = '" . $_SESSION['success'] . "';";
                    echo "document.getElementById('successModal').style.display = 'block';";
                    unset($_SESSION['success']);
                }

                if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
                    echo "document.getElementById('errorModal').style.display = 'block';";
                    echo "document.getElementById('errorMessage').innerText = '" . implode("<br>", $_SESSION['errors']) . "';";
                    unset($_SESSION['errors']);
                }
                ?>
            });

            function populateEditForm(admin) {
                document.getElementById('adminIdEdit').value = admin.admin_id;
                document.getElementById('emailEdit').value = admin.email;
                document.getElementById('firstNameEdit').value = admin.first_name;
                document.getElementById('lastNameEdit').value = admin.last_name;
                document.getElementById('phoneNumberEdit').value = admin.phone_number;
                document.getElementById('roleEdit').value = admin.role;
                document.getElementById('uploadedImage').src = admin.image_path;
                editToggleOpen();
            }

            function previewImage(event) {
                const input = event.target;
                const reader = new FileReader();
                reader.onload = function() {
                    const img = document.getElementById('uploadedImage');
                    img.src = reader.result;
                };
                reader.readAsDataURL(input.files[0]);
            }

            function previewImageAdd(event) {
                const input = event.target;
                const reader = new FileReader();
                reader.onload = function() {
                    const img = document.getElementById('uploadedImageAdd');
                    img.src = reader.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        </script>

        <script>
            const roleSelect = document.getElementById('roleAdd');
            const setGarpar = document.getElementById('setgarpar');
            const salesCheckbox = document.getElementById('setAccessSales');
            const productsCheckbox = document.getElementById('setAccessProducts');
            const ordersCheckbox = document.getElementById('setAccessOrders');
            const suppliesCheckbox = document.getElementById('setAccessSupplies');


            function updateAccessCheckboxes() {
                const selectedRole = roleSelect.value;


                salesCheckbox.checked = false;
                productsCheckbox.checked = false;
                ordersCheckbox.checked = false;

                if (selectedRole === 'Staff') {

                    salesCheckbox.checked = true;
                    productsCheckbox.checked = true;
                    ordersCheckbox.checked = true;
                    setGarpar.style.display = 'block';
                } else if (selectedRole === 'Clerk') {

                    productsCheckbox.checked = true;
                    ordersCheckbox.checked = true;
                    setGarpar.style.display = 'block';
                } else if (selectedRole === 'Cashier') {

                    salesCheckbox.checked = true;
                    setGarpar.style.display = 'block';
                } else {

                    setGarpar.style.display = 'none';
                }
            }


            roleSelect.addEventListener('change', updateAccessCheckboxes);


            updateAccessCheckboxes();
        </script>
        <script>
            function populateEditForm(admin) {
                document.getElementById('adminIdEdit').value = admin.admin_id;
                document.getElementById('emailEdit').value = admin.email;
                document.getElementById('firstNameEdit').value = admin.first_name;
                document.getElementById('lastNameEdit').value = admin.last_name;
                document.getElementById('phoneNumberEdit').value = admin.phone_number;
                document.getElementById('roleEdit').value = admin.role;
                document.getElementById('uploadedImage').src = admin.image_path;

                document.getElementById('setAccessSalesEdit').checked = admin.sales_nav == 1;
                document.getElementById('setAccessProductsEdit').checked = admin.product_nav == 1;
                document.getElementById('setAccessOrdersEdit').checked = admin.order_nav == 1;
                document.getElementById('setAccessAccountEdit').checked = admin.account_nav == 1;
                document.getElementById('setAccessSuppliesEdit').checked = admin.supplies_nav == 1;

                toggleSetAccessVisibility(admin.role);

                editToggleOpen();
            }

            function toggleSetAccessVisibility(role) {
                const setAccessContainer = document.getElementById('setgarparEdit');
                if (role === 'super_admin') {
                    setAccessContainer.style.display = 'none';
                } else {
                    setAccessContainer.style.display = 'block';
                }
            }


            document.getElementById('roleEdit').addEventListener('change', function() {
                const selectedRole = this.value;
                toggleSetAccessVisibility(selectedRole); // 
            });

            function searchTable() {
                const searchInput = document.getElementById('searchInput').value.toLowerCase();
                const rows = document.querySelectorAll('#adminTable tr:not(.tableheader)');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let matchFound = false;

                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchInput)) {
                            matchFound = true;
                        }
                    });


                    row.style.display = matchFound ? '' : 'none';
                });
            }

            function clearSearch() {

                const searchInput = document.getElementById('searchInput');
                searchInput.value = '';


                searchTable();


                const searchContainer = document.getElementById('searchinp');
                searchContainer.style.display = 'none';
            }

            function searchtoggle() {
                const searchInputContainer = document.getElementById('searchinp');
                const searchInputField = document.getElementById('searchInput');


                if (searchInputContainer.style.display === 'flex') {
                    searchInputContainer.style.display = 'none';
                    clearSearch();
                } else {
                    searchInputContainer.style.display = 'flex';
                    searchInputField.focus();
                }
            }


            document.getElementById('searchInput').addEventListener('input', searchTable);
        </script>



    </body>

    </html>