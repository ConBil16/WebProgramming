<?php
include 'Unit2_database.php';
$conn = getConnection();
$data = getCustomers($conn);
?> 
<html>
<head>
<title>Test it!</title>
</head>
<body>
<h1>List of Customers</h1>
<?php if ($data): ?>
    <?php foreach($data as $row): ?>
        <p>
            <?= $row['first_name'] ?>
            <?= $row['last_name'] ?>
            <?php echo $row['email'] ?>
        </p>
    <?php endforeach ?>
<?php endif ?>
</body>
</html>


