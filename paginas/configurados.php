<?php
    include("conexao.php");
    session_start();
    include("proteger.php");
    proteger();    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> Configurados </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/bootstrap-checkbox.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap-validator.js"></script>
        <script>
            //VARIAVEIS DEFINEM OS ID
            var maq_requi="#recipient-ip,#recipient-porta,#recipient-usuarioroot,#recipient-senharoot";
            var ftp_requi="#recipient-user,#recipient-pass";
            var dhcp_requi="#recipient-dominio,#recipient-servidordns,#recipient-gateway,#recipient-servidor,#recipient-mascara,#recipient-rangea,#recipient-rangeb";
            var smbpriv_requi="#recipient-usuariopriv,#recipient-senha,#recipient-grupodonopriv,#recipient-nomepriv,#recipient-diretoriopriv,#recipient-visibpriv,#recipient-visibpriv2,#recipient-gravapriv,#recipient-gravapriv2";
            var smbsimp_requi="#recipient-nomesimp,#recipient-diretoriosimp,#recipient-visibsimp,#recipient-visibsimp2,#recipient-gravasimp,#recipient-gravasimp2";
            
            $(function() {//FUNÇÃO PARA DESABILITAR O REQUERIMENTO PELO ID
                $(ftp_requi).prop('required', false);
                $(dhcp_requi).prop('required', false);
                $(smbpriv_requi).prop('required', false);  
                $(smbsimp_requi).prop('required', false);
            });
            
            function maq(obj, obj1, obj2, obj3, obj4){
                if(obj.style.display == "none"){//CASO A DIV ESTIVER DESATIVA EXECUTA A FUNÇÃO ABAIXO
                    obj.style.display = "block";//MOSTRA A DIV
                    tableFTP.style.display = "none"; 
                    tableDHCP.style.display = "none"; 
                    tableSAMBA.style.display = "none";
                    $(function() {
                        //FUNÇÃO PARA HABILITAR O REQUERIMENTO
                        $(maq_requi).prop('required', true);
                        //FUNÇÃO PARA DESABILITAR O REQUERIMENTO
                        //FTP
                        $(ftp_requi).prop('required', false);
                        //DHCP
                        $(dhcp_requi).prop('required', false);
                        //SAMBA
                        $(smbpriv_requi).prop('required', false);  
                        $(smbsimp_requi).prop('required', false);   
                        //TROCA A COR DO BOTÃO
                        $(obj1).removeClass("btn-danger").addClass("btn-primary");
                        $(obj2).removeClass("btn-danger").addClass("btn-danger");
                        $(obj3).removeClass("btn-danger").addClass("btn-danger");
                        $(obj4).removeClass("btn-danger").addClass("btn-danger");
                    });
                }
            }
            
            function ftp(obj, obj1, obj2, obj3, obj4){
                if(obj.style.display == "none"){//CASO A DIV ESTIVER DESATIVA EXECUTA A FUNÇÃO ABAIXO
                    obj.style.display = "block";//MOSTRA A DIV
                    tableMAQ.style.display = "none";
                    tableDHCP.style.display = "none"; 
                    tableSAMBA.style.display = "none";
                    $(function() {
                        //FUNÇÃO PARA HABILITAR O REQUERIMENTO
                        $(ftp_requi).prop('required', true);
                        //FUNÇÃO PARA DESABILITAR O REQUERIMENTO
                        //MÁQUINAS
                        $(maq_requi).prop('required', false);
                        //DHCP
                        $(dhcp_requi).prop('required', false);
                        //SAMBA
                        $(smbpriv_requi).prop('required', false);  
                        $(smbsimp_requi).prop('required', false);   
                        //TROCA A COR DO BOTÃO
                        $(obj1).removeClass("btn-primary").addClass("btn-danger");
                        $(obj2).removeClass("btn-danger").addClass("btn-primary");
                        $(obj3).removeClass("btn-danger").addClass("btn-danger");
                        $(obj4).removeClass("btn-danger").addClass("btn-danger");
                    });
                }
            }
            
            function dhcp(obj, obj1, obj2, obj3, obj4){
                if(obj.style.display == "none"){//CASO A DIV ESTIVER DESATIVA EXECUTA A FUNÇÃO ABAIXO
                    obj.style.display = "block";//MOSTRA A DIV
                    tableMAQ.style.display = "none";
                    tableFTP.style.display = "none"; 
                    tableSAMBA.style.display = "none"; 
                    $(function() { 
                        //FUNÇÃO PARA HABILITAR O REQUERIMENTO
                        $(dhcp_requi).prop('required', true);
                        //FUNÇÃO PARA DESABILITAR O REQUERIMENTO
                        //MÁQUINAS
                        $(maq_requi).prop('required', false);
                        //FTP
                        $(ftp_requi).prop('required', false);  
                        //SAMBA
                        $(smbpriv_requi).prop('required', false);  
                        $(smbsimp_requi).prop('required', false);      
                        //TROCA A COR DO BOTÃO
                        $(obj1).removeClass("btn-primary").addClass("btn-danger");
                        $(obj2).removeClass("btn-danger").addClass("btn-danger");
                        $(obj3).removeClass("btn-danger").addClass("btn-primary");
                        $(obj4).removeClass("btn-danger").addClass("btn-danger");
                    }); 
                }
            }
            
            function samba(obj, obj1, obj2, obj3, obj4){
                if(obj.style.display == "none"){//CASO A DIV ESTIVER DESATIVA EXECUTA A FUNÇÃO ABAIXO
                    obj.style.display = "block";//MOSTRA A DIV
                    tableMAQ.style.display = "none";
                    tableFTP.style.display = "none"; 
                    tableDHCP.style.display = "none"; 
                    $(function() {
                        //FUNÇÃO PARA DESABILITAR O REQUERIMENTO
                        //MÁQUINAS
                        $(maq_requi).prop('required', false);
                        //FTP
                        $(ftp_requi).prop('required', false);  
                        //DHCP
                        $(dhcp_requi).prop('required', false);
                        //TROCA A COR DO BOTÃO
                        $(obj1).removeClass("btn-primary").addClass("btn-danger");
                        $(obj2).removeClass("btn-danger").addClass("btn-danger");
                        $(obj3).removeClass("btn-danger").addClass("btn-danger");
                        $(obj4).removeClass("btn-danger").addClass("btn-primary");
                    }); 
                }
            }
            
            function sambapriv_requi(){
                //FUNÇÃO PARA HABILITAR O REQUERIMENTO DO PRIVATIVO E DESABILITA O SIMPLES
                $(function() {
                    $(smbpriv_requi).prop('required', true);
                    $(smbsimp_requi).prop('required', false);
                });
            }
            
            function sambasimp_requi(){
                //FUNÇÃO PARA HABILITAR O REQUERIMENTO DO SIMPLES E DESABILITA O PRIVATIVO
                $(function() {
                    $(smbpriv_requi).prop('required', false);
                    $(smbsimp_requi).prop('required', true);
                });       
            }
            
            $(function () {//HABILITA O TOOLTIP
              $('[data-toggle="tooltip"]').tooltip()
            })
        </script> 
    </head>
    <body>  
        <div class="container">
            <!--Navbar/Menu-->
            <?php include "menu.php"; ?>
            <!--Painel Configurados-->
            <div class="jumbotron">
                <?php 
                    if(isset($_SESSION["Sucesso"])){
                        echo '<p class="text-center alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sucesso! </strong>'; 
                        echo $_SESSION["Sucesso"]; 
                        unset($_SESSION["Sucesso"]);                     
                    }else if(isset($_SESSION["Erro"])){
                        echo '<p class="text-center alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erro! </strong>'; 
                        echo $_SESSION["Erro"];
                        unset($_SESSION["Erro"]);
                    }
                ?>
                <div class="container">
                    <div class="btn-group btn-group-justified">
                        <a class="btn btn-lg btn-primary" id="buttonMAQ" type="submit" onclick="return maq(tableMAQ,buttonMAQ,buttonFTP,buttonDHCP,buttonSAMBA);">Máquinas</a>
                        <a class="btn btn-lg btn-danger" id="buttonFTP" type="submit" onclick="return ftp(tableFTP,buttonMAQ,buttonFTP,buttonDHCP,buttonSAMBA);">FTP</a>
                        <a class="btn btn-lg btn-danger" id="buttonDHCP" type="submit" onclick="return dhcp(tableDHCP,buttonMAQ,buttonFTP,buttonDHCP,buttonSAMBA);">DHCP</a>
                        <a class="btn btn-lg btn-danger" id="buttonSAMBA" type="submit" onclick="return samba(tableSAMBA,buttonMAQ,buttonFTP,buttonDHCP,buttonSAMBA);">Samba</a>           
                    </div>
                </div>
                
                <!--Tabela de cadastro de máquinas-->
                <div id="tableMAQ" style="display:block"><br>                              
                    <div class="table-responsive">
                        <table class="table table-bordred table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-2">IP</th>
                                    <th class="col-md-2">Porta</th>
                                    <th class="col-md-2">Usuário</th>
                                    <th class="col-md-2">Senha</th>
                                    <th class="col-md-2">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query_maq=mysqli_query($conexao,"SELECT * FROM maquina"); ?>
                                <?php while($row=mysqli_fetch_array($query_maq)): ?>
                                    <tr>
                                        <td class="col-md-1"><?php echo $row['ID']; ?></td>
                                        <td class="col-md-2"><?php echo $row['Ip']; ?></td>
                                        <td class="col-md-2"><?php echo $row['Porta']; ?></td>
                                        <td class="col-md-2"><?php echo $row['Usuarioroot']; ?></td>
                                        <td class="col-md-2"><?php echo '*****'; ?></td>
                                        <td class="col-md-5">
                                            <form data-toggle="validator" role="form" method="post">
                                                <!--Botão editar-->
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalmaq" data-maq_id="<?php echo $row['ID']; ?>" 
                                                data-maq_ip="<?php echo $row['Ip']; ?>" data-maq_porta="<?php echo $row['Porta']; ?>" data-maq_usuarioroot="<?php echo $row['Usuarioroot']; ?>"  
                                                data-maq_senharoot="<?php echo $row['Senharoot']; ?>"><span class="glyphicon glyphicon-pencil"></span>Editar</button>
                                                <input type="hidden" name="id_maq_delete" id="id_maq_delete" value="<?php echo $row['ID']; ?>">
                                                <!--Botão deletar-->
                                                <button type="submit" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="bottom" title="Deleta somente do banco de dados" name="DeleteMAQno"><span class="glyphicon glyphicon-trash"></span>Deletar</button>
                                                <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Deleta tudo, ou seja, até mesmo do micro cliente" name="DeleteMAQyes"><span class="glyphicon glyphicon-trash"></span>Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!--Modal para editar Máquinas-->
                    <form data-toggle="validator" role="form" method="post">
                        <div class="modal fade" id="modalmaq" tabindex="-1" role="dialog" aria-labelledby="modalmaqLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">       
                                        
                                        <div class="form-group">
                                            <label class="control-label">Endereço IP da máquina e porta SSH: <span id="resultado_maq" style="color:red;"></span></label><!--IP E PORTA DA MÁQUINA-->
                                            <div class="input-group col-sm-6">
                                                <input type="text" name="ip" class="form-control" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" id="recipient-ip" required>
                                                <span class="input-group-addon">:</span>
                                                <input type="text" size="10" name="porta" class="form-control" pattern="[0-9]+$" maxlength="10" id="recipient-porta" required>
                                            </div>
                                            <div class="help-block with-errors">Somente números e pontos!</div>
                                        </div>  
                           
                                        <div class="form-group">
                                           <label class="control-label">Usuário:</label><!--USUÁRIO ROOT-->
                                                <input type="text" name="usuarioroot" class="form-control" maxlength="50" id="recipient-usuarioroot" required>
                                            <div class="help-block with-errors">Necessário usuário com permissão de administrador!</div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label class="control-label">Senha do usuário:</label><!--SENHA ROOT-->
                                            <input type="text" name="senharoot" class="form-control" maxlength="50" id="recipient-senharoot" required>
                                        </div>
                                        <input type="hidden" name="id-maq" id="id-maq">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="AlteraMAQ">Alterar</button>
                                        </div>
                                        
                                        <div class="text-center alert alert-warning alert-dismissable"><strong>Obs:</strong><br/>Alterar as configurações de IP neste menu não acarretará 
                                        na migração dos serviços em uma nova máquina.</div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!--Tabela de configuções FTP-->
                <div id="tableFTP" style="display:none"><br>                              
                    <div class="table-responsive">
                        <table class="table table-bordred table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-2">Usuário</th>
                                    <th class="col-md-2">Senha</th>
                                    <th class="col-md-2">Máquina</th>
                                    <th class="col-md-2">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query_ftp=mysqli_query($conexao,"SELECT * FROM ftp"); ?>
                                <?php while($row=mysqli_fetch_array($query_ftp)): ?>
                                <?php $row_maq=mysqli_fetch_array(mysqli_query($conexao,"SELECT Ip FROM maquina WHERE ID='$row[Maquina_Id]'")); ?>
                                    <tr>
                                        <td class="col-md-1"><?php echo $row['ID']; ?></td>
                                        <td class="col-md-2"><?php echo $row['Usuario']; ?></td>
                                        <td class="col-md-2"><?php echo '*****'; ?></td>
                                        <td class="col-md-2"><?php echo $row_maq['Ip']; ?></td>
                                        <td>
                                            <form data-toggle="validator" role="form" method="post">
                                                <!--Botão editar-->
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalftp" data-ftp_id="<?php echo $row['ID']; ?>" 
                                                data-ftp_user="<?php echo $row['Usuario']; ?>" data-ftp_pass="<?php echo $row['Senha']; ?>" data-maq_id_ftp="<?php echo $row['Maquina_Id']; ?>"
                                                ><span class="glyphicon glyphicon-pencil"></span>Editar</button>
                                                <input type="hidden" name="id_ftp_delete" id="id_ftp_delete" value="<?php echo $row['ID']; ?>">
                                                <input type="hidden" name="maq_id_ftp_delete" id="maq_id_ftp_delete" value="<?php echo $row['Maquina_Id']; ?>">
                                                <!--Botão deletar-->
                                                <button type="submit" class="btn btn-sm btn-danger" name="DeletaFTP"><span class="glyphicon glyphicon-trash"></span>Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!--Modal para editar FTP-->
                    <form data-toggle="validator" role="form" method="post">
                        <div class="modal fade" id="modalftp" tabindex="-1" role="dialog" aria-labelledby="modalftpLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label">Usuário: <span id="resultado_ftp" style="color:red;"></span></label>
                                            <input type="text" name="usuarioftp" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="10" id="recipient-user" required>
                                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label">Senha:</label>
                                            <input type="text" name="senhaftp" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="10" id="recipient-pass" required>
                                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                                        </div>
                                        <input type="hidden" name="id-ftp" id="id-ftp"><!--ID DO FTP NA TABELA-->
                                        <input type="hidden" name="maq-id-ftp" id="maq-id-ftp"><!--ID DA MÁQUINA -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="AlteraFTP">Alterar</button>
                                        </div>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!--Tabela de configuções DHCP-->
                <div id="tableDHCP" style="display:none"><br>
                    <div class="table-responsive">                            
                        <table class="table table-bordred table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Domínio</th>
                                    <th>DNS</th>
                                    <th>Gateway</th>
                                    <th>Servidor</th>
                                    <th>Máscara do servidor</th>
                                    <th>Range de IP's</th>
                                    <th>Máquina</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query_dhcp=mysqli_query($conexao,"SELECT * FROM dhcp"); ?>
                                <?php while($row=mysqli_fetch_array($query_dhcp)): ?>
                                <?php $row_maq=mysqli_fetch_array(mysqli_query($conexao,"SELECT Ip FROM maquina WHERE ID='$row[Maquina_Id]'")); ?>
                                    <tr>
                                        <td><?php echo $row['ID']; ?></td>
                                        <td><?php echo $row['Dominio']; ?></td>
                                        <td><?php echo $row['ServidorDNS']; ?></td>
                                        <td><?php echo $row['Gateway']; ?></td>
                                        <td><?php echo $row['Servidor']; ?></td>
                                        <td><?php echo $row['Mascara']; ?></td>
                                        <td><?php echo $row['Rangea']; ?> à <?php echo $row['Rangeb']; ?></td>
                                        <td><?php echo $row_maq['Ip']; ?></td>
                                        <td>
                                            <form data-toggle="validator" role="form" method="post">    
                                                <!--Botão editar-->
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modaldhcp" data-dhcp_id="<?php echo $row['ID']; ?>" 
                                                data-dhcp_dominio="<?php echo $row['Dominio']; ?>" data-dhcp_servidordns="<?php echo $row['ServidorDNS']; ?>" data-dhcp_gateway="<?php echo $row['Gateway']; ?>" 
                                                data-dhcp_servidor="<?php echo $row['Servidor']; ?>" data-dhcp_mascara="<?php echo $row['Mascara']; ?>" data-dhcp_rangea="<?php echo $row['Rangea']; ?>" 
                                                data-dhcp_rangeb="<?php echo $row['Rangeb']; ?>" data-maq_id_dhcp="<?php echo $row['Maquina_Id']; ?>"><span class="glyphicon glyphicon-pencil"></span>Editar</button>
                                                <input type="hidden" name="maq_id_dhcp_delete" id="maq_id_dhcp_delete" value="<?php echo $row['Maquina_Id']; ?>">
                                                <input type="hidden" name="id_dhcp_delete" id="id_dhcp_delete" value="<?php echo $row['ID']; ?>">
                                                <!--Botão deletar-->
                                                <button type="submit" class="btn btn-sm btn-danger" name="DeletaDHCP"><span class="glyphicon glyphicon-trash"></span>Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!--Modal para editar DHCP-->
                    <form data-toggle="validator" role="form" method="post">
                        <div class="modal fade" id="modaldhcp" tabindex="-1" role="dialog" aria-labelledby="modaldhcpLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label">Domínio:</label>
                                            <input type="text" name="dominio" class="form-control" pattern="[a-zA-Z\.]+" maxlength="20" id="recipient-dominio" required>
                                            <div class="help-block with-errors">Favor definir um dominio!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Servidor DNS:</label>
                                            <input type="text" name="servidordns" class="form-control" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" id="recipient-servidordns" required>
                                            <div class="help-block with-errors">IP do servidor dns, somente números e pontos!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Gateway:</label>
                                            <input type="text" name="gateway" class="form-control" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" id="recipient-gateway" required>
                                            <div class="help-block with-errors">IP do gateway, somente números e pontos!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Servidor:</label>
                                            <input type="text" name="servidor" class="form-control" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){3}$" maxlength="15" id="recipient-servidor" required>
                                            <div class="help-block with-errors">IP da rede do servidor, somente números e pontos!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Máscara do servidor:</label>
                                            <input type="text" name="mascara" class="form-control" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" id="recipient-mascara" required>
                                            <div class="help-block with-errors">Somente números e pontos!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Range de IP's:</label>
                                            <div class="input-group-addon">
                                                De:  <input type="text" size="2" name="rangea" class="form-control" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){1}$" maxlength="3" id="recipient-rangea" required> 
                                            </div>
                                            <div class="input-group-addon">
                                                Até: <input type="text" size="2" name="rangeb" class="form-control" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){1}$" maxlength="3" id="recipient-rangeb" required>
                                            </div>
                                            <div class="help-block with-errors">IP's que serão distribuidos!</div>
                                        </div>
                                        <input type="hidden" name="id-dhcp" id="id-dhcp"><!--ID DO FTP NA TABELA-->
                                        <input type="hidden" name="maq-id-dhcp" id="maq-id-dhcp"><!--ID DA MÁQUINA -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="AlteraDHCP">Alterar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!--Tabela de configuções SAMBA-->
                <div id="tableSAMBA" style="display:none"><br>
                    <!-- Tabela de configuções SAMBA SIMPLES-->
                    <div class="panel panel-primary">
                        <div class="panel-heading">Compartilhamento Simples</div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordred table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome do compar.</th>
                                    <th>Diretório</th>
                                    <th>Máquina</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query_smbsimp=mysqli_query($conexao,"SELECT * FROM smbsimp"); ?>
                                <?php while($row=mysqli_fetch_array($query_smbsimp)): ?>
                                <?php $row_maq=mysqli_fetch_array(mysqli_query($conexao,"SELECT Ip FROM maquina WHERE ID='$row[Maquina_Id]'")); ?>
                                    <tr>
                                        <td><?php echo $row['ID']; ?></td>                                      
                                        <td><?php echo $row['Nomesimp']; ?></td>
                                        <td><?php echo $row['Diretoriosimp']; ?></td>
                                        <td><?php echo $row_maq['Ip']; ?></td>
                                        <td>
                                            <form data-toggle="validator" role="form" method="post">    
                                                <!--Botão editar-->
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalsmbsimp" data-smbsimp_id="<?php echo $row['ID']; ?>" 
                                                data-smbsimp_nome="<?php echo $row['Nomesimp']; ?>" data-smbsimp_dire="<?php echo $row['Diretoriosimp']; ?>" data-maq_id_smbsimp="<?php echo $row['Maquina_Id']; ?>"
                                                onclick="sambasimp_requi()"><span class="glyphicon glyphicon-pencil"></span>Editar</button>
                                                <input type="hidden" name="maq_id_smbsimp_delete" id="maq_id_smbsimp_delete" value="<?php echo $row['Maquina_Id']; ?>">
                                                <input type="hidden" name="id_smbsimp_delete" id="id_smbsimp_delete" value="<?php echo $row['ID']; ?>">
                                                <!--Botão deletar-->
                                                <button type="submit" class="btn btn-sm btn-danger" name="DeletaSMBsimp"><span class="glyphicon glyphicon-trash"></span>Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Tabela de configuções SAMBA PRIVATIVO-->
                    <div class="panel panel-primary">
                        <div class="panel-heading">Compartilhamento Privativo</div>
                    </div>
                    <div class="table-responsive">                            
                        <table class="table table-bordred table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuário</th>
                                    <th>Senha</th>
                                    <th>Grupo(s)</th>
                                    <th>Nome do compar.</th>
                                    <th>Diretório</th>
                                    <th>Máquina</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $query_smbpriv=mysqli_query($conexao,"SELECT * FROM smbpriv"); ?>
                                <?php while($row=mysqli_fetch_array($query_smbpriv)): ?>
                                <?php $row_maq=mysqli_fetch_array(mysqli_query($conexao,"SELECT Ip FROM maquina WHERE ID='$row[Maquina_Id]'")); ?>
                                    <tr>
                                        <td><?php echo $row['ID']; ?></td>
                                        <td><?php echo $row['Usuariopriv']; ?></td>
                                        <td><?php echo '*****'; ?></td>
                                        <td><?php echo $row['Grupopriv']; ?></td>
                                        <td><?php echo $row['Nomepriv']; ?></td>
                                        <td><?php echo $row['Diretoriopriv']; ?></td>
                                        <td><?php echo $row_maq['Ip']; ?></td>
                                        <td>
                                            <form data-toggle="validator" role="form" method="post">
                                                <!--Botão editar-->
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalsmbpriv" data-smbpriv_id="<?php echo $row['ID']; ?>" 
                                                data-smbpriv_usu="<?php echo $row['Usuariopriv']; ?>" data-smbpriv_senha="<?php echo $row['Senhapriv']; ?>" data-smbpriv_grupodonopriv="<?php echo $row['Grupopriv']; ?>" 
                                                data-smbpriv_nome="<?php echo $row['Nomepriv']; ?>" data-smbpriv_dire="<?php echo $row['Diretoriopriv']; ?>" data-maq_id_smbpriv="<?php echo $row['Maquina_Id']; ?>" onclick="sambapriv_requi()">
                                                <span class="glyphicon glyphicon-pencil"></span>Editar</button>
                                                <input type="hidden" name="maq_id_smbpriv_delete" id="maq_id_smbpriv_delete" value="<?php echo $row['Maquina_Id']; ?>">
                                                <input type="hidden" name="id_smbpriv_delete" id="id_smbpriv_delete" value="<?php echo $row['ID']; ?>">
                                                <!--Botão deletar-->
                                                <button type="submit" class="btn btn-sm btn-danger" name="DeletaSMBpriv"><span class="glyphicon glyphicon-trash"></span>Deletar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!--Modal para editar SAMBA SIMPLES-->
                    <form data-toggle="validator" role="form" method="post">
                        <div class="modal fade" id="modalsmbsimp" tabindex="-1" role="dialog" aria-labelledby="modalsmbsimplabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label">Nome do compartilhamento: <span id="resultado_compar_smbsimp" style="color:red;"></span></label>
                                            <input type="text" name="nomesimp" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="25" id="recipient-nomesimp" required>
                                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Diretório: <span id="resultado_dire_smbsimp" style="color:red;"></span></label>
                                            <input type="text" name="diretoriosimp" class="form-control" pattern="(/home)\/([a-zA-Z0-9*_-]+)" id="recipient-diretoriosimp" required>
                                            <div class="help-block with-errors">Utilize letras, números e/ou os caracteres: *_-</div>
                                        </div>
                                        <input type="hidden" name="id-smbsimp" id="id-smbsimp"><!--ID DO smbsimp NA TABELA-->
                                        <input type="hidden" name="maq-id-smbsimp" id="maq-id-smbsimp"><!--ID DA MÁQUINA -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="AlteraSMBsimp">Alterar</button>
                                        </div>
                                        
                                        <div class="text-center alert alert-warning alert-dismissable"><strong>Obs:</strong><br/>Caso seja feita a alteração do caminho do compartilhamento,
                                        o diretório atual será removido senão estiver sendo utilizado pelo FTP e/ou outro compartilhamento Samba.</div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!--Modal para editar SAMBA PRIVATIVO-->
                        <div class="modal fade" id="modalsmbpriv" tabindex="-1" role="dialog" aria-labelledby="modalsmbprivlabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label">Usuário que será dono do compartilhamento:</label>
                                            <input type="text" name="usuariopriv" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="10" id="recipient-usuariopriv" required>
                                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Senha do usuário:</label>
                                            <input type="text" name="senha" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="10" id="recipient-senha" required>
                                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Grupo(s) que será dono do compartilhamento:</label>
                                            <input type="text" name="grupodonopriv" class="form-control" pattern="^([a-zA-Z]+,){0,300}[a-zA-Z]+$" maxlength="500" id="recipient-grupodonopriv" required>
                                            <div class="help-block with-errors">Somente letras, separe os grupos com vírgula!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Nome do compartilhamento: <span id="resultado_compar_smbpriv" style="color:red;"></span></label>
                                            <input type="text" name="nomepriv" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="25" id="recipient-nomepriv" required>
                                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Diretório: <span id="resultado_dire_smbpriv" style="color:red;"></span></label>
                                            <input type="text" name="diretoriopriv" class="form-control" pattern="(/home)\/([a-zA-Z0-9*_-]+)" id="recipient-diretoriopriv" required>
                                            <div class="help-block with-errors">Utilize letras, números e/ou os caracteres: *_-</div>
                                        </div>
                                        <input type="hidden" name="id-smbpriv" id="id-smbpriv"><!--ID DO smbpriv NA TABELA-->
                                        <input type="hidden" name="maq-id-smbpriv" id="maq-id-smbpriv"><!--ID DA MÁQUINA -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="AlteraSMBpriv">Alterar</button>
                                        </div>
                                        
                                        <div class="text-center alert alert-warning alert-dismissable"><strong>Obs:</strong><br/>Caso seja feita a alteração do caminho do compartilhamento,
                                        o diretório atual será removido senão estiver sendo utilizado pelo FTP e/ou outro compartilhamento Samba.</div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <script>
            //OS PARÂMETROS VEM DO BOTÃO EDITAR E DAQUI PASSA PRO MODAL
            //DEFINE OS VALORES DENTRO DOS CAMPOS DA MODAL DO MÁQUINAS
            $('#modalmaq').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var recipient_id = button.data('maq_id')
                var recipient_ip = button.data('maq_ip') //maq_ip é valor pego do banco de dados data-maq_ip
                var recipient_porta = button.data('maq_porta')
                var recipient_usuarioroot = button.data('maq_usuarioroot')
                var recipient_senharoot = button.data('maq_senharoot')

                var modal = $(this)
                //ID DO MODAL E A VARIÁVEL A CIMA
                modal.find('#id-maq').val(recipient_id)
                modal.find('#recipient-ip').val(recipient_ip) //recipient_ip é valor da variável acima
                modal.find('#recipient-porta').val(recipient_porta)
                modal.find('#recipient-usuarioroot').val(recipient_usuarioroot)
                modal.find('#recipient-senharoot').val(recipient_senharoot)
            })
            
            //DEFINE OS VALORES DENTRO DOS CAMPOS DA MODAL DO FTP
            $('#modalftp').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var recipient_id = button.data('ftp_id')
                var recipient_maq_id = button.data('maq_id_ftp')
                var recipient_user = button.data('ftp_user')
                var recipient_pass = button.data('ftp_pass')

                var modal = $(this)
                //ID DO MODAL E A VARIÁVEL A CIMA
                modal.find('#id-ftp').val(recipient_id)
                modal.find('#maq-id-ftp').val(recipient_maq_id)
                modal.find('#recipient-user').val(recipient_user)
                modal.find('#recipient-pass').val(recipient_pass)
            })
            
            //DEFINE OS VALORES DENTRO DOS CAMPOS DA MODAL DO DHCP
            $('#modaldhcp').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var recipient_id = button.data('dhcp_id')
                var recipient_maq_id = button.data('maq_id_dhcp')
                var recipient_dominio = button.data('dhcp_dominio')
                var recipient_servidordns = button.data('dhcp_servidordns')
                var recipient_gateway = button.data('dhcp_gateway')
                var recipient_servidor = button.data('dhcp_servidor')
                var recipient_mascara = button.data('dhcp_mascara')
                var recipient_rangea = button.data('dhcp_rangea')
                var recipient_rangeb = button.data('dhcp_rangeb')

                var modal = $(this)
                //ID DO MODAL E A VARIÁVEL
                modal.find('#id-dhcp').val(recipient_id)
                modal.find('#maq-id-dhcp').val(recipient_maq_id)
                modal.find('#recipient-dominio').val(recipient_dominio)
                modal.find('#recipient-servidordns').val(recipient_servidordns)
                modal.find('#recipient-gateway').val(recipient_gateway)
                modal.find('#recipient-servidor').val(recipient_servidor)
                modal.find('#recipient-mascara').val(recipient_mascara)
                modal.find('#recipient-rangea').val(recipient_rangea)
                modal.find('#recipient-rangeb').val(recipient_rangeb)
            })
            
            //DEFINE OS VALORES DENTRO DOS CAMPOS DA MODAL DO SAMBA SIMPLES
            $('#modalsmbsimp').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var recipient_id = button.data('smbsimp_id')
                var recipient_maq_id = button.data('maq_id_smbsimp')
                var recipient_nomesimp = button.data('smbsimp_nome')
                var recipient_diretoriosimp = button.data('smbsimp_dire')

                var modal = $(this)
                //ID DO MODAL E A VARIÁVEL
                modal.find('#id-smbsimp').val(recipient_id)
                modal.find('#maq-id-smbsimp').val(recipient_maq_id)
                modal.find('#recipient-nomesimp').val(recipient_nomesimp)
                modal.find('#recipient-diretoriosimp').val(recipient_diretoriosimp)
            })
            
            //DEFINE OS VALORES DENTRO DOS CAMPOS DA MODAL DO SAMBA PRIVATIVO
            $('#modalsmbpriv').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var recipient_id = button.data('smbpriv_id')
                var recipient_maq_id = button.data('maq_id_smbpriv')
                var recipient_usuariopriv = button.data('smbpriv_usu')
                var recipient_senha = button.data('smbpriv_senha')
                var recipient_grupodonopriv = button.data('smbpriv_grupodonopriv')
                var recipient_nomepriv = button.data('smbpriv_nome')
                var recipient_diretoriopriv = button.data('smbpriv_dire')
                
                var modal = $(this)
                //ID DO MODAL E A VARIÁVEL
                modal.find('#id-smbpriv').val(recipient_id)
                modal.find('#maq-id-smbpriv').val(recipient_maq_id)
                modal.find('#recipient-usuariopriv').val(recipient_usuariopriv)
                modal.find('#recipient-senha').val(recipient_senha)
                modal.find('#recipient-grupodonopriv').val(recipient_grupodonopriv)
                modal.find('#recipient-nomepriv').val(recipient_nomepriv)
                modal.find('#recipient-diretoriopriv').val(recipient_diretoriopriv)
            })
        </script>
    </body>
</html>
<!--EXECUTA AS PESQUISAS MYSQL-->
<script src="js/pesquisa-mysql.js" charset="ISO-8859-1"></script>
<?php
    include("edittable.php");
?>