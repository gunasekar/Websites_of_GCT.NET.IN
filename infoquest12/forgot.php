<?php 
    require_once 'contents/dbconfig.php';
    require_once 'contents/php_functions.php';
    $err = NULL;
    $msg = NULL;
    session_start();
    if(!isset($_SESSION['user_id'])){
        if (isset($_POST['doReset']) && $_POST['doReset']=='Reset'){
            foreach($_POST as $key => $value) {
                $data[$key] = filter($value);
            }
            if(!isEmail($data['user_email'])) {
                $err = "ERROR - Please enter a valid email"; 
            }

            $user_email = $data['user_email'];

            //check if activ code and user is valid as precaution
            $rs_check = mysql_query("select id from users where user_email='$user_email'") or die (mysql_error()); 
            $num = mysql_num_rows($rs_check);
            // Match row found with more than 1 results  - the user is authenticated. 
            if ( $num <= 0 ) { 
                $err = "Error - Sorry no such account exists or registered.";
            }

            if(empty($err)) {
                $new_pwd = GenPwd();
                $pwd_reset = PwdHash($new_pwd);
                $rs_activ = mysql_query("update users set pwd='$pwd_reset' WHERE user_email='$user_email'") or die(mysql_error());

                $host  = $_SERVER['HTTP_HOST'];
                $host_upper = strtoupper($host);

                //send email

                $message = 
                "Here are your new password details ...\n
                User Email: $user_email \n
                Passwd: $new_pwd \n

                Thank You!

                Administrator
                $host_upper
                ______________________________________________________
                THIS IS AN AUTOMATED RESPONSE. 
                ***DO NOT RESPOND TO THIS EMAIL****
                ";

                mail($user_email, "Reset Password", $message,
                "From: \"InfoQuest @ GCT.NET.IN\" <auto-reply@$host>\r\n" .
                "X-Mailer: PHP/" . phpversion());

                $msg = "Your account password has been reset and a new password has been sent to your email address.";
            }
        }
    }
?>

<!DOCTYPE html>
<php lang="en">
<head>
	<title>Sponsors - IQ'12</title>
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
	<!--[if lt IE 7]>
	<link rel="stylesheet" href="css/ie/ie6.css" type="text/css" media="all">
	<![endif]-->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="js/php5.js"></script>
	<script type="text/javascript" src="js/IE9.js"></script>
	<![endif]-->
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
			<li><a href="sponsors.php" class="current">Sponsors</a></li>
			<li><a href="contact.php">Contact</a></li>
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
      <div class="inside" align="center">
      <h2>Forgot your password?</h2>
        <p>If you have forgot the account password, you can <strong>reset password</strong> and a new password will be sent to your email address.</p>
			<form action="forgot.php" method="post" name="actForm" id="actForm" >
				<div align="center"><p>
						Your E-mail ID : <input name="user_email" type="text" id="user_email" size="25">
				</div>
				<div align="center"><p> 
				<input name="doReset" type="submit" id="doReset" value="Reset">
				</p></div>
			</form>
			<div id="actForm_errorloc"></div>
			<script language="JavaScript" type="text/javascript">
				var frmvalidator  = new Validator("actForm");
				frmvalidator.EnableOnPageErrorDisplaySingleBox();
				frmvalidator.EnableMsgsTogether();
				frmvalidator.addValidation("user_email","req","Please enter your E-Mail ID!");
				frmvalidator.addValidation("user_email","email");
				frmvalidator.addValidation("user_email","maxlen=50");
			</script>
			<br>
			<?php
			/******************** ERROR MESSAGES*************************************************
			This code is to show error messages 
			**************************************************************************/
			if($err) {
				echo $err;
			}
			if($msg) {
				echo $msg;
			}
			/******************************* END ********************************/	  
			?>
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
