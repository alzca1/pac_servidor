<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <title>Artículos</title>
</head>
<body>

<h1 class="text-center my-5"> Artículos </h1>
<section class="m-5">
    <div class="">
<a  class="btn btn-link mb-4" style="text-decoration: none" href="./Acceso.php">Volver atrás</a>
<br>
<?php
// iniciamos sesión o la reanudamos
session_start();
// comprobamos si el user es autorizado o es superadmin. Si no lo es, no podrá modificar la tabla
// y por tanto solo visualizar los datos. Además, tampoco podrá crear un nuevo artículo (este
// botón se renderiza de forma condicional) 
if ($_SESSION["enabled"] == 1 || isset($_SESSION["SuperAdmin"])) {

    echo "<form action='formArticulos.php' method='GET'>
            <input class='btn btn-success' type='submit' name='new' value='Nuevo Artículo' />
         </form>
         </div>";

}

?>


<br>
<?php
// importamos el archivo BaseDatos para acceder a las funciones allí definidas
include "./BaseDatos.php";

// comprobamos si existe un usuario en la sesión (de lo contrario, lo expulsamos
// a la página de login
if (isset($_SESSION["user"])) {

    // aqui definimos dos variables para poder acceder a las props enviadas por los
    // formularios en las flechas de cada columna y determinar si tenemos que ordenar
    // de forma ascendente o descendente. Si dichos datos no están presentes, simplemente
    // cargamos los datos desde base de datos sin darle ninguna instrucción concreta para 
    // ordenarlos. 
    $key = array_keys($_GET)[0];
    $type = array_values($_GET)[0];
    $articlesData = null;

    if ($key && $type) {
        $articlesData = getOrderedArticles($key, $type);
    } else {
        $articlesData = getArticles();
    }
    // si la variable con los datos obtenidos desde la bbdd no es una string
    // cargaremos toda la estructura de la tabla html
    if (is_string($articlesData)) {
        echo $datos;
    } else {
        echo "<table class='table table-hover table-bordered table-striped'>\n
                <tr class='text-center'> \n
                    <th class='text-primary'>Id
                    <form action='Articulos.php' method='GET'>
                    <button type='submit' name='ProductID' id='ProductID' value='ASC'>↑</button>
                    <button type='submit' name='ProductID' id='ProductID' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Categoría
                    <form action='Articulos.php' method='GET'>
                    <button type='submit' name='CategoryID' id='CategoryID' value='ASC'>↑</button>
                    <button type='submit' name='CategoryID' id='CategoryID' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Nombre
                    <form action='Articulos.php' method='GET'>
                    <button type='submit' name='Name' id='Name' value='ASC'>↑</button>
                    <button type='submit' name='Name' id='Name' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Coste
                    <form action='Articulos.php' method='GET'>
                    <button type='submit' name='Cost' id='Cost' value='ASC'>↑</button>
                    <button type='submit' name='Cost' id='Cost' value='DESC'>↓</button>
                    </form>
                    </th>\n
                    <th class='text-primary'>Precio
                    <form action='Articulos.php' method='GET'>
                    <button type='submit' name='Price' id='Price' value='ASC'>↑</button>
                    <button type='submit' name='Price' id='Price' value='DESC'>↓</button>
                    </form>
                    </th>\n";


    // aquí comoprobamos si el usuario es autorizado o superadmin para mostrar los botones
    // de Manejo (Editar y Borrar) y renderizamos condicionalmente. En este caso renderizamos
    // condicionalmente la columna y más abajo los botones. 
        if ($_SESSION["enabled"] == 1 || isset($_SESSION["SuperAdmin"])) {
            echo "<th class='text-primary'>Manejo</th>
            
                </tr>";
        } else {
            echo "</tr>\n";
        }
        // recorremos el array que nos devuelve $articlesData y los vamos insertando en 
        // las diferentes celdas. 
        while ($row = mysqli_fetch_assoc($articlesData)) {
            echo "<tr>\n
                        <td>" . $row["ProductID"] . "</td>\n
                        <td>" . $row["CategoryID"] . "</td>\n
                        <td>" . $row["Name"] . "</td>\n
                        <td>" . $row["Cost"] . "</td>\n
                        <td>" . $row["Price"] . "</td>\n";

            
        // aquí renderizamos condicionalmente los botones de Manejo (comprobando si el usuario es 
        // distinto a usuario registrado).
            if ($_SESSION["enabled"] == 1 || isset($_SESSION["SuperAdmin"])) {
                echo "<td class='d-flex justify-content-around'>
                            <form action='formArticulos.php' method='GET'>
                                <input hidden name='id' value='" . $row["ProductID"] . "'>
                                <input name='edit' type='submit' value='Editar' />
                            </form>
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
// aquí devolvemos al usuario a la página de login si este no estuviera logueado. 
} else {
    header("Location: http://localhost/pac/index.php");
}

?>

<?php ?>



<div>


</div>

</section>

</body>
</html>
