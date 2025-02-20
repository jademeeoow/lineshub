// redirect to page
// redirect to page
// redirect to page

function redirect(page) {
  window.location.href = page;
}

// hide/show sub navigations
// hide/show sub navigations
// hide/show sub navigations

function toggle1() {
  const toggleDown1 = document.getElementById("toggleDown1");
  const conMenu1 = document.getElementById("conMenu1");
  if (conMenu1.style.display === "none" || conMenu1.style.display === "") {
    conMenu1.style.display = "block";
    toggleDown1.className = "fa fa-angle-up";
  } else {
    conMenu1.style.display = "none";
    toggleDown1.className = "fa fa-angle-down";
  }
}
function toggle2() {
  const toggleDown2 = document.getElementById("toggleDown2");
  const conMenu2 = document.getElementById("conMenu2");
  if (conMenu2.style.display === "none" || conMenu2.style.display === "") {
    conMenu2.style.display = "block";
    toggleDown2.className = "fa fa-angle-up";
  } else {
    conMenu2.style.display = "none";
    toggleDown2.className = "fa fa-angle-down";
  }
}
function toggle3() {
  const toggleDown3 = document.getElementById("toggleDown3");
  const conMenu3 = document.getElementById("conMenu3");
  if (conMenu3.style.display === "none" || conMenu3.style.display === "") {
    conMenu3.style.display = "block";
    toggleDown3.className = "fa fa-angle-up";
  } else {
    conMenu3.style.display = "none";
    toggleDown3.className = "fa fa-angle-down";
  }
}

// sidebar notifications/messages
// sidebar notifications/messages
// sidebar notifications/messages

function toggleNotif() {
  const sidenotifs = document.querySelectorAll(".sidenotif");
  const marj21 = document.querySelectorAll(".marj21");
  const marj22 = document.querySelectorAll(".marj22");

  sidenotifs.forEach((sidenotif) => {
    if (sidenotif.style.width === "0px" || sidenotif.style.width === "") {
      sidenotif.style.width = "20%";
      marj21.forEach((el) => (el.style.display = "flex"));
      marj22.forEach((el) => (el.style.display = "none"));
    } else {
      if (
        Array.from(marj21).some((el) => getComputedStyle(el).display === "flex")
      ) {
        sidenotif.style.width = "0px";
        marj21.forEach((el) => (el.style.display = "none"));
      } else {
        sidenotif.style.width = "20%";
        marj21.forEach((el) => (el.style.display = "flex"));
        marj22.forEach((el) => (el.style.display = "none"));
      }
    }
  });
}
function toggleMessage() {
  const sidenotifs = document.querySelectorAll(".sidenotif");
  const marj21 = document.querySelectorAll(".marj21");
  const marj22 = document.querySelectorAll(".marj22");

  sidenotifs.forEach((sidenotif) => {
    if (sidenotif.style.width === "0px" || sidenotif.style.width === "") {
      sidenotif.style.width = "20%";
      marj22.forEach((el) => (el.style.display = "flex"));
      marj21.forEach((el) => (el.style.display = "none"));
    } else {
      if (
        Array.from(marj22).some((el) => getComputedStyle(el).display === "flex")
      ) {
        sidenotif.style.width = "0px";
        marj22.forEach((el) => (el.style.display = "none"));
      } else {
        sidenotif.style.width = "20%";
        marj22.forEach((el) => (el.style.display = "flex"));
        marj21.forEach((el) => (el.style.display = "none"));
      }
    }
  });
}

function openAddExp() {
  const addExpenceContainer = document.getElementById("addExpenceContainer");
  addExpenceContainer.style.display = "flex";
}
function closeAddExp() {
  const addExpenceContainer = document.getElementById("addExpenceContainer");
  addExpenceContainer.style.display = "none";
}


// search bar function dashboard.html
// search bar function dashboard.html
// search bar function dashboard.html

function searchtoggle() {
  const lists = document.querySelectorAll(".list");
  const searchinps = document.querySelectorAll(".searchinp");
  const searchicons = document.querySelectorAll(".searchicon");

  lists.forEach((list, index) => {
    const searchinp = searchinps[index];
    const inputField = searchinp.querySelector("input");
    const searchicon = searchicons[index];

    if (list.style.display === "block" || list.style.display === "") {
      list.style.display = "none";
      searchinp.style.display = "flex";
      inputField.focus();
      searchicon.style.backgroundColor = "#FFC000";
    } else {
      list.style.display = "block";
      searchinp.style.display = "none";
      inputField.value = "";
      searchicon.style.backgroundColor = "";
    }
  });
}
function cancelSearch() {
  const lists = document.querySelectorAll(".list");
  const searchinps = document.querySelectorAll(".searchinp");
  const searchicons = document.querySelectorAll(".searchicon");

  lists.forEach((list, index) => {
    const searchinp = searchinps[index];
    const inputField = searchinp.querySelector("input");
    const searchicon = searchicons[index];

    list.style.display = "block";
    searchinp.style.display = "none";
    inputField.value = "";
    searchicon.style.backgroundColor = "";
  });
}

// filter columns dashboard.html
// filter columns dashboard.html
// filter columns dashboard.html

function toggleColumnVisibility() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach(function (checkbox) {
    var className = checkbox.id;
    var elements = document.querySelectorAll("." + className);
    elements.forEach(function (element) {
      if (checkbox.checked) {
        element.style.display = "table-cell";
      } else {
        element.style.display = "none";
      }
    });
    checkbox.addEventListener("change", function () {
      var className = this.id;
      var elements = document.querySelectorAll("." + className);
      elements.forEach(function (element) {
        if (checkbox.checked) {
          element.style.display = "table-cell";
        } else {
          element.style.display = "none";
        }
      });
    });
  });
}
toggleColumnVisibility();


function filterColumnShow() {
  const filterColumns = document.querySelectorAll(".filterColumn");
  filterColumns.forEach(function (column) {
    column.style.display = "block";
  });
}


function filterColumnHide() {
  const filterColumns = document.querySelectorAll(".filterColumn");
  filterColumns.forEach(function (column) {
    column.style.display = "none";

    const row = column.closest("tr");
    if (row) {
 
      const columnsInRow = row.querySelectorAll(".filterColumn");
      const allColumnsHidden = Array.from(columnsInRow).every(col => col.style.display === "none");
      if (allColumnsHidden) {
        row.style.display = "none";
      }
    }
  });
}


