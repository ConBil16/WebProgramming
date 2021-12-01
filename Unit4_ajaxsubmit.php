<?php
    include 'Unit4_database_credentials.php';
    include 'Unit4_database.php';
    $conn = getConnection();
    //Fetching Values from URL

    $first=$_POST['name'];
    $second=$_POST['secondname'];
    $email=$_POST['email'];
    $amount=$_POST['Quantity'];
    $productID=$_POST['selection'];
    $quantity=$_POST['Avaliable'];
    $currentTime=$_POST['timestamp'];

    //Insert query

    $productInfo = findProductbyId($conn, $productID);
    $purchase = $productInfo['product_name']; //OHHH the productInfo in an array with all the information and you can access it!
    $price = $productInfo['price']; //Wow that makes so much sense! 
    $productQuanity = $productInfo['in_stock']; //In order to check for quantity
    $taxRate = .75;
    $donationAmount = 0;

    
    $returning = findCustomer($conn, $email);

    $total = $price; //Should be redundent
    $subtotal = $total * $amount;
    $tax = $subtotal * $taxRate; //This calculates just the tax for that particular product, very simple!
    $totalW = $subtotal + $tax;

    $customerID = returnCustomer($conn, $email); 
    $totalW = round($totalW, 2);
    
    createOrder($conn, $customerID, $productID, $amount, $price, $tax, $donationAmount, $currentTime, $productQuanity);
    echo "Order submitted for $first $second $amount $purchase <i>Total: </i>  $totalW";
?>