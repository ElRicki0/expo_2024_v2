// Codigo de validacion campo telefonico
function formatPhoneNumber(input) {

    // Obtener el valor actual del campo de entrada
    let phoneNumber = input.value;

    // Eliminar cualquier guion existente
    phoneNumber = phoneNumber.replace(/-/g, '');

    // Validar que solo se permitan números y el formato XXXX-XXXX
    let phoneNumberPattern = /^[0-9]{4}-?[0-9]{4}$/;
    if (!phoneNumberPattern.test(phoneNumber)) {

        // Mostrar mensaje de error
        input.classList.add("is-invalid");
    }

    // En caso de pasar el test del formato
    else {
        input.setCustomValidity("");
        input.classList.remove("is-invalid");
    }

    // Agregar el guion después del cuarto dígito si no se ha agregado anteriormente
    if (phoneNumber.length >= 5 && phoneNumber.charAt(4) !== '-') {
        phoneNumber = phoneNumber.slice(0, 4) + '-' + phoneNumber.slice(4);
    }

    // Establecer el valor formateado en el campo de entrada
    input.value = phoneNumber;

    // Limitar la cantidad máxima de caracteres a 9
    if (phoneNumber.length >= 9) {
        input.value = phoneNumber.slice(0, 9);
        input.setAttribute("maxlength", "9");
    }
    
    else {
        input.removeAttribute("maxlength");
    }
}

// Codigo de validacion de campo email
function formatEmail(input) {

    // Obtener el valor actual del campo de entrada
    let Email = input.value;

    // Validar formato de correo electrónico
    let emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
    if (!emailPattern.test(Email)) {

        // Mostrar mensaje de error
        input.classList.add("is-invalid");
    }

    // En caso de pasar el test del formato
    else {
        input.setCustomValidity("");
        input.classList.remove("is-invalid");
    }

    // Establecer el valor formateado en el campo de entrada
    input.value = Email;
}

// Codigo de validacion de campo de contraseña
function formatPassword(input) {

    // Obtener el valor actual del campo de entrada
    let Contraseña = input.value;

    // Validar longitud mínima de contraseña
    if (Contraseña.length < 8) {

        // Mostrar mensaje de error
        input.classList.add("is-invalid");
    }

    // En caso de pasar el test del formato
    else {
        input.setCustomValidity("");
        input.classList.remove("is-invalid");
    }

    // Establecer el valor formateado en el campo de entrada
    input.value = Contraseña;
}

// Codigo de validacion de campo de Dui
function formatDui(input) {

    // Obtener el valor actual del campo de entrada
    let Dui = input.value;

    // Eliminar cualquier guion presente en el valor del campo
    Dui = Dui.replace(/-/g, '');

    // Agregar el guion después del cuarto dígito si no se ha agregado anteriormente
    if (Dui.length >= 9 && Dui.charAt(8) !== '-') {
        Dui = Dui.slice(0, 8) + '-' + Dui.slice(8);
    }

    // Establecer el formato de tipo Dui
    let duiPattern = /^\d{8}-\d$/;
    if (!duiPattern.test(Dui)) {

        // Mostrar mensaje de error
        input.classList.add("is-invalid");
    }

    // En caso de pasar el test del formato
    else {
        input.setCustomValidity("");
        input.classList.remove("is-invalid");
    }

    // Establecer el valor formateado en el campo de entrada
    input.value = Dui;

    // Limitar la cantidad máxima de caracteres a 10
    if (Dui.length >= 10) {
        input.value = Dui.slice(0, 10);
        input.setAttribute("maxlength", "10");
    }

    else {
        input.removeAttribute("maxlength");
    }
}

// Codigo de validacion de campo alfabetico
function formatAlphabetic(input) {

    // Obtener el valor actual del campo de entrada
    let Text = input.value;

    // Establecer el formato del texto
    let TextPattern = /^[a-zA-ZñÑáÁéÉíÍóÓúÚ\s]+$/;
    if (!TextPattern.test(Text)) {

        // Mostrar mensaje de error
        input.classList.add("is-invalid");
    }

    // En caso de pasar el test del formato
    else {
        input.setCustomValidity("");
        input.classList.remove("is-invalid");
    }

    // Establecer el valor formateado en el campo de entrada
    input.value = Text;
}

