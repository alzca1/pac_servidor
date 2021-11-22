<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<a href="./Articulos.php">Atrás</a>

<?php

session_start();
// include "BaseDatos.php";
include "MostrarDatos.php";

if (isset($_SESSION["user"]) && $_SESSION["enabled"] == 1) {

    if (isset($_GET["edit"]) && isset($_GET["id"])) {
        $type = "edit";
        $productId = $_GET["id"];
        generatePopulatedForm($productId, $type);
    }

    if (isset($_GET["delete"]) && isset($_GET["id"])) {
        $type = "delete";
        $productId = $_GET["id"];
        generatePopulatedForm($productId, $type);
    }

    if (isset($_GET["new"])) {
        generateEmptyForm();
    }

    if (isset($_POST["name"]) && isset($_POST["cost"]) && isset($_POST["price"]) && isset($_POST["category"])) {

        $id = $_POST["id"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $cost = $_POST["cost"];
        $category = $_POST["category"];
        echo "this is here";

        if (isset($_POST["edit"])) {
            updateProduct($id, $name, $price, $cost, $category);
            echo "updated product";
        }

        if (isset($_POST["delete"])) {
            removeProduct($id);
            echo "removed product";
        }

        if (isset($_POST["add"])) {
            addProduct($name, $cost, $price, $category);
            echo "added product";
        }

    } else {

    }
    ;
}

?>





</body>
</html>