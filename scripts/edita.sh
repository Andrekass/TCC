#!/bin/bash

enviaproshell=$1
SAMBA="/etc/samba/smb.conf"
DHCPD="/etc/dhcp/dhcpd.conf"
SCRIPT="/home/script"

ftp(){

#ALTERA CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#VERIFICA SE O USUÁRIO NOVO JÁ EXISTE
v_usu=\`grep '^$usuario_ftp' /etc/passwd | grep -o ':x:' | wc -l\`
#SE NÃO EXISTIR ENTÃO TROCA O DIRETÓRIO E RENOMEIA O USUÁRIO 
if [ "\$v_usu" == 0 ]; then usermod -d /home/$usuario_ftp -l $usuario_ftp $usuarioftpOLD
groupmod -n $usuario_ftp $usuarioftpOLD
sed -i "s;\<path=/home/$usuarioftpOLD\>;path=/home/$usuario_ftp;g" $SAMBA; fi
#SE EXISTIR ENTÃO SOMENTE TROCA O DIRETÓRIO
if [ "\$v_usu" == 1 ]; then usermod -d /home/$usuario_ftp $usuario_ftp; fi

#REMOVE O USUÁRIO ANTIGO CASO NÃO ESTEJA SENDO USADO PELO smbpriv E NÃO FOR IGUAL
if [ "$r_usuOLD" == "no" && $usuarioftpOLD != $usuario_ftp ]; then userdel $usuarioftpOLD; fi

#ALTERA A SENHA DO USUÁRIO NOVO
echo $usuario_ftp:$senha_ftp | chpasswd

#SE O DIRETÓRIO FOR NÃO FOR IGUAL, ENTÃO RENOMEIA E DÁ PERMISSÃO AO USUÁRIO
if [ "$usuarioftpOLD" != "$usuario_ftp" ]; then 
mv /home/$usuarioftpOLD /home/$usuario_ftp
chown -R $usuario_ftp:$usuario_ftp /home/$usuario_ftp; else
#SE NÃO, ENTÃO SOMENTE DÁ PERMISSÃO AO USUÁRIO
chown -R $usuario_ftp:$usuario_ftp /home/$usuario_ftp; fi
EOF
}

dhcp(){

#ALTERA CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

echo "ddns-update-style none;" > $DHCPD
echo "option domain-name \"$dominio\";" >> $DHCPD
echo "option domain-name-servers $servidordns;" >> $DHCPD
echo "default-lease-time 600;" >> $DHCPD
echo "max-lease-time 7200;" >> $DHCPD
echo "authoritative;" >> $DHCPD
echo "log-facility local7;" >> $DHCPD
echo "option routers $gateway;" >> $DHCPD
echo "subnet $servidor.0 netmask $mascara {" >> $DHCPD
echo "  range dynamic-bootp $servidor.$rangea $servidor.$rangeb;" >> $DHCPD
echo "}" >> $DHCPD
systemctl restart isc-dhcp-server
EOF
}

smbsimp(){

#BLOCO
iniOLD="#INICIO_$nomesimpOLD#"
fimOLD="#FIM_$nomesimpOLD#"
iniNOVO="#INICIO_$nomesimp#"
fimNOVO="#FIM_$nomesimp#"

#ALTERA CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

##DIRETÓRIO##
#REM0VE O DIRETÓRIO ANTIGO CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR. OU PELO FTP E NÃO FOREM IGUAIS
if [ "$r_direOLD" == "no" ] && [ "$diretoriosimpOLD" != "$diretoriosimp" ]; then rm -rf $diretoriosimpOLD; fi
#VERIFICA SE O DIRETÓRIO NOVO JÁ EXISTE, CASO NÃO EXISTA ENTÃO CRIA
v_dire=\`find /home -type d | grep -c "/home/\<$dire_simp\>"\`
if [ "\$v_dire" == 0 ]; then mkdir $diretoriosimp; fi
chmod 777 $diretoriosimp

echo "ini='^#INICIO_$nomesimpOLD#$'" > $SCRIPT
echo "fim='^#FIM_$nomesimpOLD#$'" >> $SCRIPT
echo "sed -i \"/\\\$ini/,/\\\$fim/{ /\\\$ini/{p; a [$nomesimp]\\\npath=$diretoriosimp\\\npublic=yes\\\nbrowseable=yes\\\nwriteable=yes" >> $SCRIPT
echo "}; /\\\$fim/p; d}\" $SAMBA" >> $SCRIPT
chmod +x $SCRIPT && /home/./script && rm $SCRIPT
sed -i "s/$iniOLD/$iniNOVO/g; s/$fimOLD/$fimNOVO/g" $SAMBA
systemctl restart smbd
EOF
}

smbpriv(){

#BLOCO
iniOLD="#INICIO_$nomeprivOLD#"
fimOLD="#FIM_$nomeprivOLD#"
iniNOVO="#INICIO_$nomepriv#"
fimNOVO="#FIM_$nomepriv#"

#ALTERA CONFIGURAÇÕES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#REMOVE O(s) GRUPO(s) ANTIGOS CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR.
echo "$grupoprivOLD" | sed 's;,;\\n;g' > /home/gruposRemove
for i in \`cat /home/gruposRemove\`; do 
echo "r_grupo=\\\$(grep '^\$i:x:' /etc/group | grep -o ',' | wc -l) && if [ \"\\\$r_grupo\" == 0 ]; then groupdel \$i; fi" >> $SCRIPT; done
chmod +x $SCRIPT && /home/./script && rm $SCRIPT /home/gruposRemove

#CRIA O(s) GRUPO(s) CASO NÃO EXISTA 
echo "$grupos" | sed 's;,;\\n;g' | sort | uniq > /home/gruposCria
for i in \`cat /home/gruposCria\`; do 
echo "c_grupo=\\\$(grep '^\$i:x:' /etc/group | grep -o ',' | wc -l) && if [ \"\\\$c_grupo\" == 0 ]; then groupadd \$i; fi" >> $SCRIPT; done
chmod +x $SCRIPT && /home/./script && rm $SCRIPT

##DIRETÓRIO##
#REM0VE O DIRETÓRIO ANTIGO CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR. OU PELO FTP E NÃO FOREM IGUAIS
if [ "$r_direOLD" == "no" ] && [ $diretorioprivOLD != $diretoriopriv ]; then rm -rf $diretorioprivOLD; fi
#VERIFICA SE O DIRETÓRIO NOVO JÁ EXISTE, CASO NÃO EXISTA ENTÃO CRIA
v_dire=\`find /home -type d | grep -c "/home/\<$dire_priv\>"\`
if [ "\$v_dire" == 0 ]; then mkdir $diretoriopriv; fi

##USUÁRIO##
#CRIAR OUTRO ARQUIVO COM OS GRUPOS SEPARADOS POR VIRGULA
sed -e 'H;\${x;s/\n/,/g;s/^,//;p;};d; \$ s/.\$//' /home/gruposCria > /home/gruposCvirgula
#REMOVE O USUÁRIO ANTIGO CASO NÃO ESTEJA SENDO USADO EM OUTROS COMPAR. OU PELO FTP E NÃO FOREM IGUAIS
if [ "$r_usuOLD" == "no" && $usuarioprivOLD != $usuariopriv ]; then userdel $usuarioprivOLD; fi
#VERIFICA SE O USUÁRIO JÁ EXISTE, SE NÃO EXISTIR ENTÃO CRIA
v_usu=\`grep '^$usuariopriv' /etc/passwd | grep -o ':x:' | wc -l\`
if [ "\$v_usu" == 1 ]; then 
usermod $usuariopriv -G \`cat /home/gruposCvirgula\`; 
elif [ "\$v_usu" == 0 ]; then
useradd $usuariopriv -G \`cat /home/gruposCvirgula\`; fi

#ADICIONA SENHA AO USUÁRIO 
echo $usuariopriv:senhapriv | chpasswd
chown $usuariopriv:$usuariopriv $diretoriopriv
(echo $senhapriv; echo $senhapriv) | smbpasswd -a $usuariopriv

#CRIAR OUTRO ARQUIVO COM OS GRUPOS QUE SERÃO DONO DO COMPAR. SEPARADOS POR VIRGULA, POREM, TAMBEM COM ARROBA
echo "$grupopriv" | sed 's;,;\\n;g' | sort | uniq > /home/gruposCompar
sed -i 's/^/@/; H;\${x;s/\n/,/g;s/^,//;p;};d; \$ s/.\$//' /home/gruposCompar

echo "ini='^#INICIO_$nomeprivOLD#$'" > $SCRIPT
echo "fim='^#FIM_$nomeprivOLD#$'" >> $SCRIPT
echo "sed -i \"/\\\$ini/,/\\\$fim/{ /\\\$ini/{p; a [$nomepriv]\\\npath=$diretoriopriv\\\npublic=yes\\\nbrowseable=yes\\\nwriteable=yes\\\nvalid users=\`cat /home/gruposCompar\`" >> $SCRIPT
echo "}; /\\\$fim/p; d}\" $SAMBA" >> $SCRIPT
chmod +x $SCRIPT && /home/./script && rm $SCRIPT /home/gruposCria /home/gruposCompar /home/gruposCvirgula 
sed -i "s/$iniOLD/$iniNOVO/g; s/$fimOLD/$fimNOVO/g" $SAMBA
systemctl restart smbd
EOF
}

#VERIFICA QUAL SERVIÇO SERÁ ALTERADO
if [ "$enviaproshell" == "ftp" ]
then
    r_usuOLD=$2
    usuarioftpOLD=$3
    usuario_ftp=$4
    senha_ftp=$5
    senharoot=$6
    porta=$7
    usuarioroot=$8
    ip=$9
    ftp
elif [ "$enviaproshell" == "dhcp" ]
then
    dominio=$2
    servidordns=$3
    gateway=$4
    servidor=$5
    mascara=$6
    rangea=$7
    rangeb=$8
    senharoot=$9
    porta=${10}
    usuarioroot=${11}
    ip=${12}
    dhcp
elif [ "$enviaproshell" == "smbsimp" ]
then
    r_direOLD=$2
    nomesimpOLD=$3
    nomesimp=$4
    diretoriosimpOLD=$5
    diretoriosimp=$6
    senharoot=$7
    porta=$8
    usuarioroot=$9
    ip=${10}
    dire_simp=`echo $diretoriosimp | cut -d "/" -f3`
    smbsimp
elif [ "$enviaproshell" == "smbpriv" ]
then
    r_direOLD=$2
    r_usuOLD=$3
    usuarioprivOLD=$4
    usuariopriv=$5
    senhapriv=$6
    grupoprivOLD=$7
    grupos=$8
    grupopriv=$9
    nomeprivOLD=${10}
    nomepriv=${11}
    diretorioprivOLD=${12}
    diretoriopriv=${13}
    senharoot=${14}
    porta=${15}
    usuarioroot=${16}
    ip=${17}
    dire_priv=`echo $diretoriopriv | cut -d "/" -f3`
    smbpriv
fi

#VERIFICA SE OCORREU CORRETAMENTE O ACESSO
resul=$?

if [ $resul -eq 0 ]
then
    echo "exito" > /etc/cgi/scripts/acesso
else
    echo "erro" > /etc/cgi/scripts/acesso
fi

