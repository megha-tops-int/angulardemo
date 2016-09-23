<?php
session_start();

date_default_timezone_set("UTC");
define("MYSQL_HOST","localhost");
define("MYSQL_USERNAME","root");
define("MYSQL_PASSWORD","");
define("MYSQL_DB","angular_demo");

require_once 'includes/functions.php';
require_once 'modules/database.php';
require_once 'modules/user.php';
