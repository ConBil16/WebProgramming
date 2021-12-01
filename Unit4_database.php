<?php
function getConnection(){
    require 'Unit4_database_credentials.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
function getCustomers($conn){
    $sql = "SELECT * FROM customer";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function getProducts($conn){
    $sql = "SELECT * FROM product";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function newCustomer($conn, $firstName, $lastName, $email){
    $newCus = "INSERT INTO customer (first_name, last_name, email) VALUES ('$firstName', '$lastName', '$email');";
    $conn->query($newCus);
    // $conn->query($updateProducts);
}

function updateOrder($conn, $purchase, $productID, $customerID, $amount, $tax, $totalW, $currentTime){
    $updateProducts = "UPDATE product SET in_stock = in_stock - 1 WHERE in_stock > 0 AND product_name = '$purchase';";
    $conn->query($updateProducts);

    $updateOrder = "INSERT INTO orders (product_id, customer_id, quantity, price, tax, donation, timestamp) VALUES ('$productID', '$customerID', '$amount', '$tax', '$totalW', '$currentTime');";
    $conn->query($updateOrder);

    //The above function is returning false timestamp seems to be causing issue is timestamp
    //How to get customer_id
}

?>



<?php
    function displayGuests($conn) { // $conn is the MySQLi object returned from getConnection
        $sql = "SELECT product_name, price FROM MyGuests"; // create the query
        $result = $conn->query($sql); // execute the query

        if ($result->num_rows > 0) { // ensure the query returned data
        // output data of each row
        while($row = $result->fetch_assoc()) { // fetch the next row into an assoc array

        // notice the use of field names in the assoc array
            echo $row["product_name"]. "-" .$row["price"];
        }
        } else {
        echo "0 results";
        }

    }

    function findCustomer($conn, $email){ //This is needed
        $stmt = $conn->prepare("SELECT * FROM customer WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return true;
        } else {
            return false;
        }
    }

    function partialName($conn, $name, $field){
        $query = "SELECT * FROM customer WHERE";
        if ($field == "first") {
            $query = $query . " first_name LIKE ?";
        } else {
            $query = $query . " last_name LIKE ?";
        }

        $stmt = $conn->prepare($query);
        $name = $name."%";
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "<table id = 'cusTable'> <tr> <th>Firstname</th> <th>Lastname</th> <th>Email</th> </tr>";
            foreach ($result as $row){
                echo "<tr>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else {
            echo "No matching customers chief";
        }
    }

    function findProductById($conn, $productId) { //This is also needed
        $query = "SELECT * FROM product WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
        else {
            return 0;
        }
    }

    function findQuantityById($conn, $productId){
        $query = "SELECT in_stock FROM product WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
        else {
            return 0;
        }
    }

    function returnProductName($conn, $productID){
        $query = "SELECT product_name FROM product WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
        else {
            return 0;
        }
    }

    function returnCustomerName($conn, $customerID){
        $query = "SELECT first_name, last_name FROM customer WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $customerID);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
        else {
            return 0;
        }
    }

    
    function returnCustomer($conn, $email){ //This is needed for customerID
        $stmt = $conn->prepare("SELECT * FROM customer WHERE email=?");
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result):
            foreach ($result as $row):
                $cusID = $row['id'];
            endforeach;
            return $cusID;
        endif;
    }

    function createOrder($conn, $custId, $productId, $qty, $price, $tax, $donation, $timestamp, $productQuantity) {
        // If customer, puzzle and time match, this would be a duplicate. Don't insert.
        $dupQuery = "SELECT * FROM orders WHERE customer_id=? AND product_id = ? AND timestamp =
        ?";
        $dupStmt = $conn->prepare( $dupQuery );
        $dupStmt->bind_param("iii", $custId, $productId, $timestamp);
        $dupStmt->execute();
        $result = $dupStmt->get_result();
        if ($result->num_rows > 0) {
            return;
        }
        // Not a duplicate

        //Updating product
        if($productQuantity - $qty <= 0){
            $qty = $productQuantity; //Should ensure that the stock never becomes negative
        }
        $updateProducts = "UPDATE product SET in_stock = in_stock - '$qty' WHERE id = '$productId';";
        $conn->query($updateProducts);


        //Inserting new order
        $query = "INSERT into orders (customer_id, product_id, quantity, price, tax, donation, timestamp)
        VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare( $query );
        $stmt->bind_param("iiidddi", $custId, $productId, $qty, $price, $tax, $donation, $timestamp);
        $stmt->execute();
        $stmt->close();
    }






?>





