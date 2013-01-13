<?php
    session_start();
?>

<!DOCTYPE html>
<php lang="en">
<head>
	<title>Gallery - IQ'12</title>
	<meta charset="utf-8">
		<meta name="description" content="InfoQuest - A National Level Technical Symposium - GCT CSITA" />
	<meta name="keywords" content="InfoQuest, IQ, GCT, CSITA, IQ'12, InfoQuest'12, National, Technical, Symposium, Alohomora, TopCoder, Govt. College of Technology, Coimbatore, Tamilnadu, SSQ, Login, CSE, IT, Computer Science & Engineering and Information Technology Association" />
	<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/popup.css" type="text/css" />
	
	<script type="text/javascript" src="js/popup.js"></script>
	<script type="text/javascript" src="js/cufon-yui.js"></script>
	<script type="text/javascript" src="js/Humanst521_BT_400.font.js"></script>
	<script type="text/javascript" src="js/Humanst521_Lt_BT_400.font.js"></script>
	<script type="text/javascript" src="js/cufon-replace.js"></script>
	<script type="text/javascript" src="js/roundabout.js"></script>
	<script type="text/javascript" src="js/roundabout_shapes.js"></script>
	<script type="text/javascript" src="js/gallery_init.js"></script>
	<script type="text/javascript" src="js/loopedslider.min.js"></script>
	
	<script src="js/jquery-1.6.1.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
	<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
	
	<style type="text/css" media="screen">
		* { margin: 0; padding: 0; }
		
		h1 { font-family: Georgia; font-style: italic; margin-bottom: 5px; }
		
		h2 {
			font-family: Georgia;
			font-style: italic;
			margin: 25px 0 5px 0;
		}
		
		p { font-size: .8em; }
		
		ul li { display: inline; }
		
		.wide {
			border-bottom: 1px #000 solid;
			width: 4000px;
		}
		
		.fleft { float: left; margin: 0 20px 0 0; }
		
		.cboth { clear: both; }
		
		#main {
			background: #fff;
			margin: 0 auto;
			padding: 30px;
			width: 1000px;
		}
	</style>
		
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
			<li><a href="gallery.php" class="current">Gallery</a></li>
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
	<?}
	else
	echo "<div class='container' align='right'>Hi <span>".$_SESSION['user_name']."!</span> | <a href='logout.php'>Logout</a></div>";
	?>
    <div class="container">
      <div class="inside">
        <div class="wrapper">
        <div id="main">
        	<!-- aside -->
          <aside>
            <h2>Image <span>Archive</span></h2>
            <h3>CSITA - InfoQuest Photo Gallery</h3>
				<ul class="gallery clearfix">
					<?
					include "contents/photo.php";
					?>					
				</ul>
          </aside>
          <!-- content -->
          <section id="content">
            <article>
			<h2>Video <span>Archive</span></h2>
			
			<div class="fleft">
				<h2>YouTube</h2>
				<ul class="gallery clearfix">
					<?
					include "contents/video.php";
					?>
				</ul>
			</div>

			<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
			</script>
	
			<!-- Google Maps Code -->
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true">
			</script>
			<script type="text/javascript">
			  function initialize() {
			    var latlng = new google.maps.LatLng(-34.397, 150.644);
			    var myOptions = {
			      zoom: 8,
			      center: latlng,
			      mapTypeId: google.maps.MapTypeId.ROADMAP
			    };
			    var map = new google.maps.Map(document.getElementById("map_canvas"),
			        myOptions);
			  }

			</script>
			<!-- END Google Maps Code -->
	
			<!-- BuySellAds.com Ad Code -->
			<style type="text/css" media="screen">
				.bsap a { float: left; }
			</style>
			<script type="text/javascript">
			(function(){
			  var bsa = document.createElement('script');
			     bsa.type = 'text/javascript';
			     bsa.async = true;
			     bsa.src = '//s3.buysellads.com/ac/bsa.js';
			  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
			})();
			</script>
				
            </article> 
          </section>
		</div>
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
