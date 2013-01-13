<?
	session_start();
	if($_SESSION['user_level'] == 5){
		$_SESSION['level'] = $_GET['level'];
	}
	header('Location: alohomora.php');
?>
