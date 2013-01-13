<?php
	require_once 'config/dbconfig.php';
	require_once 'config/php_functions.php';
	session_start();
	$pageTitle = "Register";
	if(!isset($_SESSION['id'])){
		session_destroy();
		$msg = NULL;
		if(isset($_GET['status']) && $_GET['status'] == 'done')
			$msg = "<h3>Thank you!</h3><br>
                <h6>Your registration is now complete!</h6>
                <p>An activation email has been sent to your and partner's(if applicable) email address(es). Click on the activation link for activating your account.<br><br>
                <strong>Please don't forget to check your spam folder</strong><br><br></font></p>";
		
		if(isset($_POST['doRegister']) && $_POST['doRegister'] == 'Register' && !$msg) {
			if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['c_pwd'])){
				foreach($_POST as $key => $value) {
						$data[$key] = filter($value);
				}
				
				/********************* RECAPTCHA CHECK *******************************
				This code checks and validates recaptcha
				****************************************************************/
				/*require_once('recaptchalib.php');

				$resp = recaptcha_check_answer($privatekey,
											  $_SERVER["REMOTE_ADDR"],
											  $_POST["recaptcha_challenge_field"],
											  $_POST["recaptcha_response_field"]);
				if (!$resp->is_valid) {
				$err[]  = "ERROR - Image Verification failed! Try Again!";
				}*/
				
				/************************ SERVER SIDE VALIDATION **************************************/
				/********** This validation is useful if javascript is disabled in the browswer ***/
				
				// Validate User Name
				if (!isUserName($data['name'])) {
					$msg = $msg."<br>ERROR - Invalid user name. It can contain only alphabets with atleast 5 characters.";
				}
				
				// Validate Email
				if(!isEmail($data['email'])) {
					$msg = $msg."<br>ERROR - Invalid email address.";
				}
				
				// Check User Passwords
				if (!checkPwd($data['pwd'],$data['c_pwd'])) {
					$msg = $msg."<br>ERROR - Invalid Password or mismatch. Enter 5 chars or more";
				}
				
				if(!$user_registration)
				$msg = "Registration is not open!";
				
				if(!$msg){
					// stores sha1 of password
					$pwd = PwdHash($data['pwd']);
					
					// Automatically collects the hostname or domain  like example.com) 
					$host  = $_SERVER['HTTP_HOST'];
					$host_upper = strtoupper($host);
					$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					
					// Generates activation code simple 4 digit number
					$activ_code = rand(1000,9999);
					
					$name = mysql_real_escape_string($data['name']);
					$email = $data['email'];
					$phone = $data['phone'];
					
					$rs_duplicate = mysql_query("select count(*) as total from topcoders where email='$email'") or die(mysql_error());
					list($total) = mysql_fetch_row($rs_duplicate);
					if ($total > 0){
						$msg = $msg."<br>ERROR - The user already registered. Please try again with different email.";
					}
					
					if(!$msg) {
							  //Inserting in topcoders table
							$sql_insert = "INSERT INTO topcoders (`name`, `email`, `phone`, `pwd`, `activation_code`) VALUES ('$name', '$email', '$phone', '$pwd', '$activ_code');";
							mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
							$id = mysql_insert_id($link);
							if($user_registration){
								$a_link = "*****Here is your ACTIVATION LINK*****\n
										http://$host$path/activate.php?id=$id&activ_code=$activ_code";
							} else {
								$a_link = "Your account is *PENDING FOR APPROVAL* and will be soon activated by the administrator.";
							}
							$message = "Hello $name !\n
									Thank you for registering with TopCoder - GCT CSITA. Here are your login details...\n

									TopCoderGuild ID: TC$id\n
									Coder Name: $name \n
									Password: $data[pwd] \n\n
									$a_link \n\n
									Thank You!\n\n
									Administrator\n
									TopCoder - GCT CSITA\n
									______________________________________________________\n
									THIS IS AN AUTOMATED RESPONSE. \n
									***DO NOT RESPOND TO THIS EMAIL****
									";
							mail($email, "TopCoder Login Details", $message, "From: \"TopCoder @ GCT.NET.IN\" <auto-reply@$host>\r\n" . "X-Mailer: PHP/" . phpversion());
							header("Location: register.php?status=done");
							exit();
					}
					else
						$msg = $msg."<br><a href='register.php'>Registration Form</a>";
			  }
		}
			else
			$msg = "Invalid Inputs! Try again...<br><a href='register.php'>Registration Form</a>";
    }
    }
    else {
    	header('Location: index.php');
    	}
?>

<?php
	include "header.php";
?>

<!-- /content-->
<h3>TopCoderGuild Registration</h3>
<?php
	if(isset($_GET['status']) && $_GET['status'] == 'done');
	else{
?>
Registering coder will receive an activation mail. He/She has to activate in the account to be the part of this Guild.<br>
<form action='register.php' method='post' name='regForm' id='regForm' >
	<table>
		<tr>
			<td>Coder Name : </td><td><input type="text" name="name"/></td>
		</tr>
		<tr>
			<td>Coder Mail ID: </td><td><input type='text' name='email'/></td>
		</tr>
		<tr>
			<td>Coder Mobile#: </td><td><input type='text' name='phone'/></td>
		</tr>
		<tr>
			<td>Coder Password : </td><td><input type='password' name='pwd'/></td>
		</tr>
		<tr>
			<td>Confirm Password : </td><td><input type='password' name='c_pwd'/></td>
		</tr>
	</table>
	<input type="submit" name="doRegister" value="Register"/>
	<div id="r_copy"><div id="regForm_errorloc"></div></div>
</form>
<script language="JavaScript" type="text/javascript">
var frmvalidator  = new Validator("regForm");
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();   

frmvalidator.addValidation("name","req","Please enter your name");
frmvalidator.addValidation("name","maxlen=30","Maximum length for name is 30");
frmvalidator.addValidation("name","minlen=5","Minimum length for name is 6");

frmvalidator.addValidation("email","req","Please enter your E-Mail ID for account activtion");
frmvalidator.addValidation("email","email");
frmvalidator.addValidation("email","maxlen=50");

frmvalidator.addValidation("phone","req","Please enter your Contact Number");
frmvalidator.addValidation("phone","numeric","Phone number should be numeric!");
frmvalidator.addValidation("phone","maxlen=10");
frmvalidator.addValidation("phone","minlen=10");

frmvalidator.addValidation("pwd","req","Please enter your Password");
frmvalidator.addValidation("c_pwd","req","Please re-type your Password");
frmvalidator.addValidation("c_pwd","eqelmnt=pwd","The retyped password is not same as password");
frmvalidator.addValidation("pwd","neelmnt=name","The password should not be same as your name");
frmvalidator.addValidation("pwd","maxlen=20","Maximum length for your password is 20");
frmvalidator.addValidation("pwd","minlen=5","Minimum length for your password is 5");
</script>
<?}
if($msg)
echo "$msg<br>";
?>
<!-- /content-->

<?php
	include "footer.php";
?>