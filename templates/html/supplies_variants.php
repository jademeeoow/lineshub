<?php

include_once "../../php/supplies_variants.php";



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Supply Inventory</title>
    <link rel="stylesheet" href="../../static/style/variants.css">
    <link rel="stylesheet" href="../../static/style/product.css">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>







</style>


<body>
        <div class="notifTooltipCon">
        <p>hvjhvjhvjh</p>
    </div>
    <div class="whole">
        <main-header data-image-path="<?php echo $image_path; ?>" data-role="<?php echo $_SESSION['role']; ?>"></main-header>
        <div class="con">
            <?php

            include_once  "sidemenu.php";

            ?>



            <div class="content">
                <div class="title">
                    <h1> SUPPLY VARIANTS </h1>
                </div>



                <div class="marjcontent">


                    <div class="backButton">
                        <button onclick="backInventory()"> BACK </button>
                    </div>
                    <div class="backBtn">
                        <button onclick="openAddVariantForm()">Add Variants/Products</button>
                    </div>
                    <div class="rbtn">
                        <div class="rbtn-admin">
                            <input type="radio" name="inventoryBtn" id="inventoryProducts" checked>
                            <label for="inventoryProducts">Products</label>
                        </div>

                    </div>
                    <div class="contool-table">
                        <div class="tabletag">
                            <div class="list" id="list">

                            </div>

                            <div id="h3s" style=" margin-left: 1rem;">



                            

                            <p style="font-weight: bold;"> Category: <?php echo htmlspecialchars($category_name); ?></p>

                        
                             
                            </div>
                            <div class="searchinp" id="searchinp">
                                <input type="text" id="searchInput" placeholder="Search.." oninput="searchTable()">
                                <i class="fas fa-times" onclick="clearSearch()"></i>
                            </div>

                        </div>

                        <div class="tabletool">
                            <div class="n">
                                <i class="fas fa-print printicon" onclick="redirectToPrintPage()"></i>
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

                                        <div class="colWrap">
                                            <div class="in">
                                                <input type="radio" name="stockFilter" id="filterAll" onclick="filterStock('all')" checked>
                                                <label for="all">All</label>
                                            </div>
                                            <div class="in">
                                                <input type="radio" name="stockFilter" id="filterLowStock" onclick="filterStock('low')">
                                                <label for="regular">Low Stocks</label>
                                            </div>
                                            <div class="in">
                                                <input type="radio" name="stockFilter" id="filterNoStock" onclick="filterStock('no')">
                                                <label for="rush">No Stock</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>


                    <div class="table table-product" id="table-product">
                        <table class="cat">
                            <tr class="tableheader">
                                <td>Sub Category</td>
                                <td>Product Name</td>
                                <td>Product Description</td>
                                <td>Variant Color</td>
                                <td>Variant Size</td>
                                <td>Variant Price</td>
                                <td>Variant Stock</td>
                                <td>Supplier</td>
                                <td>Edit</td>
                                <td>Delete</td>
                                <td>Add Stock</td>
                                <td>Request</td>
                            </tr>
                            <?php if (!empty($variants)) : ?>
                                <?php foreach ($variants as $variant) : ?>
                                    <tr id="variant-row-<?php echo $variant['variant_id']; ?>">
                                        <td>
                                            <?php
                                            echo !empty($variant['sub_category_name'])
                                                ? htmlspecialchars($variant['sub_category_name'])
                                                : 'None';
                                            ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($variant['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($variant['product_description']); ?></td>
                                        <td><?php echo htmlspecialchars($variant['variant_color']); ?></td>
                                        <td><?php echo htmlspecialchars($variant['variant_size']); ?></td>
                                        <td><?php echo htmlspecialchars($variant['variant_price']); ?></td>
                                        <td><?php echo htmlspecialchars($variant['variant_stock']); ?></td>
                                        <td><?php echo htmlspecialchars($variant['supplier']); ?></td>
                                        <td>
                                            <button onclick="populateEditForm(
                                                  '<?php echo $variant['variant_id']; ?>',
                                                  '<?php echo htmlspecialchars(addslashes($variant['product_name'])); ?>',
                                                  '<?php echo htmlspecialchars(addslashes($variant['product_description'])); ?>',
                                                  '<?php echo htmlspecialchars(addslashes($variant['variant_color'])); ?>',
                                                  '<?php echo htmlspecialchars(addslashes($variant['variant_size'])); ?>',
                                                  '<?php echo $variant['variant_price']; ?>',
                                                  '<?php echo $variant['variant_stock']; ?>',
                                                  '<?php echo $variant['supplier_id']; ?>',  
                                                  '<?php echo $variant['supplier']; ?>',      
                                                  '<?php echo $category_id; ?>'
                                                 )">Edit</button>
                                        </td>



                                        <td>
                                            <button onclick="openDeleteConfirmModal(<?php echo $variant['variant_id']; ?>)">Delete</button>
                                        </td>

                                        <td>
                                            <div class="add-stock-wrapper" id="add-stock-wrapper-<?php echo $variant['variant_id']; ?>">
                                                <button class="add-stock-btn" onclick="showAddStockInput(<?php echo $variant['variant_id']; ?>)">Add Stock</button>
                                                <div class="add-stock-container" id="add-stock-container-<?php echo $variant['variant_id']; ?>" style="display: none;">
                                                    <input type="number" class="add-stock-input" id="addStockInput-<?php echo $variant['variant_id']; ?>" placeholder="Enter stock">
                                                    <button class="submit-stock-btn" onclick="submitStock(<?php echo $variant['variant_id']; ?>)">Submit</button>
                                                    <button class="close-stock-btn" onclick="hideAddStockInput(<?php echo $variant['variant_id']; ?>)">Close</button>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="request-wrapper" id="request-wrapper-<?php echo $variant['variant_id']; ?>">
                                                <button class="request-btn" onclick="showRequestInput(<?php echo $variant['variant_id']; ?>)">Request</button>
                                                <div class="request-container" id="request-container-<?php echo $variant['variant_id']; ?>" style="display: none;">
                                                    <input type="number" class="request-input" id="requestInput-<?php echo $variant['variant_id']; ?>" placeholder="Enter request quantity">
                                                    <button class="submit-request-btn" onclick="submitRequest(<?php echo $variant['variant_id']; ?>)">Submit</button>
                                                    <button class="close-request-btn" onclick="hideRequestInput(<?php echo $variant['variant_id']; ?>)">Close</button>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="11" style="text-align: center;">No variants found for this category.</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>



            <div id="notification" class="notification"></div>


            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>
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

    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteConfirmModal')">&times;</span>
            <p>Are you sure you want to delete this variant?</p>
            <button id="confirmDeleteButton">CONFIRM</button>
            <button id="cancel" onclick="closeModal('deleteConfirmModal')">CANCEL</button>
        </div>
    </div>





    <!-- Add Variant Form -->

    <form action="supplies_variants.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="add_variant" value="1">
        <div class="edit_variant" id="add_variant" style="display: none;">
            <div class="edit-con">
                <div class="marjcontent-edit">
                    <div class="tag-edit-account">


                        <p>Add New Product Variant</p>
                        <i class="fas fa-times" onclick="addToggleClose()"></i>
                    </div>

                    <!-- Hidden Inputs for Product Name and Description -->
                    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                    <input type="hidden" id="defaultProductName" value="<?php echo htmlspecialchars($variants[0]['product_name'] ?? ''); ?>">
                    <input type="hidden" id="defaultProductDescription" value="<?php echo htmlspecialchars($variants[0]['product_description'] ?? ''); ?>">

                    <!-- Product Name -->
                    <div class="garpar">
                        <label for="productNameSelect">Product Name</label>
                        <div class="gar">
                            <!-- Dropdown for selecting product name -->
                            <select id="productNameSelect" name="product_name" onchange="updateDescriptionDropdown()" required>
                                <option value="" disabled selected>Select Product Name</option>
                                <?php foreach ($existingProducts as $product) : ?>
                                    <option value="<?php echo htmlspecialchars($product['product_name']); ?>"
                                        data-description="<?php echo htmlspecialchars($product['product_description']); ?>">
                                        <?php echo htmlspecialchars($product['product_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <!-- Button to toggle input mode -->
                            <button type="button" id="toggleProductName" onclick="toggleField('productName')" title="Toggle Product Name">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="garpar">
                        <label for="productDescriptionSelect">Product Description</label>
                        <div class="gar">
                            <!-- Dropdown for selecting product description -->
                            <select id="productDescriptionSelect" name="product_description" required>
                                <option value="" disabled selected>Select Product Description</option>
                            </select>
                            <!-- Button to toggle input mode -->
                            <button type="button" id="toggleProductDescription" onclick="toggleField('productDescription')" title="Toggle Product Description">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="parex" style="display: none;">
                        <label for="categorySelect" class="parexp">Product Category</label>
                        <div class="inpexp">
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">

                            <select id="categorySelect" name="sub_category">
                                <option value="" disabled>Select Category</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>"
                                        <?php echo ($category['category_id'] == $category_id) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>


                    <div class="parexp">
                        <label for="subcategorySelect" class="parexp">Product Subcategory</label>
                        <div class="inpexp">
                            <select id="subcategorySelect" name="subcategory">
                                <option value="" selected>Select Subcategory</option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo htmlspecialchars($category['sub_category_id']); ?>">
                                        <?php echo htmlspecialchars($category['sub_category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                    <div class="mainVar">
                        <div class="subCategories">
                            <div class="subName">
                                <p>Variants</p>
                            </div>
                            <div class="containerPerVarviation" id="containerPerVarviation">

                                <div class="conVar" data-index="0">
                                    <div class="perVar">
                                        <div class="parexp">
                                            <label>Product Color</label>
                                            <div class="inpexp">
                                                <input type="text" name="variants[0][color]" spellcheck="false">
                                            </div>
                                        </div>
                                        <div class="parexp">
                                            <label>Product Size</label>
                                            <div class="inpexp">
                                                <input type="text" name="variants[0][size]" spellcheck="false">
                                            </div>
                                        </div>
                                        <div class="parexp">
                                            <label>Product Price</label>
                                            <div class="inpexp">
                                                <input type="number" name="variants[0][price]" step="0.01" spellcheck="false">
                                            </div>
                                        </div>
                                        <div class="parexp">
                                            <label>Number of Stock(s)</label>
                                            <div class="inpexp">
                                                <input type="text" name="variants[0][stock]" spellcheck="false">
                                            </div>
                                        </div>
                                        <div class="parexp">
                                            <label>Supplier</label>
                                            <div class="inpexp">
                                                <select name="variants[0][supplier]" >
                                                    <option value="" disabled selected style="display: none;">Select Supplier</option>
                                                    <?php foreach ($suppliers as $supplier) : ?>
                                                        <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>">
                                                            <?php echo htmlspecialchars($supplier['contact_person']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="addVar">
                                    <p onclick="addVariations2(this)">ADD VARIATIONS</p>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="btnSubmitProduct">
                        <button type="submit">Submit</button>
                    </div>
                </div>
    </form>
    </div>
    </div>
    </div>










    <form id="editForm" action="../../php/edit_supplies_variants.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmEdit()">



        <div class="edit_variant" id="edit_variant">
            <div class="edit-con">
                <div class="marjcontent-edit">
                    <div class="tag-edit-account">
                        <p>Edit Product Variant</p>
                        <i class="fas fa-times" onclick="editToggleClose()"></i>
                    </div>


                    <input type="hidden" id="originalProductName" value="">
                    <input type="hidden" id="originalProductDescription" value="">




                    <input type="hidden" name="variant_id" id="variantIdEdit" value="">
                    <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                    <input type="hidden" name="product_id" id="product_id" value="">

                    <div class="garpar">
                        <label for="productNameEdit">Product Name</label>
                        <div class="gar">
                            <input type="text" name="product_name" id="productNameEdit" value="" oninput="checkProductEdit()">

                            <span id="productNameWarning" style="display: none; color: red; margin-left: 10px;">
                                Warning: Changing the product name may affect existing variants.
                            </span>
                        </div>
                    </div>


                    <div class="garpar">
                        <label for="productDescriptionEdit">Product Description</label>
                        <div class="gar">
                            <input type="text" name="product_description" id="productDescriptionEdit">
                        </div>
                    </div>

                    <div class="garpar">
                        <label for="variantColorEdit">Variant Color</label>
                        <div class="gar">
                            <input type="text" name="variant_color" id="variantColorEdit" value="">
                        </div>
                    </div>

                    <div class="garpar">
                        <label for="variantSizeEdit">Variant Size</label>
                        <div class="gar">
                            <input type="text" name="variant_size" id="variantSizeEdit" value="">
                        </div>
                    </div>

                    <div class="garpar">
                        <label for="variantPriceEdit">Variant Price</label>
                        <div class="gar">
                            <input type="number" name="variant_price" id="variantPriceEdit" step="0.01" value="" required>
                        </div>
                    </div>

                    <div class="garpar">
                        <label for="variantStockEdit">Variant Stock</label>
                        <div class="gar">
                            <input type="text" name="variant_stock" id="variantStockEdit" value="" required>
                        </div>
                    </div>

                    <div class="garpar">
                        <label for="supplierEdit">Supplier</label>
                        <div class="gar">
                            <select name="supplier" id="supplierEdit" required>
                                <option value="" disabled>Select Supplier</option>
                                <?php foreach ($suppliers as $supplier) : ?>
                                    <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>">
                                        <?php echo htmlspecialchars($supplier['contact_person']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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



    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="confirm_modal">
        <div class="confirm-modal-content">
            <p id="confirmationMessage">You are about to change the product name or description. This change will affect all variants with the same product name within the same subcategory. Are you sure you want to continue?</p>
            <div class="modal-buttons">
                <button id="confirmYes" class="yellowButton">YES</button>
                <button id="confirmNo" class="noButton">NO</button>
            </div>
        </div>
    </div>























    <script src="../../static/script/script.js"></script>




    <script>



function redirectToPrintPage() {
        const categoryId = <?php echo json_encode($category_id); ?>;
        window.open(`../Print_Table/tablePrintSuppVar.php?category_id=${categoryId}`, '_blank');
    }
        function closeModal(modalId) {

            document.getElementById(modalId).style.display = 'none';


            clearMessageParams();
        }

        function clearMessageParams() {
            const url = new URL(window.location);
            const params = url.searchParams;


            params.delete('message');
            params.delete('message2');


            window.history.replaceState(null, '', url.pathname + '?' + params.toString());
        }

        function openDeleteConfirmModal(variantId) {
            document.getElementById('deleteConfirmModal').style.display = 'block';
            document.getElementById('confirmDeleteButton').onclick = function() {
                confirmDeleteProduct(variantId);
            };
        }

        function confirmDeleteProduct(variantId) {
            window.location.href = 'supplies_variants.php?delete_variant=' + variantId + '&category_id=<?php echo $category_id; ?>';
        }

        document.addEventListener("DOMContentLoaded", function() {
            <?php
            if (isset($_SESSION['message'])) {
                echo "document.getElementById('successMessage').innerText = '" . addslashes($_SESSION['message']) . "';";
                echo "document.getElementById('successModal').style.display = 'block';";
                unset($_SESSION['message']);
            }

            if (isset($_SESSION['message2']) && !empty($_SESSION['message2'])) {
                echo "document.getElementById('errorMessage').innerHTML = '" . addslashes($_SESSION['message2']) . "';";
                echo "document.getElementById('errorModal').style.display = 'block';";
                unset($_SESSION['message2']);
            }
            ?>

            window.onclick = function(event) {
                const modals = ['successModal', 'errorModal', 'deleteConfirmModal'];
                modals.forEach(modalId => {
                    const modal = document.getElementById(modalId);
                    if (event.target == modal) {
                        closeModal(modalId);
                    }
                });
            };
        });

        function populateEditForm(variant_id) {

            fetch(`../../php/get_supplies_variant.php?variant_id=${variant_id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const variant = data.variant;

                        // Set current form values
                        document.getElementById('variantIdEdit').value = variant.variant_id;
                        document.getElementById('productNameEdit').value = variant.product_name;
                        document.getElementById('productDescriptionEdit').value = variant.product_description;
                        document.getElementById('variantColorEdit').value = variant.variant_color;
                        document.getElementById('variantSizeEdit').value = variant.variant_size;
                        document.getElementById('variantPriceEdit').value = variant.variant_price;


                        const variantStock = variant.variant_stock.toLowerCase();
                        if (variantStock.includes('meter') || variantStock.includes('m')) {
                            document.getElementById('variantStockEdit').value = variantStock;
                        } else {
                            document.getElementById('variantStockEdit').value = parseInt(variantStock) || 0;
                        }


                        const supplierSelect = document.getElementById('supplierEdit');
                        for (let i = 0; i < supplierSelect.options.length; i++) {
                            if (supplierSelect.options[i].value == variant.supplier_id) {
                                supplierSelect.options[i].selected = true;
                                break;
                            }
                        }

                        // Set original values for comparison during edit
                        document.getElementById('originalProductName').value = variant.product_name;
                        document.getElementById('originalProductDescription').value = variant.product_description;

                        // Display the edit form
                        document.getElementById('edit_variant').style.display = 'flex';
                    } else {
                        showNotification("Error fetching variant data: " + data.message, '#f44336');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification("An error occurred while fetching the variant data.", '#f44336');
                });
        }



        function editToggleClose() {
            document.getElementById('edit_variant').style.display = 'none';
        }

        document.addEventListener("DOMContentLoaded", function() {
            function getQueryParam(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            const successMessage = getQueryParam('message');
            if (successMessage) {
                document.getElementById('successMessage').innerText = decodeURIComponent(successMessage);
                document.getElementById('successModal').style.display = 'block';
            }

            const errorMessage = getQueryParam('message2');
            if (errorMessage) {
                document.getElementById('errorMessage').innerText = decodeURIComponent(errorMessage);
                document.getElementById('errorModal').style.display = 'block';
            }
        });

        function showAddStockInput(variantId) {
            const addStockWrapper = document.getElementById(`add-stock-wrapper-${variantId}`);
            const addStockBtn = addStockWrapper.querySelector('.add-stock-btn');
            const addStockContainer = document.getElementById(`add-stock-container-${variantId}`);

            addStockBtn.style.display = 'none';
            addStockContainer.style.display = 'block';
        }

        function hideAddStockInput(variantId) {
            const addStockWrapper = document.getElementById(`add-stock-wrapper-${variantId}`);
            const addStockBtn = addStockWrapper.querySelector('.add-stock-btn');
            const addStockContainer = document.getElementById(`add-stock-container-${variantId}`);


            const stockInput = document.getElementById(`addStockInput-${variantId}`);
            stockInput.value = '';

            addStockBtn.style.display = 'flex';
            addStockContainer.style.display = 'none';
        }

        function showNotification(message, backgroundColor = '#4CAF50') {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.backgroundColor = backgroundColor;
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        function submitStock(variantId) {
            const stockInput = document.getElementById(`addStockInput-${variantId}`).value;

            if (!stockInput || isNaN(stockInput) || parseInt(stockInput) < 0) {
                showNotification("Please enter a valid stock amount.", '#f44336');
                return;
            }

            const formData = new FormData();
            formData.append('variant_id', variantId);
            formData.append('add_stock', stockInput);

            fetch('../../php/add_supplies_stock.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showNotification(data.message);

                        const stockCell = document.querySelector(`#variant-row-${variantId} td:nth-child(7)`);
                        stockCell.textContent = data.new_stock;

                        hideAddStockInput(variantId);
                    } else {
                        showNotification("Error: " + data.message, '#f44336');
                    }
                })
                .catch(error => {
                    console.error("Error updating stock:", error);
                    showNotification("An error occurred while updating the stock.", '#f44336');
                });
        }


        function openAddVariantForm() {





            document.getElementById('add_variant').style.display = 'flex';
        }


        function addToggleClose() {
            document.getElementById('add_variant').style.display = 'none';
        }



        function addVariations2(element) {

            const conVar = element.closest(".subCategories").querySelector(".conVar");


            conVar.scrollTo({
                left: conVar.scrollWidth,
                behavior: "smooth"
            });


            const newVar = document.createElement("div");
            newVar.classList.add("perVar");


            newVar.innerHTML = `
        <div class="parexp">
            <label>Product Color</label>
            <div class="inpexp">
                <input type="text" name="variants[${variantCount}][color]" spellcheck="false" placeholder="Enter Color">
            </div>                                                                  
        </div>
        <div class="parexp">
            <label>Product Size</label>
            <div class="inpexp">
                <input type="text" name="variants[${variantCount}][size]" spellcheck="false" placeholder="Enter Size">
            </div>
        </div>
        <div class="parexp">
            <label>Product Price</label>
            <div class="inpexp">
                <input type="number" name="variants[${variantCount}][price]" step="0.01" spellcheck="false" placeholder="Enter Price">
            </div>
        </div>
        <div class="parexp">
            <label>Number of Stock(s)</label>
            <div class="inpexp">
                <input type="text" name="variants[${variantCount}][stock]" spellcheck="false" placeholder="Enter Stock">
            </div>
        </div>
        <div class="parexp">
            <label>Supplier</label>
            <div class="inpexp">
                <select name="variants[${variantCount}][supplier]" required>
                    <option value="" disabled selected>Select Supplier</option>
                    <?php foreach ($suppliers as $supplier) : ?>
                        <option value="<?php echo htmlspecialchars($supplier['supplier_id']); ?>">
                            <?php echo htmlspecialchars($supplier['contact_person']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    `;

            variantCount++;


            conVar.appendChild(newVar);



        }



        function backInventory() {


            window.location.href = "supplies_inventory.php"
        }


        function filterStock(type) {
            const rows = document.querySelectorAll('.table-product table tr:not(.tableheader)');

            rows.forEach(row => {
                const stock = parseInt(row.querySelector('td:nth-child(7)').textContent) || 0;

                if (type === 'all') {
                    row.style.display = '';
                } else if (type === 'low' && stock > 0 && stock <= 5) {
                    row.style.display = '';
                } else if (type === 'no' && stock === 0) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }


        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.table-product table tr:not(.tableheader)');

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


            const searchContainer = document.getElementById('searchinp');
            searchContainer.style.display = 'none';


            filterStock('all');
        }


        function searchtoggle() {
            const searchInputContainer = document.getElementById('searchinp');
            const searchInputField = document.getElementById('searchInput');


            if (searchInputContainer.style.display === 'flex') {
                searchInputContainer.style.display = 'none';
                clearSearch()
            } else {
                searchInputContainer.style.display = 'flex';

                searchInputField.focus();
            }
        }



        function filterColumnShow() {
            const filterColumn = document.querySelector('.filterColumn');
            filterColumn.style.display = 'block';
        }

        function filterColumnHide() {
            const filterColumn = document.querySelector('.filterColumn');
            filterColumn.style.display = 'none';
        }




        function showRequestInput(variantId) {
            const requestWrapper = document.getElementById(`request-wrapper-${variantId}`);
            const requestBtn = requestWrapper.querySelector('.request-btn');
            const requestContainer = document.getElementById(`request-container-${variantId}`);

            requestBtn.style.display = 'none';
            requestContainer.style.display = 'block';
        }

        function hideRequestInput(variantId) {
            const requestWrapper = document.getElementById(`request-wrapper-${variantId}`);
            const requestBtn = requestWrapper.querySelector('.request-btn');
            const requestContainer = document.getElementById(`request-container-${variantId}`);

            const requestInput = document.getElementById(`requestInput-${variantId}`);
            requestInput.value = '';

            requestBtn.style.display = 'flex';
            requestContainer.style.display = 'none';
        }

        function submitRequest(variantId) {
            const requestInput = document.getElementById(`requestInput-${variantId}`).value;

            if (!requestInput || isNaN(requestInput) || parseInt(requestInput) <= 0) {
                showNotification("Please enter a valid request quantity.", '#f44336');
                return;
            }

            const formData = new FormData();
            formData.append('variant_id', variantId);
            formData.append('requested_quantity', requestInput);

            fetch('../../php/request_supply.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {

                        const stockCell = document.querySelector(`#variant-row-${variantId} td:nth-child(7)`);
                        const currentStockText = stockCell.textContent.trim();


                        const numericMatch = currentStockText.match(/(\d+)/);
                        const unitPart = currentStockText.replace(/\d+/, '').trim();

                        if (numericMatch) {
                            const currentStock = parseInt(numericMatch[1]);
                            const requestedQuantity = parseInt(requestInput);

                            const newStock = currentStock - requestedQuantity;

                            stockCell.textContent = `${newStock} ${unitPart}`;
                        }

                        showNotification(data.message, '#4CAF50');
                        hideRequestInput(variantId);
                    } else if (data.message2) {
                        showNotification(data.message2, '#f44336');
                    } else {
                        showNotification("Unexpected response format.", '#f44336');
                    }
                })
                .catch(error => {
                    console.error("Error submitting request:", error);
                    showNotification("An error occurred while submitting the request.", '#f44336');
                });
        }


        document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const highlighted = urlParams.get('highlighted');
    const variantId = urlParams.get('variant_id');

    if (highlighted && variantId) {
        const itemRow = document.querySelector(`#variant-row-${variantId}`);

        if (itemRow) {
           
            itemRow.classList.add("highlighted-item");

       
            itemRow.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

          
            setTimeout(() => {
                itemRow.classList.remove("highlighted-item");
            }, 5000);
        }
    }
});

        document.addEventListener("DOMContentLoaded", function() {

            populateSubCategories(<?php echo $category_id; ?>);
        });

        function populateSubCategories(categoryId) {
            if (!categoryId) return;

            fetch(`../../php/fetch_supplies_subcategory.php?category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    const subcategorySelect = document.getElementById('subcategorySelect');
                    subcategorySelect.innerHTML = '<option value="" selected>Select Subcategory</option>';

                    if (data.length > 0) {
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.sub_category_id;
                            option.textContent = subcategory.sub_category_name;
                            subcategorySelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No Subcategories Found';
                        subcategorySelect.appendChild(option);
                    }
                })
                .catch(error => console.error('Error fetching subcategories:', error));
        }
    </script>

    <script>
        function confirmEdit() {

            const originalProductName = document.getElementById('originalProductName').value;
            const originalProductDescription = document.getElementById('originalProductDescription').value;




            const currentProductName = document.getElementById('productNameEdit').value;
            const currentProductDescription = document.getElementById('productDescriptionEdit').value;


            const productNameChanged = currentProductName !== originalProductName;
            const productDescriptionChanged = currentProductDescription !== originalProductDescription;

            if (productNameChanged || productDescriptionChanged) {

                showConfirmationModal(
                    "You are about to modify the product name or description. This change will affect all variants with the same product name and description within the same subcategory. Do you want to continue?",
                    function(userConfirmed) {
                        if (userConfirmed) {
                            document.getElementById('editForm').submit();
                        }
                    }
                );
                return false;
            }

            return true;
        }

        function showConfirmationModal(message, callback) {

            document.getElementById('confirmationMessage').textContent = message;

            document.getElementById('confirmationModal').style.display = 'block';


            document.getElementById('confirmYes').onclick = function() {
                document.getElementById('confirmationModal').style.display = 'none';
                callback(true);
            };

            document.getElementById('confirmNo').onclick = function() {
                document.getElementById('confirmationModal').style.display = 'none';
                callback(false);
            };
        }



        function updateDescriptionDropdown() {
            const productNameSelect = document.getElementById('productNameSelect');
            const selectedOption = productNameSelect?.selectedOptions[0];
            const productDescriptionSelect = document.getElementById('productDescriptionSelect');


            productDescriptionSelect.innerHTML = '<option value="" disabled selected>Select Product Description</option>';

            if (selectedOption) {
                const productDescription = selectedOption.getAttribute('data-description');


                const option = document.createElement('option');
                option.value = productDescription;
                option.textContent = productDescription;
                option.selected = true;
                productDescriptionSelect.appendChild(option);
            }
        }


        function toggleField(fieldType) {
    let selectElement, toggleButton, optionsHTML;

    if (fieldType === 'productName') {
        selectElement = document.getElementById('productNameSelect');
        toggleButton = document.getElementById('toggleProductName');
        optionsHTML = `
            <option value="" disabled selected>Select Product Name</option>
            <?php foreach ($existingProducts as $product) : ?>
                <option value="<?php echo htmlspecialchars($product['product_name']); ?>" 
                        data-description="<?php echo htmlspecialchars($product['product_description']); ?>">
                    <?php echo htmlspecialchars($product['product_name']); ?>
                </option>
            <?php endforeach; ?>
        `;
    } else if (fieldType === 'productDescription') {
        selectElement = document.getElementById('productDescriptionSelect');
        toggleButton = document.getElementById('toggleProductDescription');
        optionsHTML = `
            <option value="" disabled selected>Select Product Description</option>
            <?php foreach ($existingProducts as $product) : ?>
                <option value="<?php echo htmlspecialchars($product['product_description']); ?>" 
                        data-product-id="<?php echo $product['product_id']; ?>">
                    <?php echo htmlspecialchars($product['product_description']); ?>
                </option>
            <?php endforeach; ?>
        `;
    }

 
    if (selectElement && selectElement.tagName === 'SELECT') {
        const inputField = document.createElement('input');
        inputField.type = 'text';
        inputField.name = fieldType === 'productName' ? 'product_name' : 'product_description';
        inputField.id = fieldType === 'productName' ? 'productNameInput' : 'productDescriptionInput';
        inputField.placeholder = `Enter New ${fieldType.replace('product', '')}`;
        inputField.required = true;

        selectElement.parentElement.replaceChild(inputField, selectElement);
        toggleButton.innerHTML = '<i class="fas fa-sync-alt"></i>'; 
    } else {
      
        const selectField = document.createElement('select');
        selectField.name = fieldType === 'productName' ? 'product_name' : 'product_description';
        selectField.id = fieldType === 'productName' ? 'productNameSelect' : 'productDescriptionSelect';
        selectField.required = true;
        selectField.innerHTML = optionsHTML;

        const inputField = document.getElementById(fieldType === 'productName' ? 'productNameInput' : 'productDescriptionInput');
        inputField.parentElement.replaceChild(selectField, inputField);
        toggleButton.innerHTML = '<i class="fas fa-pencil-alt"></i>';

        if (fieldType === 'productName') {
            selectField.addEventListener('change', updateDescriptionDropdown);
        }
    }
}


        function toggleProductName() {
            const productNameSelect = document.getElementById('productNameSelect');
            const toggleButton = document.getElementById('toggleProductName');

            if (productNameSelect.tagName === 'SELECT') {
                // Switch to input field
                const inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.name = 'product_name';
                inputField.id = 'productNameSelect';
                inputField.placeholder = 'Enter New Product Name';
                inputField.required = true;

                productNameSelect.replaceWith(inputField);
                toggleButton.innerHTML = '<i class="fas fa-sync-alt"></i>'; // Change icon to refresh
            } else {
                // Switch back to dropdown
                const selectField = document.createElement('select');
                selectField.id = 'productNameSelect';
                selectField.name = 'product_name';
                selectField.required = true;
                selectField.innerHTML = `
            <option value="" disabled selected>Select Product Name</option>
            <?php foreach ($existingProducts as $product) : ?>
                <option value="<?php echo $product['product_id']; ?>" 
                        data-description="<?php echo htmlspecialchars($product['product_description']); ?>">
                    <?php echo htmlspecialchars($product['product_name']); ?>
                </option>
            <?php endforeach; ?>
        `;

                inputField.replaceWith(selectField);
                toggleButton.innerHTML = '<i class="fas fa-pencil-alt"></i>'; // Change icon back to pencil
                selectField.addEventListener('change', updateDescriptionDropdown);
            }
        }

        function toggleProductDescription() {
            const productDescriptionSelect = document.getElementById('productDescriptionSelect');
            const toggleButton = document.getElementById('toggleProductDescription');

            if (productDescriptionSelect.tagName === 'SELECT') {
                // Switch to input field
                const inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.name = 'product_description';
                inputField.id = 'productDescriptionSelect';
                inputField.placeholder = 'Enter New Product Description';
                inputField.required = true;

                productDescriptionSelect.replaceWith(inputField);
                toggleButton.innerHTML = '<i class="fas fa-sync-alt"></i>'; // Change icon to refresh
            } else {
                // Switch back to dropdown
                const selectField = document.createElement('select');
                selectField.id = 'productDescriptionSelect';
                selectField.name = 'product_description';
                selectField.required = true;
                selectField.innerHTML = `
            <option value="" disabled selected>Select Product Description</option>
            <?php foreach ($existingProducts as $product) : ?>
                <option value="<?php echo htmlspecialchars($product['product_description']); ?>" 
                        data-product-id="<?php echo $product['product_id']; ?>">
                    <?php echo htmlspecialchars($product['product_description']); ?>
                </option>
            <?php endforeach; ?>
        `;

                inputField.replaceWith(selectField);
                toggleButton.innerHTML = '<i class="fas fa-pencil-alt"></i>'; // Change icon back to pencil
            }
        }
    </script>


</body>

</html>