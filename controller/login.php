<?php
session_start();
ini_set( 'session.cookie_httponly', 1 );
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";
require_once dirname(dirname(__FILE__)) . "/class/System.php";
require_once dirname(dirname(__FILE__)) . "/class/User.php";


$pass = hash("sha256", $_POST['password']);
$conn = pdo_connect_mysql_up();
$id = strtoupper($_POST['id']);
$email = strpos($id, '@');

if ($email=='' AND $email<='0') {
    $sql = "SELECT COUNT(*) FROM `up_users` WHERE password = '$pass' AND id = '$id'";
    $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
    $sql2 = "SELECT * FROM `up_users` WHERE id='$id'";
    $data = $conn->query($sql2)->fetch(); /// tablica $data[]; z danymi z up_users ostatecznie zamienic z metoda System::user_info($user_id);
} else {
    $ppp='ok';
    $sql = "SELECT COUNT(*) FROM `up_users` WHERE password = '$pass' AND email = '$_POST[id]'";
    $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
    $sql2 = "SELECT * FROM `up_users` WHERE email='$_POST[id]'";
    $data = $conn->query($sql2)->fetch(); /// tablica $data[]; z danymi z up_users ostatecznie zamienic z metoda System::user_info($user_id);
    $id = $data['id'];
}



if ($stmt[0] == 1) {
    $_SESSION['login'] = $id;
    $_SESSION['name'] = $data['name'];

    $hashId = hash('sha256', $id).'.'.$id;
    $explo = explode(".",$_COOKIE['UIDforum']);
    if($_COOKIE['UIDforum']!='' AND $explo[1]!=$id){
        $sql = "INSERT INTO `up_user_login_data_cookies` (user_id, user_id2, time) VALUES (:user_id, :user_id2, :time)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':user_id' => $id,
                ':user_id2' => $explo[1],
                ':time' => time())
        ) or die(print_r($sth->errorInfo(), true));
    }


    $token = token($id);  // controller/db_connection.php
    $_SESSION['token'] = $token;
    setcookie('id', $_SESSION['login'], time() + 604800, '/', 'uniapanstw.pl', 1, true);
    setcookie('id_controll', $id, time() + 604800, '/', 'uniapanstw.pl', 1, true);
    setcookie('token', $_SESSION['token'], time() + 604800, '/', 'uniapanstw.pl', 1, true);
    setcookie('UIDforum', $hashId, time() + 604800, '/', 'uniapanstw.pl', 1, true);

    $ip = new User($id);
    $ip->setLastIp($_SERVER['REMOTE_ADDR']);








    $ip = $_SERVER['REMOTE_ADDR'];
    $host = gethostbyaddr( $ip );
    $sql = "INSERT INTO `up_user_login_data` (user_id, data, ip, text, host) VALUES (:user_id, :data, :ip, :text, :host)";
    $sth = $conn->prepare($sql);
    $sth->execute(array(
            ':user_id' => $id,
            ':data' => time(),
            ':ip' => $_SERVER['REMOTE_ADDR'],
            ':text' => 'Logowanie do CSU',
            ':host' => $host)
    ) or die(print_r($sth->errorInfo(), true));

    header('Location: ' . $_SERVER['HTTP_REFERER']);


} else {
    header('Location: log'.$id);
}

