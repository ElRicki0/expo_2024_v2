// Constantes para completar las rutas de la API.
const SERVICIO_API = 'services/public/servicio.php';
const COMENTARIO_API = 'services/public/comentario.php';
const EMPLEADO_API = 'services/public/empleado.php';

// Constantes para establecer el contenido de la tabla.
const SERVICIOS = document.getElementById('accordionFlushExample');
const COMENTARIOS1 = document.getElementById('comentarios1');
const COMENTARIOS2 = document.getElementById('comentarios2');
const COMENTARIOS3 = document.getElementById('comentarios3');

const EMPLEADO1 = document.getElementById('empleado1');
const EMPLEADO2 = document.getElementById('empleado2');
const EMPLEADO3 = document.getElementById('empleado3');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    tablaComentarios1();
    tablaComentarios2();
    tablaComentarios3();
    tablaEmpleados1();
    tablaEmpleados2();
    tablaEmpleados3();

    // método para llenar los servicios con mayores citas
    fillTable();
})

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    PREGUNTA.innerHTML = '';
    // Arreglo con los nombres de los números en inglés.
    const numbersInEnglish = ['One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight'];

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PREGUNTA_API, 'readAll8', form);

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row, index) => {
            let valor = numbersInEnglish[index % numbersInEnglish.length]; // Asigna el número en inglés basado en el índice.
            let url = `detalles.html?id=${row.id_pregunta}`;

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            SERVICIOS.innerHTML += `
<!-- cards de acordeón -->
<div class="accordion-item inicioIndex">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed inicioIndex textoClaro" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapse${valor}" aria-expanded="false" aria-controls="flush-collapse${valor}">
            ${row.nombre_pregunta}
        </button>
    </h2>
    <div id="flush-collapse${valor}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body textoClaro">
            <div class="row">
                <div class="col-lg-2">
                    <img src="${SERVER_URL}images/servicios/${row.imagen_pregunta}" width="150px" class="card" onerror="this.onerror=null; this.src='../../resources/img/error/preguntaFrecuente.png';"
                        alt="${row.nombre_pregunta}">
                </div>
                <div class="col-lg-10">
                    <h1 class="mb-3 title-card">${row.nombre_pregunta}</h1>
                    <p>${row.contenido_pregunta}</p>
                </div>
            </div>
        </div>
    </div>
</div>
`;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}


/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaComentarios1 = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(COMENTARIO_API, 'readIndex', form);

    COMENTARIOS1.innerHTML = ``;


    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            COMENTARIOS1.innerHTML += `

<div class="col-md-4">
    <div class="card">
        <img src="${SERVER_URL}images/servicios/${row.imagen_servicio}" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">${row.tipo_servicio}</h5>
            <p class="card-text">${row.contenido_comentario}</p>
            <p class="text-secondary">${row.nombre_cliente}</p>
        </div>
    </div>
</div>

`;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaComentarios2 = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(COMENTARIO_API, 'readIndex', form);

    COMENTARIOS2.innerHTML = ``;
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            COMENTARIOS2.innerHTML += `

<div class="col-md-4">
    <div class="card">
        <img src="${SERVER_URL}images/servicios/${row.imagen_servicio}" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">${row.tipo_servicio}</h5>
            <p class="card-text">${row.contenido_comentario}</p>
            <p class="text-secondary">${row.nombre_cliente}</p>
        </div>
    </div>
</div>

`;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaComentarios3 = async (form = null) => {
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(COMENTARIO_API, 'readIndex', form);
    COMENTARIOS3.innerHTML = ``;
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            COMENTARIOS3.innerHTML += `

<div class="col-md-4">
    <div class="card">
        <img src="${SERVER_URL}images/servicios/${row.imagen_servicio}" class="card-img-top" alt="..." onerror="this.onerror=null; this.src='../../resources/img/error/';">
        <div class="card-body">
            <h5 class="card-title">${row.tipo_servicio}</h5>
            <p class="card-text">${row.contenido_comentario}</p>
            <p class="text-secondary">${row.nombre_cliente}</p>
        </div>
    </div>
</div>
`;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaEmpleados1 = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(EMPLEADO_API, 'readIndex', form);

    EMPLEADO1.innerHTML = ``;


    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            EMPLEADO1.innerHTML += `
<div class="col-4">
    <div class="card quirpracticos" style="width: 18rem; background-color: black;">
        <img src="${SERVER_URL}images/empleados/${row.imagen_empleado}" class="card-img-top" alt="..." onerror="this.onerror=null; this.src='../../resources/img/error/empleado.jpg';">
        <div class="card-body">
            <h4 class="justify-content-center text-center">${row.nombre_empleado}</h4>
            <p class="card-text">${row.especialidad_empleado}</p>
        </div>
    </div>
</div>

`;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaEmpleados2 = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(EMPLEADO_API, 'readIndex', form);

    EMPLEADO2.innerHTML = ``;


    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            EMPLEADO2.innerHTML += `
<div class="col-4">
    <div class="card quirpracticos" style="width: 18rem; background-color: black;">
        <img src="${SERVER_URL}images/empleados/${row.imagen_empleado}" class="card-img-top" alt="..." onerror="this.onerror=null; this.src='../../resources/img/error/empleado.jpg';">
        <div class="card-body">
            <h4 class="justify-content-center text-center">${row.nombre_empleado}</h4>
            <p class="card-text">${row.especialidad_empleado}</p>
        </div>
    </div>
</div>

`;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaEmpleados3 = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(EMPLEADO_API, 'readIndex', form);

    EMPLEADO3.innerHTML = ``;


    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            EMPLEADO3.innerHTML += `
<div class="col-4">
    <div class="card quirpracticos" style="width: 18rem; background-color: black;">
        <img src="${SERVER_URL}images/empleados/${row.imagen_empleado}" class="card-img-top" alt="..." onerror="this.onerror=null; this.src='../../resources/img/error/empleado.jpg';">
        <div class="card-body">
            <h4 class="justify-content-center text-center">${row.nombre_empleado}</h4>
            <p class="card-text">${row.especialidad_empleado}</p>
        </div>
    </div>
</div>

`;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}