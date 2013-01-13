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
        <?php
            require_once 'library/HTMLPurifier.auto.php';
            $config = HTMLPurifier_Config::createDefault();
        ?>
        <div id="r_content" align="center"><img src ="images/forum.png">
            <form name="post" action="forum.php" method="POST">
                Type your query below to post in our forum!
                <textarea name="post" rows="4" cols="50">
                </textarea><br>
                <input type="image" name="post" src="images/post.png" width="65" height="32">
                <div id="r_copy"><div id="post_errorloc"></div></div>
            </form>
            <script language="JavaScript" type="text/javascript">
            var frmvalidator  = new Validator("post");
            frmvalidator.EnableOnPageErrorDisplaySingleBox();
            frmvalidator.EnableMsgsTogether();
            frmvalidator.addValidation("post","maxlen=200");
            frmvalidator.addValidation("post","req","Please enter your post");
            </script>
        </div>
        <div id="f_content">
            <?php
                require_once 'config/dbconfig.php';
                require_once 'config/php_validation.php';
                $hunterid = $_SESSION['hunterid'];
                if(isset($_POST['post'])){
                    $post = $_POST['post'];
                    $purifier = new HTMLPurifier($config);
                    $post = $purifier->purify($post);
                    if(strlen($post) > 1){
                        $post = mysql_real_escape_string($post);
                        $a_query = "INSERT INTO `gctnetin_csita`.`forum` (`id` ,`posts`) VALUES ('$hunterid', '$post');";
                        $a_result = mysql_query($a_query);
                        unset($_POST['post']);
                        //Page Reload
                        $page = $_SERVER['PHP_SELF'];
                        $sec = "0";
                        header("Refresh: $sec; url=$page");
                    }
                }
                $query = "SELECT postid, time, posts, user_name FROM forum, users where forum.id = users.id";
                $result = mysql_query($query);
                if($result){
                    $count = mysql_numrows($result);
                    $i = 0;
                    $j = $count;
                    while ($i < $count) {
                        $j--;
                        $postid = mysql_result($result,$j,"postid");
                        $time = mysql_result($result,$j,"time");
                        $user_name = mysql_result($result,$j,"user_name");
                        $post = mysql_result($result,$j,"posts");
                        
                        if($_SESSION['user_level'] == ADMIN_LEVEL)
                        echo "<ul><li>$user_name @ $time<br>$post<br><font size='1'><a href='deletepost.php?postid=$postid'>Delete this post!</a></font></li></ul><br>";
                        else
                        echo "<ul><li>$user_name @ $time<br>$post</li></ul><br>";
                        $i++;
                    }
                }
            ?>
        </div>
        <div id="copy">
        <?php
        if(isset($_SESSION['hunterid'])) {
            include "show_status.php";
            ?>
        <div id="copy"><font size="2"><a href="alohomora.php">Continue my Hunt!</a></font> | <font size="2"><a href="rules.php">Rules</a></font> | <font size="2"><a href="dashboard.php">Dashboard</a></font> | <font size="2"><a href="logout.php">Logout!</a></font></div>
        <?}?>
        </div>
        <div id="copy" align ="bottom">
            <?php include "footer.html";  ?>
        </div>
    </body>
</html>
