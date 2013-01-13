<?php 
	require_once 'contents/dbconfig.php';
	require_once 'contents/php_functions.php';
	foreach($_GET as $key => $value) {
		$get[$key] = filter($value);
	}
	$err = NULL;
	$msg = NULL;
	/******** EMAIL ACTIVATION LINK**********************/
	if(isset($get['user']) && !empty($get['activ_code']) && !empty($get['user']) && is_numeric($get['activ_code']) ) {

	$user = mysql_real_escape_string($get['user']);
	$activ = mysql_real_escape_string($get['activ_code']);

	//check if activ code and user is valid
	$rs_check = mysql_query("select id from users where md5_id='$user' and activation_code='$activ'") or die (mysql_error()); 
	$num = mysql_num_rows($rs_check);
	  // Match row found with more than 1 results  - the user is authenticated. 
	   if ( $num <= 0 ) { 
		$err = "Sorry no such account exists or activation code invalid.";
		}

	if(empty($err)) {
	// set the approved field to 1 to activate the account
	$rs_activ = mysql_query("update users set approved='1' WHERE md5_id='$user' AND activation_code = '$activ' ") or die(mysql_error());
	$msg = "Thank you. Your account has been activated.";
	 }
	}

	/******************* ACTIVATION BY FORM**************************/
	if (isset($_POST['doActivate']) && $_POST['doActivate']=='Activate')
	{

	$user_email = mysql_real_escape_string($_POST['user_email']);
	$activ = mysql_real_escape_string($_POST['activ_code']);
	//check if activ code and user is valid as precaution
	$rs_check = mysql_query("select id from users where user_email='$user_email' and activation_code='$activ'") or die (mysql_error()); 
	$num = mysql_num_rows($rs_check);
	  // Match row found with more than 1 results  - the user is authenticated. 
		if ( $num <= 0 ) { 
		$err = "Sorry no such account exists or activation code invalid.";
		}
	//set approved field to 1 to activate the user
	if(empty($err)) {
		$rs_activ = mysql_query("update users set approved='1' WHERE 
							 user_email='$user_email' AND activation_code = '$activ' ") or die(mysql_error());
		$msg = "Thank you. Your account has been activated.";
	 }
	}
?>

<!DOCTYPE html>
<php lang="en">
<head>
	<title>Account Activation - IQ'12</title>
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
      <div class="inside">
        <?php
			if($err)  {
				echo $err;?>
		<br><div align="center"> 
			<h2><strong>Activate your Account!<br><br></strong></h2>
		<form action="activate.php" method="post" name="actForm" id="actForm" >
			Your Email<br>
			<input name="user_email" type="text" size="25"><br>
			Activation code<br>
			<input name="activ_code" type="password" size="25"><br>
			<input name="doActivate" type="submit"  value="Activate">
		</form>
		</div>
		<?
			}
			else if($msg)  {
				echo "<div align='center'><h2><strong>Account Activated!<br><br></strong></h2>$msg</div>";
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
        <div class="fcenter" align="center">Site designed and maintained by &nbsp;<a href="mailto:infoquest@gct.net.in">GCT CSITA - GCT CSITA - iTeam</a></div>
      </div>
    </div>
  </footer>
  <script type="text/javascript"> Cufon.now(); </script>
      
</body>
</php>
