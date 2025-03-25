<?php include('head.php'); ?>

<center><div class="table-responsive">
    <style>
        .hidden {
            display: none;
        }
    </style>
    <h2 class="mb-4">Personas Registradas</h2>
    <!-- Botones -->
    <a class="btn btn-primary" href="INSERT/Insert_Recluta_RH.php">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
            <path d="M16 19h6" />
            <path d="M19 16v6" />
            <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
        </svg>Nuevo</a>

    <form method="GET" class="form-inline d-flex justify-content-end mb-4">
        <div class="form-group mb-2">
            <label for="filtrar" class="mr-2">Filtrar por:</label>
            <select class="form-select" id="filtrar" name="filtrar" onchange="mostrarCampo()" required>
                <option value="" selected disabled>Escogue una opcion</option>
                <option value="CNombre">Nombre o Apellidos</option>
                <option value="CEstatus">Estatus</option>
                <option value="CReclutador">Reclutador</option>
            </select>
        </div>

        <!-- Campos dinámicos -->
        <div id="campo-nombres" class="form-group mb-2">
            <label for="nombre" class="mr-2">Ingresa Nombre o Apellidos:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" >
        </div>

        <div id="campo-estatus" class="form-group mb-2">
            <label for="estatus" class="mr-2">Selecciona Estatus:</label>
            <select class="form-select" id="estatus" name="estatus">
                <option value="">Todos</option>
                <option value="Seleccionado" <?php if ($estatus === 'Seleccionado') echo 'selected'; ?>>Seleccionado</option>
                <option value="Pendiente" <?php if ($estatus === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                <option value="En entrevista" <?php if ($estatus === 'En entrevista') echo 'selected'; ?>>En entrevista</option>
                <option value="Aceptado" <?php if ($estatus === 'Aceptado') echo 'selected'; ?>>Aceptado</option>
                <option value="Otro" <?php if ($estatus === 'Otro') echo 'selected'; ?>>Otro</option>
            </select>
        </div>

        <div id="campo-reclutador" class="form-group mb-2">
            <label for="reclutador" class="mr-2">Ingresa Reclutador:</label>
            <input type="text" id="reclutador" name="reclutador" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Filtrar</button>
        <button type="button" class="btn btn-danger" onclick="resetFilters()">Limpiar</button>
    </form>

    <!-- Tabla para mostrar los registros -->
    <table id="tablaReclutas" class="table table-hover table-striped mt-4">
        <thead>
            <tr class="table-primary"> 
                <th scope="col">Nmr.</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Estatus</th>
                <th scope="col">Observaciones</th>
                <th scope="col">Reclutador</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                include('../../Modelo/Conexion.php'); 
                $conexion = (new Conectar())->conexion();

                // Obtener los filtros desde el formulario
                $Nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
                $Estatus = isset($_GET['estatus']) ? $_GET['estatus'] : '';
                $Reclutador = isset($_GET['reclutador']) ? $_GET['reclutador'] : '';

                // Parámetros para la paginación
                $records_per_page = 10;
                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $records_per_page;

                // Consulta SQL base
                $sql = "SELECT ID_Recluta, Nombre, AP_Paterno, AP_Materno, Estatus, Observaciones, Reclutador 
                        FROM Recluta WHERE 1=1";
                $params = [];
                $types = "";

                if (!empty($Nombre)) {
                    $sql .= " AND (Nombre LIKE ? OR AP_Paterno LIKE ? OR AP_Materno LIKE ?)";
                    $params[] = "%$Nombre%";
                    $params[] = "%$Nombre%";
                    $params[] = "%$Nombre%";
                    $types .= "sss";
                }
                if (!empty($Estatus)) {
                    $sql .= " AND Estatus = ?";
                    $params[] = $Estatus;
                    $types .= "s";
                }
                if (!empty($Reclutador)) {
                    $sql .= " AND Reclutador LIKE ?";
                    $params[] = "%$Reclutador%";
                    $types .= "s";
                }

                // Contar total de registros
                $count_sql = str_replace("SELECT ID_Recluta, Nombre, AP_Paterno, AP_Materno, Estatus, Observaciones, Reclutador", "SELECT COUNT(*)", $sql);
                $stmt_count = $conexion->prepare($count_sql);
                if ($types) $stmt_count->bind_param($types, ...$params);
                $stmt_count->execute();
                $stmt_count->bind_result($total_rows);
                $stmt_count->fetch();
                $stmt_count->close();

                $total_pages = ceil($total_rows / $records_per_page);

                // Agregar paginación
                $sql .= " ORDER BY ID_Recluta DESC LIMIT ? OFFSET ?";
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
                            <td><?php echo $row['ID_Recluta']; ?></td>
                            <td><?php echo $row['Nombre'] . ' ' . $row['AP_Paterno'] . ' '. $row['AP_Materno'];?></td>
                            <td><?php echo $row['Estatus']; ?></td>
                            <td><?php echo $row['Observaciones']; ?></td>
                            <td><?php echo $row['Reclutador']; ?></td>
                            <td>
                                <a class='btn btn-warning' href="Update/Update_Recluta_RH.php?id=<?php echo $row['ID_Recluta']; ?>">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-edit' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='#000000' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                                        <path stroke='none' d='M0 0h24V0H24z' fill='none'/>
                                        <path d='M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1' />
                                        <path d='M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z' />
                                        <path d='M16 5l3 3' />
                                    </svg>Editar
                                </a>
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

<script src="../../js/Filtro_Reclutas.js"></script>

<?php include('footer.php'); ?>