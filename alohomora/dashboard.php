<?php
    session_start();
    if(!isset($_SESSION['hunterid']))
        header('Location: index.php');
?>

<html>
    <?php
    include "head.php";
    ?>
    <body>
        <div id="content" align="center">
            Top 25 - User Status
            <table cellspacing="5">
            <tbody>
            <?php
                require_once 'config/dbconfig.php';
                require_once 'config/php_functions.php';
                require_once 'config/event_conf.php';
                $query = "SELECT users.id, user_name, level, last_stamp FROM alohomora, users where alohomora.id = users.id ORDER BY level DESC, last_stamp ASC";
                $result = mysql_query($query);
                $i = 0;
                $count = mysql_num_rows($result);
                while ($i < $count && $i < 25) {
                    $user_name = mysql_result($result,$i,"user_name");
                    $level = mysql_result($result,$i,"level");
                    $stamp = mysql_result($result,$i,"last_stamp");
                    $j = $i + 1;
                    if($level <= $target)
                        echo "<tr><td><font color='#9A9A9A'size='2'>($j) -> $user_name</font></td><td><font color='#9A9A9A'size='2'>@</font></td><td><font color='#9A9A9A'size='2'>level $level</font></td><td><font color='#9A9A9A'size='2'>with the last submission at $stamp</font></td></tr>";
                    else
                        echo "<tr><td><font color='#9A9A9A'size='2'>($j) -> $user_name</font></td><td><font color='#9A9A9A'size='2'>has</font></td><td><font color='#9A9A9A'size='2'>Completed</font></td><td><font color='#9A9A9A'size='2'>with the last submission at $stamp</font></td></tr>";
                    $i++;
                }
            ?>
            </tbody>
        </table>
        </div>
        <div id="copy">
        <?php
        if(isset($_SESSION['hunterid'])) {
            include "show_status.php";
        ?>
        <div id="copy">
            <font size="2"><a href="alohomora.php">Continue my Hunt!</a></font> | <font size="2"><a href="rules.php">Rules</a></font> | <font size="2"><a href="forum.php">Discussion Forum</a></font> | <font size="2"><a href="logout.php">Logout!</a></font>
        </div>
        <?}?>
        </div>
        <div id="copy" align ="bottom">
            <?php include "footer.html";  ?>
        </div>
    </body>
</html>
