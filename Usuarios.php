<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos</title>
</head>
<body>

<h1> Artículos </h1>

<a href="./Acceso.php">Volver atrás</a>
<br>
<br>
<?php

session_start();
include "./BaseDatos.php";

if (isset($_SESSION["user"]) && $_SESSION["id"] == 10) {
    echo "Bievenido a la sección de usuarios, " . $_SESSION['user'] . "<br> <br>";
    $usersData = getUsers();

    if (is_string($usersData)) {
        echo $datos;
    } else {
        echo "<table>\n
                <tr> \n
                    <th>Id</th>\n
                    <th>Nombre</th>\n
                    <th>Email</th>\n
                    <th>Último Acceso</th>\n
                    <th>Enabled</th>\n
                    <th>Manejo</th>\n
                </tr>\n";

        while ($row = mysqli_fetch_assoc($usersData)) {
            echo "<tr>\n
                        <td>" . $row["UserID"] . "</td>\n
                        <td>" . $row["Name"] . "</td>\n
                        <td>" . $row["Email"] . "</td>\n
                        <td>" . $row["LastAccess"] . "</td>\n
                        <td>" . $row["Enabled"] . "</td>\n
                        <td><a href='./formArticulos'>Editar</a> <a href='#'>Borrar</a>";
        }

    }

} else {
    header("Location: http://localhost/pac/Acceso.php");
}

?>

<?php ?>



<div>


</div>

</body>
</html>
