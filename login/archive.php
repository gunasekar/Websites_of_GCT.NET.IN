<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<title>Login'11 - Prego Cohorts</title>
</head>
<body>
	<div id="wrapper">
		<div id="topnav">
			<div id="menu">
			<ul>
			<li><a href="index.php" title="Home">Home</a></li>
			<li><a href="events.php" title="Events">Events</a></li>
			<li><a href="contact.php" title="Contact">Contact</a></li>
			<li><a href="archive.php" title="Archives">Archives</a></li>
			</ul>
			</div>
		</div>

		<div id="header">
			<div id="title">
				<h1><a href="index.php" title=""><span class="t1">Login</span> <span class="t2">'11</span></a></h1>
				<h2>Prego Cohorts</h2>
			</div>
			<div align="right"><img align="center" border="0" src="images/login.gif" alt="Login'11" width="300" height="180" /></div>
		</div>
		
		<div class="clear">
		</div>

		<div id="left"><span class="headline_three">Share</span><br />
			<?php
			include "fb_plugin.php";
			?>
		</div>

		<div id="right">

		<?php
		include "youtube_links.php";
		?>
		
		</div>
		<div id="footer">
		<h2>Login'11 Banner!</h2>
		<img border="0" src="images/login11.jpg" alt="Login'11 Banner" width="900" height="600" />
		<br>
		<p><a href="mailto:webmaster@gct.net.in" title="Login'11">GCT CSITA Webmasters</a></p>
		</div>
	</div>
</body>
</html>
