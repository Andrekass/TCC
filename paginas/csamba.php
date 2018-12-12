<?php
    include("conexao.php");
    session_start();
    include("proteger.php");
    proteger();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> SAMBA </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/bootstrap-checkbox.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap-validator.js"></script>
        <script src="js/bootstrap-mostra-senha.js"></script>
        <script src="js/valida-e-mostra-senha.js"></script>
        <script src="js/bootstrap-select.js"></script>
        <script>
			function compar1(obj){ //FUNÇÃO ATIVADA PELO CHECKBOX DO COMPARTILHAMENTO SIMPLES
				if(obj.style.display == "block"){ //CASO A DIV ESTIVER ATIVA EXECUTA A FUNÇÃO ABAIXO
					obj.style.display = "none"; //ESCONDE A DIV DO COMPARTILHAMENTO SIMPLES
                    $(function() {
                        $("#nomesimp,#diretoriosimp").prop('required', false);//DESABILITAR O REQUERIMENTO
                        $("#nomesimp,#diretoriosimp").val("");//LIMPA OS CAMPOS
                    });
				}else if(obj.style.display == "none"){ //CASO A DIV ESTIVER DESATIVA EXECUTA A FUNÇÃO ABAIXO
					obj.style.display = "block"; //MOSTRA A DIV DO COMPARTILHAMENTO SIMPLES
                    $(function() { //FUNÇÃO PARA HABILITAR O REQUERIMENTO
                        $("#nomesimp,#diretoriosimp").prop('required', true);
                    });                    
				}
			}      
            function compar2(obj){ //FUNÇÃO ATIVADA PELO CHECKBOX DO COMPARTILHAMENTO PRIVATIVO
                if(obj.style.display == "block"){ //CASO A DIV ESTIVER ATIVA EXECUTA A FUNÇÃO ABAIXO
					obj.style.display = "none"; //ESCONDE A DIV DO COMPARTILHAMENTO PRIVATIVO
                    $(function() {
                        $("#usuariopriv,#senha,#csenha,#grupopriv,#nomepriv,#diretoriopriv").prop('required', false);//DESABILITAR O REQUERIMENTO
                        $("#usuariopriv,#senha,#csenha,#grupopriv,#nomepriv,#diretoriopriv").val("");//LIMPA OS CAMPOS
                    });
				}else if(obj.style.display == "none"){ //CASO A DIV ESTIVER DESATIVA EXECUTA A FUNÇÃO ABAIXO
					obj.style.display = "block"; //MOSTRA A DIV DO COMPARTILHAMENTO PRIVATIVO
                    $(function() { //FUNÇÃO PARA HABILITAR O REQUERIMENTO
                        $("#usuariopriv,#senha,#csenha,#grupopriv,#nomepriv,#diretoriopriv").prop('required', true);
                    });
				}
			}
		</script>
        <script>
            $(function() { //FUNCÂO JQUERY DA CHECKBOX
                $('input[type="checkbox"]').checkboxpicker();
            });
        </script>
    </head>
    <body>
        <div class="container">
            <!--Navbar/Menu-->
            <?php include "menu.php"; ?>
            <!--Painel samba-->
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
                        }else if(isset($_SESSION["Invalido"])){
                            echo '<p class="text-center alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Inválido! </strong>'; 
                            echo $_SESSION["Invalido"];
                            unset($_SESSION["Invalido"]);
                        }
                    ?>
                    <h2 class="panel panel-primary">
                        <div class="panel-heading">Samba</div>
                    </h2> 
                    
                    <!--CHECKBOX DO COMPARTILHAMENTO SIMPLES-->
                    <div class="col-lg-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">Compartilhamento Simples</div>
                            <div class="panel-body">
                                <input type="checkbox" data-reverse onchange="return compar1(csimples);" checked>
                                
                                <!--COMPARTILHAMENTO SIMPLES-->
                                <div id="csimples" style="display:block"><br>
                                    <div class="form-group">
                                        <label class="control-label">Nome do compartilhamento: <span id="resul_compar_simp" style="color:red;"></span></label><!--NOME DO COMPARTILHAMENTO-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="25" placeholder="Compartilhamento" name="nomesimp" id="nomesimp" required>
                                        </div>
                                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="control-label">Diretório: <span id="resul_dire_simp" style="color:red;"></span></label><!--DIRETÓRIO COMPARTILHADO-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" pattern="(/home)\/([a-zA-Z0-9*_-]+)" placeholder="/home/pasta" name="diretoriosimp" id="diretoriosimp" required>
                                        </div>
                                        <div class="help-block with-errors">Utilize letras, números e/ou os caracteres: *_-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                   
                    <!--CHECKBOX DO COMPARTILHAMENTO PRIVATIVO-->
                    <div class="col-lg-6">
                        <div class="panel panel-info">
                            <div class="panel-heading">Compartilhamento Privativo</div>
                            <div class="panel-body">
                                <input type="checkbox" data-reverse onchange="return compar2(cprivativo);" checked>
                                
                                <!--COMPARTILHAMENTO PRIVATIVO-->
                                <div id="cprivativo" style="display:block"><br>
                                    <div class="form-group">  
                                        <label class="control-label">Usuário que será dono do compartilhamento:</label><!--USUÁRIO SAMBA-->
                                        <div class="input-group">
                                            <!--Os dois comandos abaixo limpam os campos usuário e senha-->
                                            <input type="text" style="display:none">
                                            <input type="password" style="display:none">
                                            <input type="text" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Nome do usuário" name="usuariopriv" id="usuariopriv" required>
                                        </div>
                                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="control-label">Senha do usuário:</label><!--SENHA DO USUÁRIO SAMBA-->
                                        <div class="input-group">
                                            <input type="password" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Senha" data-toggle="password" name="senha" id="senha" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);" required>
                                        </div>
                                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Confirme a senha do usuário:</label><!--CONFIRMAÇÃO DA SENHA DO USUÁRIO SAMBA-->
                                        <div class="input-group">
                                            <input type="password" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="10" placeholder="Senha" data-toggle="password" name="csenha" id="csenha" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');this.select();" onBlur="this.setAttribute('readonly', true);" required>
                                        </div>
                                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="control-label">Grupo(s) que será dono do compartilhamento:</label><!--GRUPO SAMBA-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" pattern="^([a-zA-Z]+,){0,300}[a-zA-Z]+$" maxlength="500" placeholder="Nome do grupo" name="grupopriv" id="grupopriv" required>
                                        </div>
                                        <div class="help-block with-errors">Somente letras, separe os grupos com vírgula!</div>
                                    </div>
                                
                                    <div class="form-group">
                                        <label class="control-label">Nome do compartilhamento: <span id="resul_dire_compar" style="color:red;"></span></label><!--NOME DO COMPARTILHAMENTO-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" pattern="[a-zA-Z0-9]+" maxlength="25" placeholder="Compartilhamento" name="nomepriv" id="nomepriv" required>
                                        </div>
                                        <div class="help-block with-errors">Somente letras e/ou números!</div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Diretório: <span id="resul_dire_priv" style="color:red;"></span></label><!--DIRETÓRIO COMPARTILHADO-->
                                        <div class="input-group">
                                            <input type="text" class="form-control" pattern="(/home)\/([a-zA-Z0-9*_-]+)" placeholder="/home/pasta" name="diretoriopriv" id="diretoriopriv" required>
                                        </div>
                                        <div class="help-block with-errors">Utilize letras, números e/ou os caracteres: *_-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="panel panel-info">
                                <div class="panel-body">                                        
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
                                        <button class="btn btn-lg btn-success" type="submit" name="ConfigSAMBA" id="ConfigSAMBA">Confirmar</button> 
                                    </div>

                                </div>
                            </div>
                        </div>
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