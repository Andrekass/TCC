//ABA M�QUINA - EXECUTA A PESQUISA MYSQL DO IP DA M�QUINA QUE SER� CADASTRADA
$('#ConfigMAQUINA, input, .jumbotron').mouseover(function(){
    var ip = $('input#ip').val();//Pega ip que ser� cadastrado
    $.post('../codphp.php', {ip:ip}, function(data){
        if(data == "1"){//Ip j� foi cadastrado
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado').html("Este IP j� foi cadastrado!");
            $('#ip').val("");
        }else if(data == "0"){//Ip n�o foi cadastrado
            //DEFINE O INPUT COMO VALIDO
            $('#resultado').html("");
        }
    });
});

//ABA FTP - EXECUTA A PESQUISA MYSQL DO USU�RIO FTP
$('#ConfigFTP, input, .jumbotron').mouseover(function(){
    var usuarioftp = $('input#usuarioftp').val();//Pega usu�rio do ftp 
    var id_maquina = $('select#id_maquina').val();//Pega o ID da m�quina
    $.post('../codphp.php', {usuarioftp:usuarioftp, id_maquina:id_maquina}, function(data){
        if(data == "1"){//Usu�rio j� existe
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado').html("Usu�rio j� existe!");
            $('#usuarioftp').val("");
        }else if(data == "0"){//Usu�rio n�o existe
            //DEFINE O INPUT COMO VALIDO
            $('#resultado').html("");
        }
    });
});

//SAMBA SIMPLES
//ABA CSAMBA - EXECUTA A PESQUISA MYSQL DO NOME DO COMPAR. DO smbsimp
$('#ConfigSAMBA, input, .jumbotron').mouseover(function(){
    var nomesimp = $('input#nomesimp').val();//Pega nome do compar. do smbsimp
    var id_maquina = $('select#id_maquina').val();//Pega o ID da m�quina
    var nomepriv = $('input#nomepriv').val();//Pega nome do compar. do smbpriv
    if($('#nomesimp').val() == "") {//SE INPUT ESTIVER VAZIO
        $('#resul_compar_simp').html("");//N�O FAZ NADA
    }else{//SE INPUT N�O ESTIVER VAZIO
        if(nomesimp == nomepriv){//VERIFICA SE OS COMPAR. NOS INPUT S�O IGUAIS
            $('#nomesimp').val("");//SE FOREM ENT�O LIMPA O CAMPO DO COMPAR. smbsimp
        }else{
            $('#nomesimp').html(""); 
        }
    }
    $.post('../codphp.php', {nomesimp:nomesimp, id_maquina:id_maquina}, function(data){
        if(data == "1"){//Nome do compartilhamento j� existe
            //DEFINE O INPUT COMO INVALIDO
            $('#resul_compar_simp').html("J� existe!");
            $('#nomesimp').val("");
        }else if(data == "0"){//Nome do Compartilhamento n�o existe
            //DEFINE O INPUT COMO VALIDO
            $('#resul_compar_simp').html("");
        }
    });
});

//ABA CSAMBA - EXECUTA A PESQUISA MYSQL DO DIRET�RIO DO smbsimp
$('#ConfigSAMBA, input, .jumbotron').mouseover(function(){
    var diretoriosimp = $('input#diretoriosimp').val();//Pega o diret�rio do smbsimp
    var id_maquina = $('select#id_maquina').val();//Pega o ID da m�quina
    var diretoriopriv = $('input#diretoriopriv').val();//Pega o diret�rio do smbpriv
    if($('#diretoriosimp').val() == "") {//SE INPUT ESTIVER VAZIO
        $('#resul_dire_simp').html("");//N�O FAZ NADA
    }else{//SE INPUT N�O ESTIVER VAZIO
        if(diretoriosimp == diretoriopriv){//VERIFICA SE OS DIRET�RIOS NOS INPUT S�O IGUAIS
            $('#diretoriosimp').val("");//SE FOREM ENT�O LIMPA O CAMPO DO DIRET�RIO smbsimp
        }else{
            $('#diretoriosimp').html(""); 
        }
    }
    $.post('../codphp.php', {diretoriosimp:diretoriosimp, id_maquina:id_maquina}, function(data){
        if(data == "1"){//DIRET�RIO SENDO USADO PELO smbpriv
            //DEFINE O INPUT COMO INVALIDO
            $('#resul_dire_simp').html("Sendo usado pelo compartilhamento privativo!");
            $('#diretoriosimp').val("");
        }else if(data == "0"){//DIRET�RIO N�O SENDO USADO PELO smbpriv
            //DEFINE O INPUT COMO VALIDO
            $('#resul_dire_simp').html("");
        }
    });
});

