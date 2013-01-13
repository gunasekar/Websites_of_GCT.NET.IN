<?php 
	function delete($path) {
		if(!file_exists($path)) {
			return "Problem does not exists!";
		}
		else{
			$directoryIterator = new DirectoryIterator($path);

			foreach($directoryIterator as $fileInfo) {
				$filePath = $fileInfo->getPathname();
				if(!$fileInfo->isDot()) {
					if($fileInfo->isFile()) {
						unlink($filePath);
					} elseif($fileInfo->isDir()) {
						if($this->emptyDirectory($filePath)) {
							rmdir($filePath);
						} else {
							$this->delete($filePath);
						}
					}
				}
			}
			rmdir($path);
			return "Problem Deleted!";
		}
	}

	require_once 'config/dbconfig.php';
	require_once 'config/php_functions.php';
	session_start();
	$pageTitle = "Submit Problems";
	$tab = 7;
	$msg = NULL;
	if(!isset($_SESSION['id']))
	header('Location: index.php');
	if(isset($_POST['submit']) && $_POST['submit'] == "Submit"){
		if(isset($_FILES["file"])){
		if ($_FILES["file"]["error"] > 0){
			$msg = "Error: " . $_FILES["file"]["error"];
		}
		else{
			if(!$msg){
			$pid = $_POST['pid'];
			$filename = $_POST['type'];
				chdir("problems");
				if(is_dir("$pid")){
					move_uploaded_file($_FILES["file"]["tmp_name"],$dir = $pid."/".$filename);
				}
				else{
					$dir = "".$pid;
					mkdir($dir);
					move_uploaded_file($_FILES["file"]["tmp_name"],$dir = $pid."/".$filename);
				}
				$msg = "Submission result: Success";
				}
			}
		}
	}
	
	if(isset($_POST['delete']) && $_POST['delete'] == "Delete"){
			$pid = $_POST['pid'];
			$msg = delete("problems/".$pid);
	}
?>

<?php
	include "header.php";
?>
<font size="3"><strong>Problems Submissions</strong></font><br><br>
<?php
	if($msg)
	echo "<strong>$msg</strong><br><br><br><a href='submitproblems.php'>Go to Submission form -></a>";
	else{
?>
<form action="submitproblems.php" method="post" enctype="multipart/form-data" name="submitForm" id="submitForm">
<p>
	Problem ID: <input type="text" name="pid" id="pid" /> 
	<br><br>
  </p>
  <p>
	File Type:
	<select name="type" id="type">
		<option value="in" selected="selected">In</option>
		<option value="out">Out</option>
		<option value="statement">Statement</option>
	</select><br><br>
  </p>
	<label for="file">Select file:</label>
	<input type="file" name="file" id="file" /> 
	<br />
	<input type="submit" onclick="process()" name="submit" value="Submit" />
	<div id="submitForm_errorloc" class="error_strings"></div>
	</form>
<br><br><font size="3"><strong>Delete Problems</strong></font><br><br>	
	<form action="submitproblems.php" method="post" enctype="multipart/form-data" name="deleteForm" id="deleteForm">
	Problem ID: <input type="text" name="pid" id="pid" /> 
	<br><br>
	<input type="submit" onclick="process()" name="delete" value="Delete" />
	<div id="deleteForm_errorloc" class="error_strings"></div>
	</form>
<script language="JavaScript" type="text/javascript">
	var frmvalidator  = new Validator("submitForm");
	frmvalidator.EnableOnPageErrorDisplaySingleBox();
	frmvalidator.EnableMsgsTogether();
	frmvalidator.addValidation("file","req_file","File upload is required");

	frmvalidator.addValidation("pid","req","Problem ID required");
	frmvalidator.addValidation("pid","numeric","Problem ID should be numeric!");
	frmvalidator.addValidation("pid","maxlen=3");
	frmvalidator.addValidation("pid","minlen=1");
	
	var frmvalidator2  = new Validator("deleteForm");
	frmvalidator2.EnableOnPageErrorDisplaySingleBox();
	frmvalidator2.EnableMsgsTogether();
	
	frmvalidator2.addValidation("pid","req","Problem ID required");
	frmvalidator2.addValidation("pid","numeric","Problem ID should be numeric!");
	frmvalidator2.addValidation("pid","maxlen=3");
	frmvalidator2.addValidation("pid","minlen=1");
</script>
<?}?>
<!-- /content-->

<?php
	include "footer.php";
?>