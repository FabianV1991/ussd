<?php
#####################################
##Autor =       Fabian Vergara     ##
##Area  =       Soporte PP Allware ##
##Fecha =       13/04/2015         ##
#####################################
#error_reporting(E_ALL);
error_reporting(0);
include_once 'Classes/PHPExcel.php';
$DIR="/home/prepago/apps/WIQ/XLS";
$FECHA_ANTERIOR_1=date("Y-m-d", strtotime("$f   -1 day"));
$FECHA_ANTERIOR_2=date("Y-m-d", strtotime("$f   -2 day"));
$FECHA_ANTERIOR_3=date("Y-m-d", strtotime("$f   -3 day"));
$FECHA_ANTERIOR_4=date("Y-m-d", strtotime("$f   -4 day"));
$FECHA_ANTERIOR_5=date("Y-m-d", strtotime("$f   -5 day"));
$FECHA_ANTERIOR_6=date("Y-m-d", strtotime("$f   -6 day"));
$FECHA_ANTERIOR_7=date("Y-m-d", strtotime("$f   -7 day"));
$FECHA=date("Ymd");
$numero=0;
$numero2=1;
echo "comenzando!\n";

/////////////////////////////////////////////////////////////
$objXLS = new PHPExcel();
$objXLS->getProperties()->setCreator("Fabian Vergara");
/////LAMADA A LA PRIMERA HOJA/////
$objSheet = $objXLS->setActiveSheetIndex(0);


//funcion para color de celdas

//creando conexion a BD
$conexion = mysql_connect('localhost','root','albo1572')or die("\nNo se puede conectar a DB\n");
mysql_select_db('reporte_ussd',$conexion);
$result_col = mysql_query("SHOW COLUMNS FROM TBL_WIQ");

