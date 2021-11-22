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
