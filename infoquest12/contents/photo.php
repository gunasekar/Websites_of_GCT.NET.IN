<?php
$count = 41;
echo "<li> <a href='images/photos/1.jpg' rel='prettyPhoto[gallery1]' title='CSITA - InfoQuest Photo Gallery'> <img src='images/thumbnails/thumbnail1.jpg' width='60' height='60' alt='CSITA - InfoQuest Photo Archive'/></a></li>";
for($i = 2; $i <= $count; $i++)
echo "<li><a href='images/photos/$i.jpg' rel='prettyPhoto[gallery1]' title='CSITA - InfoQuest Photo Gallery'></a></li>";
echo "<br>Click to view the IQ reminiscence!";
?>