// upload img account.html
// upload img account.html
// upload img account.html

function previewImage(event) {
  const uploadedImage = document.getElementById("uploadedImage");
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      uploadedImage.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}

function editToggleClose() {
  const editAccount = document.querySelector(".edit-account");
  const computedStyle = window.getComputedStyle(editAccount);

  if (computedStyle.getPropertyValue("display") === "flex") {
    editAccount.style.display = "none";

    const inputs = document.querySelectorAll(".garpar input");
    inputs.forEach((input) => (input.value = ""));
    const fileInput = document.getElementById("uploadInput");
    fileInput.value = "";
    const uploadedImage = document.getElementById("uploadedImage");
    uploadedImage.src = "static/images/logolines.jpg";
  }
}

function editToggleOpen() {
  const editAccount = document.querySelector(".edit-account");
  editAccount.style.display = "flex";
}

// add account account.html
// add account account.html
// add account account.html

function addToggleClose() {
  const addAccount = document.querySelector(".add-account");
  const computedStyle = window.getComputedStyle(addAccount);
  if (computedStyle.getPropertyValue("display") === "flex") {
    addAccount.style.display = "none";

    const inputs = document.querySelectorAll(".garpar input");
    inputs.forEach((input) => (input.value = ""));
    const fileInput = document.getElementById("uploadInput");
    fileInput.value = "";
    const uploadedImage = document.getElementById("uploadedImage");
    uploadedImage.src = "static/images/logolines.jpg";
  }
}
function addToggleOpen() {
  const addAccount = document.querySelector(".add-account");
  addAccount.style.display = "flex";
}

// radio button function in account.html
// radio button function in account.html
// radio button function in account.html

function toggleTables() {
  const superAdminTable = document.querySelector(".table-account-superAdmin");
  const adminTable = document.querySelector(".table-account-admin");
  const superAdminRadio = document.getElementById("rbtn-button-admin");
  const adminRadio = document.getElementById("rbtn-button-user");

  if (superAdminRadio.checked) {
    superAdminTable.style.display = "block";
    adminTable.style.display = "none";
    superAdminTable.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  } else if (adminRadio.checked) {
    superAdminTable.style.display = "none";
    adminTable.style.display = "block";
    adminTable.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  }
}

window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('input[name="rbtnAccount"]').forEach((radio) => {
    radio.addEventListener("change", toggleTables);
  });

  toggleTables();
});

// radio button function in history.html
// radio button function in history.html
// radio button function in history.html

function toggleTables2() {
  const transactionTable = document.querySelector(".history-table-transaction");
  const loginTable = document.querySelector(".history-table-login");
  const restockTable = document.querySelector(".history-table-restock");
  const transactionRadio = document.getElementById("rbtn-button-transaction");
  const loginRadio = document.getElementById("rbtn-button-login");
  const restockRadio = document.getElementById("rbtn-button-restock");

  if (transactionRadio.checked) {
    transactionTable.style.display = "block";
    loginTable.style.display = "none";
    restockTable.style.display = "none";
    transactionTable.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  } else if (loginRadio.checked) {
    transactionTable.style.display = "none";
    loginTable.style.display = "block";
    restockTable.style.display = "none";
    loginTable.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  } else if (restockRadio.checked) {
    transactionTable.style.display = "none";
    loginTable.style.display = "none";
    restockTable.style.display = "block";
    restockTable.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  }
}

window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('input[name="rbtnHistory"]').forEach((radio) => {
    radio.addEventListener("change", toggleTables2);
  });

  toggleTables2();
});

// toggle Logout
function logoutToggle() {
  const logout = document.getElementById("logout");

  if (logout.style.display === "none") {
    logout.style.display = "flex";
    document.addEventListener("click", outsideClickListener);
  } else {
    logout.style.display = "none";
    document.removeEventListener("click", outsideClickListener);
  }
}

function outsideClickListener(event) {
  const logout = document.getElementById("logout");
  const pp = document.getElementById("pp");

  if (!logout.contains(event.target) && !pp.contains(event.target)) {
    logout.style.display = "none";
    document.removeEventListener("click", outsideClickListener);
  }
}

// toggle sub category
document.addEventListener("DOMContentLoaded", function () {
  function toggleInputs() {
    var inputsDiv = document.getElementById("inputs");
    var noRadioButton = document.getElementById("no");

    if (noRadioButton.checked) {
      inputsDiv.style.display = "none";
    } else {
      inputsDiv.style.display = "grid";
    }
  }

  var yesRadioButton = document.getElementById("yes");
  var noRadioButton = document.getElementById("no");

  yesRadioButton.addEventListener("change", toggleInputs);
  noRadioButton.addEventListener("change", toggleInputs);

  toggleInputs();
});

// add and clear sub category with hover effect
document.addEventListener("DOMContentLoaded", function () {
  function addHoverEffect() {
    document.querySelectorAll(".clear p").forEach(function (p) {
      p.addEventListener("mouseover", function () {
        this.closest(".coninput")
          .querySelector("input")
          .classList.add("hover-effect");
      });

      p.addEventListener("mouseout", function () {
        this.closest(".coninput")
          .querySelector("input")
          .classList.remove("hover-effect");
      });
    });
  }

  function assignUniqueIds() {
    const parexpDivs = document.querySelectorAll(".parexp");
    parexpDivs.forEach((div, index) => {
      const input = div.querySelector("input, select");
      const uniqueId = "input" + (index + 1);
      input.id = uniqueId;
      const label = div.querySelector("label");
      label.setAttribute("for", uniqueId);
    });
  }

  function addNewOption() {
    var inputsDiv = document.getElementById("inputs");

    var newConinput = document.createElement("div");
    newConinput.className = "coninput";

    newConinput.innerHTML = `
    <div class="parexp">
        <label>Enter Sub-Category</label>
        <div class="inpexp">
            <input type="text" name="subcategories[]" spellcheck="false">
        </div>
    </div>
    <div class="clear">
        <p>Clear</p>
    </div>
`;

    inputsDiv.insertBefore(newConinput, document.querySelector(".add"));

    newConinput
      .querySelector(".clear p")
      .addEventListener("click", clearOption);

    assignUniqueIds();
    addHoverEffect();
  }


  // Date unable to select if the date has passed



  

  function clearOption(event) {
    var coninputDiv = event.target.closest(".coninput");
    if (coninputDiv) {
      coninputDiv.remove();
    }
    assignUniqueIds();
  }

  var addMoreOptions = document.querySelector(".add p");


  addMoreOptions.addEventListener("click", addNewOption);


  assignUniqueIds();
  addHoverEffect();

  document.querySelectorAll(".clear p").forEach(function (clearButton) {
    clearButton.addEventListener("click", clearOption);
  });
});




