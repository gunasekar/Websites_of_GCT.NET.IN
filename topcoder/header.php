<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
	<!--head-->
	<head profile='http://gmpg.org/xfn/11'>
		<title><?php echo $pageTitle; ?> | TCG</title>

		<link rel='pingback' href='http://ssq12.gct.net.in' />
		<link rel='shortcut icon' href='favicon.ico' />

		<style type='text/css' media='all'>
		  @import 'style.css';
		  @import 'sidebox.css';
		</style>
		<script language='JavaScript' src='js/gen_validatorv4.js' type='text/javascript'></script>
		<script src='js/jquery.js' type='text/javascript'></script>
		<script src='js/fusion.js' type='text/javascript'></script>
		<meta http-equiv='content-type' content='text/html; charset=utf-8'/>
	</head>
	<!--/head-->

    <!--body-->
	<body class="home">
    	<!-- page wrappers (100% width) -->
        <div id="page-wrap1">
		<div id="page-wrap2">
            <!-- page (actual site content, custom width) -->
			<div id="page" class="with-sidebar">
				<!-- main wrapper (side & main) -->
				<div id="main-wrap">
					<!-- mid column wrap -->
					<div id="mid-wrap">
						<!-- sidebar wrap -->
						<div id="side-wrap">
							<!-- mid column -->
							<div id="mid">
								<!-- header -->
								<div id="header">
									<div id="topnav"><p><a href=".">Home</a> | <a href="peer_coders.php">Peer Coders</a> | <a href="forum.php">User Forum</a>| <a href="show.php?page=a">About</a></p></div>
									<h1 id="logo"><a href=".">TCG | GCT</a></h1>
									<!-- top tab navigation -->
									<div id="tabs">
										<ul>
										<li><a href="index.php" <? if($tab == 1)  echo "class='active'";?>><span><span>TCG</span></span></a></li>
										<li><a href="problems.php" <? if($tab == 2)  echo "class='active'";?>><span><span>Contest Problems</span></span></a></li>
										<li><a href="allproblems.php" <? if($tab == 3)  echo "class='active'";?>><span><span>TCG Problems</span></span></a></li>
										<li><a href="submit.php" <? if($tab == 4)  echo "class='active'";?>><span><span>Play</span></span></a></li>
										<li><a href="submitall.php" <? if($tab == 5)  echo "class='active'";?>><span><span>Try</span></span></a></li>
										<?php if($_SESSION['user_level'] == 1){ ?>
										<li><a href="setproblems.php" <? if($tab == 6)  echo "class='active'";?>><span><span>Set</span></span></a></li>
										<? } ?>
										<?php if($_SESSION['user_level'] == 1){ ?>
										<li><a href="submitproblems.php" <? if($tab == 7)  echo "class='active'";?>><span><span>Submit</span></span></a></li>
										<? } ?>
										</ul>
									</div>
									<!-- /top tabs -->
								</div>
                                <!-- /header -->
                                <!-- mid content -->
								<div id="mid-content" align="center">