<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login</title>
</head>

<?php

session_start();
$_SESSION['user'] = null;

include "./BaseDatos.php";

if (isset($_POST["login"]) && !empty($_POST["user"]) && !empty($_POST["email"])) {
    $user = $_POST["user"];
    $email = $_POST["email"];

    $authentication = authenticateUSer($user, $email);
    $lastAccess = updateLastAccess($user, $email);
    $userData = mysqli_fetch_assoc($authentication);
    $superIDQuery = getSuperID();
    $superID = mysqli_fetch_assoc($superIDQuery);

    // echo $userData['FullName'];

    if ($authentication) {
        if (!isset($_SESSION["user"])) {
            $_SESSION['user'] = $userData["FullName"];
            $_SESSION['email'] = $userData["Email"];
            $_SESSION['id'] = $userData["UserID"];
            $_SESSION['enabled'] = $userData["Enabled"];
        }
        if ($superID["SuperAdmin"] === $userData["UserID"]) {
            $_SESSION["SuperAdmin"] = true;
        }
    }

}

?>

<body>
    <section class="card m-5 border-white">
        <div class="mx-auto my-3">
        <h1 class="card-title">Bienvenido a Webstore</h1>
        <div classs="card-body">
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Usuario: </label>
                <input class="form-control" required type="text" name="user" />
            </div>
            <div class="mb-3">
                <label class="form-label">Email: </label>
                <input class="form-control" required type="email" name="email"/>
            </div>
            <input class="btn btn-primary mb-5 mt-2" type="submit" name="login" value="Entrar" />
        </form>
    <?php
if ($authentication) {
    echo "<span class='alert alert-success mb-3'>Bienvenido " . $userData["FullName"] . ", pulsa <a href='./acceso.php'>AQUÍ</a> para continuar </span>";
}
?>
</div>
</div>
    </section>



</body>
</html>
