<?php
	session_start();    
    require_once 'contents/dbconfig.php';
    require_once 'contents/php_functions.php';
    $err = NULL;
    if(!isset($_SESSION['user_id'])){
		$num = 0;
		foreach($_GET as $key => $value) {
			$get[$key] = filter($value); //get variables are filtered.
		}
		if (isset($_POST['doLogin']) && $_POST['doLogin']=='Login'){
			foreach($_POST as $key => $value) {
                            $data[$key] = filter($value); // post variables are filtered
			}
			if($_POST['loginid'] != mysql_real_escape_string($_POST['loginid']))
				$err = "Invalid Credentials";
			if(!$err){
				$loginid = $data['loginid'];
				$pass = $data['pwd'];
				if (strpos($loginid,'@') === false) {
					if(substr($loginid, 0, 2) == "iq" || substr($loginid, 0, 2) == "IQ" || substr($loginid, 0, 2) == "Iq" || substr($loginid, 0, 2) == "iQ"){
						$loginid = substr($loginid, 2);
						$user_cond = "users.id='$loginid'";
					}
					else
						$err = "Invalid ID";
				} else {
					$user_cond = "users.user_email='$loginid'";
				}
				if(!$err){
					$result = mysql_query("SELECT users.id, pwd, user_name, user_email, approved, user_level, e_1, e_2, e_3 FROM users, e_reg WHERE $user_cond && e_reg.id=users.id") or die (mysql_error()); 
					if($result)
					$num = mysql_num_rows($result);
				}
				if ($num > 0 && !$err){
						list($id,$pwd,$user_name,$user_email,$approved,$user_level,$e_1,$e_2,$e_3) = mysql_fetch_row($result);
						if(!$approved){
								$err = "<div align='center'><h6>Account not activated!</h6>Please check your email for activation code</div>";
						}
						else{
							//check against salt
							if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
								if(empty($err)){
									// this sets variables in the session
									$err = "<div align='center'><h6>Session Started</h6>";
									session_start();
									session_regenerate_id (true); //prevent against session fixation attacks.
									$_SESSION['user_id']= $id;
									$_SESSION['user_name'] = $user_name;
									$_SESSION['user_email'] = $user_email;
									$_SESSION['user_level'] = $user_level;
									$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
									$_SESSION['e_1'] = $e_1;
									$_SESSION['e_2'] = $e_2;
									$_SESSION['e_3'] = $e_3;
									$_SESSION['chat'] = 1;
									//update the timestamp and key for cookie
									$stamp = time();
									$ckey = GenKey();
									mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());
									//set a cookie 
									if(isset($_POST['remember'])){
											setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
											setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
											setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
									}
								}
								header('Location: index.php');
							}
							else{
								$err = "<div align='center'><h6>Invalid Login!</h6>Please try again with correct User ID/E-mail ID and password.</div>";
							}
						}
				} else {
					$err = "<div align='center'><h6>Invalid Login!</h6>No such user exists.</div>";
				}
			}
		}
	}
?>

<!DOCTYPE html>
<php lang="en">
<head>
	<title>InfoQuest'12 - A National Level Technical Symposium</title>
	<meta charset="utf-8">
	<meta name="description" content="InfoQuest - A National Level Technical Symposium - GCT CSITA" />
	<meta name="keywords" content="InfoQuest, IQ, GCT, CSITA, IQ'12, InfoQuest'12, National, Technical, Symposium, Alohomora, TopCoder, Govt. College of Technology, Coimbatore, Tamilnadu, SSQ, Login, CSE, IT, Computer Science & Engineering and Information Technology Association" />
	<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/popup.css" type="text/css" />
	<link rel="icon" href="/images/favicon.ico" />
	
	<script type="text/javascript" src="js/popup.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
	<script type="text/javascript" src="js/cufon-yui.js"></script>
	<script type="text/javascript" src="js/Humanst521_BT_400.font.js"></script>
	<script type="text/javascript" src="js/Humanst521_Lt_BT_400.font.js"></script>
	<script type="text/javascript" src="js/roundabout.js"></script>
	<script type="text/javascript" src="js/roundabout_shapes.js"></script>
	<script type="text/javascript" src="js/gallery_init.js"></script>
	<script type="text/javascript" src="js/cufon-replace.js"></script>
	<script type="text/javascript" src="js/gen_validatorv4.js"></script>
	<!--[if lt IE 7]>
	<link rel="stylesheet" href="css/ie/ie6.css" type="text/css" media="all">
	<![endif]-->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="js/html5.js"></script>
	<script type="text/javascript" src="js/IE9.js"></script>
	<![endif]-->
