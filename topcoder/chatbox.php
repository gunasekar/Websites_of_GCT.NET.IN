<?php
  if(isset($_SESSION['id'])){?>
<div align="center">Welcome, <b><?php echo $_SESSION['name']; ?></b></div>
<?}?>

<div id="chatbox"><?php
if(file_exists("log.html") && filesize("log.html") > 0){
	$handle = fopen("log.html", "r");
	$contents = fread($handle, filesize("log.html"));
	fclose($handle);
	echo $contents;
}
?>
</div>

<div>
<form name="message" action="" method="POST">
	<input name="usermsg" type="text" id="usermsg" size="16" />
	<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
</form></div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
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
});
</script>
