<?php
    error_reporting(false);
    function logout() {
        if($_GET["func"] && $_GET["func"] == "logout"){
            session_destroy();
            header("index.php");
        }
    }
?>