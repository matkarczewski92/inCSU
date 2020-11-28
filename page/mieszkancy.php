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
        <div class="card"><?

            if ($_GET['typ'] == 'Teutonii') {
                $ids = 'L0001';
            } else if ($_GET['typ'] == 'Dreamlandu') {
                $ids = 'L0002';
            } else if ($_GET['typ'] == 'Baridasu') {
                $ids = 'L0003';
            } else if ($_GET['typ'] == 'Sclavinii') {
                $ids = 'L0004';
            }

            if (isset($_GET['typ'])) {

                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_users` WHERE state_id = '$ids' AND `active` = '0'";
                $sth = $conn->query($sql);
                echo '<center><p>Mieszkańcy '.$_GET['typ'].'</p><table border="0" width="70%"><bR>';
                while ($row = $sth->fetch()) {
                    $land = System::land_info($row['state_id']);
                    $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id = '$row[id]' AND state_id = '$land[id]'";
                    $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                    if ($stmt[0] == 1) $x = '<span class="material-icons md-10" alt="OBYWATEL">star</span>'; else $x = '';
                    echo '
    <tr>
        <td width="10%" ><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"><img src="' . $row['avatar_url'] . '" alt="Zdjęcie profilowe" class="profile-imgm"></td>
        <td width="50%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . ' '.$x.'</td>
        <td width="40%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $land['name'] . '</td>
    </tr></a>';
                }
                echo '</table></center><br>';
            } else {


                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_users` WHERE `active` = '0'";
                $sth = $conn->query($sql);
                echo '<center><table border="0" width="70%"><br>';
                while ($row = $sth->fetch()) {
                    $land = System::land_info($row['state_id']);
                    $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id = '$row[id]' AND state_id = '$land[id]'";
                    $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                    if ($stmt[0] == 1) $x = '<span class="material-icons md-10" alt="OBYWATEL">star</span>'; else $x = '';
                    echo '
    <tr>
        <td width="5%" ><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"><img src="' . $row['avatar_url'] . '" alt="Zdjęcie profilowe" class="profile-imgm"></td>
        <td width="55%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . ' '.$x.'</td>
        <td width="40%"><a href="'._URL.'/profil/' . $land['id'] . '" style="text-decoration: none; color: black;">' . $land['name'] . '</td>
    </tr></a>';
                }
                echo '</table></center><br>';

            } ?></div>

    </div>
    <div class="menu">

            <div class="card menucard sticky">
                <p class=""><a href="<?php echo _URL; ?>/mieszkancy"
                               style="text-decoration: none; color: black;">Unia</a></a></p>
                <p class=""><a href="<?php echo _URL; ?>/mieszkancy/Baridasu"
                               style="text-decoration: none; color: black;">Baridas</a></p>
                <p class=""><a href="<?php echo _URL; ?>/mieszkancy/Dreamlandu"
                               style="text-decoration: none; color: black;">Dreamland</a></p>
                <p class=""><a href="<?php echo _URL; ?>/mieszkancy/Sclavinii"
                               style="text-decoration: none; color: black;">Sclavinia</a></p>
                <p class=""><a href="<?php echo _URL; ?>/mieszkancy/Teutonii"
                               style="text-decoration: none; color: black;">Teutonia</a></p>
            </div>
        </div>

</div>
