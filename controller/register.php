<?php
session_start();
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";
require_once dirname(dirname(__FILE__)) . "/class/System.php";
require_once dirname(dirname(__FILE__)) . "/class/Create.php";


if (isset($_SESSION['login'])) {
    header("Location: .");
} else {

    $id_user = System::id_generator(1);
    Create::User($id_user, $_POST['name'], $_POST['password'], $_POST['email'], '', $_POST['state_id'], '', '');

    $_SESSION['login'] = $id_user;
    $_SESSION['name'] = $_POST['name'];

    $token = token($id_user);
    $_SESSION['token'] = $token;

    setcookie('id', $id_user, time() + 86400, '/', 'uniapanstw.pl', 1, true);
    setcookie('id_controll', $id_user, time() + 86400, '/', 'uniapanstw.pl', 1, true);
    setcookie('token', $_SESSION['token'], time() + 86400, '/', 'uniapanstw.pl', 1, true);
    setcookie('UIDforum', $hashId, time() + 604800, '/', 'uniapanstw.pl', 1, true);


    $url = _URL;
    header("Location: $url");

}

