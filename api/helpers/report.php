<?php
// Se incluye la clase para generar archivos PDF.
require_once('../../libraries/fpdf185/fpdf.php');
 
/*
 *   Clase para definir las plantillas de los reportes del sitio privado.
 *   Para más información http://www.fpdf.org/
 */
class Report extends FPDF
{
    // Constante para definir la ruta de las vistas del sitio privado.
    const CLIENT_URL = 'http://localhost/expo_2024_v2/views/admin/';
    // Propiedad para guardar el título del reporte.
    private $title = null;
 
    /*
     *   Método para iniciar el reporte con el encabezado del documento.
     *   Parámetros: $title (título del reporte).
     *   Retorno: ninguno.
     */
    public function startReport($title)
    {
        // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en los reportes.
        session_start();
        // Se verifica si un administrador ha iniciado sesión para generar el documento, de lo contrario se direcciona a la página web principal.
        if (isset($_SESSION['idAdministrador'])) {
            // Se asigna el título del documento a la propiedad de la clase.
            $this->title = $title;
            // Se establecen los margenes del documento (izquierdo, superior y derecho).
            $this->setMargins(15, 15, 15);
            // Se añade una nueva página al documento con orientación vertical y formato carta, llamando implícitamente al método header()
            $this->addPage('p', 'letter');
            // Se define un alias para el número total de páginas que se muestra en el pie del documento.
            $this->aliasNbPages();
        } else {
            header('location:' . self::CLIENT_URL);
        }
    }
 
    /*
     *   Método para codificar una cadena de alfabeto español a UTF-8.
     *   Parámetros: $string (cadena).
     *   Retorno: cadena convertida.
     */
    public function encodeString($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'utf-8');
    }
 
    /*
     *   Se sobrescribe el método de la librería para establecer la plantilla del encabezado de los reportes.
     *   Se llama automáticamente en el método addPage()
     */
    // Aqui va empezar el header
    public function header()
    {
        // Se establece el header.
        $this->image('../../images/Reporte.png', 0, 0, 216);
   
        // Salto de línea para separar el encabezado de la imagen.
        $this->ln(24); // Ajuste el espacio entre la imagen y el texto del encabezado
   
        // Configurar el texto "Asunto" en negrita y alineado a la izquierda.
        $this->setFont('Arial', 'B', 10);
        $this->cell(18, 10, 'Asunto: ', 0, 0, 'L'); // Alineado a la izquierda
   
        // Configurar el título alineado a la izquierda.
        $this->setFont('Arial', '', 10);
        // Ajustar el ancho de la celda para que ocupe el resto del ancho de la página.
        $this->cell(0, 10, $this->encodeString($this->title), 0, 1, 'L');
   
        // Configurar el texto "Fecha/Hora" en negrita y alineado a la izquierda.
        $this->setFont('Arial', 'B', 10); // Negrita
        $this->cell(18, 5, 'Fecha: ', 0, 0, 'L'); // Alineado a la izquierda
       
        // Configurar la fecha y hora en texto normal.
        $this->setFont('Arial', '', 10);
        $this->cell(0, 5, date('d-m-Y H:i:s'), 0, 1, 'L'); // Alineado a la izquierda
   
        // Asegurarse de que haya suficiente espacio antes de comenzar con el contenido.
        $this->ln(5); // Ajuste el espacio después del encabezado
    }
   
    /*
     *   Se sobrescribe el método de la librería para establecer la plantilla del pie de los reportes.
     *   Se llama automáticamente en el método output()
     */
    public function footer()
    {
        // Se establece la posición para el número de página (a 15 milímetros del final).
        $this->setY(-20);
        // Se establece la fuente para el número de página.
        $this->setFont('Arial', 'I', 9);
        // Se imprime una celda con el número de página.
        $this->cell(0, 10, $this->encodeString('Página ') . $this->pageNo() . '/{nb}', 0, 0, 'C');
    }
}