// Codigo de validacion de campo de precio
function formatDolar(input) {

    // Obtener el valor actual del campo de entrada
    let Dolar = input.value;

    // Establecer el formato del precio
    let DolarPattern = /^[0-9]+(?:\.[0-9]{1,2})?$/;
    if (!DolarPattern.test(Dolar)) {

        // Mostrar mensaje de error
        input.classList.add("is-invalid");
    }

    // En caso de pasar el test del formato
    else {
        input.setCustomValidity("");
        input.classList.remove("is-invalid");
    }

    // Verificar si ya se agregó el punto antes del penúltimo dígito
    let indexOfDot = Dolar.lastIndexOf(".");
    if (indexOfDot === -1 || indexOfDot !== Dolar.length - 3) {

        // Si no se ha agregado, agregar el punto antes del penúltimo dígito
        Dolar = Dolar + ".00";
    }

    // Verificar si el valor es 0 y mostrar el mensaje de error
    if (Dolar == '0.00') {

        // Mostrar mensaje de error
        document.getElementById("mensaje-error").style.display = "block";
    }

    else {

        // En caso de pasar el test
        document.getElementById("mensaje-error").style.display = "none";
    }

    // Establecer el valor formateado en el campo de entrada
    input.value = Dolar;
}

// Codigo de validacion y proceso de imagen
function formatImg(input) {

    // Obtener el archivo de imagen seleccionado
    var archivoImagen = input.files[0];

    // Crear un objeto de FileReader
    var lectorImagen = new FileReader();

    // Definir la función de carga del lector de imágenes
    lectorImagen.onload = function (eventoCarga) {

        // Crear un elemento de imagen y establecer la vista previa
        var imagenPrev = document.createElement('img');
        imagenPrev.src = eventoCarga.target.result;

        // Mostrar la vista previa en el contenedor correspondiente
        var contenedorPrev = document.getElementById('vista-previa');
        contenedorPrev.innerHTML = '';
        contenedorPrev.appendChild(imagenPrev);
    };

    // Validar datos indefinidos o vacios
    if (input.files && input.files[0]) {

        // Leer el archivo de imagen como una URL de datos
        lectorImagen.readAsDataURL(archivoImagen);

        // Eliminar el mensaje de error
        document.getElementById("mensaje-error-previa").style.display = "none";
    }

    else {

        // Mostrar mensaje de error
        document.getElementById("mensaje-error-previa").style.display = "block";

        // Vaciar contenedor 
        contenedorPrev.src = '';
    }
}

// Codigo de validacion de Combo Box
function formatCombo(input) {

    // Obtener el valor seleccionado del combobox
    let valorSeleccionado = input.value;

    // Si no se ha seleccionado ninguna opción
    if (!valorSeleccionado) {

        // Mostrar mensaje de error
        input.classList.add("is-invalid");
    }

    // En caso de pasar el test del formato
    else {
        input.setCustomValidity("");
        input.classList.remove("is-invalid");
    }

    // Establecer el valor formateado en el campo de entrada
    input.value = valorSeleccionado
}

function validarFecha(input) {
    // Obtener la fecha actual
    var fechaActual = new Date();

    // Calcular la fecha hace 18 años
    var fechaHace18Anios = new Date(fechaActual.getFullYear() - 18, fechaActual.getMonth(), fechaActual.getDate());

    // Establecer el valor del input a la fecha hace 18 años
    input.value = fechaHace18Anios.toISOString().split('T')[0];

    // Obtener la fecha ingresada en el campo de entrada
    var fechaIngresada = new Date(input.value);

    // Comparar la fecha ingresada con la fecha hace 18 años
    if (fechaIngresada >= fechaHace18Anios) {
        // Agregar la clase "is-invalid" al campo de entrada
        input.classList.add('is-invalid');
    } else {
        // Remover la clase "is-invalid" del campo de entrada
        input.classList.remove('is-invalid');
    }
}

// Lógica para validar el formulario y habilitar el botón de submit
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()