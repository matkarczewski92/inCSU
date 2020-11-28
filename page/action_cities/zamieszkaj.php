<?php


$user = new User($_COOKIE['id']);
$user->setCityId($_GET['ptyp']);
$user->setStateId($info['state_id']);


header('Location: '._URL.'/profil/'.$_GET['ptyp'].'/ZAMI_OK');