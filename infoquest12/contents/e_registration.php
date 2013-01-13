Registrations for online events are open!<br>For other events, registrations will be on spot, which requires IQ ID with your College ID card for reference!<br><br>
<form action='events.php' method='post'>
<?php
if($_SESSION['e_1'] >= 1)
echo "<input type='checkbox' name='e_1' value='1' checked='yes' disabled>TopCoder - Online Programming Contest - <a href='http://topcoder.gct.net.in/' target='_blank'>Register your team @ Topcoder Now!</a><br><br>";
else
echo "<input type='checkbox' name='e_1' value='1'>TopCoder - Online Programming Contest<br><br>";
if($_SESSION['e_2'] >= 1)
echo "<input type='checkbox' name='e_2' value='1' checked='yes' disabled>Alohomora - Online Treasure Hunt  - <a href='http://alohomora.gct.net.in/' target='_blank'>Start your hunt @ Alohomora from 24th February!</a><br><br>";
else
echo "<input type='checkbox' name='e_2' value='1'>Alohomora - Online Treasure Hunt<br><br>";
if($_SESSION['e_3'] >= 1)
echo "<input type='checkbox' name='e_3' value='1' checked='yes' disabled>MathGenie - <a href='http://infoquest.gct.net.in/mathgenie/' target='_blank'>Explore your MathBrain!</a><br><br>";
else
echo "<input type='checkbox' name='e_3' value='1'>MathGenie<br><br>";
if($_SESSION['e_1'] + $_SESSION['e_2'] + $_SESSION['e_3'] >= 3)
echo "<input type='submit' name='submit' value='Register' disabled>";
else
echo "<input type='submit' name='submit' value='Register'>";
?>
</form>
