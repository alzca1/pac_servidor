<?php

include "BaseDatos.php";

function generateEmptyForm()
{

    echo "
    <div class='card-body'>
    <form class='w-50 my-4 p-5 bg- mx-auto border bg-light' action='formArticulos.php' method='POST'>
    <div class='mb-3'>
    <label class='form-label' for='id'>ID: </label>
    ";

    $articlesCount = countArticles();

    if (!is_string($articlesCount)) {
        $count = mysqli_fetch_assoc($articlesCount);
        echo "<input class='form-control' min='" . $count["COUNT(ProductID)"] + 1 . "' max='" . $count["COUNT(ProductID)"] + 1 . "'type='number' value='" . $count["COUNT(ProductID)"] + 1 . "' /> </div>";
    }

    echo "
    <div class='mb-3'><label class='form-label' for='category'>Category</label>
    <select class='form-select' name='category'>";

    $categoryList = getCategories();

    if ($categoryList) {
        while ($row = mysqli_fetch_assoc($categoryList)) {
            echo "<option value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
        }
    }

    echo "</select></div>
    <div class='mb-3'>
    <label class='form-label'for='name'>Name: </label>
    <input class='form-control' required type='text' name='name'>
    </div>
    <div class='mb-3'>
    <label class='form-label' for='cost'>Cost: </label>
    <input class='form-control' required type='number' name='cost'>
    </div>
    <div class='mb-5'>
    <label class='form-label' for='price'>Price: </label>
    <input class='form-control' required type='number' name='price'>
    </div>

    <div class='d-flex justify-content-around mt-3'>
    <a class='btn btn-danger btn-lg px-5' href='./Articulos.php'>Atrás</a>
    <input class='btn btn-primary btn-lg px-5' type='submit' name='add' value='Añadir' />
    </div>
    </form>";

}

function generatePopulatedForm($id, $type)
{
    // Invocamos la función getArticle contenida en el archivo BaseDatos.php para obtener toda la info del producto y 
    // llenar los campos del formulario con ello. 
    $dbQuery = getArticle($id);

    echo "
    <div class='card-body'>
    <form class='w-50 my-4 p-5 bg- mx-auto border bg-light' action='formArticulos.php' method='POST'>
    <div class='mb-3'>
    <label class='form-label' for='id'>ID: </label>
    ";

    // mostramos un mensaje con el producto que se va a modificar (su id)
    if (!is_string($dbQuery)) {
        $article = mysqli_fetch_assoc($dbQuery);
        echo "<input class='form-control' required min='" . $article["ProductID"] . "' max='" . $article["ProductID"] . "' type='number' name='id' value='" . $article["ProductID"] . "' /> </div>";
    }

    echo "
    <div class='mb-3'>
    <label class='form-label' for='category'>Categoría</label>
    <select class='form-control' name='category'>";

    // obtenemos las diferentes categorías presentes en la tabla category y los cargamos en el campo de Category
    $categoryList = getCategories();
    // si se han obtenido datos, los cargamos
    if ($categoryList) {
        while ($row = mysqli_fetch_assoc($categoryList)) {
            if ($row["CategoryID"] == $article["CategoryID"]) {
                echo "<option selected value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
            } else {
                echo "<option value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
            }
        }
    }
    // reproducimos el resto de campos del formulario accediento a la variable $article y las diferentes
    // props contenidas en ella que nos darán los valores que hemos obtenido en la llamada a la bbdd
    echo "</select>
    </div>
    <div class='mb-3'>
    <label class='form-label' for='name'>Nombre: </label>
    <input class='form-control' required type='text' name='name' value='" . $article["Name"] . "'>
    </div>
    <div class='mb-3'>
    <label class='form-label' for='cost'>Coste: </label>
    <input class='form-control' required type='number' name='cost' value='" . $article["Cost"] . "'>
    </div>
    <div class='mb-3'>
    <label class='form-label' for='price'>Precio: </label>
    <input class='form-control' required type='number' name='price' value='" . $article["Price"] . "'>
    </div>
    <div class='d-flex justify-content-around mt-3'>
    <a class='btn btn-danger btn-lg px-5' href='./Articulos.php'>Atrás</a>
    ";

    if ($type == "edit") {
        echo "<input class='btn btn-primary btn-lg px-3' type='submit' name='edit' value='Modificar Artículo' />";
    }
    ;

    if ($type == "delete") {
        echo "<input class='btn btn-primary btn-lg px-3' type='submit' name='delete' value='Borrar Artículo' />";
    }
    ;
    echo "</div> </form>";
}

