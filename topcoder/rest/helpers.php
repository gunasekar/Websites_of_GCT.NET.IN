<?php
/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
********************************************************/

function filter($data) {
	$data = trim(htmlentities(strip_tags($data)));
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	$data = mysql_real_escape_string($data);
	return $data;
}

function EncodeURL($url){
$new = strtolower(ereg_replace(' ','_',$url));
return($new);
}

function DecodeURL($url){
$new = ucwords(ereg_replace('_',' ',$url));
return($new);
}

function ChopStr($str, $len){
    if (strlen($str) < $len)
        return $str;

    $str = substr($str,0,$len);
    if ($spc_pos = strrpos($str," "))
            $str = substr($str,0,$spc_pos);

    return $str . "...";
}	

function isEmail($email){
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

function isUserName($username){
	if (preg_match('/^[a-z]{3,20}$/i', $username)) {
		return true;
	} else {
		return false;
	}
 }	
 
 function isName($name){
	if (preg_match('/^[a-z]{3,8}$/i', $name)) {
		return true;
	} else {
		return false;
	}
 }	

 
function isURL($url) {
	if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
		return true;
	} else {
		return false;
	}
} 

function checkPwd($x,$y) {
    if(empty($x) || empty($y) ) { return false; }
    if (strlen($x) < 5 || strlen($y) < 5) { return false; }

    if (strcmp($x,$y) != 0) {
        return false;
    } 
    return true;
}

function GenPwd($length = 7)
{
  $password = "";
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels
  $i = 0; 
  while ($i < $length) { 
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }

  }

  return $password;
}

function GenKey($length = 7){
  $password = "";
  $possible = "0123456789abcdefghijkmnopqrstuvwxyz";   
  $i = 0; 
  while ($i < $length) { 
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }
  }
  return $password;
}

function logout(){
	global $db;
	session_start();
	session_unset();
	session_destroy(); 
	header("Location: index.php");
}

// Password and salt generation
function PwdHash($pwd, $salt = null){
    if ($salt === null)     {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else     {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
}

function checkAdmin() {
	if($_SESSION['user_level'] == ADMIN_LEVEL){
		return 1;
	}
	else{
		return 0 ;
	}
}
?>