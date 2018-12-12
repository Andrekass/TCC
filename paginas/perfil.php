<?php
    include("conexao.php");
    session_start();
    include("proteger.php");
    proteger();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> Perfil </title>
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
            <!--Painel perfil-->
            <div class="jumbotron">
                <form data-toggle="validator" role="form" id="form-senha" method="post">
                    <center>
                        <div class="form-group">
                            <?php 
                                if(isset($_SESSION["Sucesso_perfil"])){
                                    echo '<p class="text-center alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sucesso! </strong>'; 
                                    echo $_SESSION["Sucesso_perfil"]; 
                                    unset($_SESSION["Sucesso_perfil"]);                     
                                }
                                else if(isset($_SESSION["Erro_perfil"])){
                                    echo '<p class="text-center alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erro! </strong>'; 
                                    echo $_SESSION["Erro_perfil"];
                                    unset($_SESSION["Erro_perfil"]);
                                }else if(isset($_SESSION["Invalido_perfil"])){
                                    echo '<p class="text-center alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Inválido! </strong>'; 
                                    echo $_SESSION["Invalido_perfil"];
                                    unset($_SESSION["Invalido_perfil"]);
                                }
                            ?>
                            <h2>Perfil</h2><br/>
                            <label class="control-label">Usuário:</label><!--USUÁRIO-->
                            <div class="input-group">
                                <?php $row_usuario = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM login")); ?><!--PEGA O NOME DO USUÁRIO NO BANCO-->
                                <input type="text" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" value="<?php echo $row_usuario['Usuario']; ?>" name="usuario" id="usuario">
                            </div>
                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                        </div> 
                        
                        <div class="form-group">
                            <label class="control-label">Senha atual:</label><!--SENHA ATUAL-->
                            <div class="input-group">
                                <!--O comando abaixo limpam o campo senha-->
                                <input type="password" style="display:none">
                                <input type="password" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" name="senhaatual" id="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                            </div>
                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                        </div>   

                        <div class="form-group">
                            <label class="control-label">Nova senha:</label><!--NOVA SENHA-->
                            <div class="input-group">
                                <input type="password" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" data-toggle="password" name="senha" id="senha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                            </div>
                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                        </div>
                                
                        <div class="form-group">
                            <label class="control-label">Confirme a nova senha:</label><!--CONFIRMAÇÃO DA NOVA SENHA-->
                            <div class="input-group">
                                <input type="password" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" data-toggle="password" name="csenha" id="csenha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                            </div>
                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                        </div>
                        
                        <div class="form-group"><!--NOVA PERGUNTA SECRETA-->
                            <label>Nova pergunta secreta:</label><br>
                            <select class="selectpicker" name="novapergunta">
                                <option value="Em que cidade você nasceu?">Em que cidade você nasceu?</option>
                                <option value="Qual é o nome do seu animal de estimação?">Qual é o nome do seu animal de estimação?</option>
                                <option value="Qual é o nome do meio do seu pai?">Qual é o nome do meio do seu pai?</option>
                                <option value="Qual é a sua comida favorita?">Qual é a sua comida favorita?</option>
                            </select>
                        </div>

                        <div class="form-group"><!--RESPOSTA SECRETA-->
                            <div class="input-group">
                                <input type="text" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Resposta secreta" name="novaresposta">
                            </div>
                            <div class="help-block with-errors">Somente letras e/ou números!</div>
                        </div>
                        
     
                        <div class="form-group">
                            <button class="btn btn-lg btn-success" type="submit" name="ConfigPERFIL">Confirmar</button> 
                        </div>
                    </center>
                </form>
            </div>
        </div>
        <!--Select da pergunta secreta-->
        <script type="text/javascript">
            $('.selectpicker').selectpicker({
                style: 'btn-default',
                size: 4
            });     
        </script>
    </body>
</html>
<?php
    include("codphp.php");
?>