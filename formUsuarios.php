<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Formulario Usuario</title>
</head>
<body>
    <section class="card m-5 border-white">


<?php
session_start();
include "MostrarDatos.php";
if (isset($_SESSION["user"]) && isset($_SESSION["SuperAdmin"])) {
    
    if (isset($_GET["edit"]) && isset($_GET["id"])) {
        $type = "edit";
        $userID = $_GET["id"];
        echo "<h1 class='text-center card-title'>Se va a editar el/la usuari@ nº " . $userID .  "</h1>";
        generatePopulatedUserForm($userID, $type);
    }

    if (isset($_GET["delete"]) && isset($_GET["id"])) {
        $type = "delete";
        $userID = $_GET["id"];
        echo "<h1 class='text-center card-title'>Se va a borrar el/la usuari@ nº " . $userID .  "</h1>";

        generatePopulatedUserForm($userID, $type);
    }

    if (isset($_GET["new"])) {
        echo "
        <h1 class='text-center card-title'>Se va a añadir un/a nuev@ usuari@</h1>";
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
            echo "<div class='alert alert-primary mx-auto'>
            <h2>El/la usuari@ se ha modificado correctamente
            </h2>
            </div>
            <button class='btn w-25 mt-3 mx-auto btn-primary'> <a class='text-white' style='text-decoration:none' href='./Usuarios.php'> Volver </a></button>
            ";
        }

        if (isset($_POST["delete"])) {
            removeUser($id);
            echo "<div class='alert alert-primary mx-auto'>
            <h2>El/la usuari@ se ha borrado correctamente
            </h2>
            </div>
            <button class='btn w-25 mt-3 mx-auto btn-primary'> <a class='text-white' style='text-decoration:none' href='./Usuarios.php'> Volver </a></button>
            ";
        }

        if (isset($_POST["add"])) {
            addUser($name, $email, $password, $enabled);
            echo "
            <div class='alert alert-primary mx-auto'>
            <h2>El/la usuari@ se ha añadido correctamente
            </h2>
            </div>
            <button class='btn w-25 mt-3 mx-auto btn-primary'> <a class='text-white' style='text-decoration:none' href='./Usuarios.php'> Volver </a></button>
            ";
        }

    } else {

    }

} else {
    header("Location: http://localhost/pac/acceso.php");
}
?>
 </section>
</body>
</html>