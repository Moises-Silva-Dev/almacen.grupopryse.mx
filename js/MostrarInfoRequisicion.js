// Función para formatear la dirección
function formatearDireccion(data) {
    // Verificar si los datos de dirección están disponibles
    console.log("Verificando datos de dirección:", data);

    let direccion = []; // Array para almacenar los componentes de la dirección

    // Verificar si el nombre de la calle está disponible
    if (data.Mpio && data.Mpio.trim() !== "") {
        console.log("Mpio:", data.Mpio); // Verificar si el municipio no está vacío
        direccion.push(data.Mpio); // Agregar municipio a la dirección
    }

    // Verificar si el nombre de la colonia está disponible
    if (data.Colonia && data.Colonia.trim() !== "") {
        console.log("Colonia:", data.Colonia); // Verificar si la colonia no está vacía
        direccion.push(data.Colonia); // Agregar colonia a la dirección
    }

    // Verificar si el nombre de la calle está disponible
    if (data.Calle && data.Calle.trim() !== "") {
        let calle = data.Calle; // Inicializar la calle con el valor de la propiedad Calle

        // Verificar si el número de la calle está disponible
        if (data.Nro && data.Nro.trim() !== "") {
            calle += " " + data.Nro; // Agregar el número a la calle si está disponible
        }

        console.log("Calle:", calle); // Verificar si la calle no está vacía
        direccion.push(calle); // Agregar calle a la dirección
    }

    // Verificar si el nombre de la localidad está disponible
    if (data.CP && data.CP.trim() !== "") {
        console.log("CP:", data.CP); // Verificar si el código postal no está vacío
        direccion.push("C.P. " + data.CP); // Agregar código postal a la dirección
    }

    // Verificar si el nombre del estado está disponible
    if (data.Nombre_estado && data.Nombre_estado.trim() !== "") { 
        console.log("Nombre_estado:", data.Nombre_estado); // Verificar si el nombre del estado no está vacío
        direccion.push(data.Nombre_estado); // Agregar nombre del estado a la dirección
    }

    // Verificar si la dirección tiene componentes válidos
    let direccionFinal = direccion.length > 0 ? direccion.join(", ") : "No disponible";
    console.log("Dirección final:", direccionFinal); // Verificar la dirección final
    return direccionFinal; // Devolver la dirección formateada
}

// Función para mostrar la información en el modal
function mostrarInfoRequisicion(IDRequisicionE) {
    // Hacer una solicitud al backend para obtener la información de la requisición
    fetch(`../../Controlador/GET/getObetenerInfoRequisicion.php?id=${IDRequisicionE}`)
        .then(response => response.json()) // Convertir la respuesta a JSON
        .then(data => { // Procesar la respuesta
            console.log("Datos recibidos:", data); // Verifica los valores en la consola
            if (data.success) { // Verificar si la solicitud fue exitosa
                // Obtener referencias a los elementos del modal
                document.getElementById("infoDireccion").textContent = formatearDireccion(data.requisicion);
                document.getElementById('infoSupervisor').innerText = data.requisicion.Supervisor;
                document.getElementById('infoCuenta').innerText = data.requisicion.NombreCuenta;
                document.getElementById('infoRegion').innerText = data.requisicion.Nombre_Region;
                document.getElementById('infoCentroTrabajo').innerText = data.requisicion.CentroTrabajo;
                document.getElementById('infoElementos').innerText = data.requisicion.NroElementos;
                document.getElementById('infoReceptor').innerText = data.requisicion.Receptor;
                document.getElementById('infoTelReceptor').innerText = data.requisicion.TelReceptor;
                document.getElementById('infoRfcReceptor').innerText = data.requisicion.RfcReceptor;
                document.getElementById('infoJustificacion').innerText = data.requisicion.Justificacion;

                // Agrupar productos por Descripción y Especificación
                let productosAgrupados = new Map();

                data.productos.forEach(producto => {
                    let key = `${producto.Descripcion}-${producto.Especificacion}`;
                    if (!productosAgrupados.has(key)) {
                        productosAgrupados.set(key, {
                            img: producto.IMG,
                            descripcion: producto.Descripcion,
                            especificacion: producto.Especificacion,
                            tallas: [], // Lista de tallas
                            cantidadesSolicitadas: [], // Lista de cantidades solicitadas
                            cantidadesEntregadas: [] // Lista de cantidades entregadas
                        });
                    }

                    let prod = productosAgrupados.get(key);
                    prod.tallas.push(producto.Talla);
                    prod.cantidadesSolicitadas.push(producto.Cantidad_Solicitada);
                    prod.cantidadesEntregadas.push(producto.Cantidad_Salida);
                });

                // Llenar la tabla de productos
                let tbodyProductos = document.getElementById('productosBody');
                tbodyProductos.innerHTML = ""; // Limpiar el contenido previo de la tabla

                productosAgrupados.forEach(producto => {
                    // Calcular la suma de las cantidades solicitadas y entregadas
                    const totalSolicitada = producto.cantidadesSolicitadas.reduce((acc, cantidad) => acc + parseInt(cantidad), 0);
                    const totalEntregada = producto.cantidadesEntregadas.reduce((acc, cantidad) => acc + parseInt(cantidad), 0);

                    let fila = `<tr>
                                    <td rowspan="${producto.tallas.length + 4}"><center><img src="${producto.img}" alt="Imagen del Producto" width="200" height="300"></center></td>
                                    <th scope="row">Descripción: </th>
                                    <td colspan="2">${producto.descripcion}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Especificación: </th>
                                    <td colspan="2">${producto.especificacion}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tallas</th>
                                    <th scope="row">Cantidad Solicitada</th>
                                    <th scope="row">Cantidad Entregada</th>
                                </tr>`;

                    // Agregar cada talla con su respectiva cantidad solicitada y entregada
                    producto.tallas.forEach((talla, index) => {
                        fila += `<tr>
                                    <td>${talla}</td>
                                    <td>${producto.cantidadesSolicitadas[index]}</td>
                                    <td>${producto.cantidadesEntregadas[index]}</td>
                                </tr>`;
                    });

                    // Fila total
                    fila += `<tr>
                                <td>Total: </td>
                                <td>${totalSolicitada}</td>
                                <td>${totalEntregada}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                            </tr>`;

                    tbodyProductos.innerHTML += fila; // Agregar la fila a la tabla
                });                

                // Mostrar el modal
                let infoModal = new bootstrap.Modal(document.getElementById('requisicionModal'));
                infoModal.show(); // Mostrar el modal con la información
            } else {
                Swal.fire({
                    icon: 'error', // Icono de error
                    title: 'Error', // Título del modal
                    text: 'Error al cargar la información: ' + data.message, // Mensaje de error
                });
            }
        })
        .catch(error => {
            console.error('Error:', error); // Mostrar error en la consola
            Swal.fire({
                icon: 'error', // Icono de error
                title: 'Error', // Título del modal
                text: 'Hubo un problema al cargar la información.', // Mensaje de error
            });
        });
}