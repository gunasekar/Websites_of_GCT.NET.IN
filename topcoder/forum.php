<?
	require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
    session_start();
	$pageTitle = "Forum";
	if(!isset($_SESSION['id']))
	header("Location: index.php");

	if(isset($_GET['logout'])){	
		
		//Simple exit message
		$fp = fopen("log.html", 'a');
		fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
		fclose($fp);
		header("Location: logout.php"); //Redirect the user
	}

	function loginForm(){
		echo'
		<div id="loginform">
		<form action="forum.php" method="post">
			<p>Please enter your name to continue:</p>
			<label for="name">Name:</label>
			<input type="text" name="name" id="name" />
			<input type="submit" name="enter" id="enter" value="Enter" />
		</form>
		</div>
		';
	}

	if(isset($_POST['enter'])){
		if($_POST['name'] != ""){
			$_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
		}
		else{
			echo '<span class="error">Please type in a name</span>';
		}
	}
?>

<?php
	include "header.php";
?>
<div align="left">
<script>
	$(document).ready(function(){
	$("#actForm").validate();
	});
</script>
<style type="text/css" media="all">
	@import "style.css";
	@import "forum_style.css";
</style>

<?php
if(!isset($_SESSION['name'])){
	loginForm();
}
else{
?>

<div id="menu">
	<p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
	<div style="clear:both"></div>
</div>	
<div id="chatbox"><?php
if(file_exists("log.html") && filesize("log.html") > 0){
	$handle = fopen("log.html", "r");
	$contents = fread($handle, filesize("log.html"));
	fclose($handle);
	
	echo $contents;
}
?></div>
<div align="center">
<form name="message" action="" method="post">
	<input name="usermsg" type="text" id="usermsg" size="63" />
	<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
</form></div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//If user submits the form
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});				
		$("#usermsg").attr("value", "");
		return false;
	});
		
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div				
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
			},
		});
	}

	setInterval (loadLog, 2500);	//Reload file every 2.5 seconds
	
	//If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = 'index.php?logout=true';}		
	});
});
</script>
<?php
}
?>
<!-- /content-->
</div>
<?php
	include "footer.php";
?>