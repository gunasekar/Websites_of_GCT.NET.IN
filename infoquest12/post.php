<?
session_start();
if(isset($_SESSION['user_id'])){
	$text = $_POST['text'];
	$fp = fopen("log.html", 'a');
	fwrite($fp, "<div class='msgln'><b>".$_SESSION['user_name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
	fclose($fp);
}
?>
