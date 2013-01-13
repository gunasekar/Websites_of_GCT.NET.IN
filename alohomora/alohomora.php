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
            <?php
                require_once 'config/dbconfig.php';
                require_once 'config/php_functions.php';
                require_once 'config/event_conf.php';
                $hunterid = $_SESSION['hunterid'];
                $user_name = $_SESSION['user_name'];
                /*$completed = 0;
                $level = $_SESSION['level'];
                if($level > $target)
                    $completed = 1;
                if(isset($_POST['answer']) && !$completed){
                    $answer = mysql_real_escape_string($_POST['answer']);
                    $query = "SELECT * FROM alohomora_answers WHERE level = $level AND answer = '$answer'";
                    $result = mysql_query($query);
                    if(mysql_num_rows($result) > 0){
                        $level = $level + 1;
                        $_SESSION['level'] = $level;
                        $query = "UPDATE alohomora SET last_stamp = now(), level = $level WHERE id = $hunterid";
                        mysql_query($query);
                        unset($_POST['answer']);
                    }
                }
                if(!$completed && $level <= $target)
                    include "alohomora/$level";
                else*/
                    echo "Hi $user_name, Alohomora is over!<br><br>Thanks for your participation :)";
            ?>
        </div>
        <?php
        /*if(!$completed && $level <= $target){?>
        <br><div id = "answerbox" align = "center">
            <form name="next" action="alohomora.php" method="POST">
                <input type="text" name="answer" value="" size="50" />
            </form>
        </div>
        <?}*/?>
        <div id="copy">
        <?php
        if(isset($_SESSION['hunterid'])) {
            include "show_status.php";
        ?>
        <div id="copy"><font size="2"><a href="forum.php">Discussion Forum</a></font> | <font size="2"><a href="rules.php">Rules</a></font> | <font size="2"><a href="dashboard.php">Dashboard</a></font> | <font size="2"><a href="logout.php">Logout!</a></font></div>
        <?}?>
        </div>
        <?php
        if($_SESSION['user_level'] == 5){
        echo "<div id='copy'>";
        for($i = 1; $i<$target; $i++)
        echo "<a href='goto.php?level=$i'>$i</a> | ";
        echo "<a href='goto.php?level=$i'>$i</a>";
        echo "<div>";
        }?>
        <div id="copy" align ="bottom">
            <?php include "footer.html";  ?>
        </div>
    </body>
</html>
