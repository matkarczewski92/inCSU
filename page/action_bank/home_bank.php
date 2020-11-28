<?php


echo '<h3>Lista dostępnych rachunków bankowych</h3>';

echo '<p><b>Rachunki prywatne</b> </p>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$id'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $profil_info = System::getInfo($row['owner_id']);
    $balance = $row['balance'] - $row['debit'];
    echo '<table border="0" align="center" width="60%"  style=" border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85">&nbsp;</td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
}
echo '<hr><p> </p>';


echo '<p><b>Rachunki państw i miast, którymi zarządzasz</b> </p>';

$sql1 = "SELECT * FROM `up_countries` WHERE `leader_id` = '$id'";
$sth1 = $conn->query($sql1);
while ($row1 = $sth1->fetch()) {
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $profil_info = System::getInfo($row1['id']);
        $balance = $row['balance'] - $row['debit'];
        echo '<table border="0" align="center" width="60%"  style=" border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85">&nbsp;</td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
    }
}
echo '<p> </p>';

$sql1 = "SELECT * FROM `up_cities` WHERE `leader_id` = '$id'";
$sth1 = $conn->query($sql1);
while ($row1 = $sth1->fetch()) {
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $profil_info = System::getInfo($row1['id']);
        $balance = $row['balance'] - $row['debit'];
        echo '<table border="0" align="center" width="60%"  style=" border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85">&nbsp;</td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
    }
}
echo '<p> </p>';
$sql12 = "SELECT * FROM `up_countries` WHERE `leader_id` = '$id' ";
$sth12 = $conn->query($sql12);
while ($row12 = $sth12->fetch()) {
    $sql1 = "SELECT * FROM `up_cities` WHERE `state_id` = '$row12[id]' ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $profil_info = System::getInfo($row1['id']);
            $balance = $row['balance'] - $row['debit'];
            echo '<table border="0" align="center" width="60%" border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85">&nbsp;</td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
        }
    }
}
echo '<hr><p> </p>';

echo '<p><b>Rachunki organizacji którymi zarządzasz lub których jesteś właścicielem</b> </p>';

$sql1 = "SELECT * FROM `up_organizations` WHERE `leader_id` = '$id' OR owner_id = '$id'";
$sth1 = $conn->query($sql1);
while ($row1 = $sth1->fetch()) {
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $profil_info = System::getInfo($row1['id']);
        $balance = $row['balance'] - $row['debit'];
        echo '<table border="0" align="center" width="60%"  style=" border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85">&nbsp;</td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
    }
}

echo '<hr><p> </p>';

echo '<p><b>Rachunki państw i miast - dostęp czasowy - zatrudnienie</b> </p>';

$sql1 = "SELECT distinct `user_id`, `state_id`, `until_date`, `from_date` FROM `up_countries_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
$sth1 = $conn->query($sql1);
while ($row1 = $sth1->fetch()) {
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[state_id]'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $profil_info = System::getInfo($row1['state_id']);
        $balance = $row['balance'] - $row['debit'];
        echo '<table border="0" align="center" width="60%"  style="border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85"><p>' . timeToDate($row1['until_date']) . '<br><sup>Dostęp do</sup></p></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
    }
}
echo '<p> </p>';
$sql1 = "SELECT distinct `user_id`, `state_id`, `until_date`, `from_date` FROM `up_cities_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
$sth1 = $conn->query($sql1);
while ($row1 = $sth1->fetch()) {
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[state_id]'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $profil_info = System::getInfo($row1['state_id']);
        $balance = $row['balance'] - $row['debit'];
        echo '<table border="0" align="center" width="60%"  style=" border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85"><p>' . timeToDate($row1['until_date']) . '<br><sup>Dostęp do</sup></p></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
    }
}
echo '<hr><p> </p>';

echo '<p><b>Rachunki organizacji - dostęp czasowy - zatrudnienie</b> </p>';

$sql1 = "SELECT distinct `user_id`, `organizations_id`, `until_date`, `from_date` FROM `up_organizations_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
$sth1 = $conn->query($sql1);
while ($row1 = $sth1->fetch()) {
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[organizations_id]'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $profil_info = System::getInfo($row1['organizations_id']);
        $balance = $row['balance'] - $row['debit'];
        echo '<table border="0" align="center" width="60%"  style=" border: 1px solid black; border-color: #1d4e85;">
    <tr>
        <td width="30%" style="color: #1d4e85"><p>#' . $row['id'] . '<br><sup>ID</p></sup></td>
        <td width="30%" style="color: #1d4e85" colspan="2"><p>(' . $profil_info['id'] . ') ' . $profil_info['name'] . '<br><sup>Właściciel</sup></p></td>
        
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($balance, 0, ',', ' ') . ' kr<br><sup>Saldo konta</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['balance'], 0, ',', ' ') . ' kr<br><sup>Dostępne środki</sup></p></td>
        <td width="30%" style="color: #1d4e85" bgcolor="#F2EFEA"><p>' . number_format($row['debit'], 0, ',', ' ') . ' kr<br><sup>Debet</sup></p></td>
    </tr>
    <tr>
        <td width="30%" style="color: #1d4e85"><p>' . timeToDate($row1['until_date']) . '<br><sup>Dostęp do</sup></p></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/przelew/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wykonaj przelew</a></td>
        <td width="30%" style="color: #1d4e85"><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">Wyciąg</a></td>
    </tr>
        <tr>
        <td width="30%" style="color: #1d4e85" colspan="3"></td>

    </tr>
</table>  <p> </p>';
    }
}


echo '<hr><p> </p>';