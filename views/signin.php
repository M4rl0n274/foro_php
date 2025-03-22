<?php
// signin.php
session_start(); // Asegurar el uso de sesiones
include '../php/database/connect.php';
include 'header.php';

echo '<h3>Sign in</h3>';

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
} else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        // Mostrar formulario de inicio de sesión
        echo '<form method="post" action="">
            Username: <input type="text" name="user_name" /> 
            Password: <input type="password" name="user_pass"> 
            <input type="submit" value="Sign in" /> 
        </form>';
    } else {
        // Validaciones
        $errors = array();

        if (!isset($_POST['user_name']) || empty($_POST['user_name'])) {
            $errors[] = 'The username field must not be empty.';
        }

        if (!isset($_POST['user_pass']) || empty($_POST['user_pass'])) {
            $errors[] = 'The password field must not be empty.';
        }

        if (!empty($errors)) {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach ($errors as $value) {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
        } else {
            // Conectar a la base de datos
            $conn = mysqli_connect("localhost", "prueba", "123456", "foro_php_mysql");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Escapar variables para evitar inyecciones SQL
            $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
            $user_pass = sha1($_POST['user_pass']); // Hash de la contraseña

            // Query de autenticación
            $sql = "SELECT user_id, user_name, user_level FROM users 
                    WHERE user_name = '$user_name' AND user_pass = '$user_pass'";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo 'Something went wrong while signing in. Please try again later.';
            } else {
                if (mysqli_num_rows($result) == 0) {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                } else {
                    // Iniciar sesión del usuario
                    $_SESSION['signed_in'] = true;

                    // Guardar los datos del usuario en la sesión
                    while ($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_name'] = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }

                    echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.';
                }
            }

            // Cerrar conexión
            mysqli_close($conn);
        }
    }
}

include 'footer.php';
?>
