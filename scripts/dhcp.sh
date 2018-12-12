#!/bin/bash

#ATRIBUI O QUE VEIO DO BROWSER A OUTRAS VARIÁVEIS
dominio=$1
servidordns=$2
gateway=$3
servidor=$4
mascara=$5
rangea=$6
rangeb=$7
senharoot=$8
porta=$9
usuarioroot=${10}
ip=${11}
DHCPD="/etc/dhcp/dhcpd.conf"

#CONEXÃO SSH QUE FAZ O ACESSO A MÁQUINA E ATRIBUI AS CONFIGURAÇÕES
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

#VERIFICA SE OCORREU CORRETAMENTE O ACESSO
resul=$?

if [ $resul -eq 0 ]
then
    echo "exito" > /etc/cgi/scripts/acesso
else
    echo "erro" > /etc/cgi/scripts/acesso
fi

