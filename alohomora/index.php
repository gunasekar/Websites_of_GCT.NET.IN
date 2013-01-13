<?php
    require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
    session_start();
    if(isset($_SESSION['user_id'])){
		$_SESSION['hunterid'] = $_SESSION['user_id'];
		$id = $_SESSION['user_id'];
		$result = mysql_query("SELECT u.user_name, u.user_level, a.level FROM users u, alohomora a WHERE u.id = $id and a.id = $id") or die (mysql_error()); 
        $num = mysql_num_rows($result);
        if ($num > 0 ){
			list($user_name,$user_level, $level) = mysql_fetch_row($result);
		$_SESSION['user_name'] = $user_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['level'] = $level;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		}
	}
    if(!isset($_SESSION['hunterid'])){
        $err = NULL;
        foreach($_GET as $key => $value) {
                $get[$key] = filter($value); //get variables are filtered.
        }
        if(isset($_POST['login']) && $_POST['login']=='doLogin'){
                foreach($_POST as $key => $value) {
                    $data[$key] = filter($value); // post variables are filtered
                }
                if($_POST['hunterid'] != mysql_real_escape_string($_POST['hunterid']))
                    $err = "Invalid Credentials";
                if(!$err){
                    $hunterid = $data['hunterid'];
                    $pass = $data['pwd'];
                    if (strpos($hunterid,'@') === false) {
                        if(substr($hunterid, 0, 2) == "iq" || substr($hunterid, 0, 2) == "IQ" || substr($hunterid, 0, 2) == "Iq" || substr($hunterid, 0, 2) == "iQ"){
                            $hunterid = substr($hunterid, 2);
                            $user_cond = "u.id= $hunterid and a.id= $hunterid and e.id = $hunterid";
                        }
                        else
                            $err = "Invalid ID";
                    } else {
                        $user_cond = "u.user_email='$hunterid' and a.id = (select id from users where user_email = '$hunterid') and e.id = a.id";
                    }
                    $num = 0;
                    if(!$err){
                        $result = mysql_query("SELECT u.id, u.pwd, u.user_name, u.approved, u.user_level, a.level, e_2 FROM users u, alohomora a, e_reg e WHERE $user_cond") or die (mysql_error()); 
                        $num = mysql_num_rows($result);
                    }
                    if ($num > 0 && !$err){
                            list($id,$pwd,$user_name,$approved,$user_level, $level, $e_reg) = mysql_fetch_row($result);
                            if(!$approved){
								$err = "<div align='center'><h6>Account not activated!</h6>Please check your email for activation code</div>";
                            }
                            else{
                                    //check against salt
                                    if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
                                            if(empty($err)){
                                                session_regenerate_id (true); //prevent against session fixation attacks.
												$_SESSION['hunterid']= $id;
												$_SESSION['user_name'] = $user_name;
												$_SESSION['user_level'] = $user_level;
												$_SESSION['level'] = $level;
												$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
                                            }
                                    }
                                    else{
                                        $err = "<div align='center'><h6>Invalid Login!</h6>Please try again with correct User ID/E-mail ID and password.</div>";
                                    }
                            }
                    } else {
                        $err = "<div align='center'><h6>Invalid Login!</h6>No such user exists.</div>";
                    }
                }
            }
    }
    mysql_close($link);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
    <?php
    include "head.php";
    ?>
    <body>
        <div id="content" align="center">
            <?php
                if(!isset($_SESSION['hunterid'])) {
            ?>
                    <form name="loginForm" id ="loginForm" action="index.php" method="POST">
                        <img src="images/hlogin.png">
                        <table cellspacing="20">
                            <tr>
                                <td>IQ ID/Mail ID: </td>
                                <td><input type="text" name="hunterid" size="20"></td>
                            </tr>
                        </table>
                        <br>
                        <table cellspacing="20">
                            <tr>
                                <td>Unlock ID : </td>
                                <td><input type="password" name="pwd" size="20"></td>
                            </tr>
                        </table>
                        <input type="image" name="login" value="doLogin" src="images/enter.png" width="65" height="32">
                        <div id="r_copy">If you are not able to login here, login @ <a href="http://infoquest.gct.net.in/infoquest12/">IQ site</a> first and then enter/refresh this site to hunt!</div>
                        <div id="r_copy"><div id="loginForm_errorloc"></div></div>
                    </form>
                    <?
                        if($err)
                            echo "<div id='r_copy'><font color='#B08A24'>$err</font></div>";
                    ?>
                    <script language="JavaScript" type="text/javascript">
                    var frmvalidator  = new Validator("loginForm");
                    frmvalidator.EnableOnPageErrorDisplaySingleBox();
                    frmvalidator.EnableMsgsTogether();   

                    frmvalidator.addValidation("hunterid","req","Please enter your IQ ID/Email ID");
                    frmvalidator.addValidation("hunterid","maxlen=30","Maximum length for IQ ID/Email ID is 30");
                    frmvalidator.addValidation("hunterid","minlen=6","Minimum length for IQ ID/Email ID is 6");

                    frmvalidator.addValidation("pwd","req","Please enter your password");
                    frmvalidator.addValidation("pwd","minlen=5","Minimum length for password is 5");
                    </script>
            <?
                }
                else{
					$user_name = $_SESSION['user_name'];
					echo "<br><br>Hi $user_name!<br>";?>
            <a href ="alohomora.php"><img src="images/alohomora.png"></a>
            <?
                }
            ?>
        </div>
        <?php
        if(!isset($_SESSION['hunterid'])) {?>
        <div id="copy"><font size="2">Not a Hunter yet? <a href="http://infoquest.gct.net.in/infoquest12/register.php" target="_blank">Register!</a></font></div>
        <?}
        else{
			?>
        <div id="copy"><? include "show_status.php"; ?><br><font size="2"><a href="forum.php">Discussion Forum</a></font> | <font size="2"><a href="rules.php">Rules</a></font> | <font size="2"><a href="dashboard.php">Dashboard</a></font> | <font size="2"><a href="logout.php">Logout!</a></font></div>
        <?}?>
        <div id="copy" align ="bottom">
            <?php include "footer.html";  ?>
        </div>
    </body>
</html>
