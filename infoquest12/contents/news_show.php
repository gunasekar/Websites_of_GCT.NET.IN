<marquee direction=up loop=true height="450" scrolldelay=150>
<ul class="news">
<?php
    require_once 'dbconfig.php';
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
    $db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
    $query = "SELECT * FROM news";
    $result = mysql_query($query);
    $count = mysql_numrows($result);
    $i = 0;
    $j = $count;
    while ($i < $count && $j >0) {
            $j--;
            $news = mysql_result($result,$j,"content");
            $date = mysql_result($result,$j,"date");
            echo "<li>
				<figure>$date</figure>
				$news
			</li><br>";
            $i++;
    }
    mysql_close($link);
?>
</ul>
</marquee>
