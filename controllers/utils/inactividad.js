const tiempoInactividad = 1000000; // 1 minuto en milisegundos
const tiempoAdvertencia = 500000; // 50 segundos en milisegundos
let temporizador;
let temporizadorAdvertencia;
let countdownInterval;
let tiempoUltimaActividad = Date.now();
let advertenciaMostrada = false;

// Función para resetear el temporizador de inactividad
const resetearTemporizador = () => {
    clearTimeout(temporizador);
    clearTimeout(temporizadorAdvertencia);
    clearInterval(countdownInterval); // Limpiar temporizador de cuenta atrás
    advertenciaMostrada = false;
    tiempoUltimaActividad = Date.now();

    // Configurar temporizador para advertencia y cierre de sesión
    temporizadorAdvertencia = setTimeout(mostrarAdvertencia, tiempoAdvertencia);
    temporizador = setTimeout(cerrarSesion, tiempoInactividad);
};

// Función para mostrar la advertencia con sweetAlert2
const mostrarAdvertencia = () => {
    if (!advertenciaMostrada) {
        advertenciaMostrada = true;
        const tiempoRestante = Math.max(0, Math.ceil((tiempoInactividad - (Date.now() - tiempoUltimaActividad)) / 1000));

        // Usar sweetAlert existente
        sweetAlert(3, `Tu sesión está a punto de expirar. Tiempo restante: ${tiempoRestante} segundos`, true);

        countdownInterval = setInterval(() => {
            const tiempoRestante = Math.max(0, Math.ceil((tiempoInactividad - (Date.now() - tiempoUltimaActividad)) / 1000));
            // Aquí puedes agregar una lógica para actualizar la cuenta regresiva si la necesitas.
        }, 1000);
    }
};

// Función para cerrar sesión
const cerrarSesion = async () => {
    // Petición para eliminar la sesión.
    const DATA = await fetchData(USER_API, 'logOut');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        sweetAlert(1, DATA.message, true, 'index.html');
    } else {
        sweetAlert(2, DATA.exception, false);
    }
};

// Función para comprobar inactividad
const comprobarInactividad = () => {
    if (Date.now() - tiempoUltimaActividad > tiempoInactividad) {
        cerrarSesion();
    }
};

// Manejador de eventos de actividad (scroll, mousemove, keypress)
document.addEventListener('mousemove', resetearTemporizador);
document.addEventListener('keypress', resetearTemporizador);
document.addEventListener('scroll', resetearTemporizador);

// Revisar la inactividad en intervalos regulares
setInterval(comprobarInactividad, 1000); // Comprobar cada segundo

// Iniciar temporizadores al cargar la página
resetearTemporizador();