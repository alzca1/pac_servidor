<?php

include "BaseDatos.php";

function generateEmptyForm()
{

    echo "
    <form action='formArticulos.php' method='POST'>
    <label for='id'>ID: </label>
    ";

    $articlesCount = countArticles();

    if (!is_string($articlesCount)) {
        $count = mysqli_fetch_assoc($articlesCount);
        echo "<input min='" . $count["COUNT(ProductID)"] + 1 . "' max='" . $count["COUNT(ProductID)"] + 1 . "'type='number' value='" . $count["COUNT(ProductID)"] + 1 . "' />";
    }

    echo "<label for='category'>Category</label>
    <select name='category'>";

    $categoryList = getCategories();

    if ($categoryList) {
        while ($row = mysqli_fetch_assoc($categoryList)) {
            echo "<option value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
        }
    }

    echo "</select>
    <label for='name'>Name: </label>
    <input required type='text' name='name'>
    <label for='cost'>Cost: </label>
    <input required type='number' name='cost'>
    <label for='price'>Price: </label>
    <input required type='number' name='price'>

    <input type='submit' name='add' value='Entrar' />
    </form>";

}

function generatePopulatedForm($id, $type)
{

    $dbQuery = getArticle($id);

    echo "
    <form action='formArticulos.php' method='POST'>
    <label for='id'>ID: </label>
    ";

    // $articlesCount = countArticles();

    if (!is_string($dbQuery)) {
        $article = mysqli_fetch_assoc($dbQuery);
        echo "<input required min='" . $article["ProductID"] . "' max='" . $article["ProductID"] . "' type='number' name='id' value='" . $article["ProductID"] . "' />";
    }

    echo "<label for='category'>Category</label>
    <select name='category'>";

    $categoryList = getCategories();

    if ($categoryList) {
        while ($row = mysqli_fetch_assoc($categoryList)) {
            if ($row["CategoryID"] == $article["CategoryID"]) {
                echo "<option selected value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
            } else {
                echo "<option value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
            }
        }
    }

    echo "</select>
    <label for='name'>Name: </label>
    <input required type='text' name='name' value='" . $article["Name"] . "'>
    <label for='cost'>Cost: </label>
    <input required type='number' name='cost' value='" . $article["Cost"] . "'>
    <label for='price'>Price: </label>
    <input required type='number' name='price' value='" . $article["Price"] . "'>";

    if ($type == "edit") {
        echo "<input type='submit' name='edit' value='Modificar Artículo' />";
    }
    ;

    if ($type == "delete") {
        echo "<input type='submit' name='delete' value='Borrar Artículo' />";
    }
    ;

    echo "</form>";

}

function generateEmptyUserForm()
{

    $today = date("Y-m-d");
    echo $today;
    echo "
    <form action='formUsuarios.php' method='POST'>
    <label for='id'>ID: </label>
    ";

    $usersCount = countUsers();

    if (!is_string($usersCount)) {
        $count = mysqli_fetch_assoc($usersCount);
        echo "<input name='id' min='" . $count["COUNT(UserID)"] + 1 . "' max='" . $count["COUNT(UserID)"] + 1 . "'type='number' value='" . $count["COUNT(UserID)"] + 1 . "' />";
    }

    echo "
    <label for='name'>Nombre: </label>
    <input required type='text' name='name'>

    <label for='password'>Contraseña: </label>
    <input required type='password' name='password'>

    <label for='email'>Correo: </label>
    <input required type='email' name='email'>

    <label for='last_access'>Último acceso: </label>
    <input disabled type='date' name='last_access' value='$today' />

    <label for='enabled'>SI</label>
    <input type='checkbox' name='enabled' value='1' >

    <label for='enabled'>NO</label>
    <input type='checkbox' name='enabled' value='0' >

    <input type='submit' name='add' value='Añadir' />
    </form>";

}

function generatePopulatedUserForm($id, $type)
{

    $dbQuery = getUser($id);

    echo "
    <form action='formUsuarios.php' method='POST'>
    <label for='id'>ID: </label>
    ";

    if (!is_string($dbQuery)) {
        $user = mysqli_fetch_assoc($dbQuery);
        echo "<input required min='" . $user["UserID"] . "' max='" . $user["UserID"] . "' type='number' name='id' value='" . $user["UserID"] . "' />";
    }

    echo "
    <label for='name'>Name: </label>
    <input required type='text' name='name' value='" . $user["FullName"] . "'>

    <label for='password'>Contraseña: </label>
    <input required type='password' name='password'  value='" . $user["Password"] . "'>

    <label for='email'>Correo: </label>
    <input required type='email' name='email' value='" . $user["Email"] . "'>

    <label for='last_access'>Último acceso: </label>
    <input disabled type='date' name='last_access' value='" . $user["LastAccess"] . "' />

    <label for='enabled'>SI</label>";
    if ($user["Enabled"] == 1) {
        echo "<input type='radio' id='radio1' name='enabled' checked value='1' >";
    } else {
        echo "<input type='radio' id='radio1' name='enabled' value='1' >";
    }

    echo " <label for='enabled'>NO</label>";
    if ($user["Enabled"] == 0) {
        echo "<input type='radio' id='radio2' name='enabled' checked value='0' >";
    } else {
        echo "<input type='radio' id='radio2' name='enabled'  value='0' >";
    }

    if ($type == "edit") {
        echo "<input type='submit' name='edit' value='Modificar usuari@' />";
    }
    ;

    if ($type == "delete") {
        echo "<input type='submit' name='delete' value='Borrar usuari@' />";
    }
    ;

    echo "</form>";

}

//http://localhost/pac/formUsuarios.php?
// last_access=11
// &name=Jose
// &password=1234
// &email=jose%40gmail.com
// &enabled=1

// &add=A%C3%B1adir
