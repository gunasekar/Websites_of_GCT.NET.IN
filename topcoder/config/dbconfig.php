<?php
/*******DB Specific Configuration*********/
// Set DB host
// define ("DB_HOST", "gctnetin.db.9018299.hostedresource.com");
define ("DB_HOST", "localhost");

// Set DB User
define ("DB_USER", "topcoder");

// Set DB Password
define ("DB_PASS","MyP@55w0rd");

//Set DB Name
define ("DB_NAME","topcoder");

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");



/*******Website Specific configuration******/
// Set 1 to allow registration, 0 to block registration
$user_registration = 1;

// Set Cookie Timeout in days (default is 10 days)
define("COOKIE_TIME_OUT", 10);



/********User Specific Configuration**********/
// Set Salt for password
define('SALT_LENGTH', 9);

/* Specify user levels */
define ("ADMIN_LEVEL", 5);
define ("USER_LEVEL", 1);
define ("GUEST_LEVEL", 0);



/*************** reCAPTCHA KEYS****************/
$publickey = "6LcczMwSAAAAABHTROtUx4pFKcUEb5POH9jGErhZ";
$privatekey = "6LcczMwSAAAAAJdbXq-h8MhbDTIbRanwvOVklNsO";




/******* Contest Specific Configurations *******/
// Set the points for the problems
$points = 100;

// To Set the class active for the current tab
$tab = 0;

$isProblemsPage = 0;
?>
