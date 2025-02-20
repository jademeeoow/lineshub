<?php
include_once "../../php/subcategory.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategories</title>
    <link rel="stylesheet" href="../../static/style/product.css">
    <link rel="stylesheet" href="../../static/style/variants.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="../../static/images/logolines.jpg">
    <style>
        .inputs {
            background-color: #f1f1f1;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .tableheader {
            background-color: #f4f4f4;
            text-align: left;
        }

        .tabletool {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-title {
            font-size: 16px;
            font-weight: bold;
            margin-left: 10px;
            margin-right: 25px;
        }

      
    </style>
</head>

<body>
    <div class="notifTooltipCon">
        <p>Notification Tooltip</p>
    </div>
    <div class="whole">
        <main-header data-image-path="<?php echo $image_path; ?>" data-role="<?php echo $_SESSION['role']; ?>"></main-header>
        <div class="con">
            <?php include_once "sidemenu.php"; ?>

            <div class="content">


                <div class="marjcontent">
                <div class="backButton">
                        <button onclick="backCategory()"> BACK </button>
                    </div>
                    <div class="contool-table">
                        <div class="tabletool">
                            <div  STY class="category-title">
                                Category: <?php echo htmlspecialchars($categoryName); ?>
                            </div>
                            <div class="searchinp">
                                <i class="fas fa-search searchicon" onclick="searchToggle()"></i>
                                <input type="text" id="searchInput" placeholder="Search.." oninput="searchTable()">
                                <i class="fas fa-times" onclick="clearSearch()"></i>
                            </div>
                        </div>
                    </div>

                    <table>
                        <tr class="tableheader">
                            <td>Subcategory Name</td>
                        </tr>
                        <?php if (!empty($subcategories)) : ?>
                            <?php foreach ($subcategories as $subcategory) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($subcategory['sub_category_name']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td>No subcategories found for this category.</td>
                            </tr>
                        <?php endif; ?>
                    </table>


                </div>
            </div>
            <main-sidenotif class="side sidenotif"></main-sidenotif>
        </div>


    </div>



    <script src="../../static/script/script.js"></script>
    <script>
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

        function searchTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('table tr:not(.tableheader)');

            rows.forEach(row => {
                const cellText = row.querySelector('td').textContent.toLowerCase();
                row.style.display = cellText.includes(searchInput) ? '' : 'none';
            });
        }

        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.value = '';
            searchTable();
        }

        function backCategory (){

            window.location.href = "category.php";
        }
    </script>
</body>

</html>
