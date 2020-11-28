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

if ($_GET['ods'] == 'OK') echo '<div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Działka została kupiona poprawnie</div>';
if ($_GET['ods'] == 'ERR') echo '<div class="alert ">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Coś poszło nie po myśli autora ;|</div>';
if ($_GET['ods'] == 'MONEY') echo '<div class="alert ">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak środków na koncie</div>';



if (isset($_GET['ods']) AND $_GET['ods']!='OK') {
    $plot_info = System::plotInfo($_GET['ods']);
    $title = 'Zakup działki nr. '.$plot_info['id'];
    $bank = ($plot_info['price']!='')? Bank::transfer($acc_info['id'],$acc_info_city['id'],$plot_info['price'],$title) : header('Location: ' . _URL . '/profil/plot_buy/' . $_GET['ptyp'] . '/ERR/'.$_GET['ods']);
    if ($bank=='OK'){
        $plot = new Plot($_GET['ods']);
        $plot->setOwnerId($_COOKIE['id']);
        $plot->setPrice(NULL);
        header('Location: ' . _URL . '/profil/plot_buy/' . $_GET['ptyp'] . '/OK/'.$_GET['ods']);
    } else header('Location: ' . _URL . '/profil/plot_buy/' . $_GET['ptyp'] . '/MONEY/'.$_GET['ods']);

} else {
    echo '<h3>Dostępne na sprzedaż</h3>';
    echo '<table width="90%" align="center">  <tr>
        <td width="20%">ID</td>
        <td width="40%">Adres</td>
        <td width="15%">Cena</td>
        <td width="15%">Powierzchnia</td>
        <td width="10%">&nbsp;</td>
    </tr>';


    $sql = "SELECT * FROM `up_plot` WHERE city_id = '$id' AND owner_id = '' AND price > 0 AND type_id != '2'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo ' <form action="' . _URL . '/profil/plot_buy/' . $id . '/' . $row['id'] . '" method="post" ENCTYPE="multipart/form-data">  <tr>
        <td width="20%"><a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . '</a></td>
        <td width="40%">' . $row['address'] . '</td>
        <td width="15%">' . $row['price'] . ' kr</td>
        <td width="15%">' . $row['square_meter'] . ' m2</td>
        <td width="10%">';
        echo ($acc_info['balance']>=$row['price'])? '<button class="w3-btn w3-blue-grey" >Kup</button>' : '';
        echo'</td>
    </tr>

    </tr>
    </form>';
    }
}
echo '</table><br>';
echo '<h3>Działki sprzedane</h3>';
echo '<table width="60%" align="center">  <tr>
        <td width="20%">ID</td>
        <td width="60%">Adres</td>
        <td width="20%">Powierzchnia</td>
    </tr>';


$sql = "SELECT * FROM `up_plot` WHERE city_id = '$id' AND owner_id != ''";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    echo '<tr>
        <td width="20%"><a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . '</a></td>
        <td width="60%">' . $row['address'] . '</td>
        <td width="20%">' . $row['square_meter'] . ' m2</td>
    </tr>

    </tr>
    </form>';
}
echo '</table><br>';
echo '</div></div>';






