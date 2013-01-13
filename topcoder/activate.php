<?php
	require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
    session_start();
	$pageTitle = "Account Activation";
	if(!isset($_SESSION['id'])){
		session_destroy();
		foreach($_GET as $key => $value) {
			$get[$key] = filter($value);
		}
		$err = NULL;
		$msg = NULL;
		/******** EMAIL ACTIVATION LINK**********************/
		if(isset($get['id']) && !empty($get['activ_code']) && !empty($get['id']) && is_numeric($get['activ_code']) ) {
		
			$id = mysql_real_escape_string($get['id']);
			$activ = mysql_real_escape_string($get['activ_code']);
			
			//check if activ code and user is valid
			$rs_check = mysql_query("select topcoder_id from topcoders where topcoder_id=$id and activation_code=$activ") or die (mysql_error()); 
			$num = mysql_num_rows($rs_check);
			  // Match row found with more than 1 results  - the user is authenticated. 
			    if ( $num <= 0 ) { 
				$err = "Sorry no such account exists or activation code invalid.";
				}
			if(empty($err)) {
			$rs_activ = mysql_query("update topcoders set status='1' WHERE topcoder_id='$id' AND activation_code = '$activ' ") or die(mysql_error());
			$msg = "Thank you! Your TopCoder team account has been activated.";
			 }
		}
	}
?>

<?php
	include "header.php";
?>
<h3>Account Activation</h3>
<?php
	if($err)  {
		echo $err;
?>
<br><div align="center"> 
	<h3><strong>Activate your Account!<br><br></strong></h3>
<form action="activate.php" method="get" name="actForm" id="actForm" >
	<table>
		<tr>
			<td>TopCoder Team ID : </td><td><input type="text" name="id"/></td>
		</tr>
		<tr>
			<td>Activation Code:</td><td><input type='password' name='activ_code'/></td>
		</tr>
	</table>
<input name="doActivate" type="submit"  value="Activate">
<div id="r_copy"><div id="actForm_errorloc"></div></div>
</form>
<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("actForm");
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();   

frmvalidator.addValidation("id","req","Please enter your TopCoder ID");
frmvalidator.addValidation("id","maxlen=6","Maximum length for TopCoder ID is 6");
frmvalidator.addValidation("id","minlen=6","Minimum length for TopCoder ID is 6");

frmvalidator.addValidation("activ_code","req","Please enter your Activation Code");
frmvalidator.addValidation("activ_code","minlen=4","Min length for Activation Code is 4");
frmvalidator.addValidation("activ_code","maxlen=4","Max length for Activation Code is 4");
</script>
</div>
<?php
	}
	else if($msg)  {
		echo "<div align='center'><h3><strong>Account Activated!<br><br></strong></h3>$msg</div>";
	}	  
?>

<?
	include "footer.php";
?>