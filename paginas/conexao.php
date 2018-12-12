<?php
    $conexao = mysqli_connect('localhost', 'root', 'admin');
    mysqli_select_db($conexao, 'cgi_db') or die (mysql_error());
    mysqli_set_charset($conexao,"utf8");
?>