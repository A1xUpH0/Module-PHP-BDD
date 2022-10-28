<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Module PHP-BDD</title>
</head>
<body>
<?php
include("database.php");
displayName($db);
?> <br> <?php
todayOrder($db);
?> <br> <?php
finalPrice($db);
?> <br> <?php
orderByCustomers($db);
?> <br> <?php
priceByCustomers($db);
?> <br> <?php
orderByPrice($db)
?> <br> <?php
//CreateFullOrder($db, 9, array(1,2,3) , array(1,2,3), 10);
?>
</body>
</html>