<?php 
	require_once 'config/dbconfig.php';
	require_once 'config/php_functions.php';
	session_start();
	$pageTitle = "User Stats";
	if(!isset($_SESSION['id']))
	header('Location: index.php');
?>

<?php
	include "header.php";
?>
<h3>Your Submission Status</h3>
<ul>
<?php
	$id = $_SESSION['id'];
	$result = mysql_query("SELECT score FROM topcoders WHERE topcoder_id = $id") or die (mysql_error());
	$score = mysql_result($result, 0, 'score');
	$result = mysql_query("SELECT contest_id, status FROM submission_status WHERE topcoder_id = $id order by contest_id ASC") or die (mysql_error());
	$count = mysql_num_rows($result);
	
	for($i = 0; $i<$count ; $i++){
		$pid = mysql_result($result, $i, 'contest_id');
		$status = mysql_result($result, $i, 'status');
		
		if($status == 15)
		echo "Problem ID $pid: <img src='images/r.gif'> - Solved!<br>";
		else if($status == 10)
		echo "Problem ID $pid: <img src='images/w.gif'> - Wrong Answer<br>";
		else if($status == 11)
		echo "Problem ID $pid: <img src='images/w.gif'> - Compile Time Error<br>";
		else if($status == 12)
		echo "Problem ID $pid: <img src='images/w.gif'> - Run Time Error<br>";
		else if($status == 13)
		echo "Problem ID $pid: <img src='images/w.gif'> - Time Limit Exceeded<br>";
		else if($status == 17)
		echo "Problem ID $pid: <img src='images/w.gif'> - Memory Limit Exceeded<br>";
		else if($status == 19)
		echo "Problem ID $pid: <img src='images/w.gif'> - Illegal System Call<br>";
		else if($status == 20)
		echo "Problem ID $pid: <img src='images/w.gif'> - Internal Error. Try Submitting Again!<br>";
		else
		echo "Problem ID $pid: No Submissions Till Now<br>";
	}
	
	echo "<br><br><strong>Current Contest Score is $score</strong>";
?>
</ul>

<?php
	include "footer.php";
?>