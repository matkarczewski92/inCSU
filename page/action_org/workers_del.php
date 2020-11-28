<?php
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Pracownik został usuniety poprawnie ' . $_GET['ods'] . '<br></h2>
</div>';
$timest = time() - 1;
$time = time();

$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_organizations_workers` WHERE id = '$_GET[ods]'";
$sth = $conn->query($sql);
$licznik = 0;
while ($row = $sth->fetch()) {
    if ($row['salary'] != 0) {
    $org_info = System::organization_info($_GET['ods']);
    $last_salary = $row['last_salay_date'];
    $il_dni = $time - $last_salary;
    $bank_from = $org_info['main_bank_acc'];
    $il_dni_do_wyplaty = floor($il_dni / (60 * 60 * 24));
    $wyplata_za_dzien = $row['salary'] / $row['frequency_days'];
    $do_wyplaty = ($wyplata_za_dzien * $il_dni_do_wyplaty);

    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$row[user_id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        $bank_to = $row12['id'];
    }
    $user_info = System::user_info($row['user_id']);
    $land_info = System::land_info($user_info['state_id']);
    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$land_info[id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        $bank_tax = $row12['id'];
    }
    $tax = $land_info['tax_personal'];
    $brutto = $do_wyplaty;
    $netto = $do_wyplaty * (1 - $tax);
    $tax_pay = ($brutto - $netto);
    $title = 'Wynagrodzenie za okres od: ' . timeToDate($last_salary) . ' do: ' . timeToDate($time) . ' za stanowisko: ' . $row['name'] . ' ' . $row['state_id'] . ' - rozwiązanie umowy';
    $title_tax = 'Podatek dochodowy umowa nr #' . $row['id'].' - zakonczenie umowy - zwolnienie';


        Bank::transfer($bank_from, $bank_to, $brutto, $title);
        Bank::transfer($bank_to, $bank_tax, $tax_pay, $title_tax);
    }
    update('up_organizations_workers', 'id', $row['id'], 'last_salay_date', $time);
    update('up_organizations_workers', 'id', $row['id'], 'until_date', $timest);

    $title_log = 'Usunięcie pracownika ('.$row['user_id'].') z instytucji '.$org_info['id'].' - SK - usuniecie ';
    $xlo = ($_COOKIE['id']=='')? $xlo='brak' : $xlo=$_COOKIE['id'];
    Create::Log($xlo,$title_log);
}


echo '</div></div>';