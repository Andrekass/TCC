<?php
    include("conexao.php");
    session_start();
    include("logout.php");
    logout();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> Login </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/index-modal.css">
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/bootstrap.js"></script>
        <script>
            document.write("
            <?php 
                $row = mysqli_fetch_array(mysqli_query($conexao, "SELECT * FROM login"));//PESQUISA NA TABELA login
                if(is_null($row["Usuario"])){//SE NÃO EXISTIR USUÁRIO
                    header("Location: cadastro.php");//REDIRECIONA PRA PÁGINA DE CADASTRO
                }else{//CASO EXISTIR O USUÁRIO NÃO FAÇA NADA
                }
            ?>");
        </script>
    </head>
    <body>
        <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form class="form-signin" method="post" action="index.php?pag=checkLogin">
                            <h2 class="form-signin-heading">Painel de controle</h2>
                            <input type="text" class="form-control" placeholder="Usuário" required="required" name="usuario" readonly onfocus="this.removeAttribute('readonly');this.select();">
                            <input type="password" class="form-control" placeholder="Senha" required="required" name="senha" readonly onfocus="this.removeAttribute('readonly');this.select();">
                            <button class="btn btn-lg btn-success btn-block" type="submit">Login</button>
                            <a href="#" data-target="#pwdModal" data-toggle="modal">Esqueci minha senha/usuário</a>
                        </form>
                        <br />
                        <?php 
                            if(isset($_SESSION["Sucesso"])){
                                echo '<p class="text-center alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Sucesso! </strong>'; 
                                echo $_SESSION["Sucesso"]; 
                                unset($_SESSION["Sucesso"]);                     
                            }else if(isset($_SESSION["Erro"])){
                                echo '<p class="text-center alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erro! </strong>'; 
                                echo $_SESSION["Erro"];
                                unset($_SESSION["Erro"]);
                            }else if(isset($_SESSION["Invalido"])){
                                echo '<p class="text-center alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Inválido! </strong>'; 
                                echo $_SESSION["Invalido"];
                                unset($_SESSION["Invalido"]);
                            }  
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!--Segundo modal--><!--MODAL DE ESQUECI MINHA SENHA-->
        <div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h1 class="text-center">Responta a pergunta secreta.</h1>
                        <!--Terceiro modal-->
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <p><?php echo $row['Pergunta']; ?></p> <!--PERGUNTA PARA RECUPERAR SENHA-->
                                            <div class="panel-body">
                                                <fieldset>
                                                    <form data-toggle="validator" role="form" method="post">
                                                        <div class="form-group">
                                                            <input class="form-control input-lg" pattern="[a-zA-Z0-9]+" placeholder="Responta" name="Resposta_usu" readonly onfocus="this.removeAttribute('readonly');this.select();"/>
                                                        </div>
                                                        <button class="btn btn-lg btn-success btn-block" type="submit" name="Recupera">Confirmar</button>
                                                    </form>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal de login-->
        <script type="text/javascript">
            $('#memberModal').modal({backdrop:'static',keyboard:false, show:true});
        </script>
    </body>
<html>
<?php
    include("codphp.php");
?>