document.addEventListener("DOMContentLoaded", function () {
  function addHoverEffect() {
    document.querySelectorAll(".clear2 p").forEach(function (p) {
      p.addEventListener("mouseover", function () {
        this.closest(".coninput2")
          .querySelector("input")
          .classList.add("hover-effect");
      });

      p.addEventListener("mouseout", function () {
        this.closest(".coninput2")
          .querySelector("input")
          .classList.remove("hover-effect");
      });
    });
  }

  function assignUniqueIds() {
    const parexpDivs = document.querySelectorAll(".parexp");
    parexpDivs.forEach((div, index) => {
      const input = div.querySelector("input, select");
      const uniqueId = "input" + (index + 1);
      input.id = uniqueId;
      const label = div.querySelector("label");
      label.setAttribute("for", uniqueId);
    });
  }

  function addMoreEditSubcategories() {
    var inputtedDiv = document.getElementById("inputted");

    var newConinput = document.createElement("div");
    newConinput.className = "coninput2";

    newConinput.innerHTML = `
    <div class="parexp">
        <label>Enter Sub-Category</label>
        <div class="inpexp2">
            <input type="text" name="subcategories[]" spellcheck="false">
        </div>
    </div>
    <div class="clear2">
        <p>Clear</p>
    </div>
    `;

   
    inputtedDiv.insertBefore(newConinput, document.querySelector(".add2"));

   
    newConinput
      .querySelector(".clear2 p")
      .addEventListener("click", clearOption);

    assignUniqueIds();
    addHoverEffect();
  }

  function clearOption(event) {
    var coninputDiv = event.target.closest(".coninput2");
    if (coninputDiv) {
      coninputDiv.remove();
    }
    assignUniqueIds();
  }

  
  var addMoreOptions = document.querySelector(".add2");
  addMoreOptions.addEventListener("click", addMoreEditSubcategories);

  assignUniqueIds();
  addHoverEffect();


  document.querySelectorAll(".clear2 p").forEach(function (clearButton) {
    clearButton.addEventListener("click", clearOption);
  });
});
// add category
function addCategory() {
  const optionAdd = document.getElementById("optionAdd");
  const optionAddOpt1 = document.getElementById("optionAddOpt1");
  const optionAddOpt2 = document.getElementById("optionAddOpt2");

  optionAdd.style.display = "flex";
  optionAddOpt1.style.display = "block";
  optionAddOpt2.style.display = "none";
}
function closeAddCategory() {
  const optionAdd = document.getElementById("optionAdd");
  const optionAddOpt1 = document.getElementById("optionAddOpt1");
  const optionAddOpt2 = document.getElementById("optionAddOpt2");

  optionAdd.style.display = "none";
  optionAddOpt1.style.display = "none";
  optionAddOpt2.style.display = "none";
}

function addProduct() {
  const optionAdd = document.getElementById("optionAdd");
  const optionAddOpt1 = document.getElementById("optionAddOpt1");
  const optionAddOpt2 = document.getElementById("optionAddOpt2");

  optionAdd.style.display = "flex";
  optionAddOpt1.style.display = "none";
  optionAddOpt2.style.display = "block";
}
function closeAddProduct() {
  const optionAdd = document.getElementById("optionAdd");
  const optionAddOpt1 = document.getElementById("optionAddOpt1");
  const optionAddOpt2 = document.getElementById("optionAddOpt2");

  optionAdd.style.display = "none";
  optionAddOpt1.style.display = "none";
  optionAddOpt2.style.display = "none";
}

// toggle Table Inventory.html
function toggleTableInventory() {
  const inventoryProducts = document.getElementById("inventoryProducts");
  const inventoryHistory = document.getElementById(
    "inventoryHistoryOfTheProducts"
  );
  const tableProduct = document.querySelector(".table-product");
  const tableHistory = document.querySelector(".table-historyProduct");

  if (inventoryProducts.checked) {
    tableProduct.style.display = "block";
    tableHistory.style.display = "none";
    tableProduct.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  } else if (inventoryHistory.checked) {
    tableProduct.style.display = "none";
    tableHistory.style.display = "block";
    tableHistory.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  }
}

window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('input[name="inventoryBtn"]').forEach((radio) => {
    radio.addEventListener("change", toggleTableInventory);
  });

  toggleTableInventory();
});

// label input association
document.addEventListener("DOMContentLoaded", function () {
  assignUniqueIds();
});
function assignUniqueIds() {
  const parexpDivs = document.querySelectorAll(".parexp");
  parexpDivs.forEach((div, index) => {
    const input = div.querySelector("input, select");
    const uniqueId = "input" + (index + 1);
    input.id = uniqueId;
    const label = div.querySelector("label");
    label.setAttribute("for", uniqueId);
  });
}



let variantCount = 1; 

function addVariations(element) {
  const conVar = element.closest(".subCategories").querySelector(".conVar");
  const containers = document.querySelectorAll(".containerPerVarviation");
  containers.forEach((container) => {
    container.scrollTo({
      left: container.scrollWidth,
      behavior: "smooth",
    });
  });

  const newVar = document.createElement("div");
  newVar.classList.add("perVar");
  newVar.innerHTML = `
        <div class="parexp">
            <label>Product Color</label>
            <div class="inpexp">
                <input type="text" name="variants[${variantCount}][color]" spellcheck="false">
            </div>
        </div>
        <div class="parexp">
            <label>Product Size</label>
            <div class="inpexp">
                <input type="text" name="variants[${variantCount}][size]" spellcheck="false">
            </div>
        </div>
        <div class="parexp">
            <label>Product Price</label>
            <div class="inpexp">
                <input type="number"  name="variants[${variantCount}][price]" spellcheck="false">
            </div>
        </div>
        <div class="parexp">
            <label>Number of Stock(s)</label>
            <div class="inpexp">
                <input type="number" name="variants[${variantCount}][stock]" spellcheck="false">
            </div>
        </div>
        <div class="parexp">
            <label>Supplier</label>
            <div class="inpexp">
                <select name="variants[${variantCount}][supplier]">
                    <option value="" disabled selected style="display: none;"></option>
                    <option value="Supplier 1">Supplier 1</option>
                    <option value="Supplier 2">Supplier 2</option>
                    <option value="Supplier 3">Supplier 3</option>
                    <option value="Supplier 4">Supplier 4</option>
                </select>
            </div>
        </div>
        </div>
    `;

  variantCount++;
  conVar.appendChild(newVar);
  assignUniqueIds();
}

