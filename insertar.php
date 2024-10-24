<?php

include 'conexion.php';

// Inicializar
$mensaje = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $observacion = $_POST['observacion'];

    
    if (!empty($nombre_completo) && !empty($direccion) && !empty($observacion)) {

        // Verificar si el registro ya existe
        $sql_check = "SELECT * FROM tabla WHERE nombre_completo = ? AND direccion = ? AND observacion = ?";
        if ($stmt_check = mysqli_prepare($conn, $sql_check)) {
            mysqli_stmt_bind_param($stmt_check, "sss", $nombre_completo, $direccion, $observacion);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);

            // mensaje de error
            if (mysqli_num_rows($result_check) > 0) {
                $error = "El registro ya existe";
            } else {
                // Si no existe insertar los datos
                $sql = "INSERT INTO tabla (nombre_completo, direccion, observacion) VALUES (?, ?, ?)";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sss", $nombre_completo, $direccion, $observacion);
                    if (mysqli_stmt_execute($stmt)) {

                        // Redirigir al index.php 
                        header("Location: index.php");
                        exit(); // Detener la ejecución del script 
                    } else {
                        $error = "Error al insertar los datos: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            mysqli_stmt_close($stmt_check);
        } else {
            $error = "Error al verificar los datos: " . mysqli_error($conn);
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}

mysqli_close($conn);
