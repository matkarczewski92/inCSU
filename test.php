<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"><?php
ob_start();
session_start();
date_default_timezone_set("Poland");
require_once "controller/db_connection.php";
require_once "class/User.php";
require_once "class/System.php";
require_once "class/Bank.php";
require_once "class/Create.php";
require_once "class/Investments.php";
require_once "class/Probe.php";


echo Bank::controll();
echo '<br>';

$inv = System::Invest_info('12');
print_r($inv);





