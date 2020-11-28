<?php

$sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$id'";
$sth1 = $conn->query($sql1);
$licznik = 0;
while ($row1 = $sth1->fetch()) {
    $bank_from = $row1['id'];
}
$bank_info_city = Bank::account_info($bank_from);

if($bank_info_city['balance']>=$config['city_upgrade']){
    $bank = Bank::transfer($bank_from,_KIBANK,$config['city_upgrade'],'Opłata za rozwój miasta '.$id.'. ');
    if ($bank=='OK'){
        $newLimit = $config['city_upgrade_newPlot']+$info['plot_limit'];
        update('up_cities','id',$id,'plot_limit',$newLimit);
        header('Location: '._URL.'/profil/'.$id.'/OK_LIMIT');
    }
} else header('Location: '._URL.'/profil/'.$id.'/MONEY');
