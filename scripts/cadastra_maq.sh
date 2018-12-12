#!/bin/bash

#CONEXÃO SSH QUE FAZ O ACESSO A MÁQUINA 
sshpass -p "$1" ssh -p "$2" -o StrictHostKeyChecking=no "$3"@"$4" bash -s $1 << EOF

echo "maquina cadastrada" > /etc/scriptscgi
EOF

#VERIFICA SE OCORREU CORRETAMENTE O ACESSO
resul=$?

if [ $resul -eq 0 ]
then
    echo "exito" > /etc/cgi/scripts/acesso
else
    echo "erro" > /etc/cgi/scripts/acesso
fi
