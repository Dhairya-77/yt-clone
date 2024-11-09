<?php
    session_start();

    $_SESSION=[];
    session_unset();
    session_destroy();

    setcookie("un","",time()-3600,"/");
    setcookie("pw","",time()-3600,"/");
    setcookie("uid","",time()-3600,"/");

    header('location: Login.php');
    exit;
?>