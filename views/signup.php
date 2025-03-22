<?php
// signup.php 
include '../php/database/connect.php'; // Asegúrate de que aquí se conecta a la base de datos correctamente
include 'header.php';

echo '<h3>Sign up</h3>';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // Formulario de registro
    echo '<form method="post" action=""> 
        Username: <input type="text" name="user_name" /> 
        Password: <input type="password" name="user_pass"> 
        Password again: <input type="password" name="user_pass_check"> 
        E-mail: <input type="email" name="user_email"> 
        <input type="submit" value="Register" /> 
    </form>';
} else {
    // Validaciones
    $errors = array();

    if (!isset($_POST['user_name']) || empty($_POST['user_name'])) {
        $errors[] = 'The username field must not be empty.';
    } elseif (!ctype_alnum($_POST['user_name'])) {
        $errors[] = 'The username can only contain letters and digits.';
    } elseif (strlen($_POST['user_name']) > 30) {
        $errors[] = 'The username cannot be longer than 30 characters.';
    }

    if (!isset($_POST['user_pass']) || empty($_POST['user_pass'])) {
        $errors[] = 'The password field cannot be empty.';
    } elseif ($_POST['user_pass'] != $_POST['user_pass_check']) {
        $errors[] = 'The two passwords did not match.';
    }

    if (!empty($errors)) {
        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
        echo '<ul>';
        foreach ($errors as $value) {
            echo '<li>' . $value . '</li>';
        }
        echo '</ul>';
    } else {
        // Conexión a la base de datos
        $conn = mysqli_connect("localhost", "prueba", "123456", "foro_php_mysql");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Sanitizar los datos de entrada
        $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
        $user_pass = sha1($_POST['user_pass']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);

        // Query para insertar el usuario
        $sql = "INSERT INTO users (user_name, user_pass, user_email, user_date, user_level) 
                VALUES ('$user_name', '$user_pass', '$user_email', NOW(), 0)";

        if (mysqli_query($conn, $sql)) {
            echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
        } else {
            echo 'Something went wrong while registering. Please try again later.';
            // echo mysqli_error($conn); // Descomentar para depuración
        }

        // Cerrar la conexión
        mysqli_close($conn);
    }
}

include 'footer.php';
?>
