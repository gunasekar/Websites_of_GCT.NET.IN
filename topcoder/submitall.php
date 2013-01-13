<?php 
	require_once 'config/dbconfig.php';
	require_once 'config/php_functions.php';
	session_start();
	$pageTitle = "Submit";
	$tab = 5;
	$msg = NULL;
	if(!isset($_SESSION['id']))
	header('Location: index.php');
	if(isset($_POST['submit']) && $_POST['submit'] == "Submit" && !$msg){
		if(isset($_FILES["file"])){
		if ($_FILES["file"]["error"] > 0){
			$msg = "Error: " . $_FILES["file"]["error"];
		}
		else{
			$id = $_SESSION['id'];
			$pid = $_POST['pid'];
			$type = $_POST['ftype'];
			if($type == 11) 
			$filename = $id."p".$pid.".c";
			else if($type == 1) 
			$filename = $id."p".$pid.".cpp";
			else if($type == 10) 
			$filename = $id."p".$pid.".java";
			else if($type == 35) 
			$filename = $id."p".$pid.".js";
			else if($type == 29) 
			$filename = $id."p".$pid.".php";
			else if($type == 4 || $type == 116) 
			$filename = $id."p".$pid.".py";
			else if($type == 3 || $type == 54) 
			$filename = $id."p".$pid.".pl";
			else if($type == 17) 
			$filename = $id."p".$pid.".ruby";
			else
			$msg = "Invalid File Format!";
			if(!$msg){
				chdir("tc_codes");
				if(is_dir("$id")){
					move_uploaded_file($_FILES["file"]["tmp_name"],$dir = $id."/".$filename);
				}
				else{
					$dir = "".$id;
					mkdir($dir);
					move_uploaded_file($_FILES["file"]["tmp_name"],$dir = $id."/".$filename);
				}
				$dir = $id."/".$filename;
				
				//Code Evaluation by ideone starts
				$user = 'infoquest';
				$passwd = 'csita_iq';
				// creating soap client
				$client = new SoapClient("http://ideone.com/api/1/service.wsdl");
				// calling test function
				if(file_exists($dir) && filesize($dir) > 0){
					$handle = fopen($dir, "r");
					$code = fread($handle, filesize($dir));
					fclose($handle);
				}
				chdir("../");
				$dir = "problems/".$pid."/in";
				if(file_exists($dir) && filesize($dir) > 0){
					$handle = fopen($dir, "r");
					$input = fread($handle, filesize($dir));
					fclose($handle);
				}
				$dir = "problems/".$pid."/out";
				if(file_exists($dir) && filesize($dir) > 0){
					$handle = fopen($dir, "r");
					$output = fread($handle, filesize($dir));
					fclose($handle);
				}
				$run = true;
				$private = true;
				$language = $type;
				$time_limit = 0;
				$submit = $client->createSubmission($user, $passwd, $code, $language, $input, $run, $private);
				//var_dump($submit); echo "<br>";
				if($submit['error']=="OK"){
					$result = $client->getSubmissionStatus($user, $passwd, $submit['link']);
					while ( $result['status'] != 0 ) {
						if($time_limit == 30)
						$msg = "Server Load => Timed Out! Try submitting again!";
						sleep(3);
						$time_limit+=3;
						$result = $client->getSubmissionStatus( $user, $passwd, $submit['link'] );
					}
					if($result['status'] == 0){
						$details = $client->getSubmissionDetails( $user, $passwd, $submit['link'], true, true, true, true, true );
						if ( $details['error'] == 'OK' ) {
							//var_dump( $details );
							if($details['result'] != 15 || $details['result'] == 15 && $details['output'] == $output){
								$exec_time = $details['time'];
								$memory = $details['memory'];
								if($exec_time > 10)
								$value = 13;
								else
								$value = $details['result'];
							}
							else
								$value = 10;
						}
						else {
							$msg = "Error in submission!";
							$value = 0;
						}
					}
					else
					$value = $result['result'];
				}
				//Code Evalutation Complete
				if(!$msg){
					if($value == 15){
						$result = mysql_query("SELECT * from submission_status WHERE topcoder_id =$id and contest_id=$pid")  or die (mysql_error());
						$count = mysql_num_rows($result);
						if($count==0){
							mysql_query("INSERT INTO  `gctnetin`.`submission_status` (`topcoder_id` ,`contest_id` ,`status`)VALUES ($id, $pid, $value)") or die (mysql_error());
						}
						else
						{
							$update = mysql_result($result, 0, 'status');
							if($update!=15){
								mysql_query("UPDATE submission_status SET status=$value WHERE topcoder_id=$id and contest_id=$pid") or die (mysql_error());
							}
						}
						
					}
					else{
						$result = mysql_query("SELECT * from submission_status WHERE topcoder_id =$id and contest_id=$pid") or die (mysql_error());
						$count = mysql_num_rows($result);
						if($count==0){
							mysql_query("INSERT INTO  `gctnetin`.`submission_status` (`topcoder_id` ,`contest_id` ,`status`)VALUES ($id,  $pid, $value)")  or die (mysql_error());
						}
						else{
							mysql_query("UPDATE submission_status SET status=$value WHERE topcoder_id =$id and contest_id=$pid") or die (mysql_error());
						}
					}
					
					if($value == 15)
					$pad = "<img src='images/r.gif'> - Solved!<br>";
					else if($value == 10)
					$pad = "<img src='images/w.gif'> - Wrong Answer<br>";
					else if($value == 11)
					$pad = "<img src='images/w.gif'> - Compile Time Error<br>";
					else if($value == 12)
					$pad = "<img src='images/w.gif'> - Run Time Error<br>";
					else if($value == 13)
					$pad = "<img src='images/w.gif'> - Time Limit Exceeded<br>";
					else if($value == 17)
					$pad = "<img src='images/w.gif'> - Memory Limit Exceeded<br>";
					else if($value == 19)
					$pad = "<img src='images/w.gif'> - Illegal System Call<br>";
					else if($value == 20)
					$pad = "<img src='images/w.gif'> - Internal Error. Try Submitting Again!<br>";
					else
					$pad = "No Submissions Till Now<br>";
					$msg = "Submission result for Problem ID $pid : $pad";
				}
			}
			}
		}
	    }
