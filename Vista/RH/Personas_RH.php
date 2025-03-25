<?php include('head.php'); ?>

<center><div class="table-responsive">
    <style>
        .hidden {
            display: none;
        }
    </style>
    <h2 class="mb-4">Personas Registradas</h2>
    <!-- Botones -->
    <a class="btn btn-primary" href="INSERT/Insert_Persona_RH.php">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
            <path d="M16 19h6" />
            <path d="M19 16v6" />
            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
        </svg>Nuevo</a>
    <form method="GET" class="form-inline d-flex justify-content-end mb-4">
        <div class="form-group mb-2">
            <label for="filtro_nombre" class="mr-2">Nombre o apellido:</label>
            <input type="text" name="filtro_nombre" id="filtro_nombre" class="form-control" placeholder="Buscar por nombre o apellido" required>
        </div>

        <div class="form-group mb-2">
            <label for="ID_Cuenta" class="form-label">Cuenta:</label>
                <select class="form-select mb-3" id="ID_Cuenta" name="ID_Cuenta" required>
                    <option value="" selected disabled>-- Seleccionar Cuenta --</option>
                        <?php 
                            include('../../Modelo/Conexion.php');  // incluir la conexión a la base de datos
                            $conexion = (new Conectar())->conexion(); // Conectar a la base de datos
                            $sql = $conexion->query("SELECT * FROM Cuenta;"); // Consulta a la base de datos
                            while ($resultado = $sql->fetch_assoc()) { // Recorrer los resultados de la consulta
                                echo "<option value='" . $resultado['ID'] . "'>" . $resultado['NombreCuenta'] . "</option>"; // Mostrar los resultados
                            }
                        ?>
                </select>
        </div>

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <!-- Tabla para mostrar los registros -->
    <table id="tablaReclutas" class="table table-hover table-striped mt-4">
        <thead>
            <tr class="table-primary"> 
                <th scope="col">Nmr.</th>
                <th>Nombre Completo</th>
                <th>Cuenta</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Obtener los filtros desde el formulario
                $filtro_nombre = isset($_GET['filtro_nombre']) ? $_GET['filtro_nombre'] : '';
                $filtro_cuenta = isset($_GET['ID_Cuenta']) ? $_GET['ID_Cuenta'] : '';

                // Parámetros para la paginación
                $records_per_page = 10;
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $records_per_page;

                // Consulta SQL base
                $sql = "SELECT  
                            P.ID_Persona, P.Nombres, P.Ap_paterno, P.Ap_materno, C.NombreCuenta
                        FROM
                            Persona_IMG P
                        LEFT JOIN 
                            Persona_Cuenta PU ON P.ID_Persona = PU.ID_Personas
                        LEFT JOIN 
                            Cuenta C ON PU.ID_Cuentas = C.ID
                        WHERE 
                            1=1";

                $params = [];
                $types = "";

                if (!empty($filtro_nombre)) {
                    $sql .= " AND (P.Nombres LIKE ? OR P.Ap_paterno LIKE ? OR P.Ap_materno LIKE ?)";
                    $params[] = "%$filtro_nombre%";
                    $params[] = "%$filtro_nombre%";
                    $params[] = "%$filtro_nombre%";
                    $types .= "sss";
                }
                if (!empty($filtro_cuenta)) {
                    $sql .= " AND C.ID = ?";
                    $params[] = $filtro_cuenta;
                    $types .= "i";
                }

                // Contar total de registros
                $count_sql = "SELECT COUNT(*) 
                              FROM Persona_IMG P
                              LEFT JOIN Persona_Cuenta PU ON P.ID_Persona = PU.ID_Personas
                              LEFT JOIN Cuenta C ON PU.ID_Cuentas = C.ID
                              WHERE 1=1";
                if (!empty($filtro_nombre)) {
                    $count_sql .= " AND (P.Nombres LIKE ? OR P.Ap_paterno LIKE ? OR P.Ap_materno LIKE ?)";
                }
                if (!empty($filtro_cuenta)) {
                    $count_sql .= " AND C.ID = ?";
                }

                $stmt_count = $conexion->prepare($count_sql);
                if ($types) $stmt_count->bind_param($types, ...$params);
                $stmt_count->execute();
                $stmt_count->bind_result($total_rows);
                $stmt_count->fetch();
                $stmt_count->close();

                $total_pages = ceil($total_rows / $records_per_page);

                // Agregar paginación
                $sql .= " ORDER BY P.ID_Persona DESC LIMIT ? OFFSET ?";
                $params[] = $records_per_page;
                $params[] = $offset;
                $types .= "ii";

                $stmt = $conexion->prepare($sql);
                if ($types) $stmt->bind_param($types, ...$params);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['ID_Persona']; ?></td>
                            <td><?php echo $row['Nombres'] . ' ' . $row['Ap_paterno'] . ' '. $row['Ap_materno'];?></td>
                            <td><?php echo $row['NombreCuenta']; ?></td>
                            <td>
                                <a class='btn btn-warning' href="Update/Update_Persona_RH.php?id=<?php echo $row['ID_Persona']; ?>">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-edit' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='#000000' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                        <path d='M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1' />
                                        <path d='M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z' />
                                        <path d='M16 5l3 3' />
                                    </svg>Editar
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="mostrarFotos(<?php echo $row['ID_Persona']; ?>)">Ver Fotos</button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No se encontraron registros.</td></tr>";
                }

                $stmt->close();
            ?>
        </tbody>
    </table>

    <!-- Modal para mostrar las fotos -->
    <div class="modal fade" id="fotosModal" tabindex="-1" aria-labelledby="fotosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fotosModalLabel">Fotos del Recluta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="fotoFrente" src="" class="img-fluid" alt="Foto Frente">
                            <p class="text-center mt-2">Foto Frente</p>
                        </div>
                        <div class="col-md-4">
                            <img id="fotoIzquierda" src="" class="img-fluid" alt="Foto Izquierda">
                            <p class="text-center mt-2">Foto Izquierda</p>
                        </div>
                        <div class="col-md-4">
                            <img id="fotoDerecha" src="" class="img-fluid" alt="Foto Derecha">
                            <p class="text-center mt-2">Foto Derecha</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

</div>
</center>

<script src="../../js/MostrarFotosPersona.js"></script>

<?php include('footer.php'); ?>