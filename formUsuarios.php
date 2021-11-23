<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Usuario</title>
</head>
<body>

<a href="./Usuarios.php">Volver</a>
<?php
session_start();
include "MostrarDatos.php";
if (isset($_SESSION["user"]) && isset($_SESSION["SuperAdmin"])) {
    
    if (isset($_GET["edit"]) && isset($_GET["id"])) {
        $type = "edit";
        $userID = $_GET["id"];
        generatePopulatedUserForm($userID, $type);
    }

    if (isset($_GET["delete"]) && isset($_GET["id"])) {
        $type = "delete";
        $userID = $_GET["id"];
        generatePopulatedUserForm($userID, $type);
    }

    if (isset($_GET["new"])) {
        generateEmptyUserForm();
    }

    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["enabled"])) {

        //TODO: añadir una validación isset para id e inicializar como null.
        $id = $_POST["id"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $enabled = $_POST["enabled"];
        $last_access = $_POST["last_access"];
        
        

        if (isset($_POST["edit"])) {
            updateUser($id, $name, $email, $password, $enabled);
            echo "updated user";
        }

        if (isset($_POST["delete"])) {
            removeUser($id);
            echo "removed user";
        }

        if (isset($_POST["add"])) {
            addUser($name, $email, $password, $enabled);
            echo "usuario añadido";
        }

    } else {

    }

} else {
    header("Location: http://localhost/pac/index.php");
}
?>

</body>
</html>