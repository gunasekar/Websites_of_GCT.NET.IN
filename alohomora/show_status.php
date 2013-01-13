<?php
	require_once "config/event_conf.php";
    $level = $_SESSION['level'];
    if($level <= $target)
        echo "You are in level - $level<br>";
    else
    echo "You are done with your hunt!<br>";
?>