//SAMBA PRIVATIVO
//ABA CSAMBA - EXECUTA A PESQUISA MYSQL DO NOME DO COMPAR. DO smbpriv
$('#ConfigSAMBA, input, .jumbotron').mouseover(function(){
    var nomepriv = $('input#nomepriv').val();//Pega nome do compar. do smbpriv
    var id_maquina = $('select#id_maquina').val();//Pega o ID da m�quina
    $.post('../codphp.php', {nomepriv:nomepriv, id_maquina:id_maquina}, function(data){
        if(data == "1"){//Nome do compartilhamento j� existe
            //DEFINE O INPUT COMO INVALIDO
            $('#resul_dire_compar').html("J� existe!");
            $('#nomepriv').val("");
        }else if(data == "0"){//Nome do Compartilhamento n�o existe
            //DEFINE O INPUT COMO VALIDO
            $('#resul_dire_compar').html("");
        }
    });
});

//ABA CSAMBA - EXECUTA A PESQUISA MYSQL DO DIRET�RIO DO smbpriv
$('#ConfigSAMBA, input, .jumbotron').mouseover(function(){
    var diretoriopriv = $('input#diretoriopriv').val();//Pega o diret�rio do smbpriv
    var id_maquina = $('select#id_maquina').val();//Pega o ID da m�quina
    $.post('../codphp.php', {diretoriopriv:diretoriopriv, id_maquina:id_maquina}, function(data){
        if(data == "1"){//DIRET�RIO SENDO USADO PELO smbsimp
            //DEFINE O INPUT COMO INVALIDO
            $('#resul_dire_priv').html("Sendo usado pelo compartilhamento simples!");
            $('#diretoriopriv').val("");
        }else if(data == "0"){//DIRET�RIO N�O SENDO USADO PELO smbsimp
            //DEFINE O INPUT COMO VALIDO
            $('#resul_dire_priv').html("");
        }
    });
});

///
//ABA CONFIGURADOS
///

//EXECUTA A PESQUISA MYSQL DO IP DA MAQUINA
$('#AlteraMAQ, input, .modal-body').mouseover(function(){
    var ip_maq = $('input#recipient-ip').val();//Pega ip da m�quina 
    var id_maq = $('input#id-maq').val();//Pega o ID da tabela da m�quina
    $.post('../codphp.php', {ip_maq:ip_maq, id_maq:id_maq}, function(data){
        if(data == "1"){//IP J� EM USO
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado_maq').html("IP est� em uso!");
            $('#recipient-ip').val("");
        }else if(data == "0"){//IP N�O EST� EM USO
            //DEFINE O INPUT COMO VALIDO
            $('#resultado_maq').html("");
        }
    });
});

//EXECUTA A PESQUISA MYSQL DO USU�RIO FTP
$('#AlteraFTP, input, .modal-body').mouseover(function(){
    var usuarioftp = $('input#recipient-user').val();//Pega usu�rio do ftp 
    var id_ftp = $('input#id-ftp').val();//Pega o ID da tabela do ftp
    var ip_ftp = $('input#ip-ftp').val();//Pega o IP da tabela do ftp
    $.post('../codphp.php', {usuarioftp:usuarioftp, id_ftp:id_ftp, ip_ftp:ip_ftp}, function(data){
        if(data == "1"){//Usu�rio j� existe
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado_ftp').html("Usu�rio j� existe!");
            $('#recipient-user').val("");
        }else if(data == "0"){//Usu�rio n�o existe
            //DEFINE O INPUT COMO VALIDO
            $('#resultado_ftp').html("");
        }
    });
});

