<?php
$server = 'localhost';
$username = 'prueba';
$password = '123456';
$database = 'foro_php_mysql';

$conn = mysqli_connect($server, $username, $password, $database);


if (!$conn )
{
    die('Error: could not establish database connection' .mysqli_connect_error());
}

echo "Conexión exitosa";
mysqli_close($conn)
?>