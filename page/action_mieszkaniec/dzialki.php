<?php
if (substr($_GET['typ'], 0, 2) == 'U0' or substr($_GET['typ'], 0, 2) == 'L0' or substr($_GET['typ'], 0, 2) == 'I0' or substr($_GET['typ'], 0, 2) == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];
$conn = pdo_connect_mysql_up();
$sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$_COOKIE[id]'  LIMIT 0,1";
$sth12 = $conn->query($sql12);
while ($row12 = $sth12->fetch()) {
    $bank_to_netto = $row12['id'];
}
$acc_info = Bank::account_info($bank_to_netto);

$sql_bank = "SELECT * FROM `bank_account` WHERE owner_id = '$id'  LIMIT 0,1";
$sthBank = $conn->query($sql_bank);
while ($banka = $sthBank->fetch()) {
    $city_bank = $banka['id'];
}
$acc_info_city = Bank::account_info($city_bank);


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Zarządzanie mieszkańcami</h2>
</div>';


    echo '<table width="60%" align="center">  <tr>
        <td width="20%">ID</td>
        <td width="60%">Adres</td>
        <td width="20%">Powierzchnia</td>
    </tr>';


    $sql = "SELECT * FROM `up_plot` WHERE owner_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo ' <form action="' . _URL . '/profil/plot_buy/' . $id . '/' . $row['id'] . '" method="post" ENCTYPE="multipart/form-data">  <tr>
        <td width="20%"><a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . '</a></td>
        <td width="60%">' . $row['address'] . '</td>
        <td width="20%">' . $row['square_meter'] . ' m2</td>
    </tr>

    </tr>
    </form>';
    }





echo '</table><br>';


echo '</div></div>';






