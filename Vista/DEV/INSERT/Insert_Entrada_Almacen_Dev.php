<?php include('head.php'); ?>

<div class="container mt-5">
    <center><h2>Registrar Nueva Entrada Almacén</h2></center>
    <form action="../../../Controlador/DEV/INSERT/Funcion_Insert_Entrada_Almacen.php" method="post" class="needs-validation" novalidate>

<input type="hidden" id="datosTabla" name="datosTabla">

<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header " id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Información General
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="mb-3">
                <label for="Proveedor" class="form-label">Nombre del Proveedor:</label>
                <input type="text" class="form-control" id="Proveedor" name="Proveedor" placeholder="Ingresa el Nombre del Proveedor" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" required>
                <div class="invalid-feedback">
                    Por favor, Ingresa el Nombre del Proveedor.
                </div>
            </div>
    
            <div class="mb-3">
                <label for="Receptor" class="form-label">Nombre del Receptor:</label>
                <input type="text" class="form-control" id="Receptor" name="Receptor" placeholder="Ingresa el Nombre del Receptor" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode == 32)" required>
                <div class="invalid-feedback">
                    Por favor, Ingresa el Nombre del Receptor.
                </div>
            </div>
    
            <div class="mb-3">
                <label for="Comentarios" class="form-label">Comentarios:</label>
                <textarea class="form-control" id="Comentarios" name="Comentarios" placeholder="Ingresa el comentario" required></textarea>
                <div class="invalid-feedback">
                    Por favor, Ingresa el Comentario.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Productos
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <center>
                <div class="mb-2">
                    <button type="button" class="btn btn-info" id="BtnMostrarTablaProductos">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="44" height="44" stroke-width="1.5"> 
                            <path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path> 
                            <path d="M18.5 18.5l2.5 2.5"></path> 
                            <path d="M4 6h16"></path> 
                            <path d="M4 12h4"></path> 
                            <path d="M4 18h4"></path> 
                        </svg>Catalogo</button>
                </div>
            </center>
            <table class="table table-responsive bg-info" id="tabla">
                <tbody>
                    <tr class="fila-fija" data-id="1">
                        <td>
                            <div class="mb-2">
                                <label for="ID_Producto" class="form-label">Codigo:</label>
                                <select class="form-select mb-3" id="ID_Producto" name="ID_Producto[]">
                                    <option value="" selected disabled>-- Seleccionar ID de Producto --</option>
                                    <?php
                                        include('../../../Modelo/Conexion.php'); 
                                        $conexion = (new Conectar())->conexion();
                                    
                                        $sql = $conexion->query("SELECT * FROM Producto;");
                                        while ($resultado = $sql->fetch_assoc()) {
                                            echo "<option value='" . $resultado['IdCProducto'] . "'>" . $resultado['IdCProducto'] . "</option>";
                                        }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor, selecciona una opción.
                                </div>
                            </div>
                        </td>
                        <td colspan="2">                        
                            <div class="mb-2">
                                <label for="ID_Talla" class="form-label">Talla:</label>
                                    <select class="form-select mb-3" id="ID_Talla" name="ID_Talla[]">
                                        <option value="" selected disabled>-- Seleccionar una Talla --</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, Selecciona una Opción.
                                    </div>
                            </div>
                        </td>
                        <td>                        
                            <div class="mb-2">
                                <label for="Cantidad" class="form-label">Cantidad:</label>
                                <input type="text" class="form-control" id="Cantidad" name="Cantidad[]" onkeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" placeholder="Ingresa la Cantidad">
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">
                                <button type="button" class="btn btn-secondary" id="btnMostrarImagen">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-check" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M11.102 17.957c-3.204 -.307 -5.904 -2.294 -8.102 -5.957c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a19.5 19.5 0 0 1 -.663 1.032" />
                                        <path d="M15 19l2 2l4 -4" />
                                    </svg>Mostrar Imagen
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="fila-fija2" data-id="1">
                        <td>
                            <div class="mb-2">
                                <label for="Empresa" class="form-label">Empresa:</label>
                                <input type="text" class="form-control" id="Empresa" name="Empresa[]" placeholder="Ingresa la Empresa" disabled>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">
                                <label for="Categoria" class="form-label">Categoría:</label>
                                <input type="text" class="form-control" id="Categoria" name="Categoria[]" placeholder="Ingresa la Categoría" disabled>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">
                                <label for="Descripcion" class="form-label">Descripción:</label>
                                <input type="text" class="form-control" id="Descripcion" name="Descripcion[]" placeholder="Ingresa la Descripción" disabled>
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="mb-2">
                                <label for="Especificacion" class="form-label">Especificación:</label>
                                <input type="text" class="form-control" id="Especificacion" name="Especificacion[]" placeholder="Ingresa la Especificación" disabled>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>

<br>

        <!-- Botones -->
        <div class="mb-3">
            <button id="btn_Agregar" type="button" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-text-wrap" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 6l16 0" />
                        <path d="M4 18l5 0" />
                        <path d="M4 12h13a3 3 0 0 1 0 6h-4l2 -2m0 4l-2 -2" />
                    </svg>Agregar Producto</button>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>Guardar
            </button>
            <a href="../Almacen_Dev.php" class="btn btn-danger">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>Cancelar
            </a>
        </div>
    </form>

<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="modalImagen">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Imagen del Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
            <center><img src="" alt="Imagen del Producto" id="imagenProducto" style="max-width: 100%;"></center>
        </div>
        <br>
        <div>
            <h6>Descripción:</h6>
            <p id="descripcionProducto"></p>
        </div>
        <div>
            <h6>Especificación:</h6>
            <p id="especificacionProducto"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-dark">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Identificador</th>
            <th scope="col">Empresa</th>
            <th scope="col">Categoría</th>
            <th scope="col">Descripción</th>
            <th scope="col">Especificación</th>
            <th scope="col">Talla</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Cancelar</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    </table>
</div>

    <!-- Modal -->
    <div class="modal fade" id="tablaModal" tabindex="-1" aria-labelledby="tablaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tablaModalLabel">Lista de Productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Buscador -->
                    <input type="text" id="buscador" class="form-control mb-3" placeholder="Buscar producto...">
                    
                    <!-- Tabla -->
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">Identificador</th>
                                <th scope="col">Nombre de Empresa</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Especificación</th>
                                <th scope="col">Talla</th>
                                <th scope="col">Existencias</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCuerpo">
                            <!-- Datos generados dinámicamente -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>