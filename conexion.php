<?php

$servername = "localhost";
$username = "root"; // Nombre de usuario de MySQL por defecto en WampServer
$password = ""; // Contraseña por defecto de MySQL en WampServer
$database = "prueba"; // Nombre de tu base de datos*/

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}