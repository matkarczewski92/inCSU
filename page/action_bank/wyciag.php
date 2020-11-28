<?php
$id = $_COOKIE['id'];


if (isset($_GET['ptyp'])){
echo '<p>Wycia bankowy dla konta nr '.$_GET['ptyp'].' </p><table border="0" width="90%" align="center">
 <tr>
        <td width="4%" bgcolor="'.$colour.'" align="center">ID</td>
        <td width="25%" bgcolor="'.$colour.'" align="center">Nadawca/Odbiorca</td>
        <td width="35%" bgcolor="'.$colour.'" align="center">Tytuł</td>
        <td width="15%" bgcolor="'.$colour.'" align="center">Kwota</td>
        <td width="20%" bgcolor="'.$colour.'" align="center">Data</td>
    </tr>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `bank_statement` WHERE (`from_id` = '$_GET[ptyp]' OR `to_id` = '$_GET[ptyp]') AND `value`!='0' ORDER BY `date` DESC ";
    $sth = $conn->query($sql);
    $licznik = 0;
    while ($row = $sth->fetch()) {
        if ($licznik % 2 == 0) $colour = "#F2EFEA"; else $colour = "#FFFFFF";
        $acc_info = Bank::account_info($row['from_id']);
        $acc_info2 = Bank::account_info($row['to_id']);
        $info_cp = System::getInfo($acc_info2['owner_id']);
        $info = System::getInfo($acc_info['owner_id']);
        if ($row['value'] != '0') {
            echo ' 

    <tr>
        <td width="4%" bgcolor="' . $colour . '">' . $row['id'] . '</td>
        <td width="25%" bgcolor="' . $colour . '"> 
        <sub>Nadawca</sub><br>#' . sprintf("%05d", $row['from_id']) . ' - ' . $info['name'] . '<br>
        <sub>Odbiorca</sub><br>#' . sprintf("%05d", $row['to_id']) . ' - ' . $info_cp['name'] . '<br></td>
        <td width="35%" bgcolor="' . $colour . '">' . $row['title'] . '</td>
        ';
            if ($row['from_id'] == $_GET['ptyp']) {
                echo '<td width="15%" bgcolor="#FFDDDD"">-' . number_format($row['value'], 0, ',', ' ') . ' kr</td>';
            } else echo '<td width="15%" bgcolor="#DDFFDD"">' . number_format($row['value'], 0, ',', ' ') . ' kr</td>';

            echo '</td>
        <td width="20%" bgcolor="' . $colour . '">' . timeToDateTime($row['date']) . '</td>
    </tr>';
            $licznik++;
        }
    }

echo '</table>';
} else {

    echo '<h3>Lista dostępnych rachunków bankowych</h3>';

    echo '<p><b>Rachunki prywatne</b> </p>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $profil_info = System::getInfo($row['owner_id']);
        $balance = $row['balance'] - $row['debit'];
        echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';

    }
    echo '<p><b>Rachunki państw i krajów, którymi zarządzasz</b> </p>';

    $sql1 = "SELECT * FROM `up_countries` WHERE `leader_id` = '$id'";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $profil_info = System::getInfo($row1['id']);
            $balance = $row['balance'] - $row['debit'];
            echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';
        }
    }
    $sql1 = "SELECT * FROM `up_cities` WHERE `leader_id` = '$id'";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $profil_info = System::getInfo($row1['id']);
            $balance = $row['balance'] - $row['debit'];
            echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">
        ' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';
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
                echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';
            }
        }
    }
    echo '<p><b>Rachunki organizacji którymi zarządzasz</b> </p>';

    $sql1 = "SELECT * FROM `up_organizations` WHERE `leader_id` = '$id'";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $profil_info = System::getInfo($row1['id']);
            $balance = $row['balance'] - $row['debit'];
            echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';

            echo '<p><b>Rachunki państw i krajów - dostęp czasowy - zatrudnienie</b> </p>';
        }
    }
    $sql1 = "SELECT distinct `user_id`, `state_id`, `until_date`, `from_date` FROM `up_countries_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[state_id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $profil_info = System::getInfo($row1['state_id']);
            $balance = $row['balance'] - $row['debit'];
            echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';

        }
    }

    $sql1 = "SELECT distinct `user_id`, `state_id`, `until_date`, `from_date` FROM `up_cities_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[state_id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $profil_info = System::getInfo($row1['state_id']);
            $balance = $row['balance'] - $row['debit'];
            echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';
        }
    }
    echo '<p><b>Rachunki organizacji - dostęp czasowy - zatrudnienie</b> </p>';

    $sql1 = "SELECT distinct `user_id`, `organizations_id`, `until_date`, `from_date` FROM `up_organizations_workers` WHERE `user_id` = '$id' AND bank = '1' AND until_date > '$data_time_actual' ORDER BY `from_date` ";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $sql = "SELECT * FROM `bank_account` WHERE `owner_id` = '$row1[organizations_id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $profil_info = System::getInfo($row1['organizations_id']);
            $balance = $row['balance'] - $row['debit'];
            echo '<p><a href="' . _URL . '/bank/wyciag/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . ' - ' . $profil_info['name'] . ' </a></p>';
        }
    }


}
echo '<hr>';