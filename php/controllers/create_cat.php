<?php
// create_cat.php
include '../database/connect.php';

// Asegurar que la conexión está disponible
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // El formulario no se ha enviado, lo mostramos
    echo '<form method="post" action=""> 
        Category name: <input type="text" name="cat_name" /> 
        Category description: <textarea name="cat_description"></textarea> 
        <input type="submit" value="Add category" /> 
    </form>';
} else {
    // El formulario ha sido enviado, procesamos los datos
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    $cat_description = mysqli_real_escape_string($conn, $_POST['cat_description']);

    $sql = "INSERT INTO categories (cat_name, cat_description) 
            VALUES ('$cat_name', '$cat_description')";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo 'Error: ' . mysqli_error($conn);
    } else {
        echo 'New category successfully added.';
    }
}
?>
