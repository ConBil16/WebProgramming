<?php
    include 'Unit4_database_credentials.php';
    include 'Unit4_database.php';
    $conn = getConnection();
    //Fetching Values from URL

    $name = $_POST['name'];
    $imageName = $_POST['imageName'];
    $quantity = $_POST['Quantity'];
    $price = $_POST['Price'];
    $inactive = $_POST['checkBox'];
    $type = $_POST['type'];
    
    if($inactive == 'false'){
        $randomName = 0;
    }

    else{
        $randomName = 1;
    }

    if($type == 'add'){
        //Add this product to the database
        addProduct($conn, $name, $imageName, $quantity, $price, $inactive);
    }
    else if($type == 'update'){

    }
    else{

    }
    
?>