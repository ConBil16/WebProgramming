<?php
    $partial = $_REQUEST['q'];
    $field = $_REQUEST['h'];
    include 'Unit4_database_credentials.php';
    include 'Unit4_database.php';
    $conn = getConnection();
    partialName($conn, $partial, $field);
?>