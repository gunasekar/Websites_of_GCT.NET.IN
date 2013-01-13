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
			document.getElementById("inner").innerHTML=xmlhttp.responseText;
		}
	}
	switch(event_id){
		case 1:
		xmlhttp.open("GET","contents/events/icon",true);
		xmlhttp.send();
		break;
		case 2:
		xmlhttp.open("GET","contents/events/odyssey",true);
		xmlhttp.send();
		break;
		case 3:
		xmlhttp.open("GET","contents/events/cyrusso",true);
		xmlhttp.send();
		break;
		case 4:
		xmlhttp.open("GET","contents/events/mastermind",true);
		xmlhttp.send();
		break;
		case 5:
		xmlhttp.open("GET","contents/events/impromptu",true);
		xmlhttp.send();
		break;
		case 6:
		xmlhttp.open("GET","contents/events/onsite",true);
		xmlhttp.send();
		break;
		case 7:
		xmlhttp.open("GET","contents/events/topcoder",true);
		xmlhttp.send();
		break;
		case 8:
		xmlhttp.open("GET","contents/events/sequel",true);
		xmlhttp.send();
		break;
		case 9:
		xmlhttp.open("GET","contents/events/webhunt",true);
		xmlhttp.send();
		break;
		case 10:
		xmlhttp.open("GET","contents/events/nsx",true);
		xmlhttp.send();
		break;
		case 11:
		xmlhttp.open("GET","contents/events/gnu",true);
		xmlhttp.send();
		break;
		case 12:
		xmlhttp.open("GET","contents/events/alohomora",true);
		xmlhttp.send();
		break;
		case 13:
		xmlhttp.open("GET","contents/events/creativeeye",true);
		xmlhttp.send();
		break;
		case 14:
		xmlhttp.open("GET","contents/events/posterize",true);
		xmlhttp.send();
		break;
		case 15:
		xmlhttp.open("GET","contents/events/bplan",true);
		xmlhttp.send();
		break;
		case 16:
		xmlhttp.open("GET","contents/events/marketing",true);
		xmlhttp.send();
		break;
		case 17:
		xmlhttp.open("GET","contents/events/quiz",true);
		xmlhttp.send();
		break;
		case 18:
		xmlhttp.open("GET","contents/events/silver",true);
		xmlhttp.send();
		break;
		case 19:
		xmlhttp.open("GET","contents/events/googler",true);
		xmlhttp.send();
		break;
		case 20:
		xmlhttp.open("GET","contents/events/savvyspot",true);
		xmlhttp.send();
		break;
		case 21:
		xmlhttp.open("GET","contents/events/gaming",true);
		xmlhttp.send();
		break;
		default:
		xmlhttp.open("GET","contents/events/default",true);
		xmlhttp.send();
		}
	}
</script>