</head>

<body>
  <!-- header -->
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=180636182034237";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <header>
    <div class="container">
    	<h1><a href=".">InfoQuest'12</a></h1>
      <nav>
        <ul>
			<li><a href="index.php" class="current">Home</a></li>
			<li><a href="events.php">Events</a></li>
			<li><a href="workshops.php">Workshops</a></li>
			<li><a href="gallery.php">Gallery</a></li>
			<li><a href="sponsors.php">Sponsors</a></li>
			<li><a href="contact.php">Contact</a></li>
        </ul>
      </nav>      
    </div>
	</header>
  <!-- #gallery -->
  <section id="gallery">
  	<div class="container">
  	<?php
		if(!isset($_SESSION['user_id'])){
	?>
	<div class="l_container" align="right"><strong><a href="javascript:TINY.box.show({url:'popuplogin.html',width:300,height:160,openjs:'initPopupLogin',opacity:30})">Login</a> | <a href="register.php">Register</a></strong></div>
	<?}
	else
	echo "<div class='l_container' align='right'>Hi <span>".$_SESSION['user_name']."!</span> | <a href='logout.php'>Logout</a><br><a href='http://infoquest.gct.net.in/infoquest12/alohomora/'>Hunt our Alohomora!</a></div>";
	if($err){
	echo "<h2 align='center'>Error!</h2><h3 align='center'>$err</h3>";
	}
	else{
	?>
	<div class="container" align="right"><marquee>Online Registration is Closed! | Registration Fees for IQ'12 - Rs. 100 | <a href="shortlists.php?page=c">Cyrusso(Paper) Shortlists</a> | <a href="shortlists.php?page=o">Odyssey(Project) Shortlists</a></marquee></div>
	 <ul id="myRoundabout">
      	<li><img src="images/slide1.jpg" alt=""></li>
        <li><img src="images/slide2.jpg" alt=""></li>
        <li><img src="images/slide4.jpg" alt=""></li>
        <li><img src="images/slide3.jpg" alt=""></li>
        <li><img src="images/slide5.jpg" alt=""></li>
      </ul>
    <?}?>
  	</div>
  </section>
  <!-- /#gallery -->
  <div class="main-box">
    <div class="container">
      <div class="inside">
        <div class="wrapper">
		<!-- aside -->
          <aside>
            <h2>Recent <span>Updates</span></h2>
            <!-- .news -->
            <?
            include "contents/news_show.php";
            if(isset($_SESSION['user_id'])&&$_SESSION['user_level'] == 5){
				include "contents/news_admin_content.php";
			}
            ?>
            <br><br>
            <!-- /.news -->
          </aside>
          <!-- content -->
          <section id="content">
            <article>
            	<h2>Welcome to <span>InfoQuest'12!</span></h2>
				<h2 align="center"><span>Zenith of Excappare!</span></h2>
              <figure><a href="#"><img src="images/banner1.jpg" alt=""></a></figure>
              <p>InfoQuest is a National Level Technical Symposium Conducted by the Computer Science and Information Technology Association (CSITA) of Government College of Technology, Coimbatore. IQ'12 is its latest version under our creation!</p>
				<p>After successful editions in the previous years attracting the top talents from around 275 colleges across the country, IQ is back with its latest edition</p>
				<h2 align="center"><span>IQ'12!</span></h2>
				<p>Devised with its enormous array of Events, be it the TopCoder or an all-out Gaming contest to finding the best among the lot, IQ '12 has it all to enthrall the participants further for a complete and enriching experience.<br>
				<h2 align="center">2nd and 3rd March, 2012</h2>
				</p>
            </article>
            <div class="fb-like" data-href="https://www.facebook.com/infoquest.gct" data-send="true" data-width="575" data-show-faces="true" data-font="lucida grande"></div>
            <a href="https://twitter.com/intent/tweet?screen_name=InfoQuest" class="twitter-mention-button" data-size="large" data-related="infoquest_gct">Tweet to @InfoQuest</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          </section>
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
