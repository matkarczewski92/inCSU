<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";
session_start();

session_unset();

session_destroy();
setcookie('token', "", time() - 3600, '/', 'uniapanstw.pl');
setcookie('id', '', time() - 3600, '/', 'uniapanstw.pl');
header('Location: '. _URL);
?>