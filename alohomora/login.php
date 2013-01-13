<?php
    require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
    session_start();
    if(isset($_SESSION['id'])){
    	
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
                            else if($e_reg == 0){
								$err = "<div align='center'><h6>You are not registered for Alohomora!</h6>Please register @ <a href = 'http://infoquest.gct.net.in/infoquest12/events.php'>IQ'12 Events Page</a></div>";
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
            <div id="r_copy"><div id="loginForm_errorloc"></div></div>
        </form>
<?
}
?>
