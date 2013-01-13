<?php
    require_once 'contents/dbconfig.php';
    require_once 'contents/php_functions.php';
	session_start();
	if(!isset($_SESSION['user_id']) && $user_registration){
		$msg = NULL;
		if(isset($_GET['status']) && $_GET['status'] == 'done')
			$msg = "<div align='center'><h3>Thank you!</h3><br>
					<h6>Your registration is now complete!</h6>
					<p>An activation email has been sent to your email address. Click on the activation link for activating your account.<br><br>
					<strong>Please don't forget to check your spam folder</strong><br><br></font></p></div>";
		if(isset($_POST['doRegister']) && $_POST['doRegister'] == 'Register' && !$msg) {
				foreach($_POST as $key => $value) {
						$data[$key] = filter($value);
				}
				
				/********************* RECAPTCHA CHECK *******************************
				This code checks and validates recaptcha
				****************************************************************/
				require_once('recaptchalib.php');

				$resp = recaptcha_check_answer($privatekey,
											  $_SERVER["REMOTE_ADDR"],
											  $_POST["recaptcha_challenge_field"],
											  $_POST["recaptcha_response_field"]);
				if (!$resp->is_valid) {
				$err[]  = "ERROR - Image Verification failed! Try Again!";
				}
				
				/************************ SERVER SIDE VALIDATION **************************************/
				/********** This validation is useful if javascript is disabled in the browswer ***/

				// Validate User Name
				if (!isUserName($data['user_name'])) {
					$msg = $msg."<br>ERROR - Invalid user name. It can contain only alphabets with atleast 5 characters.";
				}

				// Validate Email
				if(!isEmail($data['user_email'])) {
					$msg = $msg."<br>ERROR - Invalid email address.";
				}
				// Check User Passwords
				if (!checkPwd($data['pwd'],$data['c_pwd'])) {
					$msg = $msg."<br>ERROR - Invalid Password or mismatch. Enter 5 chars or more";
				}

				$user_ip = $_SERVER['REMOTE_ADDR'];

				// stores sha1 of password
				$pwd = PwdHash($data['pwd']);

				// Automatically collects the hostname or domain  like example.com) 
				$host  = $_SERVER['HTTP_HOST'];
				$host_upper = strtoupper($host);
				$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

				// Generates activation code simple 4 digit number
				$activ_code = rand(1000,9999);

				$user_email = $data['user_email'];
				$user_name = mysql_real_escape_string($data['user_name']);
				$college = mysql_real_escape_string($data['college']);
				$address = mysql_real_escape_string($data['address']);
				$phone = mysql_real_escape_string($data['phone']);

				/************ USER EMAIL CHECK ************************************
				This code does a second check on the server side if the email already exists. It 
				queries the database and if it has any existing email it throws user email already exists
				*******************************************************************/

				$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$user_email'") or die(mysql_error());
				list($total) = mysql_fetch_row($rs_duplicate);

				if ($total > 0){
					$msg = $msg."<br>ERROR - The user already registered. Please try again with different email.";
				}
				/***************************************************************************/
				if(!$msg) {
						$sql_insert = "INSERT into `users`
						(`user_name`,`user_email`,`pwd`,`college`,`dept`,`year`,`address`,`country`,`phone`,`date`,`users_ip`,`activation_code`)
						VALUES('$user_name','$user_email','$pwd','$college','$data[dept]','$data[year]','$address','$data[country]','$phone'
						,now(),'$user_ip','$activ_code')";
						mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
						$id = mysql_insert_id($link);  
						$md5_id = md5($id);
						mysql_query("update users set md5_id='$md5_id' where id='$id'");
						$sql_insert = "INSERT into alohomora(id) values($id)";
						mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
						$sql_insert = "INSERT into e_reg(id) values($id)";
						mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
						if($user_registration)  {
								$a_link = "*****Here is your ACTIVATION LINK*****\nhttp://$host$path/activate.php?user=$md5_id&activ_code=$activ_code";
						} else {
								$a_link = "Your account is *PENDING FOR APPROVAL* and will be soon activated by the administrator.";
						}

						$message = 
"Hello $user_name!\n
Thank you for registering with InfoQuest - GCT CSITA. Here are your login details...\n

IQ ID: IQ$id\n
Email: $user_email \n 
Passwordd: $data[pwd] \n

$a_link

Thank You!
Administrator
InfoQuest - GCT CSITA
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

						mail($user_email, "InfoQuest Login Details", $message, "From: \"InfoQuest @ GCT.NET.IN\" <auto-reply@$host>\r\n" . "X-Mailer: PHP/" . phpversion());

						header("Location: register.php?status=done");
						exit();
				}
				else
					$msg = $msg."<br><a href='register.php'>Registration Form</a>";
		}
		mysql_close($link);
	}
	else
	header('Location: index.php');
