#!/bin/bash

enviaproshell=$1
SAMBA="/etc/samba/smb.conf"
DHCPD="/etc/dhcp/dhcpd.conf"
SCRIPT="/home/script"

ftp(){

#REMOVE CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#VERIFICA SE O DIRETÓRIO ESTÁ SENDO USADO EM OUTROS COMPAR, CASO NÃO TIVER ENTÃO REMOVE
r_dire=\`grep -c "\<path=/home/$usuario_ftp\>" $SAMBA\`
if [ "\$r_dire" == 0 ]; then rm -rf /home/$usuario_ftp; fi
#REMOVE O USUÁRIO CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR
if [ "$r_usu" == "no" ]; then userdel $usuario_ftp; fi
EOF
}

dhcp(){

#REMOVE CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#FAZ UM CÓPIA COM A DATA ANTES DE REMOVE DO ARQUIVO DHCP
cp $DHCPD /etc/dhcp/"dhcpd.conf_\`date +"%Y-%m-%d"\`.bkp" && > $DHCPD
systemctl stop isc-dhcp-server
EOF
}

smbsimp(){

#BLOCO
ini="#INICIO_$nomesimp#"
fim="#FIM_$nomesimp#"

#REMOVE CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#REM0VE O DIRETÓRIO CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR. OU PELO FTP
if [ "$r_dire" == "no" ]; then rm -rf $diretoriosimp; fi

#REMOVE O COMPAR. DO ARQUIVO SAMBA
sed -i "/$ini/,/$fim/ d" $SAMBA
systemctl restart smbd
EOF
}

smbpriv(){

#BLOCO
ini="#INICIO_$nomepriv#"
fim="#FIM_$nomepriv#"

#REMOVE CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#REMOVE O(s) GRUPO(s) CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR. 
echo "$grupopriv" | sed 's;,;\\n;g' > /home/gruposRemove
for i in \`cat /home/gruposRemove\`; do 
echo "r_grupo=\\\$(grep '^\$i:x:' /etc/group | grep -o ',' | wc -l) && if [ \"\\\$r_grupo\" == 0 ]; then groupdel \$i; fi" >> $SCRIPT; done
chmod +x $SCRIPT && /home/./script && rm $SCRIPT /home/gruposRemove

#REMOVE O USUÁRIO CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR. OU PELO FTP
if [ "$r_usu" == "no" ]; then userdel $usuariopriv; fi

#REM0VE O DIRETÓRIO CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR. OU PELO FTP
if [ "$r_dire" == "no" ]; then rm -rf $diretoriopriv; fi

#REMOVE O COMPAR. DO ARQUIVO SAMBA
sed -i "/$ini/,/$fim/ d" $SAMBA
systemctl restart smbd
EOF
}

maq(){

#REMOVE CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#RETIRA OS USUÁRIOS REPETIDOS E OS REMOVE
echo "$usuarios_ftp,$usuarios_priv" | sed 's;,;\\n;g' | sort | uniq > /home/usuarios
for i in \`cat /home/usuarios\`; do userdel -r \$i; done && rm /home/usuarios

#RETIRA OS DIRETÓRIOS REPETIDOS E OS REMOVE
echo "$dire_simp,$dire_priv" | sed 's;,;\\n;g' | sort | uniq > /home/dire
for i in \`cat /home/dire\`; do rm -rf \$i; done && rm /home/dire

#RETIRA OS GRUPOS REPETIDOS E OS REMOVE
echo "$grupos_priv" | sed 's;,;\\n;g' | sort | uniq > /home/grupospriv
for i in \`cat /home/grupospriv\`; do groupdel \$i; done && rm /home/grupospriv

#FAZ UM CÓPIA COM A DATA ANTES DE REMOVE DO ARQUIVO SAMBA E DHCP
cp $SAMBA /etc/samba/"smb.conf_\`date +"%Y-%m-%d"\`.bkp" && > $SAMBA
cp $DHCPD /etc/dhcp/"dhcpd.conf_\`date +"%Y-%m-%d"\`.bkp" && > $DHCPD
systemctl restart vsftpd
systemctl restart isc-dhcp-server
systemctl restart smbd
rm -f /etc/scriptscgi
EOF
}

#VERIFICA QUAL SERVIÇO SERÁ DELETADO
if [ "$enviaproshell" == "ftp" ]
then
    r_usu=$2
    usuario_ftp=$3
    senharoot=$4
    porta=$5
    usuarioroot=$6
    ip=$7
    ftp
elif [ "$enviaproshell" == "dhcp" ]
then
    senharoot=$2
    porta=$3
    usuarioroot=$4
    ip=$5
    dhcp
elif [ "$enviaproshell" == "smbsimp" ]
then
    r_dire=$2
    nomesimp=$3
    diretoriosimp=$4
    senharoot=$5
    porta=$6
    usuarioroot=$7
    ip=$8
    smbsimp
elif [ "$enviaproshell" == "smbpriv" ]
then
    r_dire=$2
    r_usu=$3
    usuariopriv=$4
    grupopriv=$5
    nomepriv=$6
    diretoriopriv=$7
    senharoot=$8
    porta=$9
    usuarioroot=${10}
    ip=${11}
    smbpriv
elif [ "$enviaproshell" == "maq" ]
then
    opcao=$2
    #SE TODOS NÃO ESTIVEREM VAZIOS
    if [ "$opcao" == "1" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        usuarios_ftp=$7
        dire_simp=$8
        usuarios_priv=$9
        grupos_priv=${10}
        dire_priv=${11}
        maq
    #SE SOMENTE O smbpriv ESTIVER VAZIO
    elif [ "$opcao" == "2" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        usuarios_ftp=$7
        dire_simp=$8
        maq
    #SE SOMENTE O smbsimp ESTIVER VAZIO
    elif [ "$opcao" == "3" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        usuarios_ftp=$7
        usuarios_priv=$8
        grupos_priv=$9
        dire_priv=${10}
        maq
    #SE SOMENTE O ftp ESTIVER VAZIO
    elif [ "$opcao" == "4" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        dire_simp=$7
        usuarios_priv=$8
        grupos_priv=$9
        dire_priv=${10}
        maq
    #SE SOMENTE O ftp ESTIVER NÃO VAZIO
    elif [ "$opcao" == "5" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        usuarios_ftp=$7
        maq
    #SE SOMENTE O smbsimp ESTIVER NÃO VAZIO
    elif [ "$opcao" == "6" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        dire_simp=$7
        maq
    #SE SOMENTE O smbpriv ESTIVER NÃO VAZIO
    elif [ "$opcao" == "7" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        usuarios_priv=$7
        grupos_priv=$8
        dire_priv=$9
        maq
    #QUANDO TODOS ESTÃO VAZIOS
    elif [ "$opcao" == "8" ]; then
        senharoot=$3
        porta=$4
        usuarioroot=$5
        ip=$6
        maq
    fi
fi

#VERIFICA SE OCORREU CORRETAMENTE O ACESSO
resul=$?

if [ $resul -eq 0 ]
then
    echo "exito" > /etc/cgi/scripts/acesso
else
    echo "erro" > /etc/cgi/scripts/acesso
fi

