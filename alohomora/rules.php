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
        <h3>Rules</h3>
            <?
            include "ruleset.html";
            ?>
        </div>
        <div id="copy">
        <?php
        if(isset($_SESSION['hunterid'])) {
            include "show_status.php";
        ?>
        <div id="copy"><font size="2"><a href="alohomora.php">Continue my Hunt!</a></font> | <font size="2"><a href="forum.php">Discussion Forum</a></font> | <font size="2"><a href="dashboard.php">Dashboard</a></font> | <font size="2"><a href="logout.php">Logout!</a></font></div>
        <?}?>
        </div>
        <div id="copy" align ="bottom">
            <?php include "footer.html";  ?>
        </div>
    </body>
</html>
