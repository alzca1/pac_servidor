<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos</title>
</head>
<body>

<h1> Usuarios </h1>

<a href="./Acceso.php">Volver atrás</a>
<a href="./formUsuarios.php">Formulario usuarios</a>
<br>
<br>


<?php

session_start();
include "./BaseDatos.php";

echo "<form action='formUsuarios.php' method='GET'>
            <input type='submit' name='new' value='Crear nuevo usuario'/>
         </form>";

if (isset($_SESSION["user"]) && $_SESSION["id"] == 10) {
    echo "Bievenido a la sección de usuarios, " . $_SESSION['user'] . "<br> <br>";
    $key = array_keys($_GET)[0];
    $type = array_values($_GET)[0];
    $usersData = null;

    if ($key && $type) {
        $usersData = getOrderedUsers($key, $type);
    } else {
        $usersData = getUsers();
    }
    
    $superIDQuery = getSuperID();
    $superID = $superID = mysqli_fetch_assoc($superIDQuery);

    if (is_string($usersData)) {
        echo $datos;
    } else {
        echo "<table>\n
                <tr> \n
                    <th>Id
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='UserID' id='UserID' value='ASC'>↑</button>
                    <button type='submit' name='UserID' id='UserID' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th>Nombre
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='FullName' id='FullName' value='ASC'>↑</button>
                    <button type='submit' name='FullName' id='FullName' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th>
                    Email
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='Email' id='Email' value='ASC'>↑</button>
                    <button type='submit' name='Email' id='Email' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th>Último Acceso
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='LastAccess' id='LastAccess' value='ASC'>↑</button>
                    <button type='submit' name='LastAccess' id='LastAccess' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th>Enabled
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='Enabled' id='Enabled' value='ASC'>↑</button>
                    <button type='submit' name='Enabled' id='Enabled' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th>Manejo</th>\n
                </tr>\n";

        while ($row = mysqli_fetch_assoc($usersData)) {
            echo "<tr>\n
                        <td>" . $row["UserID"] . "</td>\n
                        <td>" . $row["Name"] . "</td>\n
                        <td>" . $row["Email"] . "</td>\n
                        <td>" . $row["LastAccess"] . "</td>\n
                        <td>" . $row["Enabled"] . "</td>\n
                        <td>
                            <form action='formUsuarios.php' method='GET'>";
            if ($row["UserID"] == $superID["SuperAdmin"]) {
                echo "<input disabled name='edit' type='submit' value='Editar' />";
            } else {
                echo "<input hidden name='id' value='" . $row["UserID"] . "'>
                                <input name='edit' type='submit' value='Editar' />";
            }
            echo "</form>
                            </td>
                        <td>
                            <form action='formUsuarios.php' method='GET'>";
            if ($row["UserID"] == $superID["SuperAdmin"]) {
                echo "<input disabled name='delete' type='submit' value='Borrar' />";

            } else {
                echo "<input hidden name='id' value='" . $row["UserID"] . "'>
                                <input  name='delete' type='submit' value='Borrar' />";
            }
            echo "
                            </form>
                        </td>
                    </tr>";
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
