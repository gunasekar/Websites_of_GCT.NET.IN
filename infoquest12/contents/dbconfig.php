<?php
define ("DB_HOST", "gctnetin.db.9018299.hostedresource.com"); // set database host
//define ("DB_HOST", "localhost");
define ("DB_USER", "gctnetin"); // set database user
define ("DB_PASS","GCTcsita!2"); // set database password
define ("DB_NAME","gctnetin"); // set database name

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

$user_registration = 0;  // set 0 or 1

define("COOKIE_TIME_OUT", 10); //specify cookie timeout in days (default is 10 days)
define('SALT_LENGTH', 9); // salt for password


/* Specify user levels */
define ("ADMIN_LEVEL", 5);
define ("USER_LEVEL", 1);
define ("GUEST_LEVEL", 0);

/*************** reCAPTCHA KEYS****************/
$publickey = "6LcczMwSAAAAABHTROtUx4pFKcUEb5POH9jGErhZ";
$privatekey = "6LcczMwSAAAAAJdbXq-h8MhbDTIbRanwvOVklNsO";
?>
