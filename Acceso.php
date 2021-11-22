<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso</title>
</head>
<body>
<h1>Acceso</h1>
<div>
<?php
session_start();

if (isset($_POST["killsession"])) {
    $_SESSION = null;
    session_destroy();
}

if (isset($_SESSION["user"])) {
    echo "Bievenido a la tienda, " . $_SESSION['user'];

} else {
    header("Location: http://localhost/pac/index.php");
}
;
?>
</div>

<form method="POST" action="Acceso.php">
    <input hidden name="killsession" />
    <input type="submit" value="Volver" />
</form>

<a href="./Articulos.php">Artículos</a>

<?php
if ($_SESSION["id"] == "10") {
    echo "<a href='./Usuarios.php'>Usuarios</a>";
}
?>
</body>

</html>
