<!DOCTYPE html>
<php lang="en">
<?php
    require_once 'contents/dbconfig.php';
    require_once 'contents/php_functions.php';
	$result = mysql_query("SELECT id FROM users") or die (mysql_error()); 
	if($result){
		$num = mysql_num_rows($result);
		for($i=0;$i<$num;$i++){
			$id = mysql_result($result, $i, 'id');
			$res = mysql_query("INSERT INTO `alohomora` (`id`) VALUES ('$id')") or die (mysql_error()); 
			if($res)
			echo "$id inserted!<br>";
		}
	}
	
?>
