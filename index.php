<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!-- Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS  -->
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="form-container">
                <div class="card">
                    <div class="card-header text-center">
                        <h2><i class="fas fa-edit"></i> Formulario de Registro</h2>
                    </div>
                    <div class="card-body">
                        <form action="insertar.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="nombre_completo">Nombre Completo <i class="fas fa-user"></i></label>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="direccion">Dirección <i class="fas fa-map-marker-alt"></i></label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="observacion">Observación <i class="fas fa-sticky-note"></i></label>
                                <textarea class="form-control" id="observacion" name="observacion" rows="3" required></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="spacer"></div>
            <div class="table-container">
                <h3 class="text-center"><i class="fas fa-database"></i> Datos Registrados</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Dirección</th>
                            <th>Observación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                include 'conexion.php';
                $sql = "SELECT id, nombre_completo, direccion, observacion FROM tabla";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["nombre_completo"] . "</td>
                                <td>" . $row["direccion"] . "</td>
                                <td>" . $row["observacion"] . "</td>
                                <td>
                                    <a href='editar.php?id=" . $row['id'] . "' class='btn btn-success'><i class='fas fa-edit'></i> Editar</a>
                                    <a href='eliminar.php?id=" . $row['id'] . "' class='btn btn-secondary' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este registro?');\"><i class='fas fa-trash-alt'></i> Eliminar</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No hay datos registrados</td></tr>";
                }
                $conn->close();
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- lo necesito para poder usar datatables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
                },
                "responsive": true
            });
        });
    </script>
</body>
</html>
