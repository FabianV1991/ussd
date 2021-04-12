<?php
require("/home/prepago/apps/tp/lib/class.phpmailer.php");
$MAILCC="soporte@allware.cl";
$FECHA=date("Y-m-d");
$FECHA_REPORTE=date("Ymd");

//envio EMAIL
$mail = new PHPMailer();
$mail->From = "SoporteOperacional@entel.cl";
$mail->FromName = "Soporte Prepago";

$mail->addAddress('ovaspp@entel.cl','IAADIAZ@entel.cl','CPFLORES@entel.cl','MAQUIJADA@entel.cl','RMNUNEZ@entel.cl');
##$mail->addAddress('IAADIAZ@entel.cl');
##$mail->addAddress('CPFLORES@entel.cl');
##$mail->addAddress('MAQUIJADA@entel.cl');
##$mail->addAddress('RMNUNEZ@entel.cl');

$mail->AddCC($MAILCC);
$mail->Subject = "Reporte USSD $FECHA";
$mail->IsHTML(true);
$mail->AddAttachment("/home/prepago/apps/WIQ/XLS/REPORTE_USSD_$FECHA_REPORTE.xls");
$mail->Body =  $contenido.'
<p>Estimados:</p>
<blockquote>Se adjunta planilla con informacion de trafico USSD de la ultima semana.</blockquote>
<p>Saludos,</p>
<p>Soporte Prepago </p>
';


$mail->IsHTML(true);                               // send as HTML
$mail->AltBody  =  "Reporte USSD $FECHA";



if(!$mail->Send())
{
echo 'Message was not sent.';
echo 'Mailer error: ' . $mail->ErrorInfo;
}
else
echo "Message sent";


exit();

?>
