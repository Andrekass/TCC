<?php
    include("conexao.php");
    session_start();
    include("proteger.php");
    proteger();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title> DHCP </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/bootstrap-validator.js"></script>
        <script src="js/bootstrap-select.js"></script>
    </head>
    <body>    
        <div class="container">
            <!--Navbar/Menu-->
            <?php include "menu.php"; ?>
            <!--Painel dhcp-->
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
                        <div class="panel-heading">DHCP</div>
                    </h2>
                    
                    <!--ESCOLHER A MÁQUINA-->
                    <div class="form-group">
                        <h4>Quem receberá as configurações?</h4>
                        <select class="selectpicker" required="required" name="id_maquina">
                            <!--PEGA SOMENTE AS MÁQUINAS QUE AINDA NÃO TIVERAM O DHCP CONFIGURADO-->
                            <?php $query_maq=mysqli_query($conexao,"SELECT t.* FROM maquina t WHERE NOT EXISTS(SELECT NULL FROM dhcp t1 WHERE t1.Maquina_ID = t.ID);"); ?>
                            <?php while($row=mysqli_fetch_array($query_maq)): ?>
                                <option value="<?php echo $row['ID']; ?>"><?php echo $row['Ip']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div> 
                    
                    <div class="form-group"> 
                        <label class="control-label">Domínio:</label><!--DOMINIO-->
                        <div class="input-group">
                            <input type="text" class="form-control" required="required" pattern="[a-zA-Z\.]+" maxlength="20" placeholder="dominio.net" name="dominio">
                        </div>
                        <div class="help-block with-errors">Favor definir um dominio!</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Servidor DNS:</label><!--SERVIDOR DNS-->
                        <div class="input-group">
                            <input type="text" class="form-control" required="required" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" placeholder="8.8.8.8" name="servidordns">
                        </div>
                        <div class="help-block with-errors">IP do servidor dns, somente números e pontos!</div>
                    </div>    
                        
                    <div class="form-group">  
                        <label class="control-label">Gateway:</label><!--GATEWAY-->
                        <div class="input-group">
                            <input type="text" class="form-control" required="required" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" placeholder="000.000.000.000" name="gateway">
                        </div>
                        <div class="help-block with-errors">IP do gateway, somente números e pontos!</div>
                    </div>
                     
                    <div class="form-group">
                        <label class="control-label">Servidor:</label><!--SERVIDOR-->
                        <div class="input-group">
                            <input type="text" class="form-control" required="required" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){3}$" maxlength="15" placeholder="000.000.000" name="servidor">
                        </div>
                        <div class="help-block with-errors">IP da rede do servidor, somente números e pontos!</div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Máscara do servidor:</label><!--MÁSCARA DO SERVIDOR-->
                        <div class="input-group">
                            <input type="text" class="form-control" required="required" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$" maxlength="15" placeholder="000.000.000.000" name="mascara">
                        </div>
                        <div class="help-block with-errors">Somente números e pontos!</div>
                    </div>  
                    
                    <div class="form-group">
                        <label class="control-label">Range de IP's:</label><!--RANGE DE IP'S-->
                        <div class="input-group col-sm-4">
                            <input type="text" size="2" class="form-control" required="required" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){1}$" maxlength="3" placeholder="10" name="rangea">
                            <span class="input-group-addon">á</span>
                            <input type="text" size="2" class="form-control" required="required" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){1}$" maxlength="3" placeholder="254" name="rangeb">        
                        </div>
                        <div class="help-block with-errors">IP's que serão distribuidos!</div>
                    </div>
                    
                    <div class="form-group">
                        <button class="btn btn-lg btn-success" type="submit" name="ConfigDHCP">Confirmar</button> 
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
    include("codphp.php");
?>