?>

<!DOCTYPE html>
<php lang="en">
<head>
	<title>Registration - IQ'12</title>
	<meta charset="utf-8">
		<meta name="description" content="InfoQuest - A National Level Technical Symposium - GCT CSITA" />
	<meta name="keywords" content="InfoQuest, IQ, GCT, CSITA, IQ'12, InfoQuest'12, National, Technical, Symposium, Alohomora, TopCoder, Govt. College of Technology, Coimbatore, Tamilnadu, SSQ, Login, CSE, IT, Computer Science & Engineering and Information Technology Association" />
	<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
	<link rel="stylesheet" href="css/popup.css" type="text/css" />
	
	<script type="text/javascript" src="js/popup.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
	<script type="text/javascript" src="js/cufon-yui.js"></script>
	<script type="text/javascript" src="js/Humanst521_BT_400.font.js"></script>
	<script type="text/javascript" src="js/Humanst521_Lt_BT_400.font.js"></script>
	<script type="text/javascript" src="js/cufon-replace.js"></script>
	<script type="text/javascript" src="js/roundabout.js"></script>
	<script type="text/javascript" src="js/roundabout_shapes.js"></script>
	<script type="text/javascript" src="js/gallery_init.js"></script>
	<script type="text/javascript" src="js/gen_validatorv4.js"></script>
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
	<?}
	else
	echo "<div class='container' align='right'>Hi <span>".$_SESSION['user_name']."!</span> | <a href='logout.php'>Logout</a></div>";
	?>
    <div class="container">
      <div class="inside">
		<?php
			if($msg){
				echo "<br><h2 align='center'>Registration <span>Status</span></h2><br><br>$msg";
				
			}
			else{
		?><h2 align="center">User <span>Registration</span></h2>
		<div align="center">
		<form action="register.php" method="post" name="regForm" id="regForm" >
			<table width="450" class="forms">
							<tr> 
									<td>Your Name</td>
									<td><input name="user_name" type="text" id="user_name" size="25"></td>
							</tr>

							<tr> 
									<td>College</td>
									<td><input name="college" type="text" id="college" size="25"></td>
							</tr>

							<tr>
									<td>Department</td>
									<td><select name="dept" id="dept">
									<option value="0" selected="selected">[choose yours]</option>
									<option value="1">CSE</option>
									<option value="2">IT</option>
									<option value="3">ECE</option>
									<option value="4">EEE</option>
									<option value="5">EIE</option>
									<option value="6">CS related dept</option>
									<option value="7">NON-CS dept</option>
									</select></td>
							</tr>

							<tr>
									<td>Year</td>
									<td><select name="year" id="year">
									<option value="0" selected="selected">[choose yours]</option>
									<option value="1">I</option>
									<option value="2">II</option>
									<option value="3">III</option>
									<option value="4">IV</option>
									<option value="5">Passed-outs</option>
									</select></td>
							</tr>

							<tr> 
									<td>Contact Address<br>(with PIN)</td>
									<td><textarea name="address" cols="30" rows="4" id="address"></textarea></td>
							</tr>

							<tr> 
									<td>Country</td>
									<td><select name="country" id="country">
									<option value="0" selected="selected">[choose yours]</option>
									<option value="Afghanistan">Afghanistan</option>
									<option value="Albania">Albania</option>
									<option value="Algeria">Algeria</option>
									<option value="Andorra">Andorra</option>
									<option value="Anguila">Anguila</option>
									<option value="Antarctica">Antarctica</option>
									<option value="Antigua and Barbuda">Antigua and Barbuda</option>
									<option value="Argentina">Argentina</option>
									<option value="Armenia ">Armenia </option>
									<option value="Aruba">Aruba</option>
									<option value="Australia">Australia</option>
									<option value="Austria">Austria</option>
									<option value="Azerbaidjan">Azerbaidjan</option>
									<option value="Bahamas">Bahamas</option>
									<option value="Bahrain">Bahrain</option>
									<option value="Bangladesh">Bangladesh</option>
									<option value="Barbados">Barbados</option>
									<option value="Belarus">Belarus</option>
									<option value="Belgium">Belgium</option>
									<option value="Belize">Belize</option>
									<option value="Bermuda">Bermuda</option>
									<option value="Bhutan">Bhutan</option>
									<option value="Bolivia">Bolivia</option>
									<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
									<option value="Brazil">Brazil</option>
									<option value="Brunei">Brunei</option>
									<option value="Bulgaria">Bulgaria</option>
									<option value="Cambodia">Cambodia</option>
									<option value="Canada">Canada</option>
									<option value="Cape Verde">Cape Verde</option>
									<option value="Cayman Islands">Cayman Islands</option>
									<option value="Chile">Chile</option>
									<option value="China">China</option>
									<option value="Christmans Islands">Christmans Islands</option>
									<option value="Cocos Island">Cocos Island</option>
									<option value="Colombia">Colombia</option>
									<option value="Cook Islands">Cook Islands</option>
									<option value="Costa Rica">Costa Rica</option>
									<option value="Croatia">Croatia</option>
									<option value="Cuba">Cuba</option>
									<option value="Cyprus">Cyprus</option>
									<option value="Czech Republic">Czech Republic</option>
									<option value="Denmark">Denmark</option>
									<option value="Dominica">Dominica</option>
									<option value="Dominican Republic">Dominican Republic</option>
									<option value="Ecuador">Ecuador</option>
									<option value="Egypt">Egypt</option>
									<option value="El Salvador">El Salvador</option>
									<option value="Estonia">Estonia</option>
									<option value="Falkland Islands">Falkland Islands</option>
									<option value="Faroe Islands">Faroe Islands</option>
									<option value="Fiji">Fiji</option>
									<option value="Finland">Finland</option>
									<option value="France">France</option>
									<option value="French Guyana">French Guyana</option>
									<option value="French Polynesia">French Polynesia</option>
									<option value="Gabon">Gabon</option>
									<option value="Germany">Germany</option>
									<option value="Gibraltar">Gibraltar</option>
									<option value="Georgia">Georgia</option>
									<option value="Greece">Greece</option>
									<option value="Greenland">Greenland</option>
									<option value="Grenada">Grenada</option>
									<option value="Guadeloupe">Guadeloupe</option>
									<option value="Guatemala">Guatemala</option>
									<option value="Guinea-Bissau">Guinea-Bissau</option>
									<option value="Guinea">Guinea</option>
									<option value="Haiti">Haiti</option>
									<option value="Honduras">Honduras</option>
									<option value="Hong Kong">Hong Kong</option>
									<option value="Hungary">Hungary</option>
									<option value="Iceland">Iceland</option>
									<option value="India">India</option>
									<option value="Indonesia">Indonesia</option>
									<option value="Ireland">Ireland</option>
									<option value="Israel">Israel</option>
									<option value="Italy">Italy</option>
									<option value="Jamaica">Jamaica</option>
									<option value="Japan">Japan</option>
									<option value="Jordan">Jordan</option>
									<option value="Kazakhstan">Kazakhstan</option>
									<option value="Kenya">Kenya</option>
									<option value="Kiribati ">Kiribati </option>
									<option value="Kuwait">Kuwait</option>
									<option value="Kyrgyzstan">Kyrgyzstan</option>
									<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
									<option value="Latvia">Latvia</option>
									<option value="Lebanon">Lebanon</option>
									<option value="Liechtenstein">Liechtenstein</option>
									<option value="Lithuania">Lithuania</option>
									<option value="Luxembourg">Luxembourg</option>
									<option value="Macedonia">Macedonia</option>
									<option value="Madagascar">Madagascar</option>
									<option value="Malawi">Malawi</option>
									<option value="Malaysia ">Malaysia </option>
									<option value="Maldives">Maldives</option>
									<option value="Mali">Mali</option>
									<option value="Malta">Malta</option>
									<option value="Marocco">Marocco</option>
									<option value="Marshall Islands">Marshall Islands</option>
									<option value="Mauritania">Mauritania</option>
									<option value="Mauritius">Mauritius</option>
									<option value="Mexico">Mexico</option>
									<option value="Micronesia">Micronesia</option>
									<option value="Moldavia">Moldavia</option>
									<option value="Monaco">Monaco</option>
									<option value="Mongolia">Mongolia</option>
									<option value="Myanmar">Myanmar</option>
									<option value="Nauru">Nauru</option>
									<option value="Nepal">Nepal</option>
									<option value="Netherlands Antilles">Netherlands Antilles</option>
									<option value="Netherlands">Netherlands</option>
									<option value="New Zealand">New Zealand</option>
									<option value="Niue">Niue</option>
									<option value="North Korea">North Korea</option>
									<option value="Norway">Norway</option>
									<option value="Oman">Oman</option>
									<option value="Pakistan">Pakistan</option>
									<option value="Palau">Palau</option>
									<option value="Panama">Panama</option>
									<option value="Papua New Guinea">Papua New Guinea</option>
									<option value="Paraguay">Paraguay</option>
									<option value="Peru ">Peru </option>
									<option value="Philippines">Philippines</option>
									<option value="Poland">Poland</option>
									<option value="Portugal ">Portugal </option>
									<option value="Puerto Rico">Puerto Rico</option>
									<option value="Qatar">Qatar</option>
									<option value="Republic of Korea Reunion">Republic of Korea Reunion</option>
									<option value="Romania">Romania</option>
									<option value="Russia">Russia</option>
									<option value="Saint Helena">Saint Helena</option>
									<option value="Saint kitts and nevis">Saint kitts and nevis</option>
									<option value="Saint Lucia">Saint Lucia</option>
									<option value="Samoa">Samoa</option>
									<option value="San Marino">San Marino</option>
									<option value="Saudi Arabia">Saudi Arabia</option>
									<option value="Seychelles">Seychelles</option>
									<option value="Singapore">Singapore</option>
									<option value="Slovakia">Slovakia</option>
									<option value="Slovenia">Slovenia</option>
									<option value="Solomon Islands">Solomon Islands</option>
									<option value="South Africa">South Africa</option>
									<option value="Spain">Spain</option>
									<option value="Sri Lanka">Sri Lanka</option>
									<option value="St.Pierre and Miquelon">St.Pierre and Miquelon</option>
									<option value="St.Vincent and the Grenadines">St.Vincent and the Grenadines</option>
									<option value="Sweden">Sweden</option>
									<option value="Switzerland">Switzerland</option>
									<option value="Syria">Syria</option>
									<option value="Taiwan ">Taiwan </option>
									<option value="Tajikistan">Tajikistan</option>
									<option value="Thailand">Thailand</option>
									<option value="Trinidad and Tobago">Trinidad and Tobago</option>
									<option value="Turkey">Turkey</option>
									<option value="Turkmenistan">Turkmenistan</option>
									<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
									<option value="Ukraine">Ukraine</option>
									<option value="UAE">UAE</option>
									<option value="UK">UK</option>
									<option value="USA">USA</option>
									<option value="Uruguay">Uruguay</option>
									<option value="Uzbekistan">Uzbekistan</option>
									<option value="Vanuatu">Vanuatu</option>
									<option value="Vatican City">Vatican City</option>
									<option value="Vietnam">Vietnam</option>
									<option value="Virgin Islands (GB)">Virgin Islands (GB)</option>
									<option value="Virgin Islands (U.S.) ">Virgin Islands (U.S.) </option>
									<option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
									<option value="Yemen">Yemen</option>
									<option value="Yugoslavia">Yugoslavia</option>
									</select></td>
							</tr>

							<tr> 
									<td>Phone</td>
									<td><input name="phone" type="text" size="25" id="phone"></td>
							</tr>
							
							<tr>
							<td></td>
							<td><strong>Your E-Mail will be used for your account activation!</strong></td>
							</tr>
							
							<tr>
									<td width="100">E-Mail ID</td>
									<td><input name="user_email" type="text" id="user_email" size="25"><br></td>
							</tr>
							<tr> 
									<td>Password</span> 
									</td>
									<td><input name="pwd" id="pwd" type="password" size="25"> 
							</tr>

							<tr>
									<td>Retype Password</td>
									<td><input name="c_pwd" id="c_pwd" size="25" type="password"><br></td>
							</tr>

							<tr>
								<td width="22%"><strong>reCAPTCHA Verification </strong></td>
								<td width="78%"> 
									<?php 
									require_once('recaptchalib.php');
									echo recaptcha_get_html($publickey);
									?>
								</td>
							</tr>
						</table>

			<p align="center">
				<input name="doRegister" type="submit" id="doRegister" value="Register">
			</p>
		</form>
		<div id="regForm_errorloc"></div>
		</div>
		<script language="JavaScript" type="text/javascript">
		var frmvalidator  = new Validator("regForm");
		frmvalidator.EnableOnPageErrorDisplaySingleBox();
		frmvalidator.EnableMsgsTogether();
		frmvalidator.addValidation("user_name","req","Please enter your Name");
		frmvalidator.addValidation("user_name","maxlen=20","Maximum length for your Name is 20");
		frmvalidator.addValidation("user_name","minlen=5","Minimum length for your Name is 5");
		frmvalidator.addValidation("user_name","alpha","Your Name can have alphabetic charcters only");
		
		frmvalidator.addValidation("college","req","Please enter your College Name");
			frmvalidator.addValidation("dept","dontselect=0");
		frmvalidator.addValidation("year","dontselect=0");
		
		frmvalidator.addValidation("phone","req","Please enter your Contact Number");
		frmvalidator.addValidation("phone","numeric","Phone number should be numeric!");
		frmvalidator.addValidation("phone","maxlen=10");
		frmvalidator.addValidation("phone","minlen=10");
		frmvalidator.addValidation("address","req","Please enter your Contact Address");
		frmvalidator.addValidation("country","dontselect=0");
		
		frmvalidator.addValidation("user_email","req","Please enter your E-Mail ID for account activtion");
		frmvalidator.addValidation("user_email","email");
		frmvalidator.addValidation("user_email","maxlen=50");
		
		frmvalidator.addValidation("pwd","req","Please enter your Password");
		frmvalidator.addValidation("c_pwd","req","Please re-type your Password");
		frmvalidator.addValidation("c_pwd","eqelmnt=pwd","The retyped password is not same as password");
		frmvalidator.addValidation("pwd","neelmnt=user_name","The password should not be same as your name");
		frmvalidator.addValidation("pwd","maxlen=20","Maximum length for your password is 20");
		frmvalidator.addValidation("pwd","minlen=5","Minimum length for your password is 5");
		</script>
		<?}?>
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
