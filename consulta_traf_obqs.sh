#!/bin/bash

USER="fvergara"
PASS="f4b14n123"
HOST_1="172.29.64.74"
HOST_2="172.29.64.75"
RUTA_LOG="/home/obqs/edbqs/log/edbqs.log"
CONTADOR=1
RUTA_1="/home/prepago/apps/WIQ/logs"
rm -f $RUTA_1/VALOR_TOTAL_102_.txt $RUTA_1/VALOR_TOTAL_103_.txt

while [  $CONTADOR -le 7 ];
do
DIA=`date --date='-'$CONTADOR' day' +'%Y-%m-%d'`
echo "consultado $DIA archivo..."
##Consultas
CMD_102="zgrep 'Commit de credito exitoso' $RUTA_LOG.$DIA* | grep '102 - OBQS_BILL' | wc -l"
CMD_103="zgrep 'Commit de credito exitoso' $RUTA_LOG.$DIA* | grep '103 - OBQS_BILL' | wc -l"

##OBQS_1
O1_102=$(expect -c "
spawn ssh -o StrictHostKeyChecking=no $USER@$HOST_1 $CMD_102
match_max 100000
expect \"*?assword:*\"
send -- \"$PASS\r\"
send -- \"\r\"
expect eof
")
echo "$O1_102"  > $RUTA_1/obqs1_prueba_102_$DIA.txt

O1_103=$(expect -c "
spawn ssh -o StrictHostKeyChecking=no $USER@$HOST_1 $CMD_103
match_max 100000
expect \"*?assword:*\"
send -- \"$PASS\r\"
send -- \"\r\"
expect eof
")
echo "$O1_103"  > $RUTA_1/obqs1_prueba_103_$DIA.txt


##OBQS_2

O_102=$(expect -c "
spawn ssh -o StrictHostKeyChecking=no $USER@$HOST_2 $CMD_102
match_max 100000
expect \"*?assword:*\"
send -- \"$PASS\r\"
send -- \"\r\"
expect eof
")
echo "$O_102"  > $RUTA_1/obqs2_prueba_102_$DIA.txt

O_103=$(expect -c "
spawn ssh -o StrictHostKeyChecking=no $USER@$HOST_2 $CMD_103
match_max 100000
expect \"*?assword:*\"
send -- \"$PASS\r\"
send -- \"\r\"
expect eof
")
echo "$O_103"  > $RUTA_1/obqs2_prueba_103_$DIA.txt


##Sumar Valores:
##obqs1
grep -v 172.29.64.74 $RUTA_1/obqs1_prueba_102_$DIA.txt > $RUTA_1/obqs_suma_102.txt
grep -v 172.29.64.74 $RUTA_1/obqs1_prueba_103_$DIA.txt > $RUTA_1/obqs_suma_103.txt
##obqs2
grep -v 172.29.64.75 $RUTA_1/obqs2_prueba_102_$DIA.txt >> $RUTA_1/obqs_suma_102.txt
grep -v 172.29.64.75 $RUTA_1/obqs2_prueba_103_$DIA.txt >> $RUTA_1/obqs_suma_103.txt



date --date='-'$CONTADOR' day' +'%Y-%m-%d' >> $RUTA_1/VALOR_TOTAL_102_.txt
awk '{ SUM += $1} END { print SUM }' $RUTA_1/obqs_suma_102.txt >> $RUTA_1/VALOR_TOTAL_102_.txt
date --date='-'$CONTADOR' day' +'%Y-%m-%d' >> $RUTA_1/VALOR_TOTAL_103_.txt
awk '{ SUM += $1} END { print SUM }' $RUTA_1/obqs_suma_103.txt >> $RUTA_1/VALOR_TOTAL_103_.txt


let CONTADOR=CONTADOR+1
done


sed ':a;N;$!ba;s/\n/:/g' $RUTA_1/VALOR_TOTAL_102_.txt > $RUTA_1/trafico_102.txt
sed ':a;N;$!ba;s/\n/:/g' $RUTA_1/VALOR_TOTAL_103_.txt > $RUTA_1/trafico_103.txt

awk -F\: '{print "insert into TBL_OBQS (Fecha,`*102#`) values (@"$1"@,@"$2"@);"}' $RUTA_1/trafico_102.txt | sed "s/@/'/g" > $RUTA_1/insert_TBL_102.sql
awk -F\: '{print "insert into TBL_OBQS (Fecha,`*102#`) values (@"$3"@,@"$4"@);"}' $RUTA_1/trafico_102.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_102.sql
awk -F\: '{print "insert into TBL_OBQS (Fecha,`*102#`) values (@"$5"@,@"$6"@);"}' $RUTA_1/trafico_102.txt| sed "s/@/'/g" >> $RUTA_1/insert_TBL_102.sql
awk -F\: '{print "insert into TBL_OBQS (Fecha,`*102#`) values (@"$7"@,@"$8"@);"}' $RUTA_1/trafico_102.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_102.sql
awk -F\: '{print "insert into TBL_OBQS (Fecha,`*102#`) values (@"$9"@,@"$10"@);"}' $RUTA_1/trafico_102.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_102.sql
awk -F\: '{print "insert into TBL_OBQS (Fecha,`*102#`) values (@"$11"@,@"$12"@);"}' $RUTA_1/trafico_102.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_102.sql
awk -F\: '{print "insert into TBL_OBQS (Fecha,`*102#`) values (@"$13"@,@"$14"@);"}' $RUTA_1/trafico_102.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_102.sql
echo "insertando a BD.."
mysql -uroot -palbo1572 reporte_ussd < $RUTA_1/insert_TBL_102.sql


awk -F\: '{print "update TBL_OBQS set `*103#` =@"$2"@ where Fecha =@"$1"@;"}' $RUTA_1/trafico_103.txt | sed "s/@/'/g" > $RUTA_1/insert_TBL_103.sql
awk -F\: '{print "update TBL_OBQS set `*103#` =@"$4"@ where Fecha =@"$3"@;"}' $RUTA_1/trafico_103.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_103.sql
awk -F\: '{print "update TBL_OBQS set `*103#` =@"$6"@ where Fecha =@"$5"@;"}' $RUTA_1/trafico_103.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_103.sql
awk -F\: '{print "update TBL_OBQS set `*103#` =@"$8"@ where Fecha =@"$7"@;"}' $RUTA_1/trafico_103.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_103.sql
awk -F\: '{print "update TBL_OBQS set `*103#` =@"$10"@ where Fecha =@"$9"@;"}' $RUTA_1/trafico_103.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_103.sql
awk -F\: '{print "update TBL_OBQS set `*103#` =@"$12"@ where Fecha =@"$11"@;"}' $RUTA_1/trafico_103.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_103.sql
awk -F\: '{print "update TBL_OBQS set `*103#` =@"$14"@ where Fecha =@"$13"@;"}' $RUTA_1/trafico_103.txt | sed "s/@/'/g" >> $RUTA_1/insert_TBL_103.sql
mysql -uroot -palbo1572 reporte_ussd < $RUTA_1/insert_TBL_103.sql
echo "Fin."

rm -f $RUTA_1/obqs* $RUTA_1/VALOR* $RUTA_1/trafico_*
