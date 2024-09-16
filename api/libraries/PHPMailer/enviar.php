<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'extra/src/Exception.php';
require 'extra/src/PHPMailer.php';
require 'extra/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

    // datos del html
    $emailTo = $_POST["correoAdmin"];
    $subject = $_POST["codigoAdmin"];
    $bodyEmail = '$_POST["codigoAdmin"]';
    $persona = '$_POST["persona"]';

    //Server settings
    $fromemail = "pruevacorreoempresa@gmail.com";
    $fromname = 'Quiropractica Especifica'; // Asegúrate de usar la codificación correcta aquí
    $host = 'smtp.gmail.com';
    $port = 587;
    $SMTAuth = true;
    $_SMTPSecure = "tls";
    $password = "fooqulhjwjumbqdq";

    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $fromemail;                     //SMTP username
    $mail->Password   = $password;                               //SMTP password
    $mail->SMTPSecure = $_SMTPSecure;            //Enable implicit TLS encryption
    $mail->Port       = $port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($fromemail, $fromname);
    $mail->addAddress($emailTo, $persona);     //Add a recipient //Name is optional

    // Definir la variable $body con el contenido HTML y CSS
    $body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo Electrónico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f2f2f2;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .content {
            font-size: 16px;
            color: #333;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #f2f2f2;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</h1>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Este es el cuerpo del mensaje en <strong>' . htmlspecialchars($bodyEmail, ENT_QUOTES, 'UTF-8') . '</strong>!</p>
            <p>Gracias por su atención.</p>
        </div>
        <div class="footer">
            <p>Este es el pie de página. Puede contener información adicional o un mensaje de despedida.</p>
        </div>
    </div>
</body>
</html>
';

    // Configuración del correo usando PHPMailer
    $mail->isHTML(true);  // Establecer formato de correo a HTML
    $mail->Subject = $subject; // Usar el asunto proporcionado
    $mail->Body    = $body;  // Asignar el contenido HTML a la propiedad Body
    $mail->AltBody = 'Este es el cuerpo en texto plano para clientes de correo que no soportan HTML';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