// add orders

document.addEventListener("DOMContentLoaded", function () {
  const rushRadio = document.getElementById("Rush");
  const regularRadio = document.getElementById("Regular");
  const parForRush = document.getElementById("parForRush");
  const rushLabel = document.getElementById("rushLabel");

  function rush() {
    if (rushRadio.checked) {
      parForRush.classList.add("show");
      rushLabel.style.display = "block";
    } else {
      parForRush.classList.remove("show");
      rushLabel.style.display = "none";
      parForRush.style.width = "0";
    }
  }


  rush();


  rushRadio.addEventListener("change", rush);
  regularRadio.addEventListener("change", rush);
});

function openAddOrders() {
  const addOrdersContainer = document.getElementById("addOrdersContainer");
  addOrdersContainer.style.display = "flex";
}
function closeAddOrders() {
  const addOrdersContainer = document.getElementById("addOrdersContainer");
  addOrdersContainer.style.display = "none";
}

function printOrders() {
  const printContainer = document.getElementById("printContainer");
  printContainer.style.display = "flex";


}

function printnow() {

  const printContainer = document.getElementById("printContainer");
  const printButton = document.querySelector(".printBtn button");


  printContainer.style.display = "flex";

  printButton.style.display = "none";

  setTimeout(() => {
      window.print();

      printContainer.style.display = "none";
      printButton.style.display = "flex";
  }, 100);
}

  
function toNextPage(event) {

  if (event) {
      event.preventDefault();
  }

  const nextPage = document.getElementById("nextPage");
  const formAddOrders = document.getElementById("formAddOrders");


  if (formAddOrders && nextPage) {
      
      formAddOrders.style.display = "none";
      
      nextPage.style.display = "block";
  } else {
      console.error("Element(s) not found: check the IDs and ensure they match.");
  }
}







const style = document.createElement('style');
style.innerHTML = `
    @media print {
        .hide-print {
            display: none !important; 
        }
    }
`;
document.head.appendChild(style);

class MainSidemenu extends HTMLElement {
  connectedCallback() {
    // Extract the role and access permissions from the dataset
    const role = this.dataset.role;
    const isSuperAdmin = role === "super_admin";
    const salesNav = this.dataset.salesNav === "true";
    const productNav = this.dataset.productNav === "true";
    const orderNav = this.dataset.orderNav === "true";

    // Render the menu based on access permissions
    this.innerHTML = `
        <div class="marj">
            <div class="part">
                <div class="nav">
                    <div class="label">
                        <p>Navigate</p>
                    </div>
                    <div class="toggledown"></div>
                </div>
                <div class="conmenu">
                    <div class="menu" onclick="redirect('dashboard.php')">
                        <div class="iconmenu">
                            <i class="fa fa-window-maximize"></i>
                        </div>
                        <p>Dashboard</p>
                    </div>
                </div>
            </div>
            ${this.getAdminAccess(isSuperAdmin)}
            ${productNav || isSuperAdmin ? `
            <div class="part">
                <div class="nav">
                    <div class="label">
                        <p>Products</p>
                    </div>
                    <div class="toggledown">
                        <i class="fa fa-angle-up" id="toggleDown2" onclick="toggle2()"></i>
                    </div>
                </div>
                <div class="conmenu" id="conMenu2" style="display: block;">
                    <div class="menu" onclick="redirect('category.php')">
                        <div class="iconmenu">
                            <i class="fa fa-th"></i>
                        </div>
                        <p>Category</p>
                    </div>
                    <div class="menu" onclick="redirect('inventory.php')">
                        <div class="iconmenu">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <p>Inventory</p>
                    </div>
                </div>
            </div>` : ""}
            ${orderNav || isSuperAdmin ? `
            <div class="part">
                <div class="nav">
                    <div class="label">
                        <p>Orders</p>
                    </div>
                    <div class="toggledown">
                        <i class="fa fa-angle-up" id="toggleDown3" onclick="toggle3()"></i>
                    </div>
                </div>
                <div class="conmenu" id="conMenu3" style="display: block;">
                    <div class="menu" onclick="redirect('pending.php')">
                        <div class="iconmenu">
                            <i class="fa fa-spinner"></i>
                        </div>
                        <p>Pending</p>
                    </div>
                    <div class="menu" onclick="redirect('todeliver.php')">
                        <div class="iconmenu">
                            <i class="fas fa-truck"></i>
                        </div>
                        <p>To Deliver</p>
                    </div>
                    <div class="menu" onclick="redirect('received.php')">
                        <div class="iconmenu">
                            <i class="fa fa-check-square"></i>
                        </div>
                        <p>Received</p>
                    </div>
                    <div class="menu" onclick="redirect('cancelled.php')">
                        <div class="iconmenu">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <p>Cancelled</p>
                    </div>
                    <div class="menu" onclick="redirect('returned.php')">
                        <div class="iconmenu">
                            <i class="fas fa-reply"></i>
                        </div>
                        <p>Returned</p>
                    </div>
                </div>
            </div>` : ""}
        </div>`;
  }

  getAdminAccess(isSuperAdmin) {
    const salesNav = this.dataset.salesNav === "true";

    if (isSuperAdmin || salesNav) {
      return `
            <div class="part">
                <div class="nav">
                    <div class="label">
                        <p>Admin Access</p>
                    </div>
                    <div class="toggledown">
                        <i class="fa fa-angle-up" id="toggleDown1" onclick="toggle1()"></i>
                    </div>
                </div>
                <div class="conmenu" id="conMenu1" style="display: block;">
                    <div class="menu" onclick="redirect('account.php')">
                        <div class="iconmenu">
                            <i class="fa fa-users"></i>
                        </div>
                        <p>Account</p>
                    </div>
                    <div class="menu" onclick="redirect('expenditures.php')">
                        <div class="iconmenu">
                            <i class="fa fa-book"></i>
                        </div>
                        <p>Expenditures</p>
                    </div>
                    ${salesNav ? `
                    <div class="menu" onclick="redirect('sales.php')">
                        <div class="iconmenu">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <p>Sale</p>
                    </div>` : ""}
                    <div class="menu" onclick="redirect('history.php')">
                        <div class="iconmenu">
                            <i class="fas fa-history"></i>
                        </div>
                        <p>History</p>
                    </div>
                </div>
            </div>`;
    }
    return "";
  }
}

