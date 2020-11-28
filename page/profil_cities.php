<style>.alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
    }

    .alert.success {
        background-color: #4CAF50;
    }

    .alert.info {
        background-color: #2196F3;
    }

    .alert.warning {
        background-color: #ff9800;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }

</style><?php
$timed = time();
$conn = pdo_connect_mysql_up();
if (substr($_GET['typ'], 0, 2) == 'U0' or substr($_GET['typ'], 0, 2) == 'L0' or substr($_GET['typ'], 0, 2) == 'I0' or substr($_GET['typ'], 0, 2) == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];
$user_info = System::user_info($_COOKIE['id']);
$info = System::city_info($id);
$land = System::land_info($info['state_id']);
$config = System::config_info();

$id_f_lider = substr($info['leader_id'], 0, 1);
$id_lidera = ($id_f_lider != 'U') ? System::id_leader($info['leader_id']) : $info['leader_id'];
$leader = System::user_info($id_lidera);

$sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$id'";
$sth1 = $conn->query($sql1);
$licznik = 0;
while ($row1 = $sth1->fetch()) {
    $bank_acc = $row1['id'];
}
$bank_info = Bank::account_info($bank_acc);
?>

<!DOCTYPE html>
<html lang="pl">
<head><style>
    img {
    max-width: 90%;
    height: auto;
    }
    </style>
    <link rel="stylesheet" href="<? echo _URL; ?>/css/profil.css"/>
</head>
<div class="hero">
    <div class="hero-content">
        <h2>Profil miasta</h2>
        <hr width="80%"/>
    </div>
    <div class="hero-content-mobile"><h2>Profil miasta</h2></div>
</div>
<?php

// UPRAWNIENIA START
$bank = 0; // konta bankowe
$art = 0; // dodawanie mat. prasowych
$proposals = 0; // wnioski rozpatrywanie
$edit = 0; // edycja profilu
$workers = 0; // zarzadzanie pracownikami
$up_leader = System::checkOwner($info['state_id']);

if ($_COOKIE['id'] == $id_lidera or $_COOKIE['id'] == $up_leader) {
    $bank = 1; // konta bankowe
    $art = 1; // dodawanie mat. prasowych
    $edit = 1; // edycja profilu
    $workers = 1; // zarzadzanie pracownikami
    $plot = 1;

}

$sql = "SELECT * FROM `up_countries_workers` WHERE `cities` = '1' AND `state_id` = '$info[state_id]' AND until_date > '$timed' AND user_id = '$_COOKIE[id]' GROUP BY user_id ORDER BY until_date";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $bank = 1; // konta bankowe
    $art = 1; // dodawanie mat. prasowych
    $edit = 1; // edycja profilu
    $workers = 1; // zarzadzanie pracownikami
    $plot = 1;
}

$sql1 = "SELECT * FROM `up_cities_workers` WHERE `state_id` = '$id' AND until_date > '$timed' AND user_id = '$_COOKIE[id]' GROUP BY user_id ORDER BY until_date";
$sth1 = $conn->query($sql1);
while ($row1 = $sth1->fetch()) {
    $art = 1; // dodawanie mat. prasowych
}

if (in_array($_COOKIE['id'], _ADMINS, true) != '0') {
    $bank = 1; // konta bankowe
    $art = 1; // dodawanie mat. prasowych
    $edit = 1; // edycja profilu
    $workers = 1; // zarzadzanie pracownikami
    $plot = 1;
    $global_admin = TRUE;
}


