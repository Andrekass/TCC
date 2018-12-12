<?php
    include("conexao.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> Cadastro </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/index-modal.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap-validator.js"></script>
        <script src="js/bootstrap-mostra-senha.js"></script>
        <script src="js/valida-e-mostra-senha.js"></script>
        <script src="js/bootstrap-select.js"></script>
        <script>
            document.write("
            <?php 
                $row = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM login"));//PESQUISA NA TABELA login
                if(!is_null($row["Usuario"])){//SE EXISTIR USUÁRIO
                    header("Location: index.php");//REDIRECIONA PRA PÁGINA DE LOGIN
                }else{//CASO NÃO EXISTIR O USUÁRIO NÃO FAÇA NADA
                }
            ?>");
        </script>
    </head>
    <body>  
        <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-md-offset-3">
                            <form data-toggle="validator" role="form" id="form-senha" method="post">
                                <h1 class="form-signin-heading">Cadastro</h1><br>

                                <div class="form-group"><!--USUÁRIO-->
                                    <div class="input-group">
                                        <!--Os dois comandos abaixo limpam os campos usuário e senha-->
                                        <input type="text" style="display:none">
                                        <input type="password" style="display:none">
                                        <input type="text" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Usuário" name="usuario" id="usuario">                    
                                    </div>
                                    <div class="help-block with-errors">Somente letras e/ou números!</div>
                                 </div>

                                <div class="form-group"><!--SENHA-->
                                    <div class="input-group">
                                        <input type="password" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Senha" data-toggle="password" name="senha" id="senha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                                    </div>
                                    <div class="help-block with-errors">Somente letras e/ou números!</div>
                                </div>
                                
                                <div class="form-group"><!--CONFIRMAÇÃO DA SENHA-->
                                    <div class="input-group">
                                        <input type="password" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Confirme a senha" data-toggle="password" name="csenha" id="csenha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                                    </div>
                                    <div class="help-block with-errors">Somente letras e/ou números!</div>
                                </div>
                                
                                <div class="form-group"><!--PERGUNTA SECRETA-->
                                    <label>Pergunta secreta:</label><br>
                                    <select class="selectpicker" name="pergunta">
                                        <option value="Em que cidade você nasceu?">Em que cidade você nasceu?</option>
                                        <option value="Qual é o nome do seu animal de estimação?">Qual é o nome do seu animal de estimação?</option>
                                        <option value="Qual é o nome do meio do seu pai?">Qual é o nome do meio do seu pai?</option>
                                        <option value="Qual é a sua comida favorita?">Qual é a sua comida favorita?</option>
                                    </select>
                                </div>
                                
                                <div class="form-group"><!--RESPOSTA SECRETA-->
                                    <div class="input-group">
                                        <input type="text" class="form-control" required="required" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Resposta secreta" name="resposta" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);"/>
                                    </div>
                                    <div class="help-block with-errors">Somente letras e/ou números!</div>
                                </div>
                                
                                <div class="col-md-offset-1">
                                    <button class="btn btn-lg btn-success" type="submit" name="Cadastrar">Confirmar</button>
                                </div>
                            </form>                            
                        </div>
                        <br>
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
                    </div>
                </div>
            </div>
        </div>    
        <!--Modal de cadastro-->
        <script type="text/javascript">
            $('#memberModal').modal({backdrop:'static',keyboard:false, show:true});
            //Select da pergunta secreta
            $('.selectpicker').selectpicker({
                style: 'btn-default',
                size: 4
            });     
        </script>
    </body>
<html>
<?php
    include("codphp.php");
?>