customElements.define("main-sidemenu", MainSidemenu);

class MainSidenotif extends HTMLElement {
  async connectedCallback() {
    this.innerHTML = `
        <div class="marj2 marj21" id="marj21">
          <div class="notiftag">
            <p>Stock Notifications</p>
          </div>
          <div class="connotif" id="stock-notification-list"></div>
        </div>
      `;

    await this.updateStockNotifications();
  }

  async fetchStockData() {
    try {
      const response = await fetch("../../php/endpoint.php");
      if (!response.ok) throw new Error("Network response was not ok");
      return await response.json();
    } catch (error) {
      console.error("Error fetching stock data:", error);
      return [];
    }
  }

  async updateStockNotifications() {
    const stockData = await this.fetchStockData();
    this.displayStockNotifications(stockData);
  }

  displayStockNotifications(stockData) {
    const notificationContainer = this.querySelector(
      "#stock-notification-list"
    );
    const notificationCountElement = document.querySelector(
      "#notification-count-stock"
    );

    if (!notificationContainer || !notificationCountElement) {
      console.error("Notification container or count element not found.");
      return;
    }

    let unreadCount = 0;
    notificationContainer.innerHTML = "";

    stockData.forEach((variant) => {
      const { product_name, variant_stock, initial_stock } = variant;
      const tenPercentStock = 0.1 * initial_stock;

      if (variant_stock <= tenPercentStock) {
        const notifPart = document.createElement("div");
        notifPart.classList.add("notifpart");

        notifPart.innerHTML = `
            <div class="notiflogo"></div>
            <div class="notifcontent" style ="cursor:pointer;">
              <div class="notiftop">
                <p> Low Stock for ${product_name} </p>
              </div>
              <div class="notifbot">
                <p>${new Date().toLocaleDateString()}</p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p>${new Date().toLocaleTimeString()}</p>
              </div>
            </div>
              <div class="notiftool">
               
              </div>
            </div>
          `;

        notificationContainer.appendChild(notifPart);
        unreadCount++;
      }
    });

    if (unreadCount > 0) {
      notificationCountElement.textContent = unreadCount;
      notificationCountElement.style.display = "block";
    } else {
      notificationCountElement.style.display = "none";
    }
  }
}

customElements.define("main-sidenotif", MainSidenotif);

class MainHeader extends HTMLElement {
  async connectedCallback() {
    const imageUrl = this.dataset.imagePath || "../../static/images/member";

    this.innerHTML = `
        <style>
        #notification-count-stock {
          position: absolute;
          top: -5px;
          right: -5px;
          background-color: red;
          color: white;
          border-radius: 50%;
          width: 20px;
          height: 20px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 12px;
          font-weight: bold;
          text-align: center;
          display: none; 
        }

        #notification-count-email {
        
        }
        </style>

        <div class="header">
          <div class="conheader">
            <div class="headfirst">
              <img src="../../static/images/logolines.jpg" alt="">
              <h1>Lines Hub</h1>
            </div>
             <div class="headsecond">
                  <div class="not" id="notification-bell" onclick="toggleNotif()">
                    <i class="fa fa-bell" aria-hidden="true" style= "cursor:pointer;" >

                       <span id="notification-count-stock" class="badge"></span>
                    
                    </i>
                     
                    <div class="tool">
                      <p>Notification</p>
                      
                    </div>
                    </div>
            
              <div class="not" id="email-icon" onclick="toggleMessage()">
              
                <span id="notification-count-email" class="badge"></span>
                <button id="mark-as-read" onclick="markNotificationsAsRead()" style="display: none;">Mark as Read</button>
                <div class="tool">
                  <p>Emails</p>
                </div>
              </div>
            <div class="pp" onclick="logoutToggle()" id="pp">
                <img src="${imageUrl}" alt="Profile Picture" id="profilepicture">
                <div class="logout" id="logout" style="display: none;">
                  <a style = "display:flex; text-decoration:none; " href="">
                    <p>LOGOUT</p>
                    <i class="fa-solid fa-right-from-bracket" style= "margin-left:5px;"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>`;

    this.querySelector("#logout").addEventListener(
      "click",
      this.handleLogout.bind(this)
    );

    await this.updateNotificationBadge();
  }

  async updateNotificationBadge() {
    try {
      const response = await fetch("../../php/endpoint.php");
      if (!response.ok) throw new Error("Network response was not ok");

      const stockData = await response.json();
      let unreadCount = 0;

      stockData.forEach((variant) => {
        const { variant_stock, initial_stock } = variant;
        const stockPercentage = (variant_stock / initial_stock) * 100;

        if (stockPercentage <= 10) {
          unreadCount++;
        }
      });

      const notificationCountElement = this.querySelector(
        "#notification-count-stock"
      );
      if (notificationCountElement) {
        notificationCountElement.textContent = unreadCount;
        notificationCountElement.style.display =
          unreadCount > 0 ? "flex" : "none";
      }
    } catch (error) {
      console.error("Error fetching stock data:", error);
    }
  }

