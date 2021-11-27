<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

    <title>Document</title>
</head>
<body>


<section class="card m-5 border-white">
<?php

// iniciamos sesión
session_start();
//incluimos el archivo MostrarDatos.php que utilizaremos para pintar parte del contenido de la página
include "MostrarDatos.php";
// comprobamos que la sesión tiene registrados datos de user, si el usuario es de tipo
// registrado u autorizado y/o si es superadmin o no. Si no es enabled o superadmin no podrá acceder a la 
// página (se le redirecciona a la pagina de acceso)
if (isset($_SESSION["user"]) && ($_SESSION["enabled"] == 1) || isset($_SESSION["SuperAdmin"])){

    // si se ha ejecutado el formulario, accedemos al objeto de $_GET y comprobamos si se ha ejecutado
    // un formulario de tipo "edit" y si se ha fijado la id del articulo que se quiere editar. 
    if (isset($_GET["edit"]) && isset($_GET["id"])) {
        $type = "edit";
        $productId = $_GET["id"];
        // si se cumplen ambas condiciones, renderizamos condicionalmente el mensaje de edición, añadiendo
        // la id del producto que vamos a modificar. 
        // Cargaremos un formulario con los datos de la id del producto indicado en la acción. 
        echo "<h1 class='text-center card-title'>Se va a editar el artículo nº " . $productId .  "</h1>";
        generatePopulatedForm($productId, $type);
    }

    // misma lógica pero comprobando si venimos de una acción que implica cargar el formulario para
    // realizar la eliminación de un artículo (comprobando las keys delete e id en el objeto $_GET). 
    // Cargaremos un formulario con los datos de la id del producto indicado en la acción. 
    if (isset($_GET["delete"]) && isset($_GET["id"])) {
        $type = "delete";
        $productId = $_GET["id"];
        echo "<h1 class='text-center card-title'>Se va a borrar el artículo nº " . $productId .  "</h1>";
        generatePopulatedForm($productId, $type);
    }

    // Si la key contenida en $_GET es new, cargaremos un formulario vacío. 
    if (isset($_GET["new"])) {
        echo "
        <h1 class='text-center card-title'>Se va a añadir un nuevo artículo</h1>";
        generateEmptyForm();
    }

    // comprobamos si las props name, cost, price y category vienen fijadas en el $_POST y si es así, significará
    // que venimos de la acción de completado del formulario. 
    if (isset($_POST["name"]) && isset($_POST["cost"]) && isset($_POST["price"]) && isset($_POST["category"])) {

        // Recogemos los datos que nos trae el formulario para hacer las llamadas de funciones pertinentes
        $id = $_POST["id"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $cost = $_POST["cost"];
        $category = $_POST["category"];
       
        
        // si venimos de un formulario con una acción edit, ejecutaremos la función de updateProduct contenida en 
        // el archivo BaseDatos.php, incluyendo todos los valores obtenidos del formulario. Además cargaremos
        // un mensaje informando al usuario de la correcta actualización. 
        if (isset($_POST["edit"])) {
            updateProduct($id, $name, $price, $cost, $category);
            echo "<div class='alert alert-primary mx-auto'>
            <h2>El producto se ha modificado correctamente
            </h2>
            </div>
            <button class='btn w-25 mt-3 mx-auto btn-primary'> <a class='text-white' style='text-decoration:none' href='./Articulos.php'> Volver </a></button>
            ";
        }
        // si venmos de una acción "delete", ejecutamos la función de delete. Para ello, solo necesitaremos el valor del id del producto a borrar y 
        // ejecutamos la función removeProduct()
        if (isset($_POST["delete"])) {
            removeProduct($id);
            echo "<div class='alert alert-primary mx-auto'>
            <h2>El producto se ha borrado correctamente
            </h2>
            </div>
            <button class='btn w-25 mt-3 mx-auto btn-primary'> <a class='text-white' style='text-decoration:none' href='./Articulos.php'> Volver </a></button>
            ";
        }

        // Si la key add está presente en $_POST, lo que haremos será crear un nuevo producto en la bbdd mediante la función addProduct, añadiendo los
        // parámetros necesarios. 
        if (isset($_POST["add"])) {
            addProduct($name, $cost, $price, $category);
            echo "
            <div class='alert alert-primary mx-auto'>
            <h2>El producto se ha añadido correctamente
            </h2>
            </div>
            <button class='btn w-25 mt-3 mx-auto btn-primary'> <a class='text-white' style='text-decoration:none' href='./Articulos.php'> Volver </a></button>
            ";
        }

    } else {

    }
    ;
}else{
    // si el usuario no está logueado, se le redirecciona a la página de login. 
    header("Location: http://localhost/pac/acceso.php");
}

?>





</body>
</html>