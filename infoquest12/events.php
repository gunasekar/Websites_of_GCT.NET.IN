<?php
    session_start();
    require_once 'contents/dbconfig.php';
	require_once 'contents/php_functions.php';
	if(isset($_SESSION['user_id']) && isset($_POST['submit'])){
		$id = $_SESSION['user_id'];
		$e_1 = $_SESSION['e_1'];
		$e_2 = $_SESSION['e_2'];
		$e_3 = $_SESSION['e_3'];
		if(isset($_POST['e_1']))
		$e_1 = $_POST['e_1'];
		if(isset($_POST['e_2']))
		$e_2 = $_POST['e_2'];
		if(isset($_POST['e_3']))
		$e_3 = $_POST['e_3'];
		$sql = "UPDATE e_reg SET  `e_1` =  '$e_1', `e_2` =  '$e_2', `e_3` =  '$e_3' WHERE  `e_reg`.`id` =$id";
		$result = mysql_query($sql) or die(mysql_error());
		if($result){
			if(isset($_POST['e_1']))
			$_SESSION['e_1'] = $_POST['e_1'];
			if(isset($_POST['e_2']))
			$_SESSION['e_2'] = $_POST['e_2'];
			if(isset($_POST['e_3']))
			$_SESSION['e_3'] = $_POST['e_3'];
		}
		mysql_close($link);
		header('Location: events.php?#box11');
	}
?>

