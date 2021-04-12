<?php
require("/home/prepago/apps/tp/lib/class.phpmailer.php");
$MAILCC="xxxxxx@xxxxxx.cl";
$FECHA=date("Y-m-d");
$FECHA_REPORTE=date("Ymd");

//envio EMAIL
$mail = new PHPMailer();
$mail->From = "xxxxxxx@entel.cl";
$mail->FromName = "Soporte Prepago";

$mail->addAddress('xxxx@entel.cl','xxxxx@entel.cl','xxxxx@entel.cl','xxxxx@entel.cl','xxxxxx@entel.cl');

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
