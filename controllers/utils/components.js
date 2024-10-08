/*
*   CONTROLADOR DE USO GENERAL EN TODAS LAS PÁGINAS WEB.
*/
// Constante para establecer la ruta base del servidor.
const SERVER_URL = 'http://localhost/expo_2024_v2/api/';

/*
*   Función para mostrar un mensaje de confirmación.
*   Requiere la librería sweetalert para funcionar.
*   Parámetros: message (mensaje de confirmación).
*   Retorno: resultado de la promesa.
*/
const confirmAction = (message) => {
    return swal({
        title: 'Advertencia',
        text: message,
        icon: 'warning',
        closeOnClickOutside: false,
        closeOnEsc: false,
        buttons: {
            cancel: {
                text: 'No',
                value: false,
                visible: true
            },
            confirm: {
                text: 'Sí',
                value: true,
                visible: true
            }
        }
    });
}


/*
*   Función asíncrona para manejar los mensajes de notificación al usuario.
*   Requiere la librería sweetalert para funcionar.
*   Parámetros: type (tipo de mensaje), text (texto a mostrar), timer (uso de temporizador) y url (valor opcional con la ubicación de destino).
*   Retorno: ninguno.
*/
const sweetAlert = async (type, text, timer, url = null) => {
    // Se compara el tipo de mensaje a mostrar.
    switch (type) {
        case 1:
            title = 'Éxito';
            icon = 'success';
            break;
        case 2:
            title = 'Error';
            icon = 'error';
            break;
        case 3:
            title = 'Advertencia';
            icon = 'warning';
            break;
        case 4:
            title = 'Aviso';
            icon = 'info';
    }
    // Se define un objeto con las opciones principales para el mensaje.
    let options = {
        title: title,
        text: text,
        icon: icon,
        closeOnClickOutside: false,
        closeOnEsc: false,
        button: {
            text: 'Aceptar'
        }
    };
    // Se verifica el uso del temporizador.
    (timer) ? options.timer = 3000 : options.timer = null;
    // Se muestra el mensaje.
    await swal(options);
    // Se direcciona a una página web si se indica.
    (url) ? location.href = url : undefined;
}


/*
*   Función asíncrona para cargar las opciones en un select de formulario.
*   Parámetros: filename (nombre del archivo), action (acción a realizar), select (identificador del select en el formulario) y filter (dato opcional para seleccionar una opción o filtrar los datos).
*   Retorno: ninguno.
*/
const fillSelect = async (filename, action, select, filter = undefined) => {
    // Se verifica si el filtro contiene un objeto para enviar a la API.
    const FORM = (typeof (filter) == 'object') ? filter : null;
    // Petición para obtener los datos.
    const DATA = await fetchData(filename, action, FORM);
    let content = '';
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje.
    if (DATA.status) {
        content += '<option value="" selected>Seleccione una opción</option>';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se obtiene el dato del primer campo de la sentencia SQL.
            value = Object.values(row)[0];
            // Se obtiene el dato del segundo campo de la sentencia SQL.
            text = Object.values(row)[1];
            // Se verifica el valor del filtro para enlistar las opciones.
            const SELECTED = (typeof (filter) == 'number') ? filter : null;
            if (value != SELECTED) {
                content += `<option value="${value}">${text}</option>`;
            } else {
                content += `<option value="${value}" selected>${text}</option>`;
            }
        });
    } else {
        content += '<option>No hay opciones disponibles</option>';
    }
    // Se agregan las opciones a la etiqueta select mediante el id.
    document.getElementById(select).innerHTML = content;
}

/*
*   Función para generar una paleta de colores
*   Parámetros: ninguno.
*   Retorno: xAsis.
*/
const generateColorPalette = (numColors) => {
    const palette = [];
    const baseColors = [[253, 222, 17], [94, 200, 245], [64, 169, 136], [255, 78, 78], [35, 51, 198]]; // Colores base RGB

    for (let i = 0; i < numColors; i++) {
        const baseColor = baseColors[i % baseColors.length]; // Rotar entre los colores base
        const variation = (i / numColors) * 0.5; // Variación de brillo entre 0 y 0.5
        const r = Math.round(baseColor[0] * (1 - variation));
        const g = Math.round(baseColor[1] * (1 - variation));
        const b = Math.round(baseColor[2] * (1 - variation));
        const color = `rgba(${r}, ${g}, ${b}, 1)`; // Opacidad de 1
        palette.push(color);
    }

    return palette;
}

