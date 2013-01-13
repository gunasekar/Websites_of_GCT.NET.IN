<?php
	require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
	$pageTitle = "Set Problems";
	$tab = 6;
    session_start();
	if(!isset($_SESSION['id']))
	header('Location: index.php');
	if(isset($_POST['flushProblemSetTable'])){
		mysql_query("Delete FROM `contestproblems`") or die(mysql_error());
	}
	if(isset($_POST['flushUserScores'])){
		mysql_query("UPDATE  `gctnetin`.`topcoders` SET  `score` =  '0';") or die(mysql_error());
	}
	if(isset($_POST['flushUserTable'])){
		mysql_query("Delete FROM `topcoders` where user_level<>'1'") or die(mysql_error());
	}
	if(isset($_POST['flushSubmissionStatus'])){
		mysql_query("Delete FROM `submission_status`") or die(mysql_error());
	}
	if(isset($_POST['setProblem']) && isset($_POST['contest_id']) && isset($_POST['actual_id'])){
		$actual_id = $_POST['actual_id'];
		$contest_id = $_POST['contest_id'];
		$rs_duplicate = mysql_query("Select * FROM contestproblems where contest_id='$contest_id'") or die(mysql_error());
		list($total) = mysql_fetch_row($rs_duplicate);
		if ($total > 0){
			mysql_query("UPDATE  `gctnetin`.`contestproblems` SET  `actual_id` =  '$actual_id' WHERE  `contestproblems`.`contest_id` = '$contest_id';") or die(mysql_error());
		}
		else{
			mysql_query("INSERT INTO  `gctnetin`.`contestproblems` (`contest_id` ,`actual_id`) VALUES ('$contest_id',  '$actual_id');") or die(mysql_error());
		}
	}
?>
<?php
	include "header.php";
?>
<!-- content -->
<table>
<?php
	$result = mysql_query("SELECT * FROM contestproblems") or die (mysql_error());
	$count = mysql_num_rows($result);
	if($count==0)
	echo "No Problems set yet!";
	else{
		echo "<thead><th>Contest Problem ID</th><th>Actual Problem ID</th></thead>";
		for($i = 0; $i<$count ; $i++){
			$contest_id = mysql_result($result, $i, 'contest_id');
			$actual_id = mysql_result($result, $i, 'actual_id');
			echo "<tr><td>$contest_id</td><td>$actual_id</td><tr>";
		}
	}
?>
</table>

<form action='setproblems.php' method='post' name='setProblemForm' id='setProblemForm' >
	<table>
		<tr>
			<td>Contest Problem ID: </td><td><input type='text' name='contest_id'/></td>
		</tr>
		<tr>
			<td>Actual Problem ID: </td><td><input type='text' name='actual_id'/></td>
		</tr>
	</table>
	<input type="submit" name="setProblem" value="Set Problem"/><br><br>
	<input type="submit" name="flushProblemSetTable" value="Clear Contest Problems"/><br><br>
	<input type="submit" name="flushUserScores" value="Clear User Scores"/>
	<!-- Uncomment this when needed. Action tasks are defined above!-->
	<!--input type="submit" name="flushUserTable" value="Clear User Table"/-->
	<!--input type="submit" name="flushSubmissionStatus" value="Clear Submission Status Table"/-->
</form>
<!-- content -->

<?php
	include "footer.php";
?>