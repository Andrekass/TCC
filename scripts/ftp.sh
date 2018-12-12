#!/bin/bash

#ATRIBUI O QUE VEIO DO BROWSER A OUTRAS VARIÁVEIS
usuario=$1
senha=$2
senharoot=$3
porta=$4
usuarioroot=$5
ip=$6

#CONEXÃO SSH QUE FAZ O ACESSO A MÁQUINA E ATRIBUI AS CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

v_usu=\`grep '^$usuario' /etc/passwd | grep -o ':x:' | wc -l\`
if [ "\$v_usu" == 1 ]; then
echo $usuario:$senha | chpasswd
mkdir /home/$usuario
chown $usuario:$usuario /home/$usuario
chgrp $usuario $usuario /home/$usuario
chmod a-w /home/$usuario; 
elif [ "\$v_usu" == 0 ]; then
useradd -m $usuario
echo $usuario:$senha | chpasswd
chmod 777 /home/$usuario; fi

sed -e 's/anonymous_enable=YES/anonymous_enable=NO/g; s/#local_enable=YES/local_enable=YES/g; s/#write_enable=YES/write_enable=YES/g; s/#chroot_local_user=YES/chroot_local_user=YES/g; s/pam_service_name=vsftpd/pam_service_name=ftp/g' /etc/vsftpd.conf.bkp > /etc/vsftpd.conf
echo "allow_writeable_chroot=YES" >> /etc/vsftpd.conf
systemctl restart vsftpd
EOF

#VERIFICA SE OCORREU CORRETAMENTE O ACESSO
resul=$?

if [ $resul -eq 0 ]
then
    echo "exito" > /etc/cgi/scripts/acesso
else
    echo "erro" > /etc/cgi/scripts/acesso
fi

