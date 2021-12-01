<!DOCTYPE html>
<?php
include 'Unit4_database.php';
$conn = getConnection();
$data = getCustomers($conn);
$productsData = getProducts($conn);
?> 


<html>
<head>
        <title>adminProduct</title>
        <link rel="stylesheet" href="Unit4_adminProduct.css">
        <link rel="stylesheet" href="Unit4_common.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type = "text/javascript" src="Unit4_productScript.js"></script>
</head>
<body>
<?php include 'Unit4_header.php';?>
    <main>
        <div class="left">
            <!-- #This is where the product table goes. -->
        <h1> Products </h1>
            <div class="table">
            <table>
                <tr>
                    <th> Product </th>
                    <th> Image name </th>
                    <th> Price </th>
                    <th> Quantity </th>
                    <th> Inactive? </th>
                </tr>
                <?php
                    $sql = "SELECT product_name, image_name, price, in_stock, inactive FROM product";
                    $cusResult = $conn->query($sql);
                    if($cusResult -> num_rows > 0){
                        while($row = $cusResult-> fetch_assoc()){
                            if ($row['inactive'] == '1'){
                                $inactive = "Yes";
                            }
                            else{
                                $inactive = "";
                            }
                            echo "<tr><td>" . $row["product_name"] . "</td><td>" . $row['image_name'] . "</td><td>" . $row['price'] . "</td><td>" . $row['in_stock'] . "</td><td>". $inactive . "</td></tr>";
                        }
                        echo "</table>";
                    }
                    else{
                        echo "No Products";
                    }
                ?>
            </div>
        </div>

    
        <div class= "right">
        <form id = "myForm">
        <fieldset class="contactDetails">
                <legend><span>Product Information</span></legend>
                
                <label for="productName">Product Information: * </label>
                <input type="text" name="name" id="name" required>
                <br />
                <label for="imageName">Image Name: * </label>
                <input type="text" name="imageName" id="imageName" pattern="[A-Za-z ']{1,}"  required>
                <br />
                <label for="quantity">Quantity</label>
                <input type="number" id="Quantity" name="Quantity" required>
                <br />
                <label for="price">Price</label>
                <input type="number" id="Price" name="Price" required>
                <br />
                <label for="inactive">Inactive</label>
                <input type="checkbox" id="checkBox" name="checkBox" required>
                <br />
            </fieldset>


            <div class="buttons">
                <input type="submit" id="daSubmit" value="Add Product" onclick="buttonPressed(this)">
                <button type="button" id="Delete" onclick="buttonPressed(this)">Delete</button>
                <button type="button" id="Update" onclick="buttonPressed(this)">Update</button>
            </div>
        </form>
        </div>

    </main>
    

    <?php include 'Unit4_footer.php';?>

</body>
</html>
