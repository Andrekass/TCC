<?php   
    include("conexao.php");
    ///
    //RECEBE AS ALTERAÇÕES DA MÁQUINA
    ///
    if(isset($_POST["AlteraMAQ"])){
        $ip = $_POST["ip"];
        $porta = $_POST["porta"];
        $usuarioroot = $_POST["usuarioroot"];
        $senharoot = $_POST["senharoot"];
        $id_maq = $_POST["id-maq"];
        
        //PEGA O IP ANTIGO DA MÁQUINA ANTES DA ALTERAÇÃO
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $ipOLD = $row["Ip"];
        
        shell_exec("../scripts/cadastra_maq.sh $senharoot $porta $usuarioroot $ip 2>&1");//FAZ O ACESSO A MÁQUINA POR MEIO DE UM SCRIPT
        exec("cat /etc/cgi/scripts/acesso", $resul); //VERIFICA SE FOI POSSÍVEL O ACESSO A MÁQUINA
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI ACESSADA COM SUCESSO
            //ATUALIZA A MÁQUINA E AS INFORMAÇÕES DA MÁQUINA NOS SERVIÇOS QUE POSSUEM ESSA MÁQUINA      
            $query = mysqli_query($conexao,"UPDATE maquina SET Usuarioroot='$usuarioroot', Senharoot='$senharoot', Ip='$ip', Porta='$porta' WHERE ID='$id_maq'");
            
            if($query){//CASO FOR UM SUCESSO A ALTERAÇÃO
                $_SESSION["Sucesso"] = "Alterado com sucesso.";
                echo "<script>location.href='configurados.php';</script>";
            }else{//CASO DÊ ERRO NA ALTERAÇÃO
                $_SESSION["Erro"] = "Erro ao alterar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>";
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
        }
    }
    //DELETA MÁQUINA - SOMENTE DO BANCO DE DADOS
    if(isset($_POST["DeleteMAQno"])){      
        $id_maq = $_POST["id_maq_delete"];
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A REMOVAÇÃO DO COMPAR.
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $ip = $row["Ip"];
                
        //DELETA A MÁQUINA E TODAS AS CONFIGURAÇÕES QUE POSSUEM A MÁQUINA
        $deleta = mysqli_multi_query($conexao,"DELETE FROM maquina WHERE ID='$id_maq';
                                               DELETE FROM ftp WHERE Maquina_Id='$id_maq';
                                               DELETE FROM dhcp WHERE Maquina_Id='$id_maq';
                                               DELETE FROM smbsimp WHERE Maquina_Id='$id_maq';
                                               DELETE FROM smbpriv WHERE Maquina_Id='$id_maq';");
        
        if($deleta){//CASO FOR UM SUCESSO A REMOÇÃO
            $_SESSION["Sucesso"] = "Deletado com sucesso.";
            echo "<script>location.href='configurados.php';</script>"; 
        }else{//CASO DÊ ERRO AO DELETAR
            $_SESSION["Erro"] = "Erro ao deletar no banco de dados.";
            echo "<script>location.href='configurados.php';</script>"; 
        }
    }
    //DELETA MÁQUINA - ATÉ MESMO DO MICRO CLIENTE
    if(isset($_POST["DeleteMAQyes"])){      
        $id_maq = $_POST["id_maq_delete"];
        $enviaproshell = "maq";//DEFINE
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A REMOVAÇÃO DO USUÁRIO
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row["Usuarioroot"];
        $senharoot = $row["Senharoot"];
        $ip = $row["Ip"];
        $porta = $row["Porta"];

        //FTP - PEGA OS USUÁRIOS
        $array_ftp = array();//CRIA A ARRAY
        $row_ftp = mysqli_query($conexao,"SELECT * FROM ftp WHERE Maquina_Id='$id_maq'");//BUSCA OS USUÁRIOS
        while($r_ftp = mysqli_fetch_array($row_ftp)){//ENQUANTO HOUVE USUÁRIOS
            $array_ftp[] = $r_ftp["Usuario"];//ATRIBUI A ARRAY
        }
        $usuarios_ftp = implode(",", $array_ftp);//ATRIBUI O QUE TIVER NA ARRAY A UMA VARIÁVEL
        
        //SAMBA SIMPLES - PEGA OS DIRETÓRIOS
        $array_dire_simp = array();//CRIA A ARRAY DE DIRETÓRIOS
        $row_simp = mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Maquina_Id='$id_maq'");//BUSCA O QUE HÁ NA TABELA smbsimp
        while($r_simp = mysqli_fetch_array($row_simp)){//ENQUNATO HOUVE
            $array_dire_simp[] = $r_simp["Diretoriosimp"];//ATRIBUI A ARRAY
        }
        $dire_simp = implode(",", $array_dire_simp);//ATRIBUI O QUE TIVER NA ARRAY DE DIRETÓRIOS A UMA VARIÁVEL       
        
        //SAMBA PRIVATIVO - PEGA OS USUÁRIOS, GRUPOS E DIRETÓRIOS
        $array_usu_priv = array();//CRIA A ARRAY DE USUÁRIOS
        $array_gru_priv = array();//CRIA A ARRAY DE GRUPOS
        $array_dire_priv = array();//CRIA A ARRAY DE DIRETÓRIOS
        $row_priv = mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Maquina_Id='$id_maq'");//BUSCA O QUE HÁ NA TABELA smbpriv
        while($r_priv = mysqli_fetch_array($row_priv)){//ENQUANTO HOUVE
            $array_usu_priv[] = $r_priv["Usuariopriv"];//ATRIBUI A ARRAY
            $array_gru_priv[] = $r_priv["Grupopriv"];//ATRIBUI A ARRAY
            $array_dire_priv[] = $r_priv["Diretoriopriv"];//ATRIBUI A ARRAY
        }
        $usuarios_priv = implode(",", $array_usu_priv);//ATRIBUI O QUE TIVER NA ARRAY DE USUÁRIOS A UMA VARIÁVEL
        $grupos_priv = implode(",", $array_gru_priv);//ATRIBUI O QUE TIVER NA ARRAY DE GRUPOS A UMA VARIÁVEL
        $dire_priv = implode(",", $array_dire_priv);//ATRIBUI O QUE TIVER NA ARRAY DE DIRETÓRIOS A UMA VARIÁVEL
        
        //VERIFICA QUAIS BANCO ESTÃO VAZIO E QUAL ESTIVER VAZIO ENTÃO NÃO REMOVE
        $row_priv_vazio = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Maquina_Id='$id_maq'"));//BANCO DO smbpriv
        $row_simp_vazio = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Maquina_Id='$id_maq'"));//BANCO DO smbsimp
        $row_ftp_vazio = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Maquina_Id='$id_maq'"));//BANCO DO FTP
        if($row_priv_vazio > 0 && $row_ftp_vazio > 0 && $row_simp_vazio > 0){//SE TODOS NÃO ESTIVEREM VAZIOS
            $opcao = "1";//VARIAVEL PARA O LAÇO DO SHELL
            //FAZ A REMOÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip $usuarios_ftp $dire_simp $usuarios_priv $grupos_priv $dire_priv 2>&1");    
        }else if($row_priv_vazio == 0 && $row_ftp_vazio > 0 && $row_simp_vazio > 0){//SE SOMENTE O smbpriv ESTIVER VAZIO
            $opcao = "2";
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip $usuarios_ftp $dire_simp 2>&1");
        }else if($row_simp_vazio == 0 && $row_priv_vazio > 0  && $row_ftp_vazio > 0){//SE SOMENTE O smbsimp ESTIVER VAZIO
            $opcao = "3";
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip $usuarios_ftp $usuarios_priv $grupos_priv $dire_priv 2>&1");
        }else if($row_ftp_vazio == 0 && $row_priv_vazio > 0 && $row_simp_vazio > 0){//SE SOMENTE O ftp ESTIVER VAZIO
            $opcao = "4";
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip $dire_simp $usuarios_priv $grupos_priv $dire_priv 2>&1");
        }else if($row_priv_vazio == 0 && $row_ftp_vazio > 0 && $row_simp_vazio == 0){//SE SOMENTE O ftp ESTIVER NÃO VAZIO
            $opcao = "5";
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip $usuarios_ftp 2>&1");
        }else if($row_priv_vazio == 0 && $row_ftp_vazio == 0 && $row_simp_vazio > 0){//SE SOMENTE O smbsimp ESTIVER NÃO VAZIO
            $opcao = "6";
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip $dire_simp 2>&1");
        }else if($row_priv_vazio > 0 && $row_ftp_vazio == 0 && $row_simp_vazio == 0){//SE SOMENTE O smbpriv ESTIVER NÃO VAZIO
            $opcao = "7";
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip $usuarios_priv $grupos_priv $dire_priv 2>&1");
        }else{//QUANDO TODOS ESTÃO VAZIOS
            $opcao = "8";
            shell_exec("../scripts/deleta.sh $enviaproshell $opcao $senharoot $porta $usuarioroot $ip 2>&1");
        }
        
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A REMOÇÃO
        if($resul[0] == "exito"){//ENTÃO FOI DELETADO DA MÁQUINA COM SUCESSO
            //DELETA A MÁQUINA E TODAS AS CONFIGURAÇÕES QUE POSSUEM A MÁQUINA
            $deleta = mysqli_multi_query($conexao,"DELETE FROM maquina WHERE ID='$id_maq';
                                                   DELETE FROM ftp WHERE Maquina_Id='$id_maq';
                                                   DELETE FROM dhcp WHERE Maquina_Id='$id_maq';
                                                   DELETE FROM smbsimp WHERE Maquina_Id='$id_maq';
                                                   DELETE FROM smbpriv WHERE Maquina_Id='$id_maq';");
            if($deleta){//CASO FOR UM SUCESSO A REMOÇÃO
                $_SESSION["Sucesso"] = "Deletado com sucesso.";
                echo "<script>location.href='configurados.php';</script>"; 
            }else{//CASO DÊ ERRO AO DELETAR
                $_SESSION["Erro"] = "Erro ao deletar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>"; 
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
        }
    }
    
    ///
    //RECEBE AS ALTERAÇÕES DO FTP
    ///
    if(isset($_POST["AlteraFTP"])){
        $id_ftp = $_POST["id-ftp"];
        $id_maq = $_POST["maq-id-ftp"];
        $usuario_ftp = $_POST["usuarioftp"];
        $senha_ftp = $_POST["senhaftp"];
        $enviaproshell = "ftp";//DEFINE O SERVIÇO
        
        //PEGA USUÁRIO QUE SERÁ ALTERADO
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM ftp WHERE ID='$id_ftp'"));
        $usuarioftpOLD = $row["Usuario"];
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A ALTERAÇÃO DO USUÁRIO
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"];
        
        //VERIFICA SE O USUÁRIO ANTIGO ESTÁ SENDO USADO NO smbpriv
        $row_smbpriv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Usuariopriv='$usuarioftpOLD' AND Maquina_Id='$id_maq'"));
        if($row_smbpriv > 0){ 
            $r_usuOLD = "yes"; //CASO EXISTE TAL USUÁRIO
        }else{
            $r_usuOLD = "no"; //CASO NÃO EXISTE TAL USUÁRIO
        }
        
        //FAZ A ALTERAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/edita.sh $enviaproshell $r_usuOLD $usuarioftpOLD $usuario_ftp $senha_ftp $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A ALTERAÇÃO
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI ALTERADA COM SUCESSO
            
            //ATUALIZA NO BANCO
            $q_ftp = mysqli_query($conexao,"UPDATE ftp SET Usuario='$usuario_ftp', Senha='$senha_ftp' WHERE ID='$id_ftp'");       
            if($usuarioftpOLD != $usuarioftp){//CASO FOREM DIFERENTES, ENTÃO ALTERA OS DIRETÓRIOS NOS OUTROS COMPAR. CASO ESTEJA SENDO COMPAR.
                mysqli_multi_query($conexao,"UPDATE smbpriv SET Diretoriopriv='/home/$usuario_ftp' WHERE Diretoriopriv='/home/$usuarioftpOLD' AND Maquina_Id='$id_maq';
                                             UPDATE smbsimp SET Diretoriosimp='/home/$usuario_ftp' WHERE Diretoriosimp='/home/$usuarioftpOLD' AND Maquina_Id='$id_maq';");
            }
            
            if($r_usuOLD == "yes"){//SE O USUÁRIO EXISTE NO smbriv ENTÃO ALTERA A SENHA
                $q_priv = mysqli_query($conexao,"UPDATE smbpriv SET Usuariopriv='$usuario_ftp', Senhapriv='$senha_ftp' WHERE Usuariopriv='$usuarioftpOLD' AND Maquina_Id='$id_maq'");
            }

            if($q_ftp){//CASO FOR UM SUCESSO A ALTERAÇÃO
                $_SESSION["Sucesso"] = "Alterado com sucesso.";
                echo "<script>location.href='configurados.php';</script>";
            }else{//CASO DÊ ERRO NA ALTERAÇÃO
                $_SESSION["Erro"] = "Erro ao alterar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>";
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede. $enviaproshell $r_usuOLD $usuarioftpOLD $usuario_ftp $senha_ftp $senharoot $porta $usuarioroot $ip";
            echo "<script>location.href='configurados.php';</script>";
        }
    }
    //DELETA FTP
    if(isset($_POST["DeletaFTP"])){ 
        $id_ftp = $_POST["id_ftp_delete"];
        $id_maq = $_POST["maq_id_ftp_delete"];
        $enviaproshell = "ftp";//DEFINE O SERVIÇO
        
        //USUÁRIO QUE SERÁ DELETADO
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM ftp WHERE ID='$id_ftp'"));
        $usuario_ftp = $row["Usuario"];
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A REMOVAÇÃO DO USUÁRIO
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"];
        
        //VERIFICA SE O USUÁRIO ESTÁ SENDO USADO NO smbpriv
        $row_smbpriv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Usuariopriv='$usuario_ftp' AND Maquina_Id='$id_maq'"));
        if($row_smbpriv > 0){
            $r_usu = "yes"; //CASO EXISTE TAL USUÁRIO
        }else{
            $r_usu = "no"; //CASO NÃO EXISTE TAL USUÁRIO
        }
        
        //FAZ A REMOÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/deleta.sh $enviaproshell $r_usu $usuario_ftp $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A REMOÇÃO
        if($resul[0] == "exito"){//ENTÃO FOI DELETADO DA MÁQUINA COM SUCESSO
            //DELETA NO BANCO
            $deleta = mysqli_query($conexao,"DELETE FROM ftp WHERE ID='$id_ftp'");
            if($deleta){//CASO FOR UM SUCESSO A REMOÇÃO
                $_SESSION["Sucesso"] = "Deletado com sucesso.";
                echo "<script>location.href='configurados.php';</script>"; 
            }else{//CASO DÊ ERRO AO DELETAR
                $_SESSION["Erro"] = "Erro ao deletar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>"; 
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
        }
    }
    
    ///
    //RECEBE AS ALTERAÇÕES DO DHCP
    ///
    if(isset($_POST["AlteraDHCP"])){
        $id_dhcp = $_POST["id-dhcp"];
        $id_maq = $_POST["maq-id-dhcp"];
        $dominio = $_POST["dominio"];
        $servidordns = $_POST["servidordns"];
        $gateway = $_POST["gateway"];
        $servidor = $_POST["servidor"];
        $mascara = $_POST["mascara"];
        $rangea = $_POST["rangea"];
        $rangeb = $_POST["rangeb"];
        $enviaproshell = "dhcp";//DEFINE O SERVIÇO

        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A ALTERAÇÃO DO DHCP
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"];
        
        //FAZ A ALTERAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/edita.sh $enviaproshell $dominio $servidordns $gateway $servidor $mascara $rangea $rangeb $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A ALTERAÇÃO
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI ALTERADA COM SUCESSO
            //ATUALIZA NO BANCO
            $q_dhcp = mysqli_query($conexao,"UPDATE dhcp SET Dominio='$dominio', ServidorDNS='$servidordns', Gateway='$gateway', Servidor='$servidor', Mascara='$mascara', Rangea='$rangea', Rangeb='$rangeb' WHERE ID='$id_dhcp'");
            
            if($q_dhcp){//CASO FOR UM SUCESSO A ALTERAÇÃO
                $_SESSION["Sucesso"] = "Alterado com sucesso.";
                echo "<script>location.href='configurados.php';</script>";
            }else{//CASO DÊ ERRO NA ALTERAÇÃO
                $_SESSION["Erro"] = "Erro ao alterar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>";
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
        }
    }
    //DELETA DHCP
    if(isset($_POST["DeletaDHCP"])){ 
        $id_dhcp = $_POST["id_dhcp_delete"];
        $id_maq = $_POST["maq_id_dhcp_delete"];
        $enviaproshell = "dhcp";//DEFINE O SERVIÇO
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A REMOVAÇÃO DO DHCP
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"];

        //FAZ A REMOÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/deleta.sh $enviaproshell $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A REMOÇÃO
        if($resul[0] == "exito"){//ENTÃO FOI DELETADO DA MÁQUINA COM SUCESSO
            //DELETA NO BANCO
            $deleta = mysqli_query($conexao,"DELETE FROM dhcp WHERE ID='$id_dhcp'");
            if($deleta){//CASO FOR UM SUCESSO A REMOÇÃO
                $_SESSION["Sucesso"] = "Deletado com sucesso.";
                echo "<script>location.href='configurados.php';</script>"; 
            }else{//CASO DÊ ERRO AO DELETAR
                $_SESSION["Erro"] = "Erro ao deletar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>"; 
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
       }
    }

    ///
    //RECEBE AS ALTERAÇÕES DO SAMBA SIMPLES
    ///
    if(isset($_POST["AlteraSMBsimp"])){
        $id_smbsimp = $_POST["id-smbsimp"];
        $id_maq = $_POST["maq-id-smbsimp"];
        $nomesimp = $_POST["nomesimp"];
        $diretoriosimp = $_POST["diretoriosimp"];
        $enviaproshell = "smbsimp";//DEFINE O SERVIÇO

        //PEGA OS DADOS DO COMPAR.
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE ID='$id_smbsimp'"));
        $nomesimpOLD = $row["Nomesimp"];//COMPAR. QUE SERÁ ALTERADO
        $diretoriosimpOLD = $row["Diretoriosimp"];//DIRETORIO QUE SERÁ ALTERADO
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A ALTERAÇÃO DO COMPAR.
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"];
        
        //VERIFICA SE O DIRETÓRIO ANTIGO ESTÁ SENDO USADO EM OUTROS COMPAR. OU PELO FTP
        $row_simp_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Diretoriosimp='$diretoriosimpOLD' AND Maquina_Id='$id_maq'"));
        $usu_cut = substr("$diretoriosimpOLD", 6, 20);//PEGA SOMENTE O NOME DO DIRETÓRIO 
        $row_ftp_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='$usu_cut' AND Maquina_Id='$id_maq'"));
        if($row_simp_dire > 1 || $row_ftp_dire > 0){ 
            $r_direOLD = "yes";//CASO EXISTIR MAIS DE 1
        }else{
            $r_direOLD = "no";//CASO NÃO EXISTIR MAIS DE 1
        }
          
        //FAZ A ALTERAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/edita.sh $enviaproshell $r_direOLD $nomesimpOLD $nomesimp $diretoriosimpOLD $diretoriosimp $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A ALTERAÇÃO
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI ALTERADA COM SUCESSO
            //ATUALIZA NO BANCO
            $q_smbsimp = mysqli_query($conexao,"UPDATE smbsimp SET Nomesimp='$nomesimp', Diretoriosimp='$diretoriosimp' WHERE ID='$id_smbsimp'");
            
            if($q_smbsimp){//CASO FOR UM SUCESSO A ALTERAÇÃO
                $_SESSION["Sucesso"] = "Alterado com sucesso.";
                echo "<script>location.href='configurados.php';</script>";
            }else{//CASO DÊ ERRO NA ALTERAÇÃO
                $_SESSION["Erro"] = "Erro ao alterar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>";
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
        }
    }
    //DELETA SAMBA SIMPLES
    if(isset($_POST["DeletaSMBsimp"])){      
        $id_smbsimp = $_POST["id_smbsimp_delete"];
        $id_maq = $_POST["maq_id_smbsimp_delete"];
        $enviaproshell = "smbsimp";//DEFINE O SERVIÇO
        
        //PEGA OS DADOS DO COMPAR.
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE ID='$id_smbsimp'"));
        $nomesimp = $row["Nomesimp"];//COMPAR. QUE SERÁ DELETADO
        $diretoriosimp = $row["Diretoriosimp"];//DIRETORIO QUE SERÁ DELETADO

        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A REMOVAÇÃO DO COMPAR.
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"];
        
        //VERIFICA SE O DIRETÓRIO ESTÁ SENDO USADO EM OUTROS COMPAR. OU PELO FTP
        $row_simp_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbsimp WHERE Diretoriosimp='$diretoriosimp' AND Maquina_Id='$id_maq'"));
        $usu_cut = substr("$diretoriosimp", 6, 20);//PEGA SOMENTE O NOME DO DIRETÓRIO 
        $row_ftp_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='$usu_cut' AND Maquina_Id='$id_maq'"));
        if($row_simp_dire > 1 || $row_ftp_dire > 0){ 
            $r_dire = "yes";//CASO EXISTIR MAIS DE 1
        }else{
            $r_dire = "no";//CASO NÃO EXISTIR MAIS DE 1
        }
                
        //FAZ A REMOÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/deleta.sh $enviaproshell $r_dire $nomesimp $diretoriosimp $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A REMOÇÃO
        if($resul[0] == "exito"){//ENTÃO FOI DELETADO DA MÁQUINA COM SUCESSO
            //DELETA NO BANCO
            $deleta = mysqli_query($conexao,"DELETE FROM smbsimp WHERE ID='$id_smbsimp'");
            if($deleta){//CASO FOR UM SUCESSO A REMOÇÃO
                $_SESSION["Sucesso"] = "Deletado com sucesso.";
                echo "<script>location.href='configurados.php';</script>"; 
            }else{//CASO DÊ ERRO AO DELETAR
                $_SESSION["Erro"] = "Erro ao deletar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>"; 
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
       }
    }

    ///
    //RECEBE AS ALTERAÇÕES DO SAMBA PRIVATIVO
    ///
    if(isset($_POST["AlteraSMBpriv"])){
        $id_smbpriv = $_POST["id-smbpriv"];
        $id_maq = $_POST["maq-id-smbpriv"];
        $usuariopriv = $_POST["usuariopriv"];
        $senhapriv = $_POST["senha"];
        $grupopriv_csamba = $_POST["grupodonopriv"];//GRUPO DONO DO COMPARTILHAMENTO
        $grupopriv = implode(',',array_unique(explode(',', $grupopriv_csamba)));//REMOVE OS GRUPOS REPETIDOS
        $nomepriv = $_POST["nomepriv"];
        $diretoriopriv = $_POST["diretoriopriv"];
        $enviaproshell = "smbpriv";//DEFINE O SERVIÇO

        //PEGA OS DADOS DO COMPAR.
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE ID='$id_smbpriv'"));
        $usuarioprivOLD = $row["Usuariopriv"];//USUÁRIO QUE SERÁ ALTERADO
        $grupoprivOLD = $row["Grupopriv"];//GRUPO QUE SERÁ ALTERADO
        $nomeprivOLD = $row["Nomepriv"];//COMPAR. QUE SERÁ ALTERADO
        $diretorioprivOLD = $row["Diretoriopriv"];//DIRETÓRIO. QUE SERÁ ALTERADO
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A ALTERAÇÃO DO COMPAR.
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"];     
        
        //CASO USUÁRIO JÁ EXISTA ENTÃO PEGA OS OUTROS GRUPOS A QUAL ELE PERTENCE
        $array_grupos = array();//CRIA A ARRAY DE GRUPOS
        $row_grupos = mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Usuariopriv='$usuariopriv' AND Maquina_Id='$id_maq'");
        while($r_priv = mysqli_fetch_array($row_grupos)){//ENQUANTO HOUVE
            $array_grupos[] = $r_priv["Grupopriv"];//ATRIBUI A ARRAY
        }
        $grupopriv_outros = implode(",", $array_grupos);//ATRIBUI O QUE TIVER NA ARRAY A UMA VARIÁVEL
        if(empty($grupopriv_outros)){//SE FOR VAZIO
            $grupos = "$grupopriv";
        }else{//SE NÃO FOR VAZIO
            $grupos = "$grupopriv" . ',' . "$grupopriv_outros";
        }
        
        //VERIFICA SE O DIRETÓRIO ANTIGO ESTÁ SENDO USADO EM OUTROS COMPAR. OU PELO FTP
        $row_priv_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Diretoriopriv='$diretorioprivOLD' AND Maquina_Id='$id_maq'"));
        $usu_cut = substr("$diretorioprivOLD", 6, 20);//PEGA SOMENTE O NOME DO DIRETÓRIO 
        $row_ftp_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='$usu_cut' AND Maquina_Id='$id_maq'"));
        if($row_priv_dire > 1 || $row_ftp_dire > 0){ 
            $r_direOLD = "yes";//CASO EXISTIR MAIS DE 1
        }else{
            $r_direOLD = "no";//CASO NÃO EXISTIR MAIS DE 1
        }
        
        //VERIFICA SE O USUÁRIO ANTIGO ESTÁ SENDO USADO EM OUTROS COMPAR. OU PELO FTP
        $row_priv_usu = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Usuariopriv='$usuarioprivOLD' AND Maquina_Id='$id_maq'"));
        $row_ftp_usu = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='$usuarioprivOLD' AND Maquina_Id='$id_maq'"));
        if($row_priv_usu > 1 || $row_ftp_usu > 0){ 
            $r_usuOLD = "yes";//CASO EXISTIR MAIS DE 1
        }else{
            $r_usuOLD = "no";//CASO NÃO EXISTIR MAIS DE 1
        }
        
        /* $grupoprivOLD - SÃO OS GRUPOS ANTIGOS DO COMPAR.
        $grupos - SÃO TODOS OS GRUPOS QUE O USUÁRIO PERTENCE E QUE PERTECERÁ
        $grupopriv - SÃO OS GRUPOS QUE SERÃO DONO DO COMPAR. */
        
        //FAZ A ALTERAÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/edita.sh $enviaproshell $r_direOLD $r_usuOLD $usuarioprivOLD $usuariopriv $senhapriv $grupoprivOLD $grupos $grupopriv $nomeprivOLD $nomepriv $diretorioprivOLD $diretoriopriv $senharoot $porta $usuarioroot $ip 2>&1"); 
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A ALTERAÇÃO
        if($resul[0] == "exito"){//ENTÃO A MÁQUINA FOI ALTERADA COM SUCESSO
            //ATUALIZA NO BANCO
            $q_smbpriv = mysqli_query($conexao,"UPDATE smbpriv SET Usuariopriv='$usuariopriv', Senhapriv='$senhapriv', Grupopriv='$grupopriv', Nomepriv='$nomepriv', Diretoriopriv='$diretoriopriv' WHERE ID='$id_smbpriv'");
                        
            //VERIFICA SE O USUÁRIO JÁ EXISTE
            $usu_existe_priv = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Usuariopriv='$usuariopriv' AND Maquina_Id='$id_maq'"));
            $usu_existe_ftp = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='$usuariopriv' AND Maquina_Id='$id_maq'"));
            if($usu_existe_priv > 1 || $usu_existe_ftp > 0){//CASO EXISTA, ENTÃO TROCA A SENHA
                $q_usu = mysqli_multi_query($conexao,"UPDATE ftp SET Senha='$senhapriv' WHERE Usuario='$usuariopriv' AND Maquina_Id='$id_maq';
                                                      UPDATE smbpriv SET Senhapriv='$senhapriv' WHERE Usuariopriv='$usuariopriv' AND Maquina_Id='$id_maq'");
            }
            
            if($q_smbpriv){//CASO FOR UM SUCESSO A ALTERAÇÃO
                $_SESSION["Sucesso"] = "Alterado com sucesso.";
                echo "<script>location.href='configurados.php';</script>";
            }else{//CASO DÊ ERRO NA ALTERAÇÃO
                $_SESSION["Erro"] = "Erro ao alterar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>";
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
        }
    }
    //DELETA SAMBA PRIVATIVO
    if(isset($_POST["DeletaSMBpriv"])){ 
        $id_smbpriv = $_POST["id_smbpriv_delete"];
        $id_maq = $_POST["maq_id_smbpriv_delete"];
        $enviaproshell = "smbpriv";//DEFINE O SERVIÇO
        
        //PEGA OS DADOS DO COMPAR.
        $row = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE ID='$id_smbpriv'"));
        $usuariopriv = $row["Usuariopriv"];//USUÁRIO QUE SERÁ DELETADO
        $grupopriv = $row["Grupopriv"];//GRUPO QUE SERÁ DELETADO
        $nomepriv = $row["Nomepriv"];//COMPAR. QUE SERÁ DELETADO
        $diretoriopriv = $row["Diretoriopriv"];//DIRETORIO QUE SERÁ DELETADO
        
        //PEGA OS ACESSOS DA MÁQUINA QUE SERÁ FEITA A REMOVAÇÃO DO COMPAR.
        $row_maq = mysqli_fetch_array(mysqli_query($conexao,"SELECT * FROM maquina WHERE ID='$id_maq'"));
        $usuarioroot = $row_maq["Usuarioroot"];
        $senharoot = $row_maq["Senharoot"];
        $ip = $row_maq["Ip"];
        $porta = $row_maq["Porta"]; 
               
        //VERIFICA SE O DIRETÓRIO ESTÁ SENDO USADO EM OUTROS COMPAR. OU PELO FTP
        $row_priv_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Diretoriopriv='$diretoriopriv' AND Maquina_Id='$id_maq'"));
        $usu_cut = substr("$diretoriopriv", 6, 20);//PEGA SOMENTE O NOME DO DIRETÓRIO 
        $row_ftp_dire = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='$usu_cut' AND Maquina_Id='$id_maq'"));
        if($row_priv_dire > 1 || $row_ftp_dire > 0){ 
            $r_dire = "yes";//CASO EXISTIR MAIS DE 1
        }else{
            $r_dire = "no";//CASO NÃO EXISTIR MAIS DE 1
        }
        
        //VERIFICA SE O USUÁRIO ESTÁ SENDO USADO EM OUTROS COMPAR. OU PELO FTP
        $row_priv_usu = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM smbpriv WHERE Usuariopriv='$usuariopriv' AND Maquina_Id='$id_maq'"));
        $row_ftp_usu = mysqli_num_rows(mysqli_query($conexao,"SELECT * FROM ftp WHERE Usuario='$usuariopriv' AND Maquina_Id='$id_maq'"));
        if($row_priv_usu > 1 || $row_ftp_usu > 0){ 
            $r_usu = "yes";//CASO EXISTIR MAIS DE 1
        }else{
            $r_usu = "no";//CASO NÃO EXISTIR MAIS DE 1
        }
       
        //FAZ A REMOÇÃO NA MÁQUINA POR MEIO DE UM SCRIPT
        shell_exec("../scripts/deleta.sh $enviaproshell $r_dire $r_usu $usuariopriv $grupopriv $nomepriv $diretoriopriv $senharoot $porta $usuarioroot $ip 2>&1");
        exec("cat /etc/cgi/scripts/acesso", $resul);//VERIFICA SE FOI POSSÍVEL A REMOÇÃO
        if($resul[0] == "exito"){//ENTÃO FOI DELETADO DA MÁQUINA COM SUCESSO
            //DELETA NO BANCO
            $deleta = mysqli_query($conexao,"DELETE FROM smbpriv WHERE ID='$id_smbpriv'");
            if($deleta){//CASO FOR UM SUCESSO A REMOÇÃO
                $_SESSION["Sucesso"] = "Deletado com sucesso.";
                echo "<script>location.href='configurados.php';</script>"; 
            }else{//CASO DÊ ERRO AO DELETAR
                $_SESSION["Erro"] = "Erro ao deletar no banco de dados.";
                echo "<script>location.href='configurados.php';</script>"; 
            }
        }elseif($resul[0] == "erro"){//ENTÃO NÃO FOI POSSÍVEL ACESSAR A MÁQUINA
            $_SESSION["Erro"] = "Erro ao verificar a máquina na rede.";
            echo "<script>location.href='configurados.php';</script>";
       }
    }
?>