<!DOCTYPE html>
<php lang="en">
<head>
	<title>Events - IQ'12</title>
	<meta charset="utf-8">
		<meta name="description" content="InfoQuest - A National Level Technical Symposium - GCT CSITA" />
	<meta name="keywords" content="InfoQuest, IQ, GCT, CSITA, IQ'12, InfoQuest'12, National, Technical, Symposium, Alohomora, TopCoder, Govt. College of Technology, Coimbatore, Tamilnadu, SSQ, Login, CSE, IT, Computer Science & Engineering and Information Technology Association" />
	<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/popup.css" type="text/css" />
	<link rel="stylesheet" href="css/dropdown.css" type="text/css" />
	
	<script type="text/javascript" src="js/popup.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
	<script type="text/javascript" src="js/cufon-yui.js"></script>
	<script type="text/javascript" src="js/Humanst521_BT_400.font.js"></script>
	<script type="text/javascript" src="js/Humanst521_Lt_BT_400.font.js"></script>
	<script type="text/javascript" src="js/cufon-replace.js"></script>
	<script type="text/javascript" src="js/roundabout.js"></script>
	<script type="text/javascript" src="js/roundabout_shapes.js"></script>
	<script type="text/javascript" src="js/gallery_init.js"></script>
	
    <link rel="stylesheet" type="text/css" href="css/tut.css">
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>

    <script type="text/javascript">
	$(document).ready(function() {  
		$('a.link').click(function () {  
			$('#e_wrapper').scrollTo($(this).attr('href'), 800);
			setPosition($(this).attr('href'), '#cloud1', '0px', '200px', '400px', '600px', '800px', '1000px', '1200px', '1400px', '1600px', '1800px')
			setPosition($(this).attr('href'), '#cloud2', '0px', '400px', '800px', '1200px', '1600px', '2000px', '2400px', '2800px', '3200px', '3600px')
			$('a.link').removeClass('selected');  
			$(this).addClass('selected');
			return false;  
		});  
	});
	function setPosition(check, div, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10) {
	if(check==='#box1')
		{
			$(div).scrollTo(p1, 800);
		}
	else if(check==='#box2')
		{
			$(div).scrollTo(p2, 800);
		}
	else if(check==='#box3')
		{
			$(div).scrollTo(p3, 800);
		}
	else if(check==='#box4')
		{
			$(div).scrollTo(p4, 800);
		}
	else if(check==='#box5')
		{
			$(div).scrollTo(p5, 800);
		}
	else if(check==='#box6')
		{
			$(div).scrollTo(p6, 800);
		}
	else if(check==='#box7')
		{
			$(div).scrollTo(p7, 800);
		}
	else if(check==='#box8')
		{
			$(div).scrollTo(p8, 800);
		}
	else if(check==='#box9')
		{
			$(div).scrollTo(p9, 800);
		}
	else
		{
			$(div).scrollTo(p10, 800);
		}
	};
	</script>
	
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
			<li><a href="events.php" class="current">Events</a></li>
			<li><a href="workshops.php">Workshops</a></li>
			<li><a href="gallery.php">Gallery</a></li>
			<li><a href="sponsors.php">Sponsors</a></li>
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
	<div align='center'>Login to register for the events @ IQ'12</div>
	<?}
	else{
		echo "<div class='container' align='right'>Hi <span>".$_SESSION['user_name']."!</span> | <a href='logout.php'>Logout</a></div>";
		echo "<div align='center'><a href='#box11' class='link'>Click here to register for the events @ IQ'12</a></div>";
	}
	?>
    <div class="container">
      <div class="inside">
        <div class="wrapper">
			<div id="cloud1" class="clouds">
			<div id="clouds-small"></div>
			</div><!-- end clouds -->
			<div id="cloud2" class="clouds">
				<div id="clouds-big"></div>
			</div><!-- end clouds -->
			<div id="e_header" align="center">
				<ul id="menu">
				  <li><a href="#box1" class="link">Icon</a></li>
					<li><a href="#box2" class="link">Podium'Stars</a></li>
					<li><a href="#box3" class="link">Futur E'neurs</a></li>
					<li><a href="#box4" class="link">Coder Spot</a></li>
					<li><a href="#box5" class="link">Geeks!</a></li>
					<li><a href="#box6" class="link">OSH!</a></li>
					<li><a href="#box7" class="link">Net Philia</a></li>
					<li><a href="#box8" class="link">Nerd Haters!</a></li>
					<li><a href="#box9" class="link">Nxt Warner Bros?</a></li>
					<li><a href="#box10" class="link">Play'r'Die</a></li>
				</ul>
			</div><!-- end header -->
			<div id="e_wrapper">
				<ul id="mask">
					<li id="box1" class="box">
						<a name="box1"></a>
						<div class="content" align="center"><div class="inner"><h2>Icon of IQ</h2>
						<?php 
						include "contents/events/icon";
						?>
					</li>
					<li id="box2" class="box">
						<a name="box2"></a>
						<div class="content" align="center"><div class="inner"><h2>Podium'Stars</h2>
						<?php 
						include "contents/events/cyrusso";
						include "contents/events/odyssey";
						?>
						</div></div>
					</li>
					<li id="box3" class="box">
						<a name="box3"></a>
						<div class="content" align="center"><div class="inner"><h2>Future Entrepreneurs</h2>
						<?php 
						include "contents/events/bplan";
						include "contents/events/marketing";
						?>
						</div></div>
					</li>
					<li id="box4" class="box">
						<a name="box4"></a>
						<div class="content" align="center"><div class="inner"><h2>Coders Spot</h2>
						<?php 
						include "contents/events/impromptu";
						include "contents/events/onsite";
						?>
						</div></div>
					</li>
					<li id="box5" class="box">
						<a name="box5"></a>
						<div class="content" align="center"><div class="inner"><h2>Geeks Corner</h2>
						<?php 
						include "contents/events/mastermind";
						include "contents/events/sequel";
						include "contents/events/webhunt";
						?>
						</div></div>
					</li>
					<li id="box6" class="box">
						<a name="box6"></a>
						<div class="content" align="center"><div class="inner"><h2>Open Source Handlers!</h2>
						<?php 
						include "contents/events/gnu";
						include "contents/events/nsx";
						?>
						</div></div>
					</li><li id="box7" class="box">
						<a name="box7"></a>
						<div class="content" align="center"><div class="inner"><h2>Net Philia</h2>
						<?php 
						include "contents/events/topcoder";
						include "contents/events/alohomora";
						?>
						</div></div>
					</li>
					<li id="box8" class="box">
						<a name="box8"></a>
						<div class="content" align="center"><div class="inner"><h2>Nerd Haters!</h2>
						<?php
						include "contents/events/silver";
						include "contents/events/savvyspot";
						include "contents/events/googler";
						include "contents/events/quiz";
						?>
						</div></div>
					</li>
					<li id="box9" class="box">
						<a name="box9"></a>
						<div class="content" align="center"><div class="inner"><h2>Next Warner Bros?</h2>
						<?php
						include "contents/events/creativeeye";
						include "contents/events/posterize";
						?>
						</div></div>
					</li>
					<li id="box10" class="box">
						<a name="box10"></a>
						<div class="content" align="center"><div class="inner"><h2>Play or Die</h2>
						<?php
						include "contents/events/gaming";
						?>
						</div></div>
					</li>
					<li id="box11" class="box">
						<a name="box11"></a>
						<div class="content" align="center"><div class="inner"><h2>Event Registration</h2>
						<?php
						include "contents/e_registration.php";
						echo "<br>This is just your confirmation on participating in the above events. Visit the respective websites for further process. Thanks!";
						?>
						</div></div>
					</li><!-- end box4 -->
				</ul><!-- end mask -->
			</div><!-- end wrapper -->
        
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