//llena nombre columnas
if (mysql_num_rows($result_col)> 0)
{
    while ($row = mysql_fetch_assoc($result_col))
    {
        $numero++;
        $objSheet->setCellValue('A'.$numero, utf8_encode($row['Field']));
    }
}
//llenar datos
$consulta_1="select * from TBL_WIQ where Fecha ='$FECHA_ANTERIOR_1'";
$consulta_2="select * from TBL_WIQ where Fecha ='$FECHA_ANTERIOR_2'";
$consulta_3="select * from TBL_WIQ where Fecha ='$FECHA_ANTERIOR_3'";
$consulta_4="select * from TBL_WIQ where Fecha ='$FECHA_ANTERIOR_4'";
$consulta_5="select * from TBL_WIQ where Fecha ='$FECHA_ANTERIOR_5'";
$consulta_6="select * from TBL_WIQ where Fecha ='$FECHA_ANTERIOR_6'";
$consulta_7="select * from TBL_WIQ where Fecha ='$FECHA_ANTERIOR_7'";
$resultado_1=mysql_query($consulta_1);
$resultado_2=mysql_query($consulta_2);
$resultado_3=mysql_query($consulta_3);
$resultado_4=mysql_query($consulta_4);
$resultado_5=mysql_query($consulta_5);
$resultado_6=mysql_query($consulta_6);
$resultado_7=mysql_query($consulta_7);
while ($row = mysql_fetch_array($resultado_7, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('B'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resultado_6, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('C'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resultado_5, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('D'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resultado_4, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('E'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resultado_3, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('F'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resultado_2, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('G'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resultado_1, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('H'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;

$objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$objXLS->getActiveSheet()->setTitle('Trafico_USSD');
$objXLS->getActiveSheet()->getStyle('A1:H43')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); //dentro de tabla
$objXLS->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true); //negrita
$objXLS->getActiveSheet()->getStyle('A1:A43')->getFont()->setBold(true);
$objXLS->setActiveSheetIndex(0);


/////LAMADA A LA segunda HOJA/////

$objXLS->createSheet();
$objSheet = $objXLS->setActiveSheetIndex(1);

$result_col2 = mysql_query("SHOW COLUMNS FROM TBL_OBQS");
$numero=0;
if (mysql_num_rows($result_col2)> 0)
{
    while ($row = mysql_fetch_assoc($result_col2))
    {
        $numero++;
        $objSheet->setCellValue('A'.$numero, utf8_encode($row['Field']));
    }
}
//llena campos xls.

$cons_2_1="select  fecha,`*102#`*100,`*103#`*100 from TBL_OBQS where Fecha='$FECHA_ANTERIOR_1'";
$cons_2_2="select  fecha,`*102#`*100,`*103#`*100 from TBL_OBQS where Fecha='$FECHA_ANTERIOR_2'";
$cons_2_3="select  fecha,`*102#`*100,`*103#`*100 from TBL_OBQS where Fecha='$FECHA_ANTERIOR_3'";
$cons_2_4="select  fecha,`*102#`*100,`*103#`*100 from TBL_OBQS where Fecha='$FECHA_ANTERIOR_4'";
$cons_2_5="select  fecha,`*102#`*100,`*103#`*100 from TBL_OBQS where Fecha='$FECHA_ANTERIOR_5'";
$cons_2_6="select  fecha,`*102#`*100,`*103#`*100 from TBL_OBQS where Fecha='$FECHA_ANTERIOR_6'";
$cons_2_7="select  fecha,`*102#`*100,`*103#`*100 from TBL_OBQS where Fecha='$FECHA_ANTERIOR_7'";
$resulta_2_1=mysql_query($cons_2_1);
$resulta_2_2=mysql_query($cons_2_2);
$resulta_2_3=mysql_query($cons_2_3);
$resulta_2_4=mysql_query($cons_2_4);
$resulta_2_5=mysql_query($cons_2_5);
$resulta_2_6=mysql_query($cons_2_6);
$resulta_2_7=mysql_query($cons_2_7);
while ($row = mysql_fetch_array($resulta_2_7, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('B'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_2_6, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('C'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_2_5, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('D'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_2_4, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('E'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_2_3, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('F'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_2_2, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('G'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_2_1, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('H'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;

$objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
$objXLS->getActiveSheet()->setTitle('Trafico OBQS(102-103)');
$objXLS->setActiveSheetIndex(1)->setCellValue('I2', '=sum($B2:H2)');
$objXLS->setActiveSheetIndex(1)->setCellValue('I3', '=sum($B3:H3)');
$objXLS->setActiveSheetIndex(1)->setCellValue('I1','TOTAL PESOS ');
$objXLS->getActiveSheet(1) ->getStyle('I2') ->getNumberFormat() ->setFormatCode( '_-* $#,##0\ ' ); //Formato de celda a moneda.
$objXLS->getActiveSheet(1) ->getStyle('I3') ->getNumberFormat() ->setFormatCode( '_-* $#,##0\ ' );
$objXLS->getActiveSheet(1)->getStyle('A1:I3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); //dentro de tabla
$objXLS->getActiveSheet(1)->getStyle('I1:I3')->getFont()->setBold(true);
$objXLS->setActiveSheetIndex(0);
/////LAMADA A LA TERCERA HOJA/////

$objXLS->createSheet();
$objSheet = $objXLS->setActiveSheetIndex(2);

$result_col3 = mysql_query("SHOW COLUMNS FROM TBL_SDP");
$numero=0;
if (mysql_num_rows($result_col3)> 0)
{
    while ($row = mysql_fetch_assoc($result_col3))
    {
        $numero++;
        $objSheet->setCellValue('A'.$numero, utf8_encode($row['Field']));
    }
}
//llena campos xls.

$cons_3_1="select  fecha,`*100#`*50 from TBL_SDP where Fecha='$FECHA_ANTERIOR_1'";
$cons_3_2="select  fecha,`*100#`*50 from TBL_SDP where Fecha='$FECHA_ANTERIOR_2'";
$cons_3_3="select  fecha,`*100#`*50 from TBL_SDP where Fecha='$FECHA_ANTERIOR_3'";
$cons_3_4="select  fecha,`*100#`*50 from TBL_SDP where Fecha='$FECHA_ANTERIOR_4'";
$cons_3_5="select  fecha,`*100#`*50 from TBL_SDP where Fecha='$FECHA_ANTERIOR_5'";
$cons_3_6="select  fecha,`*100#`*50 from TBL_SDP where Fecha='$FECHA_ANTERIOR_6'";
$cons_3_7="select  fecha,`*100#`*50 from TBL_SDP where Fecha='$FECHA_ANTERIOR_7'";
$resulta_3_1=mysql_query($cons_3_1);
$resulta_3_2=mysql_query($cons_3_2);
$resulta_3_3=mysql_query($cons_3_3);
$resulta_3_4=mysql_query($cons_3_4);
$resulta_3_5=mysql_query($cons_3_5);
$resulta_3_6=mysql_query($cons_3_6);
$resulta_3_7=mysql_query($cons_3_7);

while ($row = mysql_fetch_array($resulta_3_7, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('B'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_3_6, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('C'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_3_5, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('D'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_3_4, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('E'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_3_3, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('F'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_3_2, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('G'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
while ($row = mysql_fetch_array($resulta_3_1, MYSQL_NUM))
{
    for($i=0; $i<count($row); $i++)
        {
        $objSheet->setCellValue('H'.$numero2, utf8_encode($row[$i]));
        $numero2++;
        }
}$numero2=1;
$objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$objXLS->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
$objXLS->getActiveSheet()->setTitle('Trafico SDP (100)');
$objXLS->setActiveSheetIndex(2)->setCellValue('I2', '=sum($B2:H2)');
$objXLS->setActiveSheetIndex(2)->setCellValue('I1','TOTAL PESOS ');
$objXLS->getActiveSheet(2) ->getStyle('I2') ->getNumberFormat() ->setFormatCode( '_-* $#,##0\ ' ); //Formato de celda a moneda.
$objXLS->getActiveSheet(2)->getStyle('A1:I2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); //dentro de tabla
$objXLS->getActiveSheet(2)->getStyle('I1:I2')->getFont()->setBold(true);
$objXLS->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save( $DIR."/REPORTE_USSD_$FECHA.xls");





echo "excel creado \n ";
 /* CIERRE DE CONEXIONES Y ARCHIVOS*/
mysql_close($con);
mysql_close($conexion);
/* ENVIO DE CORREO*/
echo exec('php /home/prepago/apps/WIQ/envia_mail.php');



?>
