SELECT * 
FROM PRODUCT;


SELECT * 
FROM PRODUCT 
WHERE STOCK = 0 ;


SELECT * 
FROM `ORDER` 
WHERE Date = CURRENT_DATE
ORDER BY ID DESC;


SELECT Date
FROM `ORDER`
WHERE Date
BETWEEN DATE_ADD(CURRENT_DATE,INTERVAL -10 DAY) AND CURRENT_DATE;


SELECT Name, Stock, Price 

FROM ORDER_has_PRODUCT 
INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID 
WHERE ORDER_ID = 1;


SELECT ORDER_ID, SUM(Price*QUANTITY) AS FINAL_PRICE
FROM ORDER_has_PRODUCT 
INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID 
GROUP BY ORDER_ID;


SELECT SUM(Price*QUANTITY) AS FINAL_PRICE
FROM ORDER_has_PRODUCT
INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID
INNER JOIN `ORDER` ON ORDER_ID = `ORDER`.ID
WHERE Date = CURRENT_DATE;


SELECT ORDER_ID, SUM(Price*QUANTITY) AS FINAL_PRICE 
FROM ORDER_has_PRODUCT
INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID
GROUP BY ORDER_ID HAVING FINAL_PRICE  BETWEEN 100 and 550;


SELECT ID_CUSTOMERS, First_name, SUM(QUANTITY * Price) AS FINAL_PRICE
FROM ORDER_has_PRODUCT
INNER JOIN PRODUCT ON PRODUCT_ID = ID
INNER JOIN `ORDER` ON ORDER_ID = `ORDER`.ID
INNER JOIN CUSTOMERS ON ID_CUSTOMERS = CUSTOMERS.ID
GROUP BY ID_CUSTOMERS
HAVING First_name = 'Charlize';


SELECT First_name, Last_name, COUNT(ID_CUSTOMERS) AS NB_ORDERS
FROM `ORDER`
INNER JOIN CUSTOMERS ON ID_CUSTOMERS = CUSTOMERS.ID
GROUP BY First_name, Last_name, ID_CUSTOMERS;


SELECT First_name, Last_name, SUM(QUANTITY * Price) AS FINAL_PRICE
FROM `ORDER`
INNER JOIN CUSTOMERS ON ID_CUSTOMERS = CUSTOMERS.ID
INNER JOIN ORDER_has_PRODUCT ON ORDER_ID = `ORDER`.ID
INNER JOIN PRODUCT ON PRODUCT_ID = PRODUCT.ID
GROUP BY First_name, Last_name;



INSERT INTO `ORDER` (ID, Date, `Hours`, `ID_CUSTOMERS`)
VALUES (8, CURRENT_DATE, CURRENT_TIME, 3);

INSERT INTO `ORDER_has_PRODUCT` (ORDER_ID, PRODUCT_ID, QUANTITY)
VALUES (8, 5, 2);
INSERT INTO `ORDER_has_PRODUCT` (ORDER_ID, PRODUCT_ID, QUANTITY)
VALUES (8, 1, 6);
INSERT INTO `ORDER_has_PRODUCT` (ORDER_ID, PRODUCT_ID, QUANTITY)
VALUES (8, 9, 1);

UPDATE PRODUCT
SET Stock = Stock + 100
WHERE ID = 2;

UPDATE PRODUCT
INNER JOIN PRODUCT_has_CATEGORIES ON PRODUCT.ID = PRODUCT_ID
SET Price = Price * 1.05
WHERE CATEGORIES_ID = 1;

DELETE FROM PRODUCT 
WHERE ID=14;


DELETE FROM CUSTOMERS 
WHERE CUSTOMERS.ID NOT IN (SELECT ORDER.ID_CUSTOMERS FROM ORDERS);