  async handleLogout() {
    try {
      const response = await fetch("../../php/logout.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      });

      if (response.ok) {
        window.location.href = "index.php";
      } else {
        console.error("Logout failed");
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }
}

customElements.define("main-header", MainHeader);

class AddOrdersInner extends HTMLElement {
  connectedCallback() {
    this.innerHTML = `
      <div class="addOrdersContainer" id="addOrdersContainer">
          <form id="orderForm" method="post" action="../../php/order.php">
              <div class="mlz" id="mlz">
                  <div class="formAddOrders" id="formAddOrders">
                      <div class="marginWrap">
                          <div class="addTitle">
                              <p>Add Orders</p>
                              <i class="fas fa-times" onclick="closeAddOrders()"></i>
                          </div>
                          <div class="forRBTN">
                              <div>
                                  <input type="radio" name="PersonalCompany" id="personalRBTN" checked>
                                  <label for="personalRBTN">Personal</label>
                              </div>
                              <div>
                                  <input type="radio" name="PersonalCompany" id="CompanyRBTN">
                                  <label for="CompanyRBTN">Company</label>
                              </div>
                          </div>
                          <div class="customerDetails detailsCon">
                              <div class="gl">
                                  <div class="topText">
                                      <p>Customer Details</p>
                                  </div>
                                  <div class="hj">
                                      <div class="parexp">
                                          <label for="firstName">First Name <span>*</span></label>
                                          <div class="inpexp">
                                              <input type="text" name="firstName" id="firstName" required>
                                          </div>
                                      </div>
                                      <div class="parexp">
                                          <label for="lastName">Last Name <span>*</span></label>
                                          <div class="inpexp">
                                              <input type="text" name="lastName" id="lastName" required>
                                          </div>
                                      </div>
                                      <div class="parexp">
                                          <label for="phoneNumber">Phone Number <span>*</span></label>
                                          <div class="inpexp">
                                              <input type="number" name="phoneNumber" id="phoneNumber" required>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="gl">
                                  <div class="topText">
                                      <p>Order Details</p>
                                  </div>
                                  <div class="hj">
                                      <div class="parexp">
                                          <label for="additionalInstructions">Additional Instructions</label>
                                          <div class="inpexp">
                                              <input type="text" name="additionalInstructions" id="additionalInstructions">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="delivery">
                                      <p>Pick up or Delivery</p>
                                      <div class="md">
                                          <div class="hs">
                                              <input type="radio" name="delivery_method" id="Delivery" value="Delivery" >
                                              <label for="Delivery">Delivery</label>
                                          </div>
                                          <div class="hs">
                                              <input type="radio" name="delivery_method" id="Pickup" value="Pickup" checked>
                                              <label for="Pickup">Pick-up</label>
                                              
                                          </div>
                                      </div>
                                  </div>
                                  <div class="hj">
                                  <div class="parexp">
                                      <label for="deliveryDate">Delivery Date</label>
                                      <div class="inpexp" required>
                                          <input type="date" name="deliveryDate" id="deliveryDate" required min="">
                                      </div>
                                  </div>
                              </div>
                              </div>
                              <div class="gl">
                                  <div class="topText">
                                      <p>Address Details</p>
                                  </div>
                                  <div class="hj">
                                      <div class="parexp">
                                          <label for="houseNo">House No. <span>*</span></label>
                                          <div class="inpexp">
                                              <input type="text" name="houseNo" id="houseNo" required>
                                          </div>
                                      </div>
                                      <div class="parexp">
                                          <label for="streetAddress">Street Address <span>*</span></label>
                                          <div class="inpexp">
                                              <input type="text" name="streetAddress" id="streetAddress" required>
                                          </div>
                                      </div>
                                      <div class="parexp">
                                          <label for="barangay">Barangay <span>*</span></label>
                                          <div class="inpexp">
                                              <input type="text" name="barangay" id="barangay" required>
                                          </div>
                                      </div>
                                      <div class="parexp">
                                          <label for="landmark">Landmark</label>
                                          <div class="inpexp">
                                              <input type="text" name="landmark" id="landmark">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="gl">
                              <button type="button" onclick="toNextPage(event)">Next</button>
                              </div>
                          </div>
                          <div class="gl" style="display:none">
                          <div class="topText">
                              <p>Payment</p>
                          </div>
                          <div class="hj">
                              <p   class="total" name= "total_price" >Total Amount: ₱ <span id="totalAmountTop">00.00</span></p>
                         
                        
                          </div>
                      </div>
                      </div>
                  </div>
                  <div class="nextPage" id="nextPage"  style="margin-top:50px;">
                      <div class="mz">
                          <div class="formListofOrders">
                              <div class="bv">
                                  <p>List Of Orders</p>
                                  <div class="lk">
                                      <p>Item Amount: ₱ <span id="totalAmountList" name= "total_price"   >00.00</span></p>
                                  </div>
                      
                      
                                  <input type="hidden" id="hiddenVariantID" name="VariantID">
                                  <input type="hidden" id="hiddenProductName" name="ProductName">
                                  <input type="hidden"  id="hiddenColor" name="Color">
                                  <input type="hidden"  id="hiddenSize" name="Size">
                                  <input type="hidden"  id="hiddenQuantity" name="Quantity">
                                  <input type="hidden"  id="hiddenUnitPrice" name="unitPrice">
                                  <input type="hidden" " name="total_amount" id="totalAmountInput">
                               
                      
                              </div>
                              <div class="listOrderTable" id="listOrderTable">
                                  <table>
                                      <tr class="tableheader">
                                          <td class="listProductName">Product Name</td>
                                          <td class="liss">Color</td>
                                          <td class="liss">Size</td>
                                          <td class="liss">Qty</td>
                                          <td class="liss">Price</td>
                                          <td class="listo">Remove</td>
                                      </tr>
                                      <!-- Dito ga labas ang orders -->
                                  </table>
                              </div>
                          </div>
                          <div class="fz">
                              <div class="lk">
                                  <p>Total Amount: ₱ <span id="totalAmountBottom"  name= "total_price"     >00.00</span></p>
                              </div>
                              <p>Regular or Rush</p>
                              <div class="radioBtnRR">
                                  <div>
                                      <div style="display:flex;">
                                          <input type="radio" name="RR" id="Regular" value="Regular"  checked>
                                          <label for="Regular">Regular</label>
                                      </div>
                                      <div style="display:flex;">
                                          <input type="radio" name="RR" id="Rush" value="Rush">
                                          <label for="Rush">Rush</label>
                                      </div>
                                  </div>
                                  <div class="parForRush" id="parForRush">
                                      <label for="RushInput" id="rushLabel">Rush Fee</label>
                                      <div class="inpexp">
                                          <input type="number" name="RushInput" id="RushInput">
                                      </div>
                                  </div>
                              </div>
                              <div class="sf">
                                  <div class="parexp1">
                                      <label for="Customization">Customization Fee</label>
                                      <div class="inpexp">
                                          <input type="number" name="Customization" id="Customization">
                                      </div>
                                  </div>
                                  <div class="parexp2">
                                      <label for="Discount">Discount</label>
                                      <div class="inpexp">
                                          <input type="number" name="Discount" id="Discount">
                                      </div>
                                  </div>
                                  <div class="parexp3">
                                  <label for="Downpayment">Downpayment</label>
                                  <div class="inpexp">
                                      <input type="number" name="Downpayment" id="Downpayment">
                                  </div>
                              </div>

                              <button type="submit" id="submitOrders">SUBMIT ORDERS</button>
                              <div class="parex4" id="deliveryFeeSection">
                              <label for="DeliveryFee" id="deliveryFeeLabel">Delivery Fee</label>
                            <div class="inpexp">
                          <input type="number" name="DeliveryFee" id="DeliveryFee">
                              </div>
                                </div>
                      
                              </div>
                          </div>
                      </div>
                      <div class="vw">
                          <div class="parexp searchPro">
                              <label for="searchPro">Search Products</label>
                              <div class="inpexp">
                                  <input type="text" name="searchPro" id="searchPro">
                              </div>
                          </div>
                          <div class="productAdd" id="productAdd">
                          
                          </div>
                      </div>
                  </div>
              </div>
              </div>
          </form>

      </div>
    `;

    this.fetchProducts();
    this.addEventListeners();
  

    
  }
  setDeliveryDateMin() {
    const deliveryDateInput = this.querySelector('#deliveryDate');
    if (deliveryDateInput) {
      const today = new Date().toISOString().split('T')[0];
      deliveryDateInput.setAttribute('min', today);
    }
  }
  
  
  
  async fetchProducts() {
    try {
        const response = await fetch("../../php/fetchvariants.php");
        const data = await response.json();

        if (data.error) {
            console.error("Error fetching products:", data.error);
            return;
        }

        this.displayProducts(data);
    } catch (error) {
        console.error("Error:", error);
    }
}

displayProducts(products) {
    const productContainer = this.querySelector("#productAdd");
    productContainer.innerHTML = "";

    const productGroups = {};

    products.forEach((product) => {
        const {
            product_name,
            category_name,
            sub_category_name,
            product_description,
            variants,
        } = product;

        if (!productGroups[product_name]) {
            productGroups[product_name] = {
                product_name,
                category_name,
                sub_category_name,
                product_description,
                variants: [],
            };
        }

        productGroups[product_name].variants.push(...variants);
    });

    Object.values(productGroups).forEach((productGroup) => {
        const productElement = document.createElement("div");
        productElement.classList.add("conPro");

        const hardcodedPhotoPath = "../../static/images/logolines.jpg";

        const variantElements = productGroup.variants
            .map(
                (variant) => `
                    <div class="variantItem">
                        <p>
                            ${variant.variant_color || "N/A"}
                            <span>(${variant.variant_size || "N/A"} Size)</span>
                            <span>(${variant.variant_stock || "0"} pcs)</span>
                        </p>
                        <div class="addItem">
                            <button type="button" data-variant-id="${variant.variant_id}"
                                data-product-name="${productGroup.product_name}"
                                data-variant-color="${variant.variant_color}"
                                data-variant-size="${variant.variant_size}"
                                data-variant-stock="${variant.variant_stock}"
                                data-variant-price="${variant.variant_price}">
                                Add
                            </button>
                        </div>
                    </div>
                `
            )
            .join("");

        productElement.innerHTML = `
            <div class="productDetails">
                <div class="proImage">
                    <img src="${hardcodedPhotoPath}" alt="${productGroup.product_name}">
                </div>
                <div class="proName">
                    <h4>${productGroup.product_name}</h4>
                    <p>${productGroup.product_description || ""}</p>
                    <p>Category: ${productGroup.category_name || "N/A"}</p>
                    <p>Sub-Category: ${productGroup.sub_category_name || "N/A"}</p>
                </div>
            </div>
            <div class="colorAdd">
                ${variantElements}
            </div>
        `;
        productContainer.appendChild(productElement);
    });
}

addEventListeners() {
  this.querySelector("#productAdd").addEventListener("click", (event) => {
    if (event.target.tagName === "BUTTON") {
      const button = event.target;
      const variantId = button.getAttribute("data-variant-id");
      const productName = button.getAttribute("data-product-name");
      const variantColor = button.getAttribute("data-variant-color");
      const variantSize = button.getAttribute("data-variant-size");
      const variantStock = parseInt(button.getAttribute("data-variant-stock"), 10);
      const variantPrice = parseFloat(button.getAttribute("data-variant-price"));

      this.addItemToOrder(
        variantId,
        productName,
        variantColor,
        variantSize,
        variantStock,
        variantPrice
      );
    }
  });

  this.querySelector("#submitOrders").addEventListener("click", () => {
    this.submitOrders();
  });

  this.querySelector("#searchPro").addEventListener("input", (event) => {
    const searchTerm = event.target.value.toLowerCase();
    this.filterProducts(searchTerm);
  });

  this.querySelectorAll("input[name='RR']").forEach((radio) => {
    radio.addEventListener("change", (event) => {
      const isRush = event.target.id === "Rush";
      this.toggleRushFee(isRush);
    });
  });

  this.querySelectorAll("input[name='delivery_method']").forEach((radio) => {
    radio.addEventListener("change", (event) => {
        const isDelivery = event.target.value === "Delivery";
        this.toggleDeliveryFee(isDelivery);
    });
});



  this.querySelector("#RushInput").addEventListener("input", () => this.updateTotalAmount());
  this.querySelector("#Customization").addEventListener("input", () => this.updateTotalAmount());
  this.querySelector("#Discount").addEventListener("input", () => this.updateTotalAmount());
  
  this.querySelector("#Downpayment").addEventListener("input", () => this.updateTotalAmount());
  this.querySelector("#DeliveryFee").addEventListener("input", () => this.updateTotalAmount());
  this.querySelector("#listOrderTable").addEventListener("input", (event) => {
    if (event.target.classList.contains("quantity")) {
      this.updateTotalAmount();
    }
  });
}

toggleRushFee(isRush) {
  const rushFeeElement = this.querySelector("#parForRush");

  
  if (rushFeeElement) {
    if (isRush) {
      rushFeeElement.classList.add("show");
      rushLabel.style.display = 'block';
    } else {
      rushFeeElement.classList.remove("show");
      this.querySelector("#RushInput").value = ""; 
      rushLabel.style.display = 'none';
      parForRush.style.width = '0';
    }
    this.updateTotalAmount();
  } else {
    console.error("Rush fee element not found");
  }
}

toggleDeliveryFee(isDelivery) {
  const deliveryFeeSection = this.querySelector("#deliveryFeeSection");
  const deliveryFeeLabel = this.querySelector("#deliveryFeeLabel");

  if (deliveryFeeSection) {
      if (isDelivery) {
          deliveryFeeSection.classList.add("show");
          deliveryFeeLabel.style.display = 'block';
      } else {
          deliveryFeeSection.classList.remove("show");
          this.querySelector("#DeliveryFee").value = ""; 
          deliveryFeeLabel.style.display = 'none';
      }
      this.updateTotalAmount();
  } else {
      console.error("Delivery fee section not found");
  }
}

addItemToOrder(
  variantId,
  productName,
  variantColor,
  variantSize,
  variantStock,
  variantPrice
) {
  const listOrderTable = this.querySelector("#listOrderTable table");
  const hiddenOrderInput = this.querySelector("#hiddenOrderData"); 

  const existingRow = listOrderTable.querySelector(
    `tr[data-variant-id="${variantId}"]`
  );

  if (existingRow) {
    const quantityInput = existingRow.querySelector(".quantity");
    const currentQuantity = parseInt(quantityInput.value, 10);

    if (currentQuantity < variantStock) {
      quantityInput.value = currentQuantity + 1;
 
      const newTotalPrice = (variantPrice * parseInt(quantityInput.value, 10)).toFixed(2);
      existingRow.querySelector(".totalPrice").textContent = `₱ ${newTotalPrice}`;
    } else {
     
    }
  } else {
    if (variantStock > 0) {
      const newRow = document.createElement("tr");
      newRow.dataset.variantId = variantId;
      newRow.dataset.productName = productName; 
      newRow.dataset.variantColor = variantColor || "N/A"; 
      newRow.dataset.variantSize = variantSize || "N/A";
      newRow.innerHTML = `
        <td>${productName}</td>
        <td>${variantColor || "N/A"}</td>
        <td>${variantSize || "N/A"}</td>
        <td>
          <input type="number" name="quantity" class="quantity" value="1" min="1" max="${variantStock}" data-price="${variantPrice}">
        </td>
        <td class="totalPrice">₱ ${(variantPrice * 1).toFixed(2)}</td>
        <td>
          <button class="removeItem" data-variant-id="${variantId}">Remove</button>
        </td>
      `;

      listOrderTable.appendChild(newRow);

      const removeButton = newRow.querySelector(".removeItem");
      removeButton.addEventListener("click", () => {
        newRow.remove();
        this.updateTotalAmount();
        this.updateHiddenOrderData();
      });

      const quantityInput = newRow.querySelector(".quantity");
      quantityInput.addEventListener("input", () => {
       
        const newTotalPrice = (variantPrice * parseInt(quantityInput.value, 10)).toFixed(2);
        newRow.querySelector(".totalPrice").textContent = `₱ ${newTotalPrice}`;
        this.updateTotalAmount();
        this.updateHiddenOrderData(); 
      });
    } else {
    
    }
  }


  this.updateTotalAmount();
  this.updateHiddenOrderData(); 
}



updateHiddenOrderData() {
  const listOrderTable = this.querySelector("#listOrderTable table");
  const rows = listOrderTable.querySelectorAll("tr:not(.tableheader)");
  const productNames = [];
  const colors = [];
  const sizes = [];
  const quantities = [];
  const unitPrices = [];
  const variantIds = []; 
  let totalAmount = 0;

  rows.forEach(row => {
    const productName = row.dataset.productName;
    const variantColor = row.dataset.variantColor; 
    const variantSize = row.dataset.variantSize;  
    const quantity = parseInt(row.querySelector(".quantity").value, 10);
    const price = parseFloat(row.querySelector(".quantity").dataset.price);
    const variantId = row.dataset.variantId; 

    if (productName) {
      productNames.push(productName);
      colors.push(variantColor);   
      sizes.push(variantSize);   
      quantities.push(quantity);
      unitPrices.push(price);
      variantIds.push(variantId); 
      totalAmount += quantity * price;
    }
  });

  
  this.querySelector("#hiddenProductName").value = JSON.stringify(productNames);
  this.querySelector("#hiddenColor").value = JSON.stringify(colors);
  this.querySelector("#hiddenSize").value = JSON.stringify(sizes);
  this.querySelector("#hiddenQuantity").value = JSON.stringify(quantities);
  this.querySelector("#hiddenUnitPrice").value = JSON.stringify(unitPrices);
  this.querySelector("#hiddenVariantID").value = JSON.stringify(variantIds); 
  this.querySelector("#totalAmountInput").value = totalAmount.toFixed(2);
}

filterProducts(searchTerm) {
    const productElements = this.querySelectorAll("#productAdd > div");
    productElements.forEach((element) => {
        const productName = element.querySelector(".proName h4").textContent.toLowerCase();
        if (productName.includes(searchTerm)) {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    });
}




updateTotalAmount() {
  const listOrderTable = this.querySelector("#listOrderTable table");
  const rows = listOrderTable.querySelectorAll("tr:not(.tableheader)");
  let totalAmount = 0;
  let totalAmountList = 0;

  rows.forEach(row => {
      const quantityInput = row.querySelector(".quantity");
      if (quantityInput) {
          const price = parseFloat(quantityInput.dataset.price) || 0;
          const quantity = parseInt(quantityInput.value, 10) || 0;
          const rowTotal = price * quantity;
          totalAmount += rowTotal;
          totalAmountList += rowTotal;
      }
  });

  const customizationFeeInput = this.querySelector("#Customization");
  const customizationFee = parseFloat(customizationFeeInput.value.trim()) || 0;
  totalAmount += customizationFee;

  const discountInput = this.querySelector("#Discount");
  const discount = parseFloat(discountInput.value.trim()) || 0;
  totalAmount -= discount;

  const downpaymentInput = this.querySelector("#Downpayment");
  const downpayment = parseFloat(downpaymentInput.value.trim()) || 0;
  totalAmount -= downpayment;

  const rushFeeInput = this.querySelector("#RushInput");
  const rushFee = parseFloat(rushFeeInput.value.trim()) || 0;
  totalAmount += rushFee;

  const deliveryFeeInput = this.querySelector("#DeliveryFee");
  const deliveryFee = parseFloat(deliveryFeeInput.value.trim()) || 0;
  totalAmount += deliveryFee;

  this.querySelector("#totalAmountTop").textContent = ` ${totalAmount.toFixed(2)}`;
  this.querySelector("#totalAmountBottom").textContent = ` ${totalAmount.toFixed(2)}`;
  this.querySelector("#totalAmountList").textContent = ` ${totalAmountList.toFixed(2)}`;

  this.querySelector("#totalAmountInput").value = totalAmount.toFixed(2);
}


}
customElements.define("add-orders-inner", AddOrdersInner);

document.addEventListener("DOMContentLoaded", function() {
document.querySelector("add-orders-inner").connectedCallback();
});