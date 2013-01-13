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
				if ($handle = opendir('problems')) {
					while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != ".." && $entry != "default")
						{
							echo "<li class='cat-item'><a href='#show_problem' onclick='loadXMLDoc($entry)'><span>Problem $entry</span></a></li>";
						}
					}
					closedir($handle);
				}
			?>
			</ul>
		</li>
	</ul>
</li>

