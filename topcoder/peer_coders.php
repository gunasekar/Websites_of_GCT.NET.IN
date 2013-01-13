<?php 
	require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
    session_start();
	$pageTitle = "Peer Coders";
	if(!isset($_SESSION['id']))
	header('Location: index.php');
?>
<?php
	include "header.php";
?>
<h3>Peer Coders' Status</h3>
<table>
<?php
	$id = $_SESSION['id'];
	if($_SESSION['user_level'] == 1){
		$result = mysql_query("SELECT name, score, email, phone FROM topcoders where score > 0 order by score DESC") or die (mysql_error());
	}
	else{
		$result = mysql_query("SELECT name, score, email, phone FROM topcoders where score > 0 order by score DESC LIMIT 25") or die (mysql_error());
	}
	$count = mysql_num_rows($result);
	if($count==0)
	echo "No submissions yet!";
	else{
		if($_SESSION['user_level'] == 1){
			echo "<thead><th>Coder</th><th>Score</th><th>Mail ID</th><th>Phone</th></thead>";
		}
		else{
			echo "<thead><th>Coder</th><th>Score</th></thead>";
		}
		for($i = 0; $i<$count && $i<5; $i++){
			$name = mysql_result($result, $i, 'name');
			$score = mysql_result($result, $i, 'score');
			if($_SESSION['user_level'] == 1){
				$email = mysql_result($result, $i, 'email');
				$phone = mysql_result($result, $i, 'phone');
				echo "<tr><td>$name</td><td>$score</td><td>$email</td><td>$phone</td><tr>";
			}
			else{
				echo "<tr><td>$name</td><td>$score</td><tr>";
			}
		}
	}
?>
</table>
<?php
	include "footer.php";
?>