/*
*   Función para generar un gráfico de barras verticales.
*   Requiere la librería chart.js para funcionar.
*   Parámetros: canvas (identificador de la etiqueta canvas), xAxis (datos para el eje X), yAxis (datos para el eje Y), legend (etiqueta para los datos) y title (título del gráfico).
*   Retorno: ninguno.
*/
const barGraph = (canvas, xAxis, yAxis, legend, title) => {
    const colors = generateColorPalette(xAxis.length); // Generar paleta de colores
    // Se generan códigos hexadecimales de 6 cifras de acuerdo con el número de datos a mostrar y se agregan al arreglo.
    xAxis.forEach(() => {
        colors.push('#' + (Math.random().toString(16)).substring(2, 8));
    });
    // Se crea una instancia para generar el gráfico con los datos recibidos.
    new Chart(document.getElementById(canvas), {
        type: 'bar',
        data: {
            labels: xAxis,
            datasets: [{
                label: legend,
                data: yAxis,
                backgroundColor: colors
            }]
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        color: 'white' // Cambia el color del texto en el eje x a blanco
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)' // Cambia el color de las líneas de la cuadrícula en el eje x a blanco
                    }
                },
                y: {
                    ticks: {
                        color: 'white' // Cambia el color del texto en el eje y a blanco
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)' // Cambia el color de las líneas de la cuadrícula en el eje y a blanco
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: title,
                    color: 'white' // Cambia el color del texto del título a blanco
                },
                legend: {
                    display: legend ? true : false,
                    labels: {
                        color: 'white' // Cambia el color del texto en la leyenda a blanco
                    }
                }
            }
        }
    });
}