function generateEmptyUserForm()
{

    $today = date("Y-m-d");

    echo "
    <div class='card-body'>
    <form class='w-50 my-4 p-5 bg- mx-auto border bg-light' action='formUsuarios.php' method='POST'>
    <div class='mb-3'>
    <label class='form-label' for='id'>ID: </label>
    ";

    $usersCount = countUsers();

    if (!is_string($usersCount)) {
        $count = mysqli_fetch_assoc($usersCount);
        echo "<input class='form-control' name=' id' min='" . $count["COUNT(UserID)"] + 1 . "' max='" . $count["COUNT(UserID)"] + 1 . "'type='number' value='" . $count["COUNT(UserID)"] + 1 . "' /> </div>";
    }

    echo "
    <div class='mb-3'>
    <label class='form-label' for='name'>Nombre: </label>
    <input class='form-control' required type='text' name='name'>
    </div>
    <div class='mb-3'>
    <label class='form-label' for='password'>Contraseña: </label>
    <input class='form-control' required type='password' name='password'>
    </div>
    <div class='mb-3'>
    <label class='form-label' for='email'>Correo: </label>
    <input class='form-control' required type='email' name='email'>
    </div>
    <div class='mb-4'>
    <label class='form-label' for='last_access'>Último acceso: </label>
    <input class='form-control' disabled type='date' name='last_access' value='$today' />
    </div>
    <div class='mb-3'>
    <div class='form-check-inline'>
    <span class='me-3 lead text-primary'>Autorizado/a</span>
    <label class='form-check-label lead' for='enabled'>SI</label>
    <input class='form-check-input lead' type='radio' name='enabled' value='1' >
    </div>
    <div class='form-check-inline'>
    <label class='form-check-label lead' for='enabled'>NO</label>
    <input class='form-check-input lead' type='radio' name='enabled' value='0' checked>
    </div>
    </div>

    <div class='d-flex justify-content-around mt-5'>
    <a class='btn btn-danger btn-lg px-5' href='./Articulos.php'>Atrás</a>
    <input class='btn btn-primary btn-lg px-5' type='submit' name='add' value='Añadir' />
    </div>
    </form>
    "
    ;

}

function generatePopulatedUserForm($id, $type)
{

    $dbQuery = getUser($id);

    echo "
    <div class='card-body'>
    <form class='w-50 my-4 p-5 bg- mx-auto border bg-light' action='formUsuarios.php' method='POST'>
    <div class='mb-3'>
    <label class='form-label' for='id'>ID: </label>
    ";

    if (!is_string($dbQuery)) {
        $user = mysqli_fetch_assoc($dbQuery);
        echo "<input class='form-control' required min='" . $user["UserID"] . "' max='" . $user["UserID"] . "' type='number' name='id' value='" . $user["UserID"] . "' />";
    }

    echo "
   <div class='mb-3'>
    <label class='form-label' for='name'>Name: </label>
    <input class='form-control' required type='text' name='name' value='" . $user["FullName"] . "'>
    </div>
<div class='mb-3'>
    <label class='form-label' for='password'>Contraseña: </label>
    <input class='form-control' type='password' name='password'  value='" . $user["Password"] . "'>
    </div>
<div class='mb-3'>
    <label class='form-label' for='email'>Correo: </label>
    <input class='form-control' required type='email' name='email' value='" . $user["Email"] . "'>
    </div>
<div class='mb-3'>
    <label class='form-label' for='last_access'>Último acceso: </label>
    <input class='form-control' disabled type='date' name='last_access' value='" . $user["LastAccess"] . "' />
    </div>
<div class='mb-3'>
<div class='form-check-inline'>
<span class='me-3 lead text-primary'>Autorizado/a</span>
    <label class='form-check-label lead me-2' for='enabled'>SI</label>";
    if ($user["Enabled"] == 1) {
        echo "<input class='form-check-input lead' type='radio' id='radio1' name='enabled' checked value='1' >";
    } else {
        echo "<input class='form-check-input lead' type='radio' id='radio1' name='enabled' value='1' >";
    }

    echo "
    </div>
    <div class='form-check-inline'>
    <label class='form-check-label lead me-2' for='enabled'>NO</label>";
    if ($user["Enabled"] == 0) {
        echo "<input class='form-check-input lead' type='radio' id='radio2' name='enabled' checked value='0' >";
    } else {
        echo "<input class='form-check-input lead' type='radio' id='radio2' name='enabled'  value='0' >";
    }
    echo "</div>
    </div>
    <div class='d-flex justify-content-around mt-5'>
    <a class='btn btn-danger btn-lg px-5 me-1' href='./Usuarios.php'>Atrás</a>
    ";

    if ($type == "edit") {
        echo "<input class='btn btn-primary btn-lg px-3' type='submit' name='edit' value='Modificar usuari@' />";
    }
    ;

    if ($type == "delete") {
        echo "<input class='btn btn-primary btn-lg px-3' type='submit' name='delete' value='Borrar usuari@' />";
    }
    ;

    echo "
    </div>
    </form>";

}

//http://localhost/pac/formUsuarios.php?
// last_access=11
// &name=Jose
// &password=1234
// &email=jose%40gmail.com
// &enabled=1

// &add=A%C3%B1adir
