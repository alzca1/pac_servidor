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
<form action="formArticulos.php" method="GET">
    <input type="submit" name="new" value="Nuevo Artículo" />
</form>

<br>
<?php

session_start();
include "./BaseDatos.php";

if (isset($_SESSION["user"])) {
    echo "Bievenido a la sección de artículos, " . $_SESSION['user'] . "<br> <br>";
    $articlesData = getArticles();

    if (is_string($articlesData)) {
        echo $datos;
    } else {
        echo "<table>\n
                <tr> \n
                    <th>Id</th>\n
                    <th>Categoría</th>\n
                    <th>Nombre</th>\n
                    <th>Coste</th>\n
                    <th>Precio</th>\n";

        if ($_SESSION["enabled"] == 1) {
            echo "<th>Manejo</th> \n
                </tr>";
        } else {
            echo "</tr>\n";
        }

        while ($row = mysqli_fetch_assoc($articlesData)) {
            echo "<tr>\n
                        <td>" . $row["ProductID"] . "</td>\n
                        <td>" . $row["CategoryID"] . "</td>\n
                        <td>" . $row["Name"] . "</td>\n
                        <td>" . $row["Cost"] . "</td>\n
                        <td>" . $row["Price"] . "</td>\n";

            if ($_SESSION["enabled"] == 1) {
                echo "<td>
                            <form action='formArticulos.php' method='GET'>
                                <input hidden name='id' value='" . $row["ProductID"] . "'>
                                <input name='edit' type='submit' value='Editar' />
                            </form>
                    </td>
                    <td>
                            <form action='formArticulos.php' method='GET'>
                                <input hidden name='id' value='" . $row["ProductID"] . "'>
                                <input name='delete' type='submit' value='Borrar' />
                            </form>
                    </td>
                </tr>";
            } else {
                echo "</tr>";
            }

        }

    }

} else {
    header("Location: http://localhost/pac/index.php");
}

?>

<?php ?>



<div>


</div>

</body>
</html>
