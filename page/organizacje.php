<?php
$id = $_COOKIE['id'];

?>

<div class="hero">
    <div class="hero-content">
        <h2>Rejestr mieszkańców</h2>
        <hr width="800"/>
        <p>
            Spis mieszkańców oraz obywateli Unii Państw Niepodległych
        </p>
    </div>
    <div class="hero-content-mobile"><h2>Rejestr mieszkańców</h2></div>
</div>

<div class="main">
    <div class="content">
        <div class="card"><?php

            if ($_GET['typ'] == 'Centralne') {
                $ids = '0';
            } else if ($_GET['typ'] == 'Krajowe') {
                $ids = '1';
            } else if ($_GET['typ'] == 'Prywatne') {
                $ids = '2';
            } else if ($_GET['typ'] == 'Lenna') {
                $ids = '3';
            }  else if ($_GET['typ'] == 'Budowlane') {
                $ids = '4';
            }

            if (isset($_GET['typ'])) {

                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_organizations` WHERE type_id = '$ids'";
                $sth = $conn->query($sql);
                echo '<center><p>Organizacje '.$_GET['typ'].'</p><table border="0" width="90%"><br>   
 <tr>
        <td width="7%" align="center"><b>ID</b></td>
        <td width="20%" align="center"><b>Kraj rejestracji</b></td>
        <td width="40%" align="center"><b>Nazwa</b></td>
        <td width="30%" align="center"><b>Zarządca</b></td>
    </tr>';
                while ($row = $sth->fetch()) {
                    $land = System::getInfo($row['leader_id']);
                    $land_in = ($row['state_id']!='' OR $row['state_id']!='I00001')? System::land_info($row['state_id']) : 'Unia Niepodległych Państw';

                    echo '
    <tr>
        <td width="7%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['id'] . ' </td>        
        <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $land_in['name'] . ' </td>
        <td width="40%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</td>
        <td width="30%"><a href="'._URL.'/profil/' . $land['id'] . '" style="text-decoration: none; color: black;">' . $land['name'] . '</td>
    </tr></a>';
                }
                echo '</table></center><br>';
            } else {


                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_organizations`";
                $sth = $conn->query($sql);
                echo '<center><p>Organizacje wszystkie</p><table border="0" width="90%"><br>   
 <tr>
        <td width="7%" align="center"><b>ID</b></td>
        <td width="20%" align="center"><b>Kraj rejestracji</b></td>
        <td width="40%" align="center"><b>Nazwa</b></td>
        <td width="30%" align="center"><b>Zarządca</b></td>
    </tr>';
                while ($row = $sth->fetch()) {
                    $leader = System::checkOwner($row['leader_id']);
                    if ($leader == '') $leader = System::checkOwner($row['owner_id']);
                    $land = System::getInfo($leader);
                    $land_in = System::land_info($row['state_id']);

                    echo '
    <tr>
        <td width="7%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['id'] . ' </td>        
        <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $land_in['name'] . ' </td>
        <td width="40%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</td>
        <td width="30%"><a href="'._URL.'/profil/' . $land['id'] . '" style="text-decoration: none; color: black;">' . $land['name'] . '</td>
    </tr></a>';
                }
                echo '</table></center><br>';

            } ?></div>
    </div>
    <div class="menu">

            <div class="card menucard sticky">
                <p class=""><a href="<?php echo _URL; ?>/organizacje"
                               style="text-decoration: none; color: black;">Wszystkie</a></a></p>
                <p class=""><a href="<?php echo _URL; ?>/organizacje/Centralne"
                               style="text-decoration: none; color: black;">Centralne</a></p>
                <p class=""><a href="<?php echo _URL; ?>/organizacje/Krajowe"
                               style="text-decoration: none; color: black;">Krajowe</a></p>
                <p class=""><a href="<?php echo _URL; ?>/organizacje/Prywatne"
                               style="text-decoration: none; color: black;">Prywatne</a></p>
                <p class=""><a href="<?php echo _URL; ?>/organizacje/Lenna"
                               style="text-decoration: none; color: black;">Lenna</a></p>
                <p class=""><a href="<?php echo _URL; ?>/organizacje/Budowlane"
                               style="text-decoration: none; color: black;">Budowlane</a></p>
            </div>

    </div>
</div>
