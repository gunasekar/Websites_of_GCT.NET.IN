<?php
    require_once 'config/dbconfig.php';
    require_once 'config/php_validation.php';
    $result = mysql_query("SELECT id FROM users WHERE id not in (select id from e_reg)") or die (mysql_error());
    //$result = mysql_query("SELECT id FROM alohomora"); 
    $num = mysql_num_rows($result);
    echo $num;
    for($i = 0; $i < $num; $i++){
    	$id = mysql_result($result, $i, 'id');
    	echo "$id<br>";
    	$r = mysql_query("INSERT into e_reg(id) values($id)") or die (mysql_error());
    }
?>
