<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>


<body>
    <h1>Bienvenido a Webstore</h1>
    <form action="index.php" method="POST">
        <label>Nombre de Usuario</label>
        <input required type="text" name="user" />
        <label>Correo Electrónico</label>
        <input required type="email" name="email"/>
        <input type="submit" name="login" value="Entrar" />
    </form>


<?php
session_start();

include "./BaseDatos.php";

if (isset($_POST["login"]) && !empty($_POST["user"]) && !empty($_POST["email"])) {
    $user = $_POST["user"];
    $email = $_POST["email"];

    $authentication = authenticateUSer($user, $email);
    $userData = mysqli_fetch_assoc($authentication);

    // echo $userData['FullName'];

    if ($authentication) {
        echo "Bienvenido " . $userData["FullName"] . ", pulsa <a href='./acceso.php'>AQUÍ</a> para continuar";
        if (!isset($_SESSION["user"])) {
            $_SESSION['user'] = $userData["FullName"];
            $_SESSION['email'] = $userData["Email"];
            $_SESSION['id'] = $userData["UserID"];
            $_SESSION['enabled'] = $userData["Enabled"];
        }
    }

}

?>
</body>
</html>
