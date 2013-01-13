<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta name="Description" content="MathGenie - Online Math Contest" />
<meta name="Keywords" content="IQ, InfoQuest, IQ 12, InfoQuest 12, GCT, Coimbatore, InfoQuestGCT, infoquest gct" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="images/Envision.css" type="text/css" />

<title>MathGenie - Online Math Contest of IQ'12</title>

<script type="text/javascript">
function loadXMLDoc(event_id){
	var xmlhttp;
	if (window.XMLHttpRequest){
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("statement").innerHTML=xmlhttp.responseText;
		}
	}
	switch(event_id){
		case 1:
		xmlhttp.open("GET","problems/1",true);
		xmlhttp.send();
		break;
		case 2:
		xmlhttp.open("GET","problems/2",true);
		xmlhttp.send();
		break;
		case 3:
		xmlhttp.open("GET","problems/3",true);
		xmlhttp.send();
		break;
		case 4:
		xmlhttp.open("GET","problems/4",true);
		xmlhttp.send();
		break;
		case 5:
		xmlhttp.open("GET","problems/5",true);
		xmlhttp.send();
		break;
		case 6:
		xmlhttp.open("GET","problems/6",true);
		xmlhttp.send();
		break;
		case 7:
		xmlhttp.open("GET","problems/7",true);
		xmlhttp.send();
		break;
		case 8:
		xmlhttp.open("GET","problems/8",true);
		xmlhttp.send();
		break;
		case 9:
		xmlhttp.open("GET","problems/9",true);
		xmlhttp.send();
		break;
		case 10:
		xmlhttp.open("GET","problems/10",true);
		xmlhttp.send();
		break;
		case 11:
		xmlhttp.open("GET","problems/11",true);
		xmlhttp.send();
		break;
		case 12:
		xmlhttp.open("GET","problems/12",true);
		xmlhttp.send();
		break;
		case 13:
		xmlhttp.open("GET","problems/13",true);
		xmlhttp.send();
		break;
		case 14:
		xmlhttp.open("GET","problems/14",true);
		xmlhttp.send();
		break;
		case 15:
		xmlhttp.open("GET","problems/15",true);
		xmlhttp.send();
		break;
		case 16:
		xmlhttp.open("GET","problems/16",true);
		xmlhttp.send();
		break;
		case 17:
		xmlhttp.open("GET","problems/17",true);
		xmlhttp.send();
		break;
		case 18:
		xmlhttp.open("GET","problems/18",true);
		xmlhttp.send();
		break;
		case 19:
		xmlhttp.open("GET","problems/19",true);
		xmlhttp.send();
		break;
		case 20:
		xmlhttp.open("GET","problems/20",true);
		xmlhttp.send();
		break;
		default:
		xmlhttp.open("GET","problems/about",true);
		xmlhttp.send();
		}
	}
</script>


</head>

<body>
<!-- wrap starts here -->
<div id="wrap">
		
		<!--header -->
		<div id="header">			
				
			<h1 id="logo-text"><a href="./">MathGenie</a></h1>		
			<p id="slogan" style="margin-left: 100px">Online Math Contest of <a style="color:white; text-decoration: none; font-weight: bold" href="http://infoquest.gct.net.in/">InfoQuest'12</a></p>		
			<div id="header-links">
			
		</div>		
						
		</div>
		
		<!-- menu -->	
		<div  id="menu">
			<ul>
				<li class="last"><a href="./">Submission Rules</a></li>		
			</ul>
		</div>					
			
		<!-- content-wrap starts here -->
		<div id="content-wrap">
				
			<div id="sidebar">
			
				<h3>Problem Sets</h3>	
				
				<ul class="sidemenu">				
					<li><a href='#show_event' onclick="loadXMLDoc(1)">Problem ID 1</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(2)">Problem ID 2*</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(3)">Problem ID 3</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(4)">Problem ID 4*</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(5)">Problem ID 5</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(6)">Problem ID 6</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(7)">Problem ID 7</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(8)">Problem ID 8*</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(9)">Problem ID 9</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(10)">Problem ID 10</a></li>
					<?php
					if(0){?>
					<li><a href='#show_event' onclick="loadXMLDoc(11)">Problem ID 11</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(12)">Problem ID 12</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(13)">Problem ID 13</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(14)">Problem ID 14</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(15)">Problem ID 15</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(16)">Problem ID 16</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(17)">Problem ID 17</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(18)">Problem ID 18</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(19)">Problem ID 19</a></li>
					<li><a href='#show_event' onclick="loadXMLDoc(20)">Problem ID 20</a></li>
					<?}
					?>
				</ul>
								
			</div>
				
			<div id="main">
			
                <div id="statement">
                <?
                include "problems/default";
                ?>
                </div>
                
			</div>
		
		<!-- content-wrap ends here -->	
		</div>
					
		<!--footer starts here-->
		<div id="footer">
			
            <p>
		    &copy; 2012 <strong>GCT CSITA - iTeam</strong>

   	    </p>
				
		</div>	

<!-- wrap ends here -->
</div>

</body>
</html>
