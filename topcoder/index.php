<?php
	require_once 'config/dbconfig.php';
    require_once 'config/php_functions.php';
    session_start();
	$pageTitle = "Home";
	$tab = 1;
    if(!isset($_SESSION['id'])){
        $err = NULL;
        foreach($_GET as $key => $value) {
                $get[$key] = filter($value); //get variables are filtered.
        }
        if(isset($_POST['doLogin']) && $_POST['doLogin']=='Login'){
                foreach($_POST as $key => $value) {
                    $data[$key] = filter($value); // post variables are filtered
                }
                if($data['loginid'] != mysql_real_escape_string($data['loginid']))
                    $err = "Invalid Credentials";
                if(!$err){
                    $loginid = $data['loginid'];
                    $pass = $data['pwd'];

						if(strlen($loginid)==6 && is_numeric(substr($loginid, 2, 4)) && substr($loginid, 0, 2) == "tc" || substr($loginid, 0, 2) == "TC" || substr($loginid, 0, 2) == "Tc" || substr($loginid, 0, 2) == "tC"){
						 $loginid = substr($loginid, 2);
						 $user_cond = "topcoder_id= $loginid";
						}
						else {
						$user_cond = "email='$loginid'";
						}
	              
                    if(!$err){
                        $result = mysql_query("SELECT topcoder_id, pwd, name, status, user_level FROM topcoders WHERE $user_cond") or die (mysql_error()); 
                        $num = mysql_num_rows($result);
                    }
                    if ($num > 0 && !$err){
                            list($id,$pwd,$name,$status, $user_level) = mysql_fetch_row($result);
                            if(!$status){
                              	$err = "<div align='center'><h6>Account not activated!</h6>Please check your email for activation code</div>";
                            }
                            else{
                                    //check against salt
                                    if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
                                            if(empty($err)){
                                                    session_start();
                                                    session_regenerate_id (true); //prevent against session fixation attacks.
                                                    $_SESSION['id']= $id;
                                                    $_SESSION['name'] = $name;
													$_SESSION['user_level'] = $user_level;
                                                    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
                                            }
                                            header('Location: index.php');
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
?>

<?php
	include "header.php";
?>

<!-- comments -->
<?php
	include "index_content";
	//include "updates.php";
?>
<!-- /comments-->

<?php
	include "footer.php";
?>