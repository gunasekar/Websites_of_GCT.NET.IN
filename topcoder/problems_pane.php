<li>
    <!-- sidebar menu (categories) -->
    <ul class="nav">
        <!-- sidebar menu 1-->
        <li class="cat-item">
            <a href="#show_problem" onclick="loadXMLDoc(0)" class="active"><span>Problem Sets</span></a><a class="rss tip" href="#show_problem" onclick="loadXMLDoc(0)"></a>
        </li>
        <!-- sidebar menu 2-->
        <li class="cat-item">
			<ul>
			<?php
			$result = mysql_query("SELECT * FROM contestproblems") or die (mysql_error());
			$count = mysql_num_rows($result);
			if($count==0)
				echo "No Contest Problems!";
			else{
				require_once "config/tcgconfig.php";
				for($i = 0; $i < $count; $i++){
					$tempID = $i + 1;
					$actualid = mysql_result($result, $i, 'actual_id');
					echo "<li class='cat-item'><a href='#show_problem' onclick='loadXMLDoc($actualid)'><span>Problem $tempID - $points Points</span></a></li>";
				}
			}
			?>
			</ul>
		</li>
	</ul>
</li>

