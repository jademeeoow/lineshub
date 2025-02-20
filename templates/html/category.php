<?php
include_once "../../php/category.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="../../static/style/product.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
</head>

<style>
    .inputs {
        background-color: #f1f1f1;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
    }

    .coninput {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }



    .add {
        margin-top: 10px;
        text-align: center;
        cursor: pointer;
    }

    .btnSubmitCategory {
        margin-top: 20px;
        text-align: center;
    }

    .addTitle {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .parexp,
    .inpexp {
        width: 100%;
    }

    .inputs .coninput:last-child {
        margin-bottom: 20px;

    }

    table th, 
table td {
    border: 1px solid #ccc;
  
}
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


            <!-- END OF SIDEMENU -->

            <div class="content">
                <div class="title">
                    <h1>CATEGORY</h1>
                </div>

                <div class="marjcontent">
                    <div class="categoryAddButton">
                        <button onclick="addCategory()">Add Category</button>
                        <button onclick="addProduct()">Add Product</button>
                    </div>


                    <!-- Add Category -->
                    <div class="option" id="optionAdd" style="display: none;">
                        <div class="opt opt1" id="optionAddOpt1">
                            <form action="category.php" method="POST" id="categoryForm">
                                <input type="hidden" name="add_category" value="1">
                                <div class="marjOption">
                                    <div class="addTitle">
                                        <p>Add Category</p>
                                        <i class="fas fa-times" onclick="closeAddCategory()"></i>
                                    </div>
                                    <div class="parexp">
                                        <label for="enterCategory">Enter Category</label>
                                        <div class="inpexp">
                                            <input type="text" name="categoryName" id="enterCategory" spellcheck="false" required>
                                        </div>
                                    </div>
                                    <p>Does this category have drop down options?</p>
                                    <div class="btnYesNo">
                                        <div class="radioBtn">
                                            <input type="radio" name="hasSubcategories" id="yes" value="yes">
                                            <label for="yes">Yes</label>
                                        </div>
                                        <div class="radioBtn">
                                            <input type="radio" name="hasSubcategories" id="no" value="no" checked>
                                            <label for="no">No</label>
                                        </div>
                                    </div>

                                    <div class="inputs" id="inputs">
                                        <div class="coninput">
                                            <div class="parexp">
                                                <label for="subCategory">Enter Sub-Category</label>
                                                <div class="inpexp">
                                                    <input type="text" name="subcategories[]" class="subCategoryInput" spellcheck="false">
                                                </div>
                                            </div>
                                            <div class="clear">
                                                <p>Clear</p>
                                            </div>
                                        </div>

                                        <div class="add">
                                            <p>ADD MORE OPTIONS</p>
                                        </div>
                                    </div>

                                    <div class="btnSubmitCategory">
                                        <button type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>













                        <!-- Add Products -->
                        <div class="opt opt2" id="optionAddOpt2">
                            <form action="category.php" method="POST" id="productForm">
                                <input type="hidden" name="add_product" value="1">
                                <div class="addproducts">
                                    <div class="addTitle">
                                        <p>Add Products</p>
                                        <i class="fas fa-times" onclick="closeAddProduct()"></i>
                                    </div>
                                    <div class="parexp">
                                        <label for="productName">Product Name</label>
                                        <div class="inpexp">
                                            <input type="text" name="productName" id="productName" spellcheck="false" required>
                                        </div>
                                    </div>
                                    <div class="parexp">
                                        <label for="productDescription">Product Description</label>
                                        <div class="inpexp">
                                            <input type="text" name="productDescription" id="productDescription" spellcheck="false" required>
                                        </div>
                                    </div>
                                    <div class="parex">
                                        <label for="categorySelect" class="parexp">Product Category</label>
                                        <div class="inpexp">
                                            <select id="categorySelect" name="category" required>
                                                <option value="" disabled selected>Select Category</option>
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="parexp">
                                        <label for="subcategorySelect" class="parexp">Product Subcategory</label>]

                                        <div class="inpexp">
                                            <select id="subcategorySelect" name="subcategory">


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
                                                                <input type="number" name="variants[0][stock]" spellcheck="false">
                                                            </div>
                                                        </div>
                                                        <div class="parexp">
                                                            <label>Supplier</label>
                                                            <div class="inpexp">
                                                                <select name="variants[0][supplier]" required>
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
                                                <!-- Button to add more variants -->
                                                <div class="addVar">
                                                    <p onclick="addVariations(this)">ADD VARIATIONS</p>
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







                    <!-- Edit Category -->

                    <div class="option" id="optionEdit" style="display: none;">
                        <div class="opt opt1" id="optionEditOpt1">
                            <form action="category.php" method="POST" id="editCategoryForm">
                                <input type="hidden" name="edit_category" value="1">
                                <input type="hidden" name="category_id" id="editCategoryId" value="">
                                <div class="marjOption">
                                    <div class="addTitle">
                                        <p>Edit Category</p>
                                        <i class="fas fa-times" onclick="closeEditCategory()"></i>
                                    </div>
                                    <div class="parexp">
                                        <label for="enterCategory">Enter Category</label>
                                        <div class="inpexp">
                                            <input type="text" name="categoryName" id="editCategoryName" spellcheck="false" required>
                                        </div>
                                    </div>
                                    <p style="display:none">Does this category have drop down options?</p>
                                    <div class="btnYesNo" style="display:none">
                                        <div class="radioBtn">
                                            <input type="radio" name="hasSubcategories" id="editYes" value="yes">
                                            <label for="editYes">Yes</label>
                                        </div>
                                        <div class="radioBtn">
                                            <input type="radio" name="hasSubcategories" id="editNo" value="no" checked>
                                            <label for="editNo">No</label>
                                        </div>
                                    </div>

                                    <!-- Subcategory inputs container -->
                                    <div class="inputs" id="editInputs">
                                        <!-- Container for existing subcategory inputs -->
                                        <div class="coninput">
                                            <div class="parexp">
                                                <label for="editSubCategory">Enter Sub-Category</label>
                                                <div class="inpexp">
                                                    <input type="text" name="subcategories[]" class="subCategoryEditInput" spellcheck="false">
                                                </div>
                                            </div>
                                            <div class="clear" onclick="this.parentElement.remove()">
                                                <p>Clear</p>
                                            </div>
                                        </div>

                                        <!-- Add More Options button inside the container -->
                                        <div class="add" id="addEditOptions" style="display: none;" onclick="addMoreEditSubcategories()">
                                            <p>ADD MORE OPTIONS</p>
                                        </div>
                                    </div>
                                    <div class="btnSubmitCategory">
                                        <button type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
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
                                <i class="fas fa-search searchicon" onclick="searchToggle()"></i>

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





                    <table>
                        <tr class="tableheader">
                            <td>Category</td>
                            <td>SubCategory</td>
                            <td>Actions</td>


                        </tr>
                        <?php foreach ($categories as $category) : ?>
                            <tr data-category-id="<?php echo htmlspecialchars($category['category_id']); ?>">
                            <td><?php echo htmlspecialchars(ucwords(strtolower(html_entity_decode($category['category_name'])))); ?></td>

                                <td>
                                    <button class="btnView" onclick="redirectToSubcategory(<?php echo htmlspecialchars($category['category_id']); ?>)">
                                        </i> View
                                    </button>
                                </td>

                                <td>
                                    <button onclick="editCategory(<?php echo htmlspecialchars($category['category_id']); ?>)">Edit</button>
                                    <button onclick="openDeleteConfirmModal(<?php echo htmlspecialchars($category['category_id']); ?>)">Delete</button>

                                </td>
                                
                            </tr>
                        <?php endforeach; ?>


                    </table>

                </div>













                <div id="successModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('successModal')">&times;</span>
                        <p id="successMessage"></p>

                        <button class="inventory-btn" id="goToInventoryBtn" style="display: none;" onclick="redirectToInventory()">Go to Inventory</button>
                    </div>
                </div>

                <div id="errorModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('errorModal')">&times;</span>
                        <p id="errorMessage"></p>
                    </div>
                </div>


                <div id="deleteConfirmModal" class="modal">
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






        <script src="../../static/script/script.js"></script>

        <script>
            const suppliers = <?php echo json_encode($suppliers); ?>;

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

            document.addEventListener("DOMContentLoaded", function() {
                <?php
                if (isset($_SESSION['message'])) {

                    echo "document.getElementById('successMessage').innerText = '" . $_SESSION['message'] . "';";
                    echo "document.getElementById('successModal').style.display = 'block';";


                    if (strpos($_SESSION['message'], "Product added successfully!") !== false) {
                        echo "document.getElementById('goToInventoryBtn').style.display = 'inline-block';";
                    }

                    unset($_SESSION['message']);
                }

                if (isset($_SESSION['message2']) && !empty($_SESSION['message2'])) {
                    echo "document.getElementById('errorModal').style.display = 'block';";
                    echo "document.getElementById('errorMessage').innerHTML = '" . implode("<br>", $_SESSION['message2']) . "';";
                    unset($_SESSION['message2']);
                }
                ?>




                const categorySelect = document.getElementById('categorySelect');
                const subcategorySelect = document.getElementById('subcategorySelect');

                function updateSubcategories() {
                    const selectedCategoryId = categorySelect.value;


                    subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';


                    const subcategories = <?php echo json_encode($categories); ?>;
                    const filteredSubcategories = subcategories
                        .find(category => category.category_id == selectedCategoryId)
                        ?.subcategories || [];

                    let hasNoneOption = false;

                    filteredSubcategories.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.sub_category_id;
                        option.textContent = subcat.sub_category_name;
                        subcategorySelect.appendChild(option);

                        if (subcat.sub_category_name === 'None') {
                            hasNoneOption = true;
                        }
                    });


                    const options = Array.from(subcategorySelect.options);
                    const onlyNoneOption = options.length === 2 && hasNoneOption;


                    if (onlyNoneOption) {
                        subcategorySelect.value = '';
                        subcategorySelect.options[1].selected = true;
                    } else {
                        subcategorySelect.value = '';
                    }
                }

                categorySelect.addEventListener('change', updateSubcategories);
            });


            let deleteCategoryId = null;

            function openDeleteConfirmModal(categoryId) {
                deleteCategoryId = categoryId;
                document.getElementById('deleteConfirmModal').style.display = 'block';
            }

            function confirmDeleteCategory() {
                if (deleteCategoryId !== null) {

                    window.location.href = 'category.php?delete_category=' + deleteCategoryId;
                }
                closeModal('deleteConfirmModal');
            }


            document.getElementById('confirmDeleteButton').addEventListener('click', confirmDeleteCategory);


            document.querySelectorAll('.table button').forEach(button => {
                button.addEventListener('click', function() {
                    if (this.textContent === 'Delete') {
                        const categoryId = this.closest('tr').dataset.categoryId;
                        openDeleteConfirmModal(categoryId);
                    }
                });
            });

            function handleCategoryFormSubmission(event) {
                const hasSubcategoriesNo = document.querySelector('input[name="hasSubcategories"]:checked').value === 'no';
                const subcategoryInputs = document.querySelectorAll('.subCategoryInput');

                if (hasSubcategoriesNo) {

                    subcategoryInputs.forEach(input => {
                        input.value = 'None';
                    });
                }

                const hasEmptySubcategories = [...subcategoryInputs].some(input => input.value.trim() === '');
                if (hasEmptySubcategories) {
                    subcategoryInputs.forEach(input => {
                        if (input.value.trim() === '') {
                            input.value = 'None';
                        }
                    });
                }


                document.getElementById('categoryForm').submit();
            }



            function searchToggle() {
                const searchInput = document.getElementById('searchInput');
                const searchContainer = document.getElementById('searchinp');

                if (searchContainer.style.display === 'flex') {

                    searchContainer.style.display = 'none';
                    searchInput.value = '';
                    searchTable();
                } else {

                    searchContainer.style.display = 'flex';
                    searchInput.focus();
                }
            }


            document.addEventListener("DOMContentLoaded", function() {
                function toggleEditInputs() {

                    var editInputsDiv = document.getElementById("editInputs");
                    var editYesRadioButton = document.getElementById("EditYes");
                    var editNoRadioButton = document.getElementById("EditNo");


                    if (editYesRadioButton.checked) {
                        editInputsDiv.style.display = "grid";
                    } else if (editNoRadioButton.checked) {
                        editInputsDiv.style.display = "none";
                    }
                }

                var editYesRadioButton = document.getElementById("EditYes");
                var editNoRadioButton = document.getElementById("EditNo");


                editYesRadioButton.addEventListener("change", toggleEditInputs);
                editNoRadioButton.addEventListener("change", toggleEditInputs);


                toggleEditInputs();
            });


            function redirectToInventory() {

                window.location.href = "inventory.php"



            }


            function filterCategories(filterType) {
                const rows = document.querySelectorAll('table tr:not(.tableheader)');
                rows.forEach(row => {
                    const subcategories = row.querySelector('td:nth-child(2)').innerText.trim();
                    switch (filterType) {
                        case 'all':
                            row.style.display = '';
                            break;
                        case 'with':

                            row.style.display = subcategories !== 'None' ? '' : 'none';
                            break;
                        case 'without':

                            row.style.display = subcategories === 'None' ? '' : 'none';
                            break;
                    }
                });
            }

            function searchTable() {
                const searchInput = document.getElementById('searchInput').value.toLowerCase();
                const rows = document.querySelectorAll('table tr:not(.tableheader)');

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


                const currentFilter = document.querySelector('input[name="categoryFilter"]:checked').value;
                filterCategories(currentFilter);
            }


            function clearSearch() {

                const searchInput = document.getElementById('searchInput');
                searchInput.value = '';


                const searchContainer = document.getElementById('searchinp');
                searchContainer.style.display = 'none';
                searchTable();

                filterStock('all');
            }


            function editCategory(categoryId) {

                const category = <?php echo json_encode($categories); ?>.find(cat => cat.category_id == categoryId);


                document.getElementById('editCategoryId').value = category.category_id;


                document.getElementById('editCategoryName').value = category.category_name;


                editInputs.innerHTML = '';

                if (category.subcategories && category.subcategories.length > 0) {

                    editYesRadioButton.checked = true;


                    category.subcategories.forEach(subcat => {
                        const newInput = document.createElement('div');
                        newInput.classList.add('coninput');
                        newInput.innerHTML = `
                <div class="parexp">
                    <label for="editSubCategory">Enter Sub-Category</label>
                    <div class="inpexp">
                        <input type="text" name="subcategories[]" class="subCategoryEditInput" value="${subcat.sub_category_name}" spellcheck="false">
                    </div>
                </div>
                <div class="clear" onclick="this.parentElement.remove()">
                    <p>Clear</p>
                </div>
            `;
                        editInputs.appendChild(newInput);
                    });


                    addEditOptions.style.display = 'block';
                } else {

                    editNoRadioButton.checked = true;

                    editInputs.innerHTML = '';
                    addEditOptions.style.display = 'none';
                }

                toggleEditInputs();


                document.getElementById('optionEdit').style.display = 'flex';
                document.getElementById('optionEditOpt1').style.display = 'block';
            }


            function closeEditCategory() {
                const optionEdit = document.getElementById("optionEdit");
                const optionEditOpt1 = document.getElementById("optionEditOpt1");
                const optionAddOpt1 = document.getElementById("optionAddOpt1");
                const optionAddOpt2 = document.getElementById("optionAddOpt2");

                optionEdit.style.display = "none";
                optionEditOpt1.style.display = "none";
                optionAddOpt1.style.display = "none";
                optionAddOpt2.style.display = "none";
            }

            document.addEventListener('DOMContentLoaded', function() {
                const editYesRadioButton = document.getElementById('editYes');
                const editNoRadioButton = document.getElementById('editNo');
                const editInputs = document.getElementById('editInputs');
                const addEditOptions = document.getElementById('addEditOptions');


                function toggleEditInputs() {
                    if (editYesRadioButton.checked) {
                        editInputs.style.display = 'block';
                        addEditOptions.style.display = 'block';
                    } else {
                        editInputs.style.display = 'none';
                        addEditOptions.style.display = 'none';
                    }
                }

                editYesRadioButton.addEventListener('change', toggleEditInputs);
                editNoRadioButton.addEventListener('change', toggleEditInputs);

                function addMoreEditSubcategories() {
                    const newInput = document.createElement('div');
                    newInput.classList.add('coninput');
                    newInput.innerHTML = `
            <div class="parexp">
                <label for="editSubCategory">Enter Sub-Category</label>
                <div class="inpexp">
                    <input type="text" name="subcategories[]" class="subCategoryEditInput" spellcheck="false">
                </div>
            </div>
            <div class="clear" onclick="this.parentElement.remove()">
                <p>Clear</p>
            </div>
        `;

                    editInputs.insertBefore(newInput, addEditOptions);
                }


                window.addMoreEditSubcategories = addMoreEditSubcategories;


                function editCategory(categoryId) {

                    const category = <?php echo json_encode($categories); ?>.find(cat => cat.category_id == categoryId);


                    document.getElementById('editCategoryId').value = category.category_id;


                    document.getElementById('editCategoryName').value = category.category_name;


                    editInputs.innerHTML = '';


                    if (category.subcategories && category.subcategories.length > 0) {

                        editYesRadioButton.checked = true;


                        category.subcategories.forEach(subcat => {
                            const newInput = document.createElement('div');
                            newInput.classList.add('coninput');
                            newInput.innerHTML = `
                    <div class="parexp">
                        <label for="editSubCategory">Enter Sub-Category</label>
                        <div class="inpexp">
                            <input type="text" name="subcategories[]" class="subCategoryEditInput" value="${subcat.sub_category_name}" spellcheck="false">
                        </div>
                    </div>
                    <div class="clear" onclick="this.parentElement.remove()">
                        <p>Clear</p>
                    </div>
                `;
                            editInputs.appendChild(newInput);
                        });


                        addEditOptions.style.display = 'block';
                        editInputs.appendChild(addEditOptions);
                    } else {

                        editNoRadioButton.checked = true;


                        editInputs.innerHTML = '';
                        addEditOptions.style.display = 'none';
                    }


                    toggleEditInputs();


                    document.getElementById('optionEdit').style.display = 'flex';
                    document.getElementById('optionEditOpt1').style.display = 'block';
                }

                window.editCategory = editCategory;
            });


            function redirectToSubcategory(categoryId) {
                window.location.href = `subcategory.php?category_id=${categoryId}`;
            }
        </script>
</body>

</html>