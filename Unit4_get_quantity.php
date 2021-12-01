
<?php
    $q = $_GET['q'];
    include 'Unit4_database_credentials.php';
    include 'Unit4_database.php';
    $conn = getConnection();
    $return = findQuantityById($conn, $q);
    $returnValue = $return['in_stock'];
    echo "$returnValue";
?>

