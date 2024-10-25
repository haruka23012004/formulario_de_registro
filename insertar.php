<?php

include 'conexion.php';

$mensaje = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $observacion = $_POST['observacion'];

    // Verificar que todos los campos estén completos, es decir, que no estén vacíos
    if (!empty($nombre_completo) && !empty($direccion) && !empty($observacion)) {

        // Preparar la consulta SQL para insertar los datos en la tabla
        $sql = "INSERT INTO tabla (nombre_completo, direccion, observacion) VALUES (?, ?, ?)";

        // Preparar la sentencia SQL utilizando la conexión a la base de datos
        if ($stmt = mysqli_prepare($conn, $sql)) {

            // Vincular los parámetros a la declaración preparada usando "sss" para indicar que son strings (texto)
            mysqli_stmt_bind_param($stmt, "sss", $nombre_completo, $direccion, $observacion);

            // Ejecutar la declaración preparada
            if (mysqli_stmt_execute($stmt)) {

                $mensaje = "Registro ingresado correctamente";
                
                echo "<script>
                        alert('$mensaje');
                        window.location.href='index.php';
                    </script>";

                exit(); // Detener la ejecución del script después de la redirección
            } else {
                // Si hay un error al ejecutar la declaración, mostrar un mensaje de error
                echo "Error al insertar los datos: " . mysqli_error($conn);
            }

            // Cerrar la declaración preparada para liberar los recursos
            mysqli_stmt_close($stmt);
        } else {
            // Si hay un error al preparar la declaración, mostrar un mensaje de error
            echo "Error al preparar la declaración: " . mysqli_error($conn);
        }
    } else {
        echo "<script>
                        alert('por favor, completa los campos, los datos ingresados son incongruentes');
                        window.location.href='index.php';
                    </script>";
                    exit();
    }
}

// Cerrar la conexión a la base de datos al finalizar
mysqli_close($conn);
