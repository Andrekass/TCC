<?php
    include("conexao.php");
    session_start();
    include("proteger.php");
    proteger();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> Cadastro de máquina </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap-validator.js"></script>
        <script src="js/bootstrap-mostra-senha.js"></script>
        <script src="js/valida-e-mostra-senha.js"></script>
    </head>
    <body>
        <div class="container">
            <!--Navbar/Menu-->
            <?php include "menu.php"; ?>
            <!--Painel Cadastro de máquina-->
            <div class="jumbotron">
                <form data-toggle="validator" role="form" id="form-senha" method="post">
                    <?php 
                        if(isset($_SESSION["Sucesso"])){
                            echo '<p class="text-center alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sucesso! </strong>'; 
                            echo $_SESSION["Sucesso"]; 
                            unset($_SESSION["Sucesso"]);                     
                        }
                        else if(isset($_SESSION["Erro"])){
                            echo '<p class="text-center alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erro! </strong>'; 
                            echo $_SESSION["Erro"];
                            unset($_SESSION["Erro"]);
                        }
                    ?>
                    <h2 class="panel panel-primary">
                        <div class="panel-heading">Cadastro de máquina</div>
                    </h2>
                    
                    <div class="form-group">
                        <label class="control-label">Endereço IP da máquina e porta SSH: <span id="resultado" style="color:red;"></span></label><!--IP DA MÁQUINA-->
                        <div class="input-group col-sm-4">
                            <input type="text" class="form-control" required="required" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" placeholder="000.000.000.000" name="ip" id="ip">
                            <span class="input-group-addon">:</span>
                            <input type="text" size="10" class="form-control" required="required" pattern="[0-9]+$" maxlength="10" value="22" name="porta">
                        </div>
                        <div class="help-block with-errors">Somente números e pontos!</div>
                    </div>  
                                        
                    <div class="form-group">
                        <label class="control-label">Usuário:</label><!--USUÁRIO ROOT-->
                        <div class="input-group">
                            <!--Os dois comandos abaixo limpam os campos usuário e senha-->
                            <input type="text" style="display:none">
                            <input type="password" style="display:none">
                            <input type="text" class="form-control" maxlength="50" required="required" placeholder="root" name="usuarioroot">
                        </div>
                        <div class="help-block with-errors">Necessário usuário com permissão de administrador!</div>
                    </div> 
                    
                    <div class="form-group">
                        <label class="control-label">Senha do usuário:</label><!--SENHA ROOT-->
                        <div class="input-group">
                            <input type="password" class="form-control" required="required" placeholder="Senha" data-toggle="password" name="senha" id="senha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Confirme a senha do usuário:</label><!--CONFIRMAÇÃO DA SENHA ROOT-->
                        <div class="input-group">
                            <input type="password" class="form-control" required="required" placeholder="Senha" data-toggle="password" name="csenha" id="csenha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                        </div>
                    </div>
 
                    <div class="form-group">
                        <button class="btn btn-lg btn-success" type="submit" name="ConfigMAQUINA" id="ConfigMAQUINA">Confirmar</button> 
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<!--EXECUTA AS PESQUISAS MYSQL-->
<script src="js/pesquisa-mysql.js" charset="ISO-8859-1"></script>
<?php
    include("codphp.php");
?>
