<!DOCTYPE html>
<html>
<head>
    <title> Admin </title>
    <link rel="stylesheet" href="Unit4_admin.css">
    <link rel="stylesheet" href="Unit4_common.css">
</head>
<body>
    <?php include 'Unit4_header.php';?>
    <h1> Customers </h1>
    <table>
        <tr>
            <th> Last Name </th>
            <th> First name </th>
            <th> Email </th>
        </tr>
        <?php
           include 'Unit4_database.php'; 
           $conn = getConnection();
           $sql = "SELECT last_name, first_name, email FROM customer";
           $cusResult = $conn->query($sql);
           if($cusResult-> num_rows > 0){
               while($row = $cusResult-> fetch_assoc()){
                   echo "<tr><td>" . $row["last_name"] . "</td><td>" . $row['first_name'] . "</td><td>" . $row['email'] . "</td></tr>";
               }
               echo "</table>";
           }
           else{
               echo "No Customers";
           }
        ?>
    <h1> Orders </h1>
    <table>
        <?php
           $sql = "SELECT customer_id, product_id, timestamp, price, quantity, donation, tax FROM orders";
           $cusResult = $conn->query($sql);
           if($cusResult-> num_rows > 0){
            echo "<tr>
                <th> Customer </th>
                <th> Product </th>
                <th> Date </th>
                <th> Price </th>
                <th> Quantity </th>
                <th> Donation </th>
                <th> Tax </th>
            </tr>";
               while($row = $cusResult-> fetch_assoc()){
                
                //Finding the product name
                $productID = $row['product_id'];
                $productNameArray = returnProductName($conn, $productID);
                $productName = $productNameArray['product_name'];

                //Finding the customer name
                $customerID = $row['customer_id'];
                $customerNameArray = returnCustomerName($conn, $customerID);
                $customerFirstName = $customerNameArray['first_name'];
                $customerLastName = $customerNameArray['last_name'];


                echo "<tr><td>" . $customerFirstName . " " . $customerLastName . "</td><td>" . $productName . "</td><td>" . date("m/d/y h:iA", $row['timestamp']) .  "</td><td>" .  $row['price'] . "</td><td>" .  $row['quantity']  . "</td><td>" . $row['donation'] . "</td><td>" . $row['tax'] . "</td></tr>";
               }
               echo "</table>";
           }
           else{
               echo "<h3>No Orders</h3>";
           }
        ?>

<table>
    <h1> Products </h1>
    <tr>
        <th> Product </th>
        <th> Price </th>
        <th> # in stock </th>
    </tr>

    <?php
        $sql = "SELECT product_name, price, in_stock FROM product";
        $cusResult = $conn->query($sql);
        if($cusResult-> num_rows > 0){
            while($row = $cusResult-> fetch_assoc()){
                echo "<tr><td>" . $row["product_name"] . "</td><td>" . $row['price'] . "</td><td>" . $row['in_stock'] . "</td></tr>";
            }
            echo "</table>";
        }
        else{
            echo "No Products";
        }
    ?>

    <?php include 'Unit4_footer.php';?> 

</html>