if ($_GET['typ'] == 'adm_edytuj' and $edit == '1') {
    require_once 'action_cities/adm_edytuj.php';
} else if ($_GET['typ'] == 'adm_media' and $art == '1') {
    require_once 'action_cities/adm_media.php';
} else if ($_GET['typ'] == 'adm_media_edytuj' and $art == '1') {
    require_once 'action_cities/adm_media_edytuj.php';
} else if ($_GET['typ'] == 'zamieszkaj') {
    require_once 'action_cities/zamieszkaj.php';
} else if ($_GET['typ'] == 'adm_plot' and $art == '1') {
    require_once 'action_cities/adm_plot.php';
}  else if ($_GET['typ'] == 'adm_plot_sale' and $art == '1') {
    require_once 'action_cities/adm_plot_sale.php';
}  else if ($_GET['typ'] == 'adm_city_update' and $art == '1') {
    require_once 'action_cities/adm_city_update.php';
}  else if ($_GET['typ'] == 'plot_buy' and $art == '1') {
    require_once 'action_cities/plot_buy.php';
} else {
    echo '<div class="main">
    <div class="content"> <div class="card">
            <div class="card-header">
                <img src="' . $info['gfx_url'] . '" alt="Zdjęcie profilowe" class="profile-img">
            </div>
            <div class="card-body">
                <p class="full-name">' . $info['name'] . ' </p>
                <p class="username">&nbsp;</p>';

    if ($_GET['ptyp'] == 'ZAMI_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Miejsce zamieszkania zmienione poprawnie.</div>';
    if ($_GET['ptyp'] == 'OK_LIMIT') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Rozbudowano pomyślnie</div>';
    if ($_GET['ptyp'] == 'MONEY') echo '
    <div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak wystarczających środków na rachunku bankowym miasta.</div>';
    echo'
              
                <p class="desc" >' . $info['text'] . '</p>
            </div>
            <div class="card-footer">
                <div class="col vr">
                    <p><span class="count">' . $info['id'] . ' </span> ID</p>
                </div>
                                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $land['id'] . '" style="text-decoration: none; color: #1d4e85">(' . $info['state_id'] . ') ' . $land['name'] . '</a> </span> Kraj</p>
                </div>
                
                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $info['leader_id'] . '" style="text-decoration: none; color: #1d4e85">(' . $info['leader_id'] . ') ' . $leader['name'] . '</a></span> Lider kraju</p>
                </div>

            </div>
            <div class="card-footer">
                <div class="col vr">
                    <p><span class="count"><a href="' . $info['webpage_url'] . '" target="_blank" style="text-decoration: none; color: #1d4e85">Strona WWW</a></span>Adres strony WWW</p>
                </div>
                <div class="col vr">
                     <p><span class="count">' . $bank_info['balance'] . ' kr</span> Rachunek bankowy #'.$bank_info['id'].'</p>
                </div>
                <div class="col vr">
                     <p><span class="count">' . $info['plot_limit'] . '</span> Limit nieruchomości</p>
                </div>
                                <div class="col vr">
                     <p><span class="count">' . System::plotMetrageCounter($id) . ' m2</span> Powierzchnia miasta </p>
                </div>
                

            </div>
            <div class="card-footer">
                <div class="col vr obywatelstwa">
                    <p>Mieszkańcy / <b>Obywatele</b><span class="count"><ul>
                    ';


    $sql = "SELECT * FROM `up_users` WHERE city_id = '$id' AND active = '0'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id = '$row[id]' AND state_id = '$land[id]'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        echo ($stmt[0] == 1) ? '<b><a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . ' ' . $x . '</a></b>, &nbsp;&nbsp;' :
            '<a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . ' ' . $x . '</a>, &nbsp;&nbsp;';
    }
    echo ' </ul></span> </p>
                </div>
                                </div>
            <div class="card-footer herbobyw">
                <div class="col herbdiv">
                    <p><span class="count"><img src="' . $info['arm_url'] . '"  class="herb"></span> Herb</p>
                </div>
            </div>
        </div></div>
';

}
echo '
<div class="menu">
        <div class="card menucard sticky">';
echo '  <p class=""><a href="' . _URL . '/profil/' . $id . '" style="text-decoration: none;  color: #1d4e85">Profil</a></p>';
echo '  <p class=""><a href="' . _URL . '/profil/plot_buy/' . $id . '" style="text-decoration: none;  color: #1d4e85">Działki na sprzedaż</a></p>';
echo ($user_info['city_id'] != $id) ? ' <p class=""><a href="' . _URL . '/profil/zamieszkaj/' . $id . '" style="text-decoration: none; color: #1d4e85">Zamieszkaj</a></p>' : '';


if ($_COOKIE['id_controll'] == $id_lidera or $global_admin == TRUE) {
    echo ' <p class=""> <br> </p>';
    echo ($global_admin) ? '*---GLOBAL ADMIN MODE ON---*' : '';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_edytuj/' . $id . '" style="text-decoration: none;  color: #1d4e85">Edycja profilu</a></p>';
    echo ' <p class=""> <br> </p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_media/' . $id . '" style="text-decoration: none; color: #1d4e85">Artykuły - dodaj</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_media_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Artykuły - edytuj</a></p>';
    echo ' <p class=""> <br> </p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_plot/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj działkę na sprzedaż </a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_plot_sale/' . $id . '" style="text-decoration: none; color: #1d4e85">Zarządzaj działkami </a></p>';
    echo ' <p class=""> <br> </p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_city_update/' . $id . '" style="text-decoration: none; color: #1d4e85">Zwiększ powierzchnie miasta<br> Limit nieruchomości +'.$config['city_upgrade_newPlot'].' <br> ('.$config['city_upgrade'].' kr ) </a></p>';

}

echo ($edit == '1' and $_COOKIE['id'] != $id_lidera and $global_admin != TRUE) ? '<p class=""><a href="' . _URL . '/profil/adm_edytuj/' . $id . '" style="text-decoration: none;  color: #1d4e85">Edycja profilu</a></p>' : '';
echo ($art == '1' and $_COOKIE['id'] != $id_lidera and $global_admin != TRUE) ? '<p class=""><a href="' . _URL . '/profil/adm_media/' . $id . '" style="text-decoration: none; color: #1d4e85">Artykuły - dodaj</a></p>' : '';
echo ($art == '1' and $_COOKIE['id'] != $id_lidera and $global_admin != TRUE) ? '<p class=""><a href="' . _URL . '/profil/adm_media_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Artykuły - edytuj</a></p>' : '';
'';


echo '</div>
    </div>
</div>

';

?>
</html>
