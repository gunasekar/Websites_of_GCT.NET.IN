<?php
session_start();
if(isset($_SESSION['hunterid'])){
	$text = $_POST['text'];

	/*require_once '../../htmlpurifier/HTMLPurifier.auto.php';
	
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	$text = $purifier->purify($text);*/
 
	$fp = fopen("log.html", 'a');
	if($fp)
	fwrite($fp, "<div class='msgln'><b>".$_SESSION['user_name']."</b>: ".$text."<br></div>");
	//fwrite($fp, "<div class='msgln'><b>".$_SESSION['user_name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
	else
	echo "Error!";
	fclose($fp);
}
?>


<SCRIPT>alert("Your site is hacked!")</SCRIPT>