//SAMBA SIMPLES
//EXECUTA A PESQUISA MYSQL DO NOME DO COMPARTILHAMENTO DO smbsimp
$('#AlteraSMBsimp, input, .modal-body').mouseover(function(){
    var nomesimp = $('input#recipient-nomesimp').val();//Pega nome do compar. do smbsimp
    var id_smbsimp = $('input#id-smbsimp').val();//Pega o ID da tabela do smbsimp
    var ip_smbsimp = $('input#ip-smbsimp').val();//Pega o IP da tabela do smbsimp
    $.post('../codphp.php', {nomesimp:nomesimp, id_smbsimp:id_smbsimp, ip_smbsimp:ip_smbsimp}, function(data){
        if(data == "1"){//Nome do compartilhamento j� existe
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado_compar_smbsimp').html("J� existe!");
            $('#recipient-nomesimp').val("");
        }else if(data == "0"){//Nome do Compartilhamento n�o existe
            //DEFINE O INPUT COMO VALIDO
            $('#resultado_compar_smbsimp').html("");
        }
    });
});

//EXECUTA A PESQUISA MYSQL DO DIRET�RIO DO smbsimp
$('#AlteraSMBpriv, input, .modal-body').mouseover(function(){
    var diretoriosimp = $('input#recipient-diretoriosimp').val();//Pega o diret�rio do smbsimp
    var ip_smbsimp = $('input#ip-smbsimp').val();//Pega o IP da tabela do smbpriv
    $.post('../codphp.php', {diretoriosimp:diretoriosimp, ip_smbsimp:ip_smbsimp}, function(data){
        if(data == "1"){//DIRET�RIO SENDO USADO PELO smbpriv
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado_dire_smbsimp').html("Sendo usado pelo compartilhamento privativo!");
            $('#recipient-diretoriosimp').val("");
        }else if(data == "0"){//DIRET�RIO N�O SENDO USADO PELO smbpriv
            //DEFINE O INPUT COMO VALIDO
            $('#resultado_dire_smbsimp').html("");
        }
    });
});

//SAMBA PRIVATIVO
//EXECUTA A PESQUISA MYSQL DO NOME DO COMPARTILHAMENTO DO smbpriv
$('#AlteraSMBpriv, input, .modal-body').mouseover(function(){
    var nomepriv = $('input#recipient-nomepriv').val();//Pega nome do compar. do smbpriv
    var id_smbpriv = $('input#id-smbpriv').val();//Pega o ID da tabela do smbpriv
    var ip_smbpriv = $('input#ip-smbpriv').val();//Pega o IP da tabela do smbpriv
    $.post('../codphp.php', {nomepriv:nomepriv, id_smbpriv:id_smbpriv, ip_smbpriv:ip_smbpriv}, function(data){
        if(data == "1"){//Nome do compartilhamento j� existe
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado_compar_smbpriv').html("J� existe!");
            $('#recipient-nomepriv').val("");
        }else if(data == "0"){//Nome do Compartilhamento n�o existe
            //DEFINE O INPUT COMO VALIDO
            $('#resultado_compar_smbpriv').html("");
        }
    });
});

//EXECUTA A PESQUISA MYSQL DO DIRET�RIO DO smbpriv
$('#AlteraSMBpriv, input, .modal-body').mouseover(function(){
    var diretoriopriv = $('input#recipient-diretoriopriv').val();//Pega o diret�rio do smbpriv
    var ip_smbpriv = $('input#ip-smbpriv').val();//Pega o IP da tabela do smbpriv
    $.post('../codphp.php', {diretoriopriv:diretoriopriv, ip_smbpriv:ip_smbpriv}, function(data){
        if(data == "1"){//DIRET�RIO SENDO USADO PELO smbsimp
            //DEFINE O INPUT COMO INVALIDO
            $('#resultado_dire_smbpriv').html("Sendo usado pelo compartilhamento simples!");
            $('#recipient-diretoriopriv').val("");
        }else if(data == "0"){//DIRET�RIO N�O SENDO USADO PELO smbsimp
            //DEFINE O INPUT COMO VALIDO
            $('#resultado_dire_smbpriv').html("");
        }
    });
});

