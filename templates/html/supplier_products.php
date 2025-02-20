<?php

include_once    "../../php/supplier_products.php";


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
                <div class="backButton">
                        <button onclick="backCategory()"> BACK </button>
                    </div>
                   

                    

                    <div class="aaaa">
                        <div class="filterCon">
                            <div id="h3s">
                            <h1 style="font-size:16px;">Products of <?= htmlspecialchars($supplierName); ?></h1>

                            </div>


                            <div class="searchinp" id="searchinp" style="display: none;">
                                <input type="text" id="searchInput" placeholder="Search..." spellcheck="false">
                                <i class="fas fa-times" onclick="cancelSearch()"></i>
                            </div>


                            <div class="filwrap" style="display: none;">

                                <i class="fas fa-filter" onclick="toggleFilter()"></i>


                                <div class="filterSales" id="filterBusinesstype" style="display: none;">
                                    <div class="businesstype-filter">
                                        <h2 style="font-size: 15px;">Filter by Business Type</h2>
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

                                <i class="fas fa-search" onclick="toggleSearch()"></i>
                                <i class="fas fa-print" onclick="redirectToPrintPage()" target="_blank"></i>

                            </div>
                        </div>
                    </div>





                    <div class="table-account table-account-superAdmin">
                    <table id="supplierTable">
                        <tr class="tableheader">
                            <td>Products</td>
                        </tr>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td class="no-products">No products available for this supplier.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars(ucwords(strtolower(html_entity_decode($product['product_name'])))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>



                   
                </div>




              











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



        function backCategory(){

            window.location.href ="suppliers.php"
        }

      
    </script>
</body>

</html>