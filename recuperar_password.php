<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require "conexion.php";
require "generador_contraseñas.php";
 
$conexion = $mysqli;

if ($conexion->connect_error) {
    die("Conexion fallida: " . $conexion->connect_error);
}
echo "Conexion exitosa";

$destinatario = $_POST['usuario'];
$contraseña = generar_contraseña(8);
$fecha = date("Y-m-d");
$fecha_vencimiento = date("Y-m-d", strtotime($fecha . ' + 1 days'));
 

//Envio de contraseña a la base de datos
 
if ($_POST) 
{
    $sql = "SELECT id_usuario, correo_electronico
    FROM tbl_ms_usuarios
    WHERE usuario ='$destinatario'";
    
    $resultado = $conexion->query($sql);
    
    $num = $resultado->num_rows;

    if ($num > 0) 
    {
        $row = $resultado->fetch_assoc();
        $id = $row['id_usuario'];
	$correo = $row['correo_electronico'];

        
	$sql = "update tbl_ms_usuarios set contraseña = '$contraseña', fecha_vencimiento = date_add(now(), interval 1 day)
where id_usuario = $id;";
        
	//$resultado = $conexion->query($sql);

	if ($conexion->query($sql)){
	echo "<script>alert('Grabado en la base de datos')</script>";
	}
	

    } else {
        echo "<script>alert('El usuario no existe')</script>";
     //   echo "<script>setTimeout(\"location.href='password.html'\",1000)</script>"; 
    }
}

/*
update pruebas_fechas set fecha1 = '2022-06-29 07:56:50', fecha2 = now()
where idpruebas_fechas = 1; 
select timestampdiff(day, fecha1, date_add(now(), interval 1 day)) diferencia 
from pruebas_fechas where idpruebas_fechas = 1;
update tbl_ms_usuarios set vencimiento_contraseña_temporal = date_add(now(), interval 1 day)
where id_usuario = 2;
 */

    //Envio de correo   

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'mauriciorenecarcamorivera1@gmail.com';                     //SMTP username
        $mail->Password   = 'mcfilaoniaiqnwxo';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('mauriciorenecarcamorivera1@gmail.com', 'NPH');
        $mail->addAddress($correo);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recuperacion de contreseña de NPH ';
        $mail->Body    = 'Esta es su nueva contraseña temporal: <b>' . $contraseña . '</b><br>Expirara dentro de 24 horas, periodo en cual debera cambiar su contraseña';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';

        echo "<script>alert('Correo enviado exitosamente a $destinatario')</script>";
        //echo "<script>setTimeout(\"location.href='index.php'\",1000)</script>";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>