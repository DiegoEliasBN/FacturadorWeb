<?php
require_once "../../controladores/ventas.controlador.php";
require_once "../../modelos/ventas.modelo.php";
require_once "../../controladores/retencion.controlador.php";
require_once "../../modelos/retencion.modelo.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
//$retenciones = ControladorRetenciones::ctrMostrarRetencionesEmail();
$respuestaVenta=ControladorVentas::ctrMostrarFacturasEmail();
foreach ($respuestaVenta as $key => $venta) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
	try {
		if ($venta['email'] == '') {
			$mail->ErrorInfo = "El cliente no tiene un correo registrado";
			throw new Exception('Correo no valido');
		}
    	//Server settings
	    $mail->SMTPDebug = 0;                      // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = 'smtpout.secureserver.net';                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'notificaciones@systsolutionsec.com';                     // SMTP username
	    $mail->Password   = 'Syst*2020*';                               // SMTP password
	    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	    $mail->Port       = 80;                                    // TCP port to connect to
	    //Recipients
	    $mail->setFrom('notificaciones@systsolutionsec.com', 'LA TERNERA');
	    $mail->addAddress($venta['email'], $venta['nombre']);     // Add a recipient
	    // Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Factura Electronica';
	    $mail->Body    = "<a href='https://laternera-ec.com/'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/TerneraLogoFactura.png' style='width:605px'> </a>
	    <p>Estimado(a) contribuyente <strong>{$venta['nombre']} </strong>,</p>
            <p>Adjunto sirvase encontrar el siguiente documento electronico emitido en los formatos XML y PDF :</p>
            <table cellspacing='0' cellpadding='0' border='0'>
            <tbody><tr>
            <td>Comprobante Nro.</td><td>: <strong>{$venta['secuencia']}</strong></td>
            </tr><tr>
            <td>Fecha de emision</td><td>: {$venta['fecha']}.</td>
                </tr><tr>
            <td>Valor</td><td>: US$ {$venta['total']}</td>
            </tr><tr>
            <td>Clave de acceso</td><td>: {$venta['claveacceso']}</td>
            </tr>
            <tr>
            <td>Descargar</td><td>:
            <a href='https://sistema.laternera-ec.com/?ruta=sri&ride={$venta['claveacceso']}'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/descargar-pdf.png'></a>
            <a href='https://sistema.laternera-ec.com/?ruta=sri&xml={$venta['claveacceso']}'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/descargar-xml.png'></a>
            </td>
            </tr>
            </tbody></table>
            <p>
            <br>
        			SU FACTURA ELECTRONICA ESTARA DISPONIBLE EN NUESTRA WEB: <b>www.laternera-ec.com</b> <br> INGRESANDO SU NUMERO DE CEDULA.
        			<br>
        			<br>
        			SISTEMA DESARROLLADO POR:
        			<br>
        			<a href='https://laternera-ec.com/'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/FirmaCorreo1.png' style='width:605px'> </a>
        			<br>
        			<br>
            <span style='font-size:12pt; color:#ff0000;'>
                <strong>Este es un mensaje generado y entregado de manera automatica por SystSolutionsEC. No conteste a este correo</strong >
        </span>
        </p>
        <p>(Las tildes han sido omitidas intencionalmente para evitar problemas de lectura).</p>";
		//die('pre envio');	
	    $mail->send();
	    // die( 'Correo enviado con exito');
	} catch (Exception $e) {
    	echo "El correo no pudo ser enviado a . Mailer Error: {$mail->ErrorInfo}";
	}
	$actualizar = ModeloVentas::mdlActualizarVenta('ventas', 'id','estado_email', $venta['id'],1 );
}
/*
foreach ($retenciones as $key => $retencion) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
	try {
		if ($retencion['email'] == '') {
			$mail->ErrorInfo = "El cliente no tiene un correo registrado";
			throw new Exception('Correo no valido');
		}
    	//Server settings
	    $mail->SMTPDebug = 0;                      // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = 'smtpout.secureserver.net';                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 'notificaciones@systsolutionsec.com';                     // SMTP username
	    $mail->Password   = 'Syst*2020*';                               // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	    $mail->Port       = 465;                                    // TCP port to connect to
	    //Recipients
	    $mail->setFrom('notificaciones@systsolutionsec.com', 'LA TERNERA');
	    $mail->addAddress($retencion['email'], $retencion['razon_social']);     // Add a recipient
	    // Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Retencion Electronica';
	    $mail->Body    = "<a href='https://laternera-ec.com/'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/TerneraLogoFactura.png' style='width:605px'> </a>
	    <p>Estimado(a) contribuyente <strong>{$retencion['razon_social']} </strong>,</p>
            <p>Adjunto sirvase encontrar el siguiente documento electronico emitido en los formatos XML y PDF :</p>
            <table cellspacing='0' cellpadding='0' border='0'>
            <tbody><tr>
            <td>Comprobante Nro.</td><td>: <strong>{$retencion['secuencia']}</strong></td>
            </tr><tr>
            <td>Fecha de emision</td><td>: {$retencion['fecha']}.</td>
                </tr><tr>
                <td>Factura</td><td>: {$retencion['numeroComprobante']}.</td>
                </tr><tr>
            <td>Clave de acceso</td><td>: {$retencion['claveacceso']}</td>
            </tr>
            <tr>
            <td>Formato</td><td>
            <a href='https://sistema.laternera-ec.com/?ruta=sri&ride={$retencion['claveacceso']}'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/descargar-pdf.png'></a>
            <a href='https://sistema.laternera-ec.com/?ruta=sri&xml={$retencion['claveacceso']}'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/descargar-xml.png'></a>
            </td>
            </tr>
            </tbody></table>
            <p>
        			<br>
        			<br>
        			SISTEMA DESARROLLADO POR:
        			<br>
        			 <a href='https://laternera-ec.com/'><img src='https://sistema.laternera-ec.com/vistas/img/plantilla/FirmaCorreo1.png' style='width:605px'> </a>
        			<br>
        			<br>
            <span style='font-size:12pt; color:#ff0000;'>
                <strong>Este es un mensaje generado y entregado de manera automatica por SystSolutionsEC. No conteste a este correo</strong >
        </span>
        </p>
        <p>(Las tildes han sido omitidas intencionalmente para evitar problemas de lectura).</p>";
	    $mail->send();
	    echo 'Correo enviado con exito';
	} catch (Exception $e) {
    	echo "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
	}
	$actualizar = ModeloRetenciones::mdlActualizarRetencion('retencion', 'ID','estado_email', $retencion['ID'],1 );
}
*/
