<?php 
	require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
	$pageTitle = "Contest Problems";
	$isProblemsPage = 1;
	$tab = 2;
    session_start();
	if(!isset($_SESSION['id']))
	header('Location: index.php');
?>
<?php
	include "header.php";
?>
<script type="text/javascript">
	function loadXMLDoc(p_id){
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
				document.getElementById("problem_area").innerHTML=xmlhttp.responseText;
			}
		}
		if(p_id != 0){
			var path = "problems/"+p_id+"/statement"
			xmlhttp.open("GET",path,true);
			xmlhttp.send();
		}
		else
		{
			xmlhttp.open("GET","problems/default",true);
			xmlhttp.send();
		}
	}
</script>

<!-- content -->
<a name='#show_problem'></a>
<font size="3"><strong>Contest Problem Sets</strong></font></div>
<div id="problem_area">
<?php
include "problems/default";
?>
<!-- content -->

<?php
	include "footer.php";
?>