<?php
    session_start();
    require_once "config/dbconfig.php";
    mysql_close($link);
    session_unset();
    session_destroy();
    header('Location: index.php');
?>

