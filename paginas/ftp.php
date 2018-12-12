<?php
    include("conexao.php");
    session_start();
    include("proteger.php");
    proteger();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> FTP </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap-validator.js"></script>
        <script src="js/bootstrap-mostra-senha.js"></script>
        <script src="js/valida-e-mostra-senha.js"></script>
        <script src="js/bootstrap-select.js"></script>
    </head>
    <body>  
        <div class="container">
            <!--Navbar/Menu-->
            <?php include "menu.php"; ?>
            <!--Painel ftp-->
            <div class="jumbotron">
                <form data-toggle="validator" role="form" id="form-senha" method="post">
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
                    <h2 class="panel panel-primary">
                        <div class="panel-heading">FTP</div>
                    </h2>
                    
                    <!--ESCOLHER A MÁQUINA-->
                    <div class="form-group">
                        <h4>Quem receberá as configurações?</h4>
                        <select class="selectpicker" required="required" name="id_maquina" id="id_maquina">
                            <?php $query_maq=mysqli_query($conexao,"SELECT * FROM maquina"); ?>
                            <?php while($row=mysqli_fetch_array($query_maq)): ?>
                                <option value="<?php echo $row['ID']; ?>"><?php echo $row['Ip']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>         
                    
                    <div class="form-group">
                        <h4>Criação de usuário</h4>
                        <label class="control-label">Usuário: <span id="resultado" style="color:red;"></span></label><!--USUÁRIO FTP-->
                        <div class="input-group">
                            <!--Os dois comandos abaixo limpam os campos usuário e senha-->
                            <input type="text" style="display:none">
                            <input type="password" style="display:none">
                            <input type="text" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Nome do usuário" name="usuarioftp" id="usuarioftp" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                        </div>
                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Senha do usuário:</label><!--SENHA FTP-->
                        <div class="input-group">
                            <input type="password" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Senha" data-toggle="password" name="senha" id="senha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                        </div>
                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Confirme a senha do usuário:</label><!--CONFIRMAÇÃO DA SENHA FTP-->
                        <div class="input-group">
                            <input type="password" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Senha" data-toggle="password" name="csenha" id="csenha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                        </div>
                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                    </div>
                    
                    <div class="form-group">
                        <button class="btn btn-lg btn-success" type="submit" name="ConfigFTP" id="ConfigFTP">Confirmar</button>
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