?>

<?php
	include "header.php";
?>
<font size="3"><strong>Test Submissions</strong></font><br><br>
<?php
	if($msg)
	echo "<strong>$msg</strong><br><br><br><a href='submitall.php'>Go to Submission form -></a>";
	else{
?>
<form action="submitall.php" method="post" enctype="multipart/form-data" name="submitForm" id="submitForm">
<p>
	Problem ID
	<?php
		echo "<select name='pid' id='pid'>";
		if ($handle = opendir('problems')) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && $entry != "default")
				{
					if($entry == "1")
					echo "<option value='$entry' selected='selected'>Problem ID $entry</option>";
					else
					echo "<option value='$entry'>Problem ID $entry</option>";
				}
			}
			closedir($handle);
		}
		echo "</select>";
	?>
	<br><br>
  </p>
  <p>
	Source Code Type
	<select name="ftype" id="ftype">
		<option value="11" selected="selected">C (gcc-4.3.4)</option>
		<option value="1">C++ (gcc-4.3.4)</option>
		<option value="10">Java (sun-jdk-1.6.0.17)</option>
		<option value="35">JavaScript (rhino) (rhino-1.6.5)</option>
		<option value="112">JavaScript (spidermonkey) (spidermonkey-1.7)</option>
		<option value="3">Perl (perl 5.12.1)</option>
		<option value="54">Perl 6 (rakudo-2010.08)</option>
		<option value="29">PHP (php 5.2.11)</option>
		<option value="4">Python (python 2.6.4)</option>
		<option value="116">Python 3 (python-3.1.2)</option>
		<option value="17">Ruby (ruby-1.9.2)</option>
	</select><br><br>
  </p>
	<label for="file">Source Code:</label>
	<input type="file" name="file" id="file" /> 
	<br />
	<input type="submit" onclick="process()" name="submit" value="Submit" />
	<div id="submitForm_errorloc" class="error_strings"></div>
	</form>
<script language="JavaScript" type="text/javascript">
	var frmvalidator  = new Validator("submitForm");
	frmvalidator.EnableOnPageErrorDisplaySingleBox();
	frmvalidator.EnableMsgsTogether();
	frmvalidator.addValidation("file","req_file","File upload is required");
</script>
<?}?>
<!-- /content-->

<?php
	include "footer.php";
?>