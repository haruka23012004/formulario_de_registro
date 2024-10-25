<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

$mensaje = '';


// Verificar si se ha enviado un ID por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para eliminar el registro
    $sql = "DELETE FROM tabla WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $mensaje = "Registro eliminado correctamente";
                
                echo "<script>
                        alert('$mensaje');
                        window.location.href='index.php';
                    </script>";
            exit();
        } else {
            echo "Error al eliminar el registro: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
