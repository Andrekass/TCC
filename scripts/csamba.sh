#!/bin/bash

privez=$1
enviaproshell=$2
SAMBA="/etc/samba/smb.conf"

#ESTA CONFIGURA«√O SER¡ FEITA CASO FOR A PRIMEIRA VEZ
privez(){

if [ "$privez" == "yes" ]
then
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

echo "workgroup=WORKGROUP" > $SAMBA
echo " " >> $SAMBA
EOF
fi
}

#FUN«„O DO COMPARTILHAMENTO SIMPLES
simples(){ 

#ATRIBUI CONFIGURA«’ES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

echo "#INICIO_$nomesimp#" >> $SAMBA
echo "[$nomesimp]" >> $SAMBA
echo "path=$diretoriosimp" >> $SAMBA
echo "public=yes" >> $SAMBA
echo "browseable=yes" >> $SAMBA
echo "writable=yes" >> $SAMBA
echo "#FIM_$nomesimp#" >> $SAMBA
#CRIA O DIRET”RIO SOMENTE SE N√O EXISTIR
if [ -d "$diretoriosimp" ]; then echo " "; else mkdir "$diretoriosimp"; fi
chmod 777 $diretoriosimp
systemctl restart smbd
EOF
}

#FUN«√O DO COMPARTILHAMENTO PRIVATIVO
privativo(){ 

#ATRIBUI CONFIGURA«’ES
sshpass -p "$senharoot" ssh -p "$porta" -o StrictHostKeyChecking=no "$usuarioroot"@"$ip" bash -s $1 << EOF

#RETIRA OS GRUPOS REPETIDOS E ATRIBUI A UM ARQUIVO, DEPOIS CRIA OS GRUPOS
echo "$grupos" | sed 's;,;\\n;g' | sort | uniq > /home/gruposCria
for i in \`cat /home/gruposCria\`; do groupadd \$i; done

#CRIAR OUTRO ARQUIVO COM OS GRUPOS SEPARADOS POR VIRGULA
sed -e 'H;\${x;s/\n/,/g;s/^,//;p;};d; \$ s/.\$//' /home/gruposCria > /home/gruposCvirgula

#VERIFICA SE O USU¡RIO J¡ EXISTE
v_usu=\`grep '^$usuariopriv' /etc/passwd | grep -o ':x:' | wc -l\`
if [ "\$v_usu" == 1 ]; then 
usermod $usuariopriv -G \`cat /home/gruposCvirgula\`; 
elif [ "\$v_usu" == 0 ]; then
useradd $usuariopriv -G \`cat /home/gruposCvirgula\`; fi

echo $usuariopriv:$senhapriv | chpasswd
mkdir $diretoriopriv 
chown $usuariopriv:$usuariopriv $diretoriopriv
(echo $senhapriv; echo $senhapriv) | smbpasswd -a $usuariopriv
echo "#INICIO_$nomepriv#" >> $SAMBA
echo "[$nomepriv]" >> $SAMBA
echo "path=$diretoriopriv" >> $SAMBA
echo "public=yes" >> $SAMBA
echo "browseable=yes" >> $SAMBA
echo "writable=yes" >> $SAMBA

#CRIAR OUTRO ARQUIVO COM OS GRUPOS QUE SER√O DONO DO COMPAR. SEPARADOS POR VIRGULA, POREM, TAMBEM COM ARROBA
echo "$grupopriv" | sed 's;,;\\n;g' | sort | uniq > /home/gruposCompar
sed -i 's/^/@/; H;\${x;s/\n/,/g;s/^,//;p;};d; \$ s/.\$//' /home/gruposCompar
echo "valid users=\`cat /home/gruposCompar\`" >> $SAMBA
echo "#FIM_$nomepriv#" >> $SAMBA
chmod 777 $diretoriopriv
systemctl restart smbd
rm /home/gruposCria /home/gruposCvirgula /home/gruposCompar
EOF
}

#VERIFICA O SERVI«O ESCOLHIDO PELO USU¡RIO NO BROWSER
if [ "$enviaproshell" == "todos" ]
then
    nomesimp=$3
    diretoriosimp=$4
    usuariopriv=$5
    senhapriv=$6
    grupos=$7
    grupopriv=$8
    nomepriv=$9
    diretoriopriv=${10}
    senharoot=${11}
    porta=${12}
    usuarioroot=${13}
    ip=${14}
    privez
    sleep 1
    simples
    sleep 1
    privativo
elif [ "$enviaproshell" == "simp" ]
then
    nomesimp=$3
    diretoriosimp=$4
    senharoot=$5
    porta=$6
    usuarioroot=$7
    ip=$8
    privez
    sleep 1
    simples
elif [ "$enviaproshell" == "priv" ]
then
    usuariopriv=$3
    senhapriv=$4
    grupos=$5
    grupopriv=$6
    nomepriv=$7
    diretoriopriv=$8
    senharoot=$9
    porta=${10}
    usuarioroot=${11}
    ip=${12}
    privez
    sleep 1
    privativo
fi

#VERIFICA SE OCORREU CORRETAMENTE O ACESSO
resul=$?

if [ $resul -eq 0 ]
then
    echo "exito" > /etc/cgi/scripts/acesso
else
    echo "erro" > /etc/cgi/scripts/acesso
fi
