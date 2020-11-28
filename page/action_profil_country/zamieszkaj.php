<?php

$user = new User($_COOKIE['id']);
$user->setStateId($_GET['ptyp']);
$city_id = $user->getCityId();
$city_info = System::city_info($city_id);
if ($city_info['state_id'] != $_GET['ptyp']) {
    $user->setCityId('');
}
header("Location: " . _URL . "/profil/$_GET[ptyp]");
