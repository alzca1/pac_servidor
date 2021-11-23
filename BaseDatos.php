<?php

function createConnection($database)
{
    $host = "localhost";
    $user = "root";
    $password = "";

    $connection = mysqli_connect($host, $user, $password, $database);
    if (!$connection) {
        die("<br> Error de conexión con la base de datos: " . mysqli_connect_error());
    }

    return $connection;
}

function authenticateUSer($username, $email)
{
    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM user WHERE FullName='" . $username . "' AND Email='" . $email . "'";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        echo "Ha habido un error con tu usuario y/o contraseña";
    }

    mysqli_close($DB);

}

function getArticle($id)
{

    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM product WHERE ProductID='" . $id . "'";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;
        // Si no, enviamos un mensaje de error.
    } else {
        echo "No hay nada en la lista de artículos .";
    }

    mysqli_close($DB);

}

function getArticles()
{
    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM product";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;
        // Si no, enviamos un mensaje de error.
    } else {
        echo "No hay nada en la lista de artículos .";
    }

    mysqli_close($DB);
}

function getUsers()
{
    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM user";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;

    } else {
        echo "No hay nada en la lista de usuarios .";
    }

    mysqli_close($DB);
}

function getOrderedUsers($key, $type){

    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM user ORDER BY " . $key . " " . $type ."";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;

    } else {
        echo "No hay nada en la lista de usuarios .";
    }

    mysqli_close($DB);
}

function getOrderedArticles($key, $type){

    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM product ORDER BY " . $key . " " . $type ."";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;

    } else {
        echo "No hay nada en la lista de usuarios .";
    }

    mysqli_close($DB);
}

function getCategories()
{
    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM category ORDER BY Name";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        echo "No hay nada en la lista de categorías.";
    }
    mysqli_close($DB);
}

function countArticles()
{
    $DB = createConnection("pac3_daw");

    $sql = "SELECT COUNT(ProductID) FROM product";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        echo "No hay nada en la lista de categorías.";
    }
    mysqli_close($DB);
}

function addProduct($name, $cost, $price, $category)
{
    $DB = createConnection("pac3_daw");

    $sql = "INSERT INTO product (Name, Cost, Price, CategoryID) VALUES ('" . $name . "', '" . $cost . "','" . $price . "','" . $category . "')";
    // $sql = "INSERT INTO product (Name, Cost, Price, CategoryID) VALUES ('$name', '$cost','$price','$category')";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {
        echo "No se ha podido añadir el pedido a la base de datos";
    }

    mysqli_close($DB);

}

function removeProduct($id)
{
    $DB = createConnection("pac3_daw");

    $sql = "DELETE FROM product WHERE ProductID='$id'";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {
        echo "No se ha podido eliminar el pedido de la base de datos";
    }

    mysqli_close($DB);
}

function updateProduct($id, $name,$price, $cost,  $category){

    $DB = createConnection("pac3_daw");

    $sql = "UPDATE product set Name= '$name', Price= '$price', Cost= '$cost', CategoryID= '$category' WHERE ProductID= '$id'";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {
        echo "No se ha podido actualizar el pedido de la base de datos";
    }

    mysqli_close($DB);
}

function getSuperID(){
    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM setup WHERE Host='localhost'";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {
        echo "No se ha podido actualizar el pedido de la base de datos";
    }

    mysqli_close($DB);
}


function countUsers()
{
    $DB = createConnection("pac3_daw");

    $sql = "SELECT COUNT(UserID) FROM user";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        echo "No hay nada en la lista de usuarios.";
    }
    mysqli_close($DB);
}


function addUser($name, $email, $password, $enabled){

    $DB = createConnection("pac3_daw");

    $sql = "INSERT INTO user (FullName, Email, Password, Enabled) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $enabled . "')";
    // $sql = "INSERT INTO product (Name, Cost, Price, CategoryID) VALUES ('$name', '$cost','$price','$category')";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {    

        echo "No se ha podido añadir el usuario a la base de datos";
    }

    mysqli_close($DB);

}

function getUser($id){
    $DB = createConnection("pac3_daw");

    $sql = "SELECT * FROM user WHERE UserID='" . $id . "'";
    $result = mysqli_query($DB, $sql);

    if (mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        echo "No hay nada en la lista de artículos .";
    }

    mysqli_close($DB);
}


function updateUser($id, $name, $email, $password, $enabled){
    $DB = createConnection("pac3_daw");

    $sql = "UPDATE user set FullName='$name', Email='$email', Password='$password', Enabled='$enabled' WHERE UserID= '$id'";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {
        echo "No se ha podido actualizar el usuari@ en la base de datos";
    }

    mysqli_close($DB);
}

function removeUser($id){
    $DB = createConnection("pac3_daw");

    $sql = "DELETE FROM user WHERE UserID='". $id ."'";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {
        echo "No se ha podido eliminar el usuari@ de la base de datos";
    }

    mysqli_close($DB);
}

function updateLastAccess($username, $email){
    $DB = createConnection("pac3_daw");

    $today = date("Y-m-d");
    $sql = "UPDATE user set LastAccess='$today' WHERE FullName='" . $username . "' AND Email='" . $email . "'";
    $result = mysqli_query($DB, $sql);

    if ($result) {
        return $result;
    } else {
        echo "No se ha podido actualizar el usuari@ en la base de datos";
    }

    mysqli_close($DB);

}