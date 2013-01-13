<?php 
	require_once 'config/dbconfig.php';
	require_once 'config/php_functions.php';
	session_start();
	$pageTitle = "About";
?>

<?php
	include "header.php";
?>

<!-- content -->
<div align="left">
<?php
if($_GET['page'] == "p")
	include "programming_guide.html";
else if($_GET['page'] == "s")
	include "submission_guide.html";
else if($_GET['page'] == "a")
	include "about.html";
else
	header('Location: .')
?>
</div>
<!-- /content-->

<?php
	include "footer.php";
?>