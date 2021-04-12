#!/bin/bash

HOST="xxxxxx"
USER="xxxxx"
PASS="xxxxxx"
RUTA_PROTOKOLL="/home/wiq/wIQ_R2/data/log/"
PROTOKOLL="Protocol."
CONTADOR=9
RUTA="/home/prepago/apps/WIQ/logs"

while [  $CONTADOR -le 11 ];
do
DIA=`date --date='-'$CONTADOR' day' +'%Y%m%d'`
DIA_UPDATE=`date --date='-'$CONTADOR' day' +'%Y-%m-%d'`
echo "Copiando "$CONTADOR" archivo protokoll"
expect -c  "
spawn scp -o StrictHostKeyChecking=yes $USER@$HOST:$RUTA_PROTOKOLL$PROTOKOLL$DIA* .
match_max 100000
expect \"*?assword:*\"
send -- \"$PASS\r\"
send -- \"\r\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect \"*100%*\"
expect eof
"
echo " "
echo "consultado archivo.."
zgrep HT_LOADED $PROTOKOLL$DIA* | grep -v "<user abort>" | egrep ":\*100#|:\*140#|:\*502#|:\*221#|:\*118#|:\*120#|:\*311#|:\*102#|:\*103#|:\*113#|:\*114#|:\*126#|:\*191#|:\*301#|:\*109#|:\*110#|:\*119#|:\*121#|:\*122#|:\*127#|:\*128#|:\*129#|:\*130#|:\*131#|:\*132#|:\*133#|:\*136#|:\*137#|:\*105#|:\*106#|:\*107#|:\*116#|:\*117#|:\*123#|:\*142#|:\*143#|:\*147#|:\*148#|:\*149#"| awk -F':' '{print substr($8,1,5)}'| sort | uniq -c > $RUTA/datos_ussd_$DIA.txt

echo "OK. archivo generado = datos_ussd_$DIA.txt"

rm -f $PROTOKOLL$DIA
echo "Protokoll" $PROTOKOLL$DIA "ya procesado, se elimina."

##CREAR INSERT BD.
awk  '{print "insert into TBL_WIQ (`"$2"`) values (@"$1"@);"}' $RUTA/datos_ussd_$DIA.txt | sed "s/@/'/g" | head -1 >  $RUTA/Inser_Updata.sql
awk '{print "update TBL_WIQ set `"$2"` = @"$1"@ where Fecha =@0000-00-00@; "}' $RUTA/datos_ussd_$DIA.txt | sed "s/@/'/g" >> $RUTA/Inser_Updata.sql
echo "update TBL_WIQ set Fecha ='$DIA_UPDATE' where Fecha='0000-00-00'" >> $RUTA/Inser_Updata.sql
mysql -uroot -palbo1572 reporte_ussd < $RUTA/Inser_Updata.sql


let CONTADOR=CONTADOR+1
done

echo "Se procesan los ultimos 7 protokoll de WIQ"
