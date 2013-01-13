<?php
session_start();
if(isset($_SESSION['name'])){
	$text = $_POST['text'];

	//require_once 'library/HTMLPurifier.auto.php';
	
	//$config = HTMLPurifier_Config::createDefault();
	//$purifier = new HTMLPurifier($config);
	//$text = $purifier->purify($text);
 
	$fp = fopen("log.html", 'a');
	if($fp)
	fwrite($fp, "<div class='msgln'><b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
	else
	echo "Error!";
	fclose($fp);
}
?>