/*
*   Función para generar un gráfico de radar.
*   Requiere la librería chart.js para funcionar.
*   Parámetros: canvas (identificador de la etiqueta canvas), xAxis (datos para el eje X), yAxis (datos para el eje Y), legend (etiqueta para los datos) y title (título del gráfico).
*   Retorno: ninguno.
*/
const radarGraph = (canvas, legends, values, title) => {
    let colors = values.map(() => '#' + (Math.random().toString(16)).substring(2, 8));

    // Configurar los datos del gráfico
    new Chart(document.getElementById(canvas), {
        type: 'radar',
        data: {
            labels: legends,
            datasets: [{
                label: title,
                data: values,
                backgroundColor: colors,
                borderColor: colors,
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                r: {
                    suggestedMin: 0 // Establecer el mínimo del eje radial a 0
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: title,
                    color: 'white'
                },
                legend: {
                    display: false, // Ocultar la leyenda porque ya tenemos etiquetas en el radar
                }
            }
        }
    });
};

/*
*   Función para generar un gráfico de pastel. Requiere la librería chart.js para funcionar.
*   Parámetros: canvas (identificador de la etiqueta canvas), legends (valores para las etiquetas), values (valores de los datos) y title (título del gráfico).
*   Retorno: ninguno.
*/
const pieGraph = (canvas, legends, values, title) => {
    const numColors = values.length; // Número de colores necesarios
    const colors = generateColorPalette(numColors); // Generar paleta de colores
    // Se crea una instancia para generar el gráfico con los datos recibidos.
    new Chart(document.getElementById(canvas), {
        type: 'pie',
        data: {
            labels: legends,
            datasets: [{
                data: values,
                backgroundColor: colors
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: title,
                    color: 'white' // Cambia el color del texto del título a blanco
                },
                legend: {
                    labels: {
                        color: 'white' // Cambia el color del texto de las leyendas a blanco
                    }
                }
            },
            // Ajustar el color del texto en la parte del gráfico (si es necesario)
            elements: {
                arc: {
                    borderColor: 'white' // Cambia el color del borde de los arcos (opcional)
                }
            }
        }
    });
}

const lineGraph = (canvas, values, yAxis, xAxis, legend, title) => {
    const colors = generateColorPalette(xAxis.length); // Generar paleta de colores
    // Se generan códigos hexadecimales de 6 cifras de acuerdo con el número de datos a mostrar y se agregan al arreglo.
    values.forEach(() => {
        colors.push('#' + (Math.random().toString(16)).substring(2, 8));
    });
    // Se crea una instancia para generar el gráfico con los datos recibidos.
    new Chart(document.getElementById(canvas), {
        type: 'line',
        data: {
            labels: values,
            datasets: [{
                label: legend,
                data: yAxis,
                borderColor: colors,
                fill: false // no rellenar el area bajo la linea
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: title,
                    color: 'white' // Cambia el color del texto del título a blanco

                },
                legend: {
                    labels: {
                        color: 'white' // Cambia el color del texto de las leyendas a blanco
                    }
                }
            },
            // Ajustar el color del texto en la parte del gráfico (si es necesario)
            elements: {
                arc: {
                    borderColor: 'black' // Cambia el color del borde de los arcos (opcional)
                }
            }
        }
    });
}
/*
*   Función para generar un gráfico de dona.
*   Requiere la librería chart.js para funcionar.
*   Parámetros: canvas (identificador de la etiqueta canvas), legends (valores para las etiquetas), values (valores de los datos) y title (título del gráfico).
*   Retorno: ninguno.
*/
const donaGraph = (canvas, legends, values, title) => {
    // Se declara un arreglo para guardar códigos de colores en formato hexadecimal.
    const colors = generateColorPalette(legends.length);
    // Se crea una instancia para generar el gráfico con los datos recibidos.
    new Chart(document.getElementById(canvas), {
        type: 'doughnut',
        data: {
            labels: legends,
            datasets: [{
                data: values,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: title,
                    color: 'white' // Cambia el color del texto del título a blanco
                },
                legend: {
                    labels: {
                        color: 'white' // Cambia el color del texto de las leyendas a blanco
                    }
                }
            },
            // Ajustar el color del texto en la parte del gráfico (si es necesario)
            elements: {
                arc: {
                    borderColor: 'white' // Cambia el color del borde de los arcos (opcional)
                }
            }
        }
    });
}

/*
*   Función asíncrona para cerrar la sesión del usuario.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const logOut = async () => {
    // Se muestra un mensaje de confirmación y se captura la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de cerrar la sesión?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Petición para eliminar la sesión.
        const DATA = await fetchData(USER_API, 'logOut');
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            sweetAlert(1, DATA.message, true, 'index.html');
        } else {
            sweetAlert(2, DATA.exception, false);
        }
    }
}

/*
*   Función asíncrona para intercambiar datos con el servidor.
*   Parámetros: filename (nombre del archivo), action (accion a realizar) y form (objeto opcional con los datos que serán enviados al servidor).
*   Retorno: constante tipo objeto con los datos en formato JSON.
*/
const fetchData = async (filename, action, form = null) => {
    // Se define una constante tipo objeto para establecer las opciones de la petición.
    const OPTIONS = {};
    // Se determina el tipo de petición a realizar.
    if (form) {
        OPTIONS.method = 'post';
        OPTIONS.body = form;
    } else {
        OPTIONS.method = 'get';
    }
    try {
        // Se declara una constante tipo objeto con la ruta específica del servidor.
        const PATH = new URL(SERVER_URL + filename);
        // Se agrega un parámetro a la ruta con el valor de la acción solicitada.
        PATH.searchParams.append('action', action);
        // Se define una constante tipo objeto con la respuesta de la petición.
        const RESPONSE = await fetch(PATH.href, OPTIONS);
        // Se retorna el resultado en formato JSON.
        return await RESPONSE.json();
    } catch (error) {
        // Se muestra un mensaje en la consola del navegador web cuando ocurre un problema.
        console.log(error);
    }
}