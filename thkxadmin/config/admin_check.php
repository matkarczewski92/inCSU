<?php
$link = _URL.'/thkxadmin';
define('_URLADM', $link);
$conn = pdo_connect_mysql_up();
$sql = "SELECT COUNT(*) FROM `up_admin` WHERE user_id = '$_COOKIE[id]'";
$stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);

$admin = ($stmt[0]>0)? '1' : '0';
$acces = [];

$sql = "SELECT * FROM `up_admin_access` WHERE user_id = '$_COOKIE[id]'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $acces[] = $row['module'];
}




