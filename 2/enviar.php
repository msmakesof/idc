<?php
$name = $_POST['name'];
$email = $_POST['email'];
$mensaje = $_POST['message'];


$NombreRes = strtoupper($name);
$user_email = trim($email);	

$subject = "**  Solicitud Informacion desde la Web. **" ;

$enviado = "N";
//Create a new PHPMailer instance
include('PHPMailer/src/Exception.php');
include('PHPMailer/src/PHPMailer.php');
include('PHPMailer/src/SMTP.php');

//Especificamos los datos y configuración del servidor
$mail = new PHPMailer(true) ;
try 
{
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug outpu
    //$mail->SMTPDebug = 2;
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = "mail.litigantes.lawyer";              	// Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = "envios@litigantes.lawyer";     		// SMTP username
    $mail->Password   = "Boshika2020$";                         // SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; Puerto 587 OK
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable TLS encryption; Puerto 465 OK
    $mail->Port       = 465;

    //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
    //una cuenta gratuita, por tanto lo pongo a 30  
    $mail->Timeout = 10;
     
    //Agregamos la información que el correo requiere  
    $mail->setFrom($Usuario, "Origen Web.");
    
    ////$mail->FromName = "$TextoCuentaOrigen";
    // destinatario o el asignadoa con la si
    $mail->AddAddress($user_email);
    $mail->AddAddress("msmakesof@gmail.com");

    $mail->Subject = $subject;
    $mail->AltBody = "";
    $mail->MsgHTML($mensaje);	

    $mail->AddAttachment("");

    $mail->isHTML(true);

    //se envia el mensaje, si no ha habido problemas 
    //la variable $exito tendra el valor true
    
    $exito = $mail->Send();

    $intentos = 1; 
    while ((!$exito) && ($intentos < 5)) {
        sleep(5);	
        $exito = $mail->Send();
        $intentos = $intentos+1;	
    }	
    
    //Enviamos el correo electrónico : $mail->Send();
    if(!$exito)	
    {
        echo "EMail Error: {$mail->ErrorInfo}" ;	
    }
    else
    {
        $enviado = "S";			
    }				
}
catch (Exception $e) 
{
    echo "Email Error: {$mail->ErrorInfo}";
}			

//Fin Envio correo 
if ($enviado == "S" )  // && $enviado == "S"
{
    $respuesta = "S";
}
?>