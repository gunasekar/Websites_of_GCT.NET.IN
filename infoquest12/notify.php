<!DOCTYPE html>
<php lang="en">
<?php
	require_once 'contents/dbconfig.php';
    require_once 'contents/php_functions.php';
	session_start();
	if(isset($_SESSION['user_id']) && $_SESSION['user_level'] == 5){
		if(isset($_POST['submit'])){
			if(isset($_POST['subject']) && isset($_POST['content'])){
				$message = $_POST['content'];
				$subject = $_POST['subject'];
				$subject = "InfoQuest'12 - $subject";
				$user_name = $_SESSION['user_name'];
				$user_email = $_SESSION['user_email'];
				$result = mysql_query("select user_name, user_email from users where id=2012");
				$count = mysql_num_rows($result);
				for($i = 0; $i<$count;$i++){
					$mailid = mysql_result($result, $i, 'user_email');
					$name = mysql_result($result, $i, 'user_name');
					$content = "Hi $name,\n\n".$message."\n\nThanks & Regards\nInfoQuest Administrator";
					mail($mailid, $subject, $content, "From: \"$user_name\" <$user_email>\r\n" . "X-Mailer: PHP/" . phpversion());
				}
				header("Location: notify.php");
				exit();
			}
		}
	}
	else
	header('Location: index.php');
?>
<head>
	<title>Notify All - IQ'12</title>
	<meta charset="utf-8">
		<meta name="description" content="InfoQuest - A National Level Technical Symposium - GCT CSITA" />
	<meta name="keywords" content="InfoQuest, IQ, GCT, CSITA, IQ'12, InfoQuest'12, National, Technical, Symposium, Alohomora, TopCoder, Govt. College of Technology, Coimbatore, Tamilnadu, SSQ, Login, CSE, IT, Computer Science & Engineering and Information Technology Association" />
	<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/popup.css" type="text/css" />
	
	<script type="text/javascript" src="js/popup.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
	<script type="text/javascript" src="js/cufon-yui.js"></script>
	<script type="text/javascript" src="js/Humanst521_BT_400.font.js"></script>
	<script type="text/javascript" src="js/Humanst521_Lt_BT_400.font.js"></script>
	<script type="text/javascript" src="js/cufon-replace.js"></script>
	<script type="text/javascript" src="js/roundabout.js"></script>
	<script type="text/javascript" src="js/roundabout_shapes.js"></script>
	<script type="text/javascript" src="js/gallery_init.js"></script>
	<script type="text/javascript" src="js/gen_validatorv4.js"></script>
</head>

<body>
  <!-- header -->
  <header>
    <div class="container">
    	<h1><a href="index.php">InfoQuest'12</a></h1>
      <nav>
        <ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="events.php">Events</a></li>
			<li><a href="workshops.php">Workshops</a></li>
			<li><a href="gallery.php">Gallery</a></li>
			<li><a href="sponsors.php">Sponsors</a></li>
			<li><a href="contact.php" class="current">Contact</a></li>
        </ul>
      </nav>
    </div>
	</header>

  <div class="main-box">
  	<?php
		if(!isset($_SESSION['user_id'])){
	?>
	<div class="container" align="right"><strong><a href="javascript:TINY.box.show({url:'popuplogin.html',width:300,height:160,openjs:'initPopupLogin',opacity:30})">Login</a> | <a href="register.php">Register</a></strong></div>
	<?}
	else
	echo "<div class='container' align='right'>Hi <span>".$_SESSION['user_name']."!</span> | <a href='logout.php'>Logout</a></div>";
	?>
    <div class="container">
      <div class="inside">
        <div class="wrapper">
            <h2>Notification <span>Form</span></h2>
            <?php
            if(isset($_SESSION['user_id']) && $_SESSION['user_level']==5){
            ?>
              <form name="sendForm" id="sendForm" action="notify.php" method="post">
                <fieldset>
                  <div class="field">
                    <label>Subject</label><br>
                    <input name="subject" id="subject" type="text" value=""/>
                  </div>
                  <div class="field">
                    <label>Your Message</label><br>
                    <textarea name="content" id="content" rows="10" cols="50"></textarea>
                  </div><br>
                </fieldset>
                <div><input type="submit" name="submit" value="Send Your Message!"></div>
              </form>
              <div id="sendForm_errorloc"></div>
			<script language="JavaScript" type="text/javascript">
				var frmvalidator  = new Validator("sendForm");
				frmvalidator.EnableOnPageErrorDisplaySingleBox();
				frmvalidator.EnableMsgsTogether();
				frmvalidator.addValidation("subject","req","Please enter the subject!");
				frmvalidator.addValidation("content","req","Please enter the content!");
			</script>
              <?
              }
              else
              echo "Please login as administrator to send notification to the registerants!";
              ?>
        </div>
      </div>
    </div>
  </div>
  <!-- footer -->
  <footer>
    <div class="container">
    	<div class="wrapper">
        <div class="fleft">Copyright &copy; <a rel="nofollow" href="http://www.infoquest.gct.net.in/" target="_blank">InfoQuest</a></div>
        <div class="fright"><a href="about.php">iVer 12.0</a></div>
        <div class="fcenter" align="center">Site designed and maintained by &nbsp;<a href="mailto:infoquest@gct.net.in">GCT CSITA - iTeam</a></div>
      </div>
    </div>
  </footer>
  <script type="text/javascript"> Cufon.now(); </script>  
</body>
</php>
