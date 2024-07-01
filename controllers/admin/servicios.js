// Obtener el input de carga de imagen y la imagen
var imageUpload = document.getElementById("imageUpload");
var serviceImage = document.getElementById("serviceImage");

 // Cuando el usuario hace clic en la imagen, abre el input de carga de imagen
 serviceImage.onclick = function() {
    imageUpload.click();
}

// Cuando el usuario selecciona una imagen, cambia la imagen mostrada
imageUpload.onchange = function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        serviceImage.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}