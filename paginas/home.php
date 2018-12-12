<?php
    include("conexao.php");
    session_start();
    include("proteger.php");
    proteger();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> Home </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
    </head>
    <body>    
        <div class="container">
            <!--Navbar/Menu-->
            <?php include "menu.php"; ?>
            <!--Boas-vindas-->
            <div class="jumbotron">
                <h2 class="panel panel-primary">
                    <div class="panel-heading">Bem-vindo(a) ao painel de controle</div>
                </h2>
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Esta aplicação tem como objetivo a simplificação e organização de scripts de serviços fundamentais, gerenciáveis pelo <i>browser</i> 
                            tornando mais amigável a interação com o usuário. Divididos em abas, com um clique é possível executar e inserir as configurações para o 
                            serviço Linux desejado, como FTP, DHCP e SAMBA.
                        </h4>
                        <h3><b>Instalação de requisitos</b></h3>
                        <article>
                            <div class="col-xs-12">
                                <h4>Antes da utilização da ferramenta é necessário seguir o procedimento abaixo na máquina cliente.</h4>
                                <h4>FTP</h4>
                                <code>
                                    apt-get -y install vsftpd
                                </code><br />
                                <code>
                                    cp /etc/vsftpd.conf /etc/vsftpd.conf.bkp
                                </code>

                                <h4>DHCP</h4>
                                <code>
                                    apt-get -y install isc-dhcp-server
                                </code><br />
                                <code>
                                    cp /etc/dhcp/dhcpd.conf /etc/dhcp/dhcpd.conf.bkp
                                </code>

                                <h4>SAMBA</h4>
                                <code>
                                    apt-get -y install samba
                                </code><br />
                                <code>
                                    cp /etc/samba/smb.conf /etc/samba/smb.conf.bkp
                                </code>      

                                <h4>SSH</h4>
                                <code>
                                    apt-get -y install openssh-server
                                </code><br />
                                <code>
                                    cp /etc/ssh/sshd_config /etc/ssh/sshd_config.bkp
                                </code><br />
                                <code>
                                    sed -e 's/PermitRootLogin prohibit-password/PermitRootLogin yes/g' sshd_config.bkp > sshd_config
                                </code><br />
                                <code>
                                    systemctl restart ssh
                                </code>
                            </div>
                         </article>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>