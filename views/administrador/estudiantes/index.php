<?php
    // Conectar a la base de datos
    require_once '../../../config/db.php';
    require_once '../../../router.php';

    // Procesar la eliminación si se recibe un ID válido por GET
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];

        // Verificar si el ID es válido y realizar la eliminación
        if (!empty($delete_id)) {
            $query = "DELETE FROM estudiantes WHERE ID_estudiante = :delete_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':delete_id', $delete_id);

            if ($stmt->execute()) {
                // Redirigir de vuelta a la página actual después de la eliminación
                header("Location: index.php");
                exit();
            } else {
                echo "Error al intentar eliminar el estudiante.";
            }
        }
    }

    // Obtener y mostrar la lista de estudiantes
    $query = "SELECT * FROM estudiantes";
    $result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Gestión de Estudiantes</title>
    <link rel="stylesheet" type="text/css" href="../../../assets/styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Añadido -->
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../../../assets/Logo.png" alt="Logo de la empresa" class="logo">
        </div>
        <div class="title">
            <h1>Gestión de Estudiantes</h1>
        </div>
        <div class="datetime">
            <?php
                date_default_timezone_set('America/Bogota');
                $fechaActual = date("d/m/Y");
                $horaActual = date("h:i a");
            ?>
            <div class="datetime">
                <div class="fecha">
                    <p>Fecha actual: <?php echo $fechaActual; ?></p>
                </div>
                <div class="hora">
                    <p>Hora actual: <?php echo $horaActual; ?></p>
                </div>
            </div>
        </div>
    </header>
    <section class="admin">
        <div class="subtitulo-admin">
            <h2>Estudiantes</h2>
        </div>
        <div class="crear-estudiante">
            <a href="/dashboard/cjs/views/administrador/estudiantes/create.php" class="button boton-centrado">Crear Nuevo Estudiante</a>
        </div>
        <section class="estudiantes" id="section-estudiantes">
            <div class="descripcion-ambiente">
                <p>Listado y Gestión de Estudiantes</p>
            </div>
            <div class="tabla-estudiantes tabla-scroll">
                <table class="table table-striped table-dark table_id" border="1" id="tabla-estudiantes">
                    <thead>
                        <tr>
                            <th>ID Estudiante</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Identificación</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Género</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>ID Curso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->rowCount() > 0) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_estudiante']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombres']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellidos']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Identificacion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Fecha_nacimiento']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Genero']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Direccion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Telefono']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Correo_electronico']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ID_curso']) . "</td>";
                                echo "<td>";
                                $url_update = '/dashboard/cjs/views/administrador/estudiantes/update.php?id=' . $row['ID_estudiante'];
                                echo "<a href='" . htmlspecialchars($url_update) . "' class='boton-modificar'><img src='../../../assets/editar.svg' alt='Editar'></a>";
                                $url_delete = htmlspecialchars($_SERVER["PHP_SELF"]) . "?delete_id=" . $row['ID_estudiante'];
                                echo "<a href='#' class='boton-eliminar' onclick=\"confirmarEliminar('" . $row['ID_estudiante'] . "')\"><img src='../../../assets/eliminar.svg' alt='Eliminar'></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11'>No hay estudiantes registrados</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="regresar">
                <a href="http://localhost/dashboard/cjs/views/administrador/index.php" class="button boton-centrado" id="btn-regresar">Regresar</a>
            </div>
            <div class="salir">
                <button id="btn_salir">Salir</button>
            </div>
        </section>
    </section>
    <script>
        $(document).ready(function() {
            var table = $('#tabla-estudiantes').DataTable({
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activar para ordenar la columna ascendente",
                        "sortDescending": ": activar para ordenar la columna descendente"
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ],
                paging: true,
                pageLength: 6
            });
        });

        function confirmarEliminar(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará al estudiante.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_id=' + id;
                }
            });
        }
    </script>
    <footer>
        <p>Todos los derechos reservados</p>
    </footer>
</body>
</html>
