<!DOCTYPE html>
<?php
include 'Unit4_database.php';
$conn = getConnection();
$data = getCustomers($conn);
$productsData = getProducts($conn);
date_default_timezone_set("America/Denver");
?> 

<html>
    <head>
        <title>Connor's exotic goods</title>
        <link rel="stylesheet" href="Unit4_common.css">
        <link rel="stylesheet" href="Unit4_order_entry.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type = "text/javascript" src="Unit4_script.js"></script>
    </head>

<body>
    <?php include 'Unit4_header.php';?>
    <main>
        <div class="left">
            <form id="myForm">

                <fieldset class="contactDetails">
                    <legend><span>Personal Information</span></legend>
                    
                    <label for="name">First Name: </label>
                    <input type="text" name="name" id="name" pattern="[A-Za-z ']{1,}" title="Only letters, ' and spaces allowed" onkeyup="showHint(this.value, 'first')" required>
                    <br />
                    <label for="secondname">Last Name: </label>
                    <input type="text" name="secondname" id="secondname" pattern="[A-Za-z ']{1,}" onkeyup="showHint(this.value, 'last')" required>
                    <br />
                    <label for="email">Enter your email:</label>
                    <input type="email" id="email" name="email" required>
                </fieldset>

                <div class = "Selection">
                    <legend><span>Product Information</span><legend>
                    <lable for="Avaliable">Avaiable: </lable>
                    <input type="text" class = "dumb" id="quantity" name="Avaliable" value="" readonly><br>
                    <select name = "selection" id="drinks" required onchange="myFunction(this.value);">
                        <option value="" disabled selected hidden>Please Choose a product</option>
                        <?php if ($productsData): ?>
                            <?php foreach($productsData as $row): ?>
                                    <option value=<?=$row['id']?> data-instock="<?=$row['in_stock']?>" data-image="<?=$row['product_name']?>"><?=$row['product_name']?> $<?=$row['price']?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                    <label for="Quantity">Quantity:</label>
                    <input type="number" id="Quantity" name="Quantity" min="0" max="100" value="1" required><br>
                </div>
                <input type="hidden" name="timestamp" value="<?php echo time(); ?>">
                <div id = "buttons">
                    <input id = "submit" type="submit" value="Submit">
                    <input id="clear" type="reset" value="Clear">
                </div>
            </form>
        </div>

        
        <div class= "right">
                <h3><i>Choose an exisiting customer</i></h3>
                <div id="cusTable" onclick="highlight_row()"></div>
        </div>

    </main>
    

    <?php include 'Unit4_footer.php';?>
    <script>
    
    //Quantity function
    function myFunction(str) {
            if (str == "") {
                document.getElementById("quantity").value = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("quantity").value = this.responseText;
                }
                };
                xmlhttp.open("GET","Unit4_get_quantity.php?q="+str,true);
                xmlhttp.send();
                }
        }

    //Show the table function
    function showHint(hint, type){
        if (hint.length == 0) {
            document.getElementById("cusTable").innerHTML = "";
            return;
        } else {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onload = function() {
                document.getElementById("cusTable").innerHTML = this.responseText;
        }
    xmlhttp.open("GET", "Unit4_get_customer_table.php?q=" + hint + "&h=" + type, true);
    xmlhttp.send();
    }
}

    //Highlight the cell function
    highlight_row();
    function highlight_row() {
    var table = document.getElementById('cusTable');
    var cells = table.getElementsByTagName('td');
    for (var i = 0; i < cells.length; i++) {
        // Take each cell
        var cell = cells[i];
        // do something on onclick event for cell
        cell.onclick = function () {
            // Get the row id where the cell exists
            var rowId = this.parentNode.rowIndex;

            var rowsNotSelected = table.getElementsByTagName('tr');
            for (var row = 0; row < rowsNotSelected.length; row++) {
                rowsNotSelected[row].style.backgroundColor = "";
                rowsNotSelected[row].classList.remove('selected');
            }
            var rowSelected = table.getElementsByTagName('tr')[rowId];
            rowSelected.style.backgroundColor = "yellow";
            rowSelected.className += " selected";

            document.getElementById("name").value = rowSelected.cells[0].innerHTML;
            document.getElementById("secondname").value = rowSelected.cells[1].innerHTML;
            document.getElementById("email").value = rowSelected.cells[2].innerHTML;
        }
    }
}

    </script>

</body>
</html>