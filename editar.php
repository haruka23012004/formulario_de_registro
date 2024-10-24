<?php

include 'conexion.php';

// Verificar si se ha enviado un ID por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para obtener los datos del registro
    $sql = "SELECT * FROM tabla WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "Registro no encontrado.";
            exit();
        }

        mysqli_stmt_close($stmt);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre_completo = $_POST['nombre_completo'];
    $direccion = $_POST['direccion'];
    $observacion = $_POST['observacion'];

    if (!empty($nombre_completo) && !empty($direccion) && !empty($observacion)) {
        $sql = "UPDATE tabla SET nombre_completo = ?, direccion = ?, observacion = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $nombre_completo, $direccion, $observacion, $id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al actualizar los datos: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo_editar.css"> <!-- CSS -->

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- iconos -->
</head>
<body>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-11 col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2>EDITAR REGISTRO</h2>
                </div>
                <div class="card-body">
                    <form action="editar.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        
                        <div class="mb-3">
                            <label for="nombre_completo" class="form-label">
                                Nombre Completo <i class="fas fa-user"></i>
                            </label>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $row['nombre_completo']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">
                                Dirección <i class="fas fa-map-marker-alt"></i>
                            </label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $row['direccion']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="observacion" class="form-label">
                                Observaciones <i class="fas fa-sticky-note"></i>
                            </label>
                            <textarea class="form-control" id="observacion" name="observacion" rows="3" required><?php echo $row['observacion']; ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>