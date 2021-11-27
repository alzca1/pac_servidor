<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Acceso</title>
</head>
<body>
<div>
<?php
// iniciamos sesión
session_start();

// comprobamos si se ha lanzado un formulario con la key "killsession". Si es así, 
// significará que el usuario ha pulsado el botón "Volver" y por tanto eliminamos
// su sesión fijando el valor de $_SESSION igual a null e invocando el método
// session_destroy(): 
if (isset($_POST["killsession"])) {
    $_SESSION = null;
    session_destroy();
}
// si se ha fijado un usuario en la pantalla anterior de login, mostramos el 
// nombre de usuario junto con un mensaje de bienvenida. 
if (isset($_SESSION["user"])) {
    echo "<section class='card m-5 border-white'>
    <div class='mx-auto my-3'>
    <h2>Bienvenido a la tienda, " . $_SESSION['user'] . "</h2>";

} else {
    // Si no hay ningún usuario en $_SESSION, lo mandamos a la pantalla de login para
    // que se autentique. 
    header("Location: http://localhost/pac/index.php");
}
;
?>
</div>

    <div class="mx-auto d-flex">
        <div class="card p-5 mx-2 bg-light">
            <div class="card-body bg-light">
        <h2><a style="text-decoration:none"href="./Articulos.php">Artículos</a></h2>
</div>
</div>
<?php

// si el usuario es de tipo superAdmin (comprobamos si la $_SESSION contiene la prop
// SuperAdmin), mostramos el acceso a la lista de usuarios. 

if (isset($_SESSION["SuperAdmin"])) {
    echo "
    <div class='card p-5 mx-2 bg-light'>
    <div class='card-body '>
    <h2><a style='text-decoration:none' href='./Usuarios.php'>Usuarios</a></h2>
    </div>
    </div>";
}
?>
</div>
<div class="mx-auto my-5">

    <form method="POST" action="Acceso.php">
        <input hidden name="killsession" />
    <!-- aquí ejecutamos el formulario con el input sobre estas líneas con el atributo name = "killsession". 
    Eso impedirá que un usuario anteriormente logueado "robe" la sesión a otro usuario que se ha logueado
    posteriormente  -->
        <input class="px-5 py-2" type="submit" value="Volver" />
    </form>

</div>
</div>
</section>

</body>

</html>
