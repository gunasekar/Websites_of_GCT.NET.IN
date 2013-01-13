<?php
    session_start();
    if(!isset($_SESSION['hunterid']))
        header('Location: index.php');
?>

<html>
    <?php
    include "head.php";
    ?>
    <body>
        <div id="content" align="center"><img src ="images/forum.png">
			<div id="menu" align="center">
				<h4 align="center">Welcome, <b><?php echo $_SESSION['user_name']; ?></b></h4>
				Check out for clues and hints in the forum. Please don't post the answers in this forum!
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
		</div>
        <div id="copy">
        <?php
        if(isset($_SESSION['hunterid'])) {
            include "show_status.php";
            ?>
        <div id="copy"><font size="2"><a href="alohomora.php">Continue my Hunt!</a></font> | <font size="2"><a href="rules.php">Rules</a></font> | <font size="2"><a href="dashboard.php">Dashboard</a></font> | <font size="2"><a href="logout.php">Logout!</a></font></div>
        <?}?>
        </div>
        <div id="copy" align ="bottom">
            <?php include "footer.html";  ?>
        </div>
    </body>
</html>
