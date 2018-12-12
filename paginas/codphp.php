<?php   
    include ("conexao.php");

    ///
    //PESQUISAS
    ///

    //ABA MÁQUINA - PESQUISA MYSQL DO IP DA MÁQUINA QUE SERÁ CADASTRADA
    if(isset($_POST["ip"])){
        $row = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM maquina WHERE Ip='" . $_POST["ip"] . "'"));
        if( $row > 0 ){
            echo "1";//Já foi cadastrado
        }else{
            echo "0";//Não foi cadastrado
        }
    }
    
    //ABA FTP - PESQUISA MYSQL DO USUÁRIO FTP
    if(isset($_POST["usuarioftp"]) && isset($_POST["id_maquina"])){
        //PEGA O IP DA MÁQUINA
        //$row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='" . $_POST["id_maquina"] . "'"));
        //$ip = $row["Ip"];
 
        //VERIFICA SE O USUÁRIO JÁ EXISTE NA MÁQUINA
        $row_ftp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='" . $_POST["usuarioftp"] . "' AND Maquina_Id='" . $_POST["id_maquina"] . "'"));//BANCO DO FTP
        if($row_ftp > 0){ 
            echo "1";//Já existe
        }else{
            echo "0";//Não existe
        }
    }
    
    //SAMBA SIMPLES
    //ABA CSAMBA - PESQUISA MYSQL DO NOME DO COMPARTILHAMENTO DO smbsimp
    if(isset($_POST["nomesimp"]) && isset($_POST["id_maquina"])){
        //PEGA O IP DA MÁQUINA
        //$row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='" . $_POST["id_maquina"] . "'"));
        //$ip = $row["Ip"];
        
        //VERIFICA SE O NOME DO COMPARTILHAMENTO JÁ EXISTE NA MÁQUINA
        $row_smbsimp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Nomesimp='" . $_POST["nomesimp"] . "' AND Maquina_Id='" . $_POST["id_maquina"] . "'"));//BANCO DO smbsimp
        $row_smbpriv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Nomepriv='" . $_POST["nomesimp"] . "' AND Maquina_Id='" . $_POST["id_maquina"] . "'"));//BANCO DO smbpriv
        if($row_smbsimp > 0 || $row_smbpriv > 0){ 
            echo "1";//Já existe
        }else{
            echo "0";//Não existe
        } 
    }

    //ABA CSAMBA - PESQUISA MYSQL DO DIRETÓRIO DO smbsimp
    if(isset($_POST["diretoriosimp"]) && isset($_POST["id_maquina"])){
        //PEGA O IP DA MÁQUINA
        //$row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='" . $_POST["id_maquina"] . "'"));
        //$ip = $row["Ip"];
        
        //VERIFICA SE O DIRETÓRIO ESTÁ SENDO USADO PELO smbpriv
        $row_dire_priv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Diretoriopriv='" . $_POST["diretoriosimp"] . "' AND Maquina_Id='" . $_POST["id_maquina"] . "'"));//BANCO DO smbpriv
        if($row_dire_priv > 0){ 
            echo "1";//SENDO USADO PELO smbpriv
        }else{
            echo "0";//NÃO SENDO USADO PELO smbpriv
        } 
    }
    
    //SAMBA PRIVATIVO
    //ABA CSAMBA - PESQUISA MYSQL DO NOME DO COMPARTILHAMENTO DO smbpriv
    if(isset($_POST["nomepriv"]) && isset($_POST["id_maquina"])){
        //PEGA O IP DA MÁQUINA
        //$row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='" . $_POST["id_maquina"] . "'"));
        //$ip = $row["Ip"];
        
        //VERIFICA SE O NOME DO COMPARTILHAMENTO JÁ EXISTE NA MÁQUINA
        $row_smbsimp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Nomesimp='" . $_POST["nomepriv"] . "' AND Maquina_Id='" . $_POST["id_maquina"] . "'"));//BANCO DO smbsimp
        $row_smbpriv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Nomepriv='" . $_POST["nomepriv"] . "' AND Maquina_Id='" . $_POST["id_maquina"] . "'"));//BANCO DO smbpriv
        if($row_smbsimp > 0 || $row_smbpriv > 0){ 
            echo "1";//Já existe
        }else{
            echo "0";//Não existe
        } 
    }

    //ABA CSAMBA - PESQUISA MYSQL DO DIRETÓRIO DO smbpriv
    if(isset($_POST["diretoriopriv"]) && isset($_POST["id_maquina"])){
        //PEGA O IP DA MÁQUINA
        //$row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='" . $_POST["id_maquina"] . "'"));
        //$ip = $row["Ip"];
        
        //VERIFICA SE O DIRETÓRIO ESTÁ SENDO USADO PELO smbpriv
        $row_dire_simp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Diretoriosimp='" . $_POST["diretoriopriv"] . "' AND Maquina_Id='" . $_POST["id_maquina"] . "'"));//BANCO DO smbsimp
        if($row_dire_simp > 0){ 
            echo "1";//SENDO USADO PELO smbsimp
        }else{
            echo "0";//NÃO SENDO USADO PELO smbsimp
        } 
    }

    ///
    //PESQUISAS
    //ABA CONFIGURADOS
    ///

    //PESQUISA MYSQL DO IP DA MAQUINA
    if(isset($_POST["ip_maq"]) && isset($_POST["id_maq"])){

        $row = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM maquina WHERE Ip='" . $_POST["ip_maq"] . "'"));//VERIFICA SE O IP JÁ ESTÁ EM USO
        if($row > 0){
            $query = mysqli_fetch_assoc(mysqli_query($conexao,"SELECT Ip FROM maquina WHERE ID='" . $_POST["id_maq"] . "'"));//VERIFICA O IP FORNECIDO ATRAVÉS DO ID FORNECIDO
            if($query["Ip"] == $_POST["ip_maq"]){//CASO O IP FORNECIDO E O IP NO BANCO FOREM OS MESMO ENTÃO CONTINUA
                echo "0";//É o mesmo ip, ou seja, não existe
            }else{
                echo "1";//Já em uso
            }
        }else{
            echo "0";//Não esta em uso
        }
    }

    //PESQUISA MYSQL DO USUÁRIO FTP
    if(isset($_POST["usuarioftp"]) && isset($_POST["id_ftp"]) && isset($_POST["ip_ftp"])){

        $row = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='" . $_POST["usuarioftp"] . "' AND Ip='" . $_POST["ip_ftp"] . "'"));//VERIFICA SE O USUÁRIO JÁ EXISTA NESTA MAQUINA
        if($row > 0){
            $query = mysqli_fetch_assoc(mysqli_query($conexao,"SELECT Usuario FROM ftp WHERE ID='" . $_POST["id_ftp"] . "'"));//VERIFICA O USUÁRIO FORNECIDO ATRAVÉS DO ID FORNECIDO
            if($query["Usuario"] == $_POST["usuarioftp"]){//CASO O USUÁRIO FORNECIDO E O USUARIO NO BANCO FOREM OS MESMO ENTÃO CONTINUA
                echo "0";//É o mesmo usuário, ou seja, não existe
            }else{
                echo "1";//Já existe
            }
        }else{
            echo "0";//Não existe
        }
    }

    //SAMBA SIMPLES
    //PESQUISA MYSQL DO NOME DO COMPARTILHAMENTO DO smbsimp
    if(isset($_POST["nomesimp"]) && isset($_POST["id_smbsimp"]) && isset($_POST["ip_smbsimp"])){

        $row_smbpriv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Nomepriv='" . $_POST["nomesimp"] . "' AND Ip='" . $_POST["ip_smbsimp"] . "'"));//VERIFICA SE O COMPAR. JÁ EXISTA NESTA MAQUINA NO smbpriv
        if($row_smbpriv == 0){ //SE NÃO EXISTE VERIFICA NO BANCO DO smbsimp
            $row = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Nomesimp='" . $_POST["nomesimp"] . "' AND Ip='" . $_POST["ip_smbsimp"] . "'"));//VERIFICA SE O COMPAR. JÁ EXISTA NESTA MAQUINA NO smbsimp
            if($row > 0){
                $query = mysqli_fetch_assoc(mysqli_query($conexao,"SELECT Nomesimp FROM smbsimp WHERE ID='" . $_POST["id_smbsimp"] . "'"));//VERIFICA O COMPAR. FORNECIDO ATRAVÉS DO ID FORNECIDO
                if($query["Nomesimp"] == $_POST["nomesimp"]){//CASO O COMPAR. FORNECIDO E O COMPAR. NO BANCO FOREM OS MESMO ENTÃO CONTINUA
                    echo "0";//É o mesmo compartilhamento, ou seja, não existe
                }else{
                    echo "1";//Já existe
                }
            }else{
                echo "0";//Não existe
            }
        }else{
            echo "1";//Já existe
        }
    }

    //PESQUISA MYSQL DO DIRETÓRIO DO smbsimp
    if(isset($_POST["diretoriosimp"]) && isset($_POST["ip_smbsimp"])){
        
        //VERIFICA SE O DIRETÓRIO ESTÁ SENDO USADO PELO smbpriv
        $row_dire_smbpriv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Diretoriopriv='" . $_POST["diretoriosimp"] . "' AND Ip='" . $_POST["ip_smbsimp"] . "'"));//BANCO DO smbpriv
        if($row_dire_smbpriv > 0){ 
            echo "1";//Já existe
        }else{
            echo "0";//Não existe
        } 
    }

    //SAMBA PRIVATIVO
    //PESQUISA MYSQL DO NOME DO COMPARTILHAMENTO DO smbpriv
    if(isset($_POST["nomepriv"]) && isset($_POST["id_smbpriv"]) && isset($_POST["ip_smbpriv"])){
        
        $row_smbsimp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Nomesimp='" . $_POST["nomepriv"] . "' AND Ip='" . $_POST["ip_smbpriv"] . "'"));//VERIFICA SE O COMPAR. JÁ EXISTA NESTA MAQUINA NO smbsimp
        if($row_smbsimp == 0){ //SE NÃO EXISTE VERIFICA NO BANCO DO smbpriv
            $row = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Nomepriv='" . $_POST["nomepriv"] . "' AND Ip='" . $_POST["ip_smbpriv"] . "'"));//VERIFICA SE O COMPAR. JÁ EXISTA NESTA MAQUINA 
            if($row > 0){
                $query = mysqli_fetch_assoc(mysqli_query($conexao,"SELECT Nomepriv FROM smbpriv WHERE ID='" . $_POST["id_smbpriv"] . "'"));//VERIFICA O COMPAR. FORNECIDO ATRAVÉS DO ID FORNECIDO
                if($query["Nomepriv"] == $_POST["nomepriv"]){//CASO O COMPAR. FORNECIDO E O COMPAR. NO BANCO FOREM OS MESMO ENTÃO CONTINUA
                    echo "0";//É o mesmo compartilhamento, ou seja, não existe
                }else{
                    echo "1";//Já existe
                }
            }else{
                echo "0";//Não existe
            }
        }else{
            echo "1";//Já existe
        }
    }

    //PESQUISA MYSQL DO DIRETÓRIO DO smbpriv
    if(isset($_POST["diretoriopriv"]) && isset($_POST["ip_smbpriv"])){
        
        //VERIFICA SE O DIRETÓRIO ESTÁ SENDO USADO PELO smbpriv
        $row_dire_smbsimp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Diretoriosimp='" . $_POST["diretoriopriv"] . "' AND Ip='" . $_POST["ip_smbpriv"] . "'"));//BANCO DO smbsimp
        if($row_dire_smbsimp > 0){ 
            echo "1";//Já existe
        }else{
            echo "0";//Não existe
        } 
    }

    ///
    //FIM PESQUISAS
    ///
    
    //INDEX LOGIN
    if(isset($_GET["pag"])){
        $user = $_POST["usuario"];
        $pass = $_POST["senha"];

        $check = mysqli_query($conexao,"SELECT * FROM login WHERE Usuario='$user' AND Senha='$pass'") or die (mysql_error());
        $row = mysqli_num_rows($check);
        if($row > 0){
            header("Location: home.php");
            session_start();
            $_SESSION["Usuario"] = $user;
        }else{
            $_SESSION["Invalido"] = "Usuário e/ou senha inválido(s).";
            header("Location: index.php");
        }
    }
    
    //CADASTRO
    if(isset($_POST["Cadastrar"])){
        $Usuario = $_POST["usuario"];
        $Senha = $_POST["senha"];
        $Pergunta = $_POST["pergunta"];
        $Resposta = $_POST["resposta"];

        $query = mysqli_query($conexao,"INSERT INTO login (Usuario, Senha, Pergunta, Resposta) VALUES ('$Usuario', '$Senha', '$Pergunta', '$Resposta')");
        if($query){//CASO FOR UM SUCESSO A REGISTRO
            $_SESSION["Sucesso"] = "Cadastrado com sucesso.";
            echo "<script>location.href='index.php';</script>";
        }else{//CASO DÊ ERRO NA REGISTRO
            $_SESSION["Erro"] = "Erro ao registrar usuário";
            echo "<script>location.href='cadastro.php';</script>"; 
        }
    }
    
    //INDEX ESQUECI MINHA SENHA
    if(isset($_POST["Recupera"])){
        $Resposta_usu = $_POST["Resposta_usu"];
        
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM login"));//VERIFICA O CONTEÚDO DA TABELA login
        $Usu_recu = $row["Usuario"];//PEGA O VALOR DENTRO DO CAMPO Usuário E ATRIBUI EM UMA VARIÁVEL
        $Senha_recu = $row["Senha"];//PEGA O VALOR DENTRO DO CAMPO Senha E ATRIBUI EM UMA VARIÁVEL
        $row2 = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM login WHERE Resposta='$Resposta_usu'"));
        if($row2 > 0){
            $_SESSION["Sucesso"] = "Senha recuperada com sucesso. <br/><b>Usuário:</b> ".$Usu_recu." <b>Senha:</b> ".$Senha_recu."";
            header("Location: index.php");
        }else{
            $_SESSION["Invalido"] = "Resposta inválida.";
            header("Location: index.php");
        }
    }  
    
    //PERFIL
    if(isset($_POST["ConfigPERFIL"])){
        $novaUsuario = $_POST["usuario"];
        $senhaAtual = $_POST["senhaatual"];
        $novaSenha = $_POST["senha"];
        $novaPergunta = $_POST["novapergunta"];
        $novaResposta = $_POST["novaresposta"];
        
        $row = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM login WHERE Senha='$senhaAtual'"));//LAÇO PARA VERIFICAR SE A SENHA É AUTÊNTICA
        if($row > 0){//CASO A SENHA ESTEJA AUTÊNTICA
            $query = mysqli_query($conexao,"UPDATE login SET Usuario='$novaUsuario', Senha='$novaSenha', Pergunta='$novaPergunta',  Resposta='$novaResposta'");
            if($query){
                $_SESSION["Sucesso_perfil"] = "Alterado com sucesso.";
                echo "<script>location.href='perfil.php';</script>"; 
            }else{
                $_SESSION["Erro_perfil"] = "Erro ao alterar.";
                echo "<script>location.href='perfil.php';</script>"; 
            }
        }else{//CASO A SENHA NÃO ESTEJA AUTÊNTICA
            $_SESSION["Invalido_perfil"] = "Senha atual errada.";
            echo "<script>location.href='perfil.php';</script>"; 
        }
    }

    //CADASTRO DE MÁQUINAS
    if(isset($_POST["ConfigMAQUINA"])){
        //ATRIBUTOS DA MÁQUINA QUE RECEBERÁ AS CONFIGURAÇÕES
        $usuarioroot = $_POST["usuarioroot"];
        $senharoot = $_POST["senha"];
        $ip = $_POST["ip"];
        $porta = $_POST["porta"];
        
        shell_exec("../scripts/cadastra_maq.sh $senharoot $porta $usuarioroot $ip 2>&1");//FAZ O ACESSO A MÁQUINA POR MEIO DE UM SCRIPT
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL O ACESSO A MÁQUINA
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI ACESSADA COM SUCESSO
            $query = mysqli_query($conexao,"INSERT INTO maquina (Usuarioroot, Senharoot, Ip, Porta) VALUES ('$usuarioroot', '$senharoot', '$ip', '$porta')");//ATRIBUI AO BANCO 
            if($query){
                $_SESSION["Sucesso"] = "Máquina cadastrada com sucesso.";
                echo "<script>location.href='cadastro_maq.php';</script>";
            }else{
                $_SESSION["Erro"] = "Erro ao cadastrar a máquina no banco.";
                echo "<script>location.href='cadastro_maq.php';</script>";
            }  
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='cadastro_maq.php';</script>";
        }
    }
    
    ///
    //SERVIÇOS
    ///

    //FTP    
    if(isset($_POST["ConfigFTP"])){
        $usuario = $_POST["usuarioftp"];
        $senha = $_POST["senha"];
        //ID DA MÁQUINA QUE RECEBERÁ AS CONFIGURAÇÕES
        $id_maquina = $_POST["id_maquina"];
      
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A CONFIGURAÇÃO
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maquina'"));
        $usuarioroot = $row["Usuarioroot"];
        $senharoot = $row["Senharoot"];
        $ip = $row["Ip"];
        $porta = $row["Porta"];

        //FAZ A CONFIGURAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/ftp.sh $usuario $senha $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A CONFIGURAÇÃO
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI CONFIGURADA COM SUCESSO
            //ATRIBUI AO BANCO
            $query = mysqli_query($conexao,"INSERT INTO ftp (Maquina_Id, Usuario, Senha) VALUES ('$id_maquina', '$usuario', '$senha')");
            //ATUALIZA AS SENHAS DOS USUÁRIOS DA TABELA smbpriv QUE SEJAM O MESMO USUÁRIO CRIADO PELO FTP
            $query2 = mysqli_query($conexao,"UPDATE smbpriv SET Senhapriv='$senha' WHERE Usuariopriv='$usuario'");
            if($query && $query2){
                $_SESSION["Sucesso"] = "Serviço configurado com sucesso.";
                echo "<script>location.href='ftp.php';</script>";
            }else{
                $_SESSION["Erro"] = "Erro ao registrar configuração no banco.";
                echo "<script>location.href='ftp.php';</script>";
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL CONFIGURAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='ftp.php';</script>";
        }
    }
 
    //DHCP
    if(isset($_POST["ConfigDHCP"])){
        $dominio = $_POST["dominio"];
        $servidordns = $_POST["servidordns"];
        $gateway = $_POST["gateway"];
        $servidor = $_POST["servidor"];
        $mascara = $_POST["mascara"];
        $rangea = $_POST["rangea"];
        $rangeb = $_POST["rangeb"];
        //ID DA MÁQUINA QUE RECEBERÁ AS CONFIGURAÇÕES
        $id_maquina = $_POST["id_maquina"];
           
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A CONFIGURAÇÃO
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maquina'"));
        $usuarioroot = $row["Usuarioroot"];
        $senharoot = $row["Senharoot"];
        $ip = $row["Ip"];
        $porta = $row["Porta"];
        
        //FAZ A CONFIGURAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/dhcp.sh $dominio $servidordns $gateway $servidor $mascara $rangea $rangeb $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A CONFIGURAÇÃO
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI CONFIGURADA COM SUCESSO
            //ATRIBUI AO BANCO 
            $query = mysqli_query($conexao,"INSERT INTO dhcp (Maquina_Id, Dominio, ServidorDNS, Gateway, Servidor, Mascara, Rangea, Rangeb) VALUES 
            ('$id_maquina', '$dominio', '$servidordns', '$gateway', '$servidor', '$mascara', '$rangea', '$rangeb')");
            if($query){
                $_SESSION["Sucesso"] = "Serviço configurado com sucesso.";
                echo "<script>location.href='dhcp.php';</script>";
            }else{
                $_SESSION["Erro"] = "Erro ao registrar configuração no banco.";
                echo "<script>location.href='dhcp.php';</script>";
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL CONFIGURAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='dhcp.php';</script>";
        }
    } 

    //CSAMBA
    if(isset($_POST["ConfigSAMBA"])){
        //SIMPLES
        $nomesimp = $_POST["nomesimp"];//NOME DO COMPARTILHAMENTO - []
        if(empty($nomesimp)){//VERIFICA SE A VARIÁVEL nomesimp É VAZIA
            $configurasimp = "no";
            $enviaproshell = "priv";
        }else{
            $configurasimp = "yes";
        }
        $diretoriosimp = $_POST["diretoriosimp"];//DIRETÓRIO COMPARTILHADO - path

        //PRIVATIVO
        $nomepriv = $_POST["nomepriv"];//NOME DO COMPARTILHAMENTO - []
         if(empty($nomepriv)){//VERIFICA SE A VARIÁVEL nomepriv É VAZIA
            $configurapriv = "no";
            $enviaproshell = "simp";
        }else{
            $configurapriv = "yes";
        }
        $diretoriopriv = $_POST["diretoriopriv"];//DIRETÓRIO COMPARTILHADO - path
        $usuariopriv = $_POST["usuariopriv"];//USUÁRIO DONO
        $senhapriv = $_POST["senha"];//SENHA DO USUÁRIO DONO
        $grupopriv_csamba = $_POST["grupopriv"];//GRUPO DONO DO COMPARTILHAMENTO
        $grupopriv = implode(',',array_unique(explode(',', $grupopriv_csamba)));//REMOVE OS GRUPOS REPETIDOS
        //ID DA MÁQUINA QUE RECEBERÁ AS CONFIGURAÇÕES
        $id_maquina = $_POST["id_maquina"];
           
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A CONFIGURAÇÃO
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maquina'"));
        $usuarioroot = $row["Usuarioroot"];
        $senharoot = $row["Senharoot"];
        $ip = $row["Ip"];
        $porta = $row["Porta"];
        
        //VERIFICA SE JÁ FOI FEITA ALGUMA CONFIGURAÇÃO NA MÁQUINA
        $row_priv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Maquina_Id='$id_maquina'"));
        $row_simp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Maquina_Id='$id_maquina'"));
        if($row_priv > 0 || $row_simp > 0){ 
            $privez = "no"; //CASO JÁ TIVER ALGUMA CONFIGURAÇÃO
        }else{
            $privez = "yes"; //CASO NÃO TIVER CONFIGURAÇÃO
        }
        
        //CASO USUÁRIO JÁ EXISTA ENTÃO PEGA OS OUTROS GRUPOS A QUAL ELE PERTENCE
        $array_grupos = array();//CRIA A ARRAY DE GRUPOS
        $row_grupos = mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Usuariopriv='$usuariopriv' AND Maquina_Id='$id_maquina'");
        while($r_priv = mysqli_fetch_array($row_grupos)){//ENQUANTO HOUVE
            $array_grupos[] = $r_priv["Grupopriv"];//ATRIBUI A ARRAY
        }
        $grupopriv_outros = implode(",", $array_grupos);//ATRIBUI O QUE TIVER NA ARRAY A UMA VARIÁVEL
        if(empty($grupopriv_outros)){//SE FOR VAZIO
            $grupos = "$grupopriv";
        }else{//SE NÃO FOR VAZIO
            $grupos = "$grupopriv" . ',' . "$grupopriv_outros";
        }
        
        /* $grupos - SÃO TODOS OS GRUPOS QUE O USUÁRIO PERTENCE E QUE PERTECERÁ
        $grupopriv - SÃO OS GRUPOS QUE SERÃO DONO DO COMPAR. */
        
        if($configurasimp == "no" && $configurapriv == "no"){//CASO NÃO FOR PREENCHIDO NENHUM CAMPO
            $_SESSION["Invalido"] = "Necessário definir ao menos um serviço!";
            echo "<script>location.href='csamba.php';</script>";
        }elseif(($configurasimp == "no" && $configurapriv == "yes") || ($configurasimp == "yes" && $configurapriv == "no")){
            //FAZ A CONFIGURAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
            shell_exec("../scripts/csamba.sh $privez $enviaproshell $nomesimp $diretoriosimp $usuariopriv $senhapriv $grupos $grupopriv $nomepriv $diretoriopriv $senharoot $porta $usuarioroot $ip 2>&1");
            exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A CONFIGURAÇÃO
            if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI CONFIGURADA COM SUCESSO   
                
                if($enviaproshell == "priv"){//PRIVATIVO
                    $query = mysqli_query($conexao,"INSERT INTO smbpriv (Maquina_Id, Usuariopriv, Senhapriv, Grupopriv, Nomepriv, Diretoriopriv) VALUES 
                    ('$id_maquina', '$usuariopriv', '$senhapriv', '$grupopriv', '$nomepriv', '$diretoriopriv')");
                    
                    //ATUALIZA TODOS OS USUÁRIOS DOS OUTROS SERVIÇOS QUE TENHAM O MESMO USUÁRIO
                    $query2 = mysqli_multi_query($conexao,"UPDATE ftp SET Senha='$senhapriv' WHERE Usuario='$usuariopriv';
                                                           UPDATE smbpriv SET Senhapriv='$senhapriv' WHERE Usuariopriv='$usuariopriv';"); 
                }elseif($enviaproshell == "simp"){//SIMPLES
                    $query = mysqli_query($conexao,"INSERT INTO smbsimp (Maquina_Id, Nomesimp, Diretoriosimp) VALUES 
                    ('$id_maquina', '$nomesimp', '$diretoriosimp')");
                }
                    
                if($query){//CASO FOR UM SUCESSO O REGISTRO NO BANCO
                    $_SESSION["Sucesso"] = "Serviço configurado com sucesso.";
                    echo "<script>location.href='csamba.php';</script>";
                }else{
                    $_SESSION["Erro"] = "Erro ao registrar configuração no banco.";
                    echo "<script>location.href='csamba.php';</script>";
                }
            }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL CONFIGURAR A MÁQUINA
                $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
                echo "<script>location.href='csamba.php';</script>";
            }

        }elseif($configurasimp == "yes" && $configurapriv == "yes"){
            //CONFIGURA O SIMPLES E PRIVATIVO
            $enviaproshell = "todos";
            //FAZ A CONFIGURAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
            shell_exec("../scripts/csamba.sh $privez $enviaproshell $nomesimp $diretoriosimp $usuariopriv $senhapriv $grupos $grupopriv $nomepriv $diretoriopriv $senharoot $porta $usuarioroot $ip 2>&1");
            exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A CONFIGURAÇÃO
            if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI CONFIGURADA COM SUCESSO
                
                $query = mysqli_query($conexao,"INSERT INTO smbpriv (Maquina_Id, Usuariopriv, Senhapriv, Grupopriv, Nomepriv, Diretoriopriv) VALUES 
                ('$id_maquina', '$usuariopriv', '$senhapriv', '$grupopriv', '$nomepriv', '$diretoriopriv')");
               
                $query2 = mysqli_query($conexao,"INSERT INTO smbsimp (Maquina_Id, Nomesimp, Diretoriosimp) VALUES 
                ('$id_maquina', '$nomesimp', '$diretoriosimp')");
                
                //ATUALIZA TODOS OS USUÁRIOS DOS OUTROS SERVIÇOS QUE TENHAM O MESMO USUÁRIO
                $query3 = mysqli_multi_query($conexao,"UPDATE ftp SET Senha='$senhapriv' WHERE Usuario='$usuariopriv';
                                                       UPDATE smbpriv SET Senhapriv='$senhapriv' WHERE Usuariopriv='$usuariopriv';"); 
                
                if($query && $query2 && $query3){//CASO FOR UM SUCESSO O REGISTRO NO BANCO
                    $_SESSION["Sucesso"] = "Serviços configurado com sucesso.";
                    echo "<script>location.href='csamba.php';</script>";
                }else{
                    $_SESSION["Erro"] = "Erro ao registrar configurações no banco.";
                    echo "<script>location.href='csamba.php';</script>";
                }
            }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL CONFIGURAR A MÁQUINA
                $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
                echo "<script>location.href='csamba.php';</script>";
            }
        }
    }
?>