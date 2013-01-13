<?php
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
    $db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
    $qry = "SELECT * FROM news";
    $rs = mysql_query($qry);
    $cnt = mysql_numrows($rs);
    $i = 0;
    $j = $cnt;
    while ($i < $cnt && $i < 4) {
	$j--;
	$news = mysql_result($rs,$j,"content");
	$date = mysql_result($rs,$j,"date");
	echo "
		<!-- comment block -->
		<li class='comment with-avatars'>
			<div class='wrap tiptrigger'>                                	
				<!--avatar-->
				<div class='avatar'>
					<a class='gravatar'><img src='images/avatar.jpg' alt='default avatar' /></a>
				</div>
				<!--/avatar-->
				<!--comment body-->
				<div class='details regularcomment'>
					<p class='head'><span class='info'>By <a href='about.php'>OPC Team</a>  - $date</span></p>
					<!-- comment contents -->
						<div class='text'>
							<div id='commentbody'>
							<p>$news</p>
							</div>
						</div>
					<!-- /comment contents -->
					</div>
				<!--/comment body-->
				<!--Like Button--
				<div class='act tip'>
					<span class='button reply'><a href='like.php'><span><span>Like</span></span></a></span>
				</div>
				<!--/Like Button-->
			</div>
		</li>
		<!-- /comment block -->";
	$i++;
    }
    mysql_close($link);
?>
