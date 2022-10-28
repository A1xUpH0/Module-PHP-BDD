<?php
// Souvent on identifie cet objet par la variable $conn ou $db
try
{

    $db= new PDO(
        'mysql:host=localhost;dbname=Database_It.2;charset=utf8',
        'David',
        'Database2024!'
    );

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


// On affiche chaque recette une à une
function displayName($db){
    $DatabaseStatement = $db->prepare('SELECT * FROM CUSTOMERS');
    $DatabaseStatement->execute();
    $database = $DatabaseStatement->fetchAll();
    foreach ($database as $data) {
        ?>
        <p><?php echo $data['First_name'] . " " . $data['Last_name'];?> </p> <?php
    }
}

function todayOrder($db){
    $DatabaseStatement = $db->prepare('SELECT * FROM `ORDER`');
    $DatabaseStatement->execute();
    $database = $DatabaseStatement->fetchAll();
    foreach ($database as $data) {
        if ($data['Date'] == date("Y-m-d")){?>
        <p><?php echo "Date & Heure : " . $data['Date'] . ":" . $data['Hours'] . " | Numéro de client : " . $data['ID_CUSTOMERS']; ?> </p> <?php
        }
    }
}

function finalPrice($db){
    $DatabaseStatement = $db->prepare('SELECT SUM(Price*QUANTITY) AS FINAL_PRICE FROM ORDER_has_PRODUCT INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID INNER JOIN `ORDER` ON ORDER_ID = `ORDER`.ID WHERE Date = CURRENT_DATE');
    $DatabaseStatement->execute();
    $database = $DatabaseStatement->fetchAll();
    foreach ($database as $data) { ?>
        <p><?php echo "Montant total à payer : " . $data['FINAL_PRICE'] . " €"; ?> </p> <?php
        }
}

function orderByCustomers($db){
    $DatabaseStatement = $db->prepare('SELECT First_name, Last_name, COUNT(ID_CUSTOMERS) AS NB_ORDERS FROM `ORDER` INNER JOIN CUSTOMERS ON ID_CUSTOMERS = CUSTOMERS.ID GROUP BY First_name, Last_name, ID_CUSTOMERS');
    $DatabaseStatement->execute();
    $database = $DatabaseStatement->fetchAll();
    foreach ($database as $data) { ?>
        <p><?php echo $data['First_name'] . " " . $data['Last_name'] . " possède " . $data['NB_ORDERS'] . " commandes"; ?> </p> <?php
    }
}

function priceByCustomers($db){
    $DatabaseStatement = $db->prepare('SELECT First_name, Last_name, SUM(QUANTITY * Price) AS FINAL_PRICE FROM `ORDER` INNER JOIN CUSTOMERS ON ID_CUSTOMERS = CUSTOMERS.ID INNER JOIN ORDER_has_PRODUCT ON ORDER_ID = `ORDER`.ID INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID GROUP BY First_name, Last_name');
    $DatabaseStatement->execute();
    $database = $DatabaseStatement->fetchAll();
    foreach ($database as $data) { ?>
        <p><?php echo $data['First_name'] . " " . $data['Last_name'] . " doit payer " . $data['FINAL_PRICE'] . " €"; ?> </p> <?php
    }
}

function orderByPrice($db){
    $DatabaseStatement = $db->prepare('SELECT ORDER_ID, SUM(Price*QUANTITY) AS FINAL_PRICE FROM ORDER_has_PRODUCT INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID GROUP BY ORDER_ID HAVING FINAL_PRICE BETWEEN 100 and 550;');
    $DatabaseStatement->execute();
    $database = $DatabaseStatement->fetchAll();
    foreach ($database as $data) { ?>
        <p><?php echo "La commande n° " . $data['ORDER_ID'] . " coûte " . $data['FINAL_PRICE'] . " €"; ?> </p> <?php
    }
}



function addOrder($db, $OrderId, $CustomerId){
    $DatabaseStatement = $db->prepare("INSERT INTO `ORDER` (ID, `Date`, Hours, ID_CUSTOMERS) VALUES ($OrderId, CURRENT_DATE(), CURRENT_TIME(), $CustomerId)");
    $DatabaseStatement->execute();?>
        <p><?php echo "Votre commande à été créée"; ?> </p> <?php
}

function addOrder_has_Product($db, $OrderId, $tabProduct, $tabQuantity){
    $DatabaseStatement = $db->prepare("INSERT INTO ORDER_has_PRODUCT (ORDER_ID, PRODUCT_ID, QUANTITY) VALUES ($OrderId, $tabProduct[0], $tabQuantity[0]); INSERT INTO ORDER_has_PRODUCT (ORDER_ID, PRODUCT_ID, QUANTITY) VALUES ($OrderId, $tabProduct[1], $tabQuantity[1]); INSERT INTO ORDER_has_PRODUCT (ORDER_ID, PRODUCT_ID, QUANTITY) VALUES ($OrderId, $tabProduct[2], $tabQuantity[2])");
    $DatabaseStatement->execute();?>
        <p><?php echo "Les produits ont été ajoutés à votre commande"; ?> </p> <?php
}

function CreateFullOrder($db, $OrderId, $tabProduct, $tabQuantity, $CustomerId){
    addOrder($db, $OrderId, $CustomerId);
    addOrder_has_Product($db, $OrderId, $tabProduct, $tabQuantity);
}