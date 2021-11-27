<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Usuarios</title>
</head>
<body>

<h1 class="text-center my-5"> Usuarios </h1>
<section class='m-5'>
<a class="btn btn-link " href="./Acceso.php">Volver atrás</a>
<br>
<br>


<?php

// reanudamos la sesión
session_start();
include "./BaseDatos.php";

// generamos el botón para crear un nuevo usuario mediante una form 
echo "<form action='formUsuarios.php' method='GET'>
            <input class='btn btn-success my-4' type='submit' name='new' value='Crear nuevo usuario'/>
         </form>";
// comprobamos que hay un user en la session y que este posee la prop SuperAdmin, de lo contrario lo 
// enviamos fuera de aquí (a la página de acceso)
if (isset($_SESSION["user"]) && isset($_SESSION["SuperAdmin"])) {

    // guardamos en las variables key y type las llaves para controlar si hay algún 
    // parámetro cargado en $_GET que nos indique que la tabla de usuarios debe ser ordenada
    // atendiendo a algún parametro (definido en $type).
    $key = array_keys($_GET)[0];
    $type = array_values($_GET)[0];
    // inicializamos la variable $usersData, en la que alojaremos la consulta a la bbdd
    // con un orden específico o sin él. 
    $usersData = null;

    if ($key && $type) {
        $usersData = getOrderedUsers($key, $type);
    } else {
        $usersData = getUsers();
    }
    // obtenemos la superadmin id para mostrar el usuario superadmin con los botones de
    // editar y borrar deshabilitados
    $superIDQuery = getSuperID();
    $superID = mysqli_fetch_assoc($superIDQuery);
    

    if (is_string($usersData)) {
        echo $datos;
    } else {
        echo "<table class='table table-hover table-bordered table-striped'>\n
                <tr class='text-center'> \n
                    <th class='text-primary'>Id
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='UserID' id='UserID' value='ASC'>↑</button>
                    <button type='submit' name='UserID' id='UserID' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Nombre
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='FullName' id='FullName' value='ASC'>↑</button>
                    <button type='submit' name='FullName' id='FullName' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>
                    Email
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='Email' id='Email' value='ASC'>↑</button>
                    <button type='submit' name='Email' id='Email' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Último Acceso
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='LastAccess' id='LastAccess' value='ASC'>↑</button>
                    <button type='submit' name='LastAccess' id='LastAccess' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Enabled
                    <form action='Usuarios.php' method='GET'>
                    <button type='submit' name='Enabled' id='Enabled' value='ASC'>↑</button>
                    <button type='submit' name='Enabled' id='Enabled' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Manejo</th>\n
                </tr>\n";

        while ($row = mysqli_fetch_assoc($usersData)) {
            // si el UserID es igual al número contenido en $superID, 
            // la row tendrá la clase y la id "super", con la que podemos modificar
            // el css de la fila del superAdmin. 
            if ( $row["UserID"] == $superID["SuperAdmin"]) {
                echo "<tr class='super' id='super'>\n";
            } else {
                echo "<tr>\n";
            }
            echo "
                        <td>" . $row["UserID"] . "</td>\n
                        <td>" . $row["FullName"] . "</td>\n
                        <td>" . $row["Email"] . "</td>\n
                        <td>" . $row["LastAccess"] . "</td>\n
                        <td>" . $row["Enabled"] . "</td>\n
                        <td class='d-flex justify-content-around'>
                            ";
            // si el usuario es superAdmin, mostramos los botones de Editar y Borrar usuarios
            if ($row["UserID"] == $superID["SuperAdmin"]) {
                echo "
                <form action='formUsuarios.php' method='GET'>
                <input disabled name='edit' type='submit' value='Editar' />
                ";
            } else {
                echo "
                <form action='formUsuarios.php' method='GET'>
                    <input hidden name='id' value='" . $row["UserID"] . "'>
                    <input name='edit' type='submit' value='Editar' />
                ";
            }
            echo "
                </form>
                        ";

            if ($row["UserID"] == $superID["SuperAdmin"]) {
                echo "
                <form action='formUsuarios.php' method='GET'>
                    <input disabled name='delete' type='submit' value='Borrar' />";

            } else {
                echo "
                <form action='formUsuarios.php' method='GET'>
                    <input hidden name='id' value='" . $row["UserID"] . "'>
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
</section>
</body>
</html>
