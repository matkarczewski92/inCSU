<style>
    img {
        width: 90%;
        height: auto;
    }
</style><style>.alert {
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
    }</style><?php
if (substr($_GET['typ'], 0, 2) == 'U0' or substr($_GET['typ'], 0, 2) == 'L0' or substr($_GET['typ'], 0, 2) == 'I0' or substr($_GET['typ'], 0, 2) == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];
$timed = time();
$user_info = System::user_info($_COOKIE['id']);
$info = System::land_info($id);
$leader = System::getInfo($info['leader_id']);
$oplata = System::config_info();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="<? echo _URL; ?>/css/profil.css"/>
</head>
<div class="hero">
    <div class="hero-content">
        <h2>Profil kraju</h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Profil kraju</h2></div>
</div>
<?php
$sql = "SELECT * FROM `up_countries_workers` WHERE state_id = '$id' AND until_date > '$timed' AND user_id = '$_COOKIE[id]' GROUP BY user_id ORDER BY until_date";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $law = $row['law'];
    $proposal = $row['proposal'];
    $edit = $row['edit'];
    $cities = $row['cities'];
    $workers = $row['workers'];
    $users = $row['users'];
    $org = $row['org'];
}
if (($_COOKIE['id'] == $info['leader_id'] or $_COOKIE['id'] == $info['leader_id'])) {
    $law = 1;
    $proposal = 1;
    $edit = 1;
    $cities = 1;
    $workers = 1;
    $users = 1;
    $org = 1;  //adm_dodaj_org
    $probe = 1;
}
if (in_array($_COOKIE['id'], _ADMINS, true) != '0') {
    $law = 1;
    $proposal = 1;
    $edit = 1;
    $cities = 1;
    $workers = 1;
    $users = 1;
    $org = 1;  //adm_dodaj_org
    $global_admin = TRUE;
    $probe = 1;
}

if ($_GET['typ'] == 'adm_worker_delete' && $workers == 1) {
    require_once 'action_profil_country/adm_worker_delete.php';
} else if ($_GET['typ'] == 'adm_edytuj' && $edit == 1) {
    require_once 'action_profil_country/adm_edytuj_country.php';
} else if ($_GET['typ'] == 'probe_adm' && $probe == 1) {//////////////
    require_once 'action_profil_country/probe_adm.php';
} else if ($_GET['typ'] == 'adm_wnioski_add' && $proposal == 1) {
    require_once 'action_profil_country/adm_wnioski_add.php';
} else if ($_GET['typ'] == 'adm_wnioski_show' && $proposal == 1) {
    require_once 'action_profil_country/adm_wnioski_show.php';
} else if ($_GET['typ'] == 'adm_dodaj_miast' && $cities == 1) {
    require_once 'action_profil_country/adm_dodaj_miast.php';
} else if ($_GET['typ'] == 'adm_edytuj_miasto' && $cities == 1) {
    require_once 'action_profil_country/adm_edytuj_miasto.php';
} else if ($_GET['typ'] == 'adm_wnioski' && $proposal == 1) {
    require_once 'action_profil_country/adm_wnioski.php';
} else if ($_GET['typ'] == 'adm_prawo' && $law == 1) {
    require_once 'action_profil_country/adm_prawo.php';
} else if ($_GET['typ'] == 'adm_dodaj_org' && $law == 1) {
    require_once 'action_profil_country/adm_dodaj_org.php';
} else if ($_GET['typ'] == 'adm_prawo_edycja' && $law == 1) {
    require_once 'action_profil_country/adm_prawo_edycja.php';
} else if ($_GET['typ'] == 'adm_hr' && $workers == 1) {
    require_once 'action_profil_country/adm_hr.php';
} else if ($_GET['typ'] == 'adm_hr_edycja' && $workers == 1) {
    require_once 'action_profil_country/adm_hr_edycja.php';
} else if ($_GET['typ'] == 'adm_mieszkancy' && $users == 1) {
    require_once 'action_profil_country/mieszkancy.php';
} else if ($_GET['typ'] == 'zamieszkaj') {
    require_once 'action_profil_country/zamieszkaj.php';
} else if ($_GET['typ'] == 'media_dodaj') {
    require_once 'action_profil_country/media_dodaj.php';
} else if ($_GET['typ'] == 'media_edytuj') {
    require_once 'action_profil_country/media_edytuj.php';
} else if ($_GET['typ'] == 'wniosek') {
    require_once 'action_profil_country/wniosek.php';
} else if (substr($id, 0, 2) == 'L0') {


    $sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$id'";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $bank_account = $row1['balance'];
    }
    echo '<div class="main">
    <div class="content"> <div class="card">
            <div class="card-header">
                <img src="' . $info['gfx_url'] . '" alt="Zdjęcie profilowe" class="profile-img">
            </div>
            <div class="card-body">
                <p class="full-name">' . $info['name'] . '</p>
                <p class="username">&nbsp;</p>

                <p class="desc">' . $info['text'] . '</p>
            </div>
            <div class="card-footer">
                <div class="col vr">
                    <p><span class="count">' . $info['id'] . ' </span> ID</p>
                </div>
                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $info['leader_id'] . '" style="text-decoration: none; color: #1d4e85">(' . $info['leader_id'] . ') ' . $leader['name'] . '</a></span> Lider kraju</p>
                </div>

                <div class="col">
                    <p><span class="count">' . $info['tax_personal'] * 100 . '%</span> Podatek dochodowy</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="col vr">
                    <p><a href="' . $info['webpage_url'] . '" target="_blank" style="text-decoration: none; color: #1d4e85">Strona WWW</a></p>
                </div>
                                <div class="col vr">
                   <p><span class="count">' . number_format($bank_account, 0, ',', ' ') . ' kr</span> Stan rachunku bankowego</a></p>
                </div>

            </div>
            <div class="card-footer herbobyw">
                <div class="col vr obywatelstwa" style="width: 70%">
                    <p > Mieszkańcy / <b>Obywatele</b>  </p><p align="justify">
                    ';

    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_users` WHERE state_id = '$id' AND active = '0'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id = '$row[id]' AND state_id = '$info[id]'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);

        echo ($stmt[0] == 1) ? '<b><a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . ' ' . $x . '</a></b> &nbsp;&nbsp;' :
            '<a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . ' ' . $x . '</a> &nbsp;&nbsp;';
    }
    echo '</p>
                </div>
                                <div class="col vr obywatelstwa">
                    <p>Miasta<span class="count"><ul>
                    ';

    $sql = "SELECT * FROM `up_cities` WHERE state_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '<li><a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . '</a></li>';
    }
    echo ' </p>
                </div>
            </div>
                        <div class="card-footer">
                <div class="col vr"><p>Urzędnicy państwowi<span class="count"><ul>';

    $sql = "SELECT * FROM `up_countries_workers` WHERE state_id = '$id' AND until_date > '$timed' GROUP BY user_id ORDER BY until_date";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $usr = System::user_info($row['user_id']);
        echo '<li><table border="0" align="center" width="70%">
    <tr>
        <td width="5%">' . $row['user_id'] . '</td>
        <td width="25%"><a href="' . _URL . '/profil/' . $row['user_id'] . '" style="text-decoration: none; color: #1d4e85">' . $usr['name'] . '</td>
        <td width="20%">' . $row['name'] . '</td>
        <td width="10%">' . timeToDate($row['from_date']) . '</td>
        <td width="10%">' . timeToDate($row['until_date']) . '</td>
        </tr><table><table border="0" align="center" width="50%">
        <td width="10%">';
        if ($row['law'] == 1) echo '<span class="material-icons" title="Możliwość publikacji/edycji praw kraju">gavel</span>';
        echo '</td>
        <td width="10%">';
        if ($row['bank'] == 1) echo '<span class="material-icons" title="Dostęp do rachunków bankowych">account_balance</span>';
        echo '</td>
        <td width="10%">';
        if ($row['users'] == 1) echo '<span class="material-icons" title="Zarządzanie mieszkańcami">group</span>';
        echo '</td>
        <td width="10%">';
        if ($row['cities'] == 1) echo '<span class="material-icons" title="Możliwość zarządzania miastami">business</span>';
        echo '</td>
        <td width="10%">';
        if ($row['proposal'] == 1) echo '<span class="material-icons"title="Możliwość rozpatrywania wniosków">description</span>';
        echo '</td>
        <td width="10%">';
        if ($row['edit'] == 1) echo '<span class="material-icons" title="Możliwość edycji profilu">create</span>';
        echo '</td>
        <td width="10%">';
        if ($row['workers'] == 1) echo '<span class="material-icons" title="Możliwość zarządzania pracownikami">engineering</span>';
        echo '</td>        
        <td width="10%">';
        if ($row['org'] == 1) echo '<span class="material-icons" title="Możliwość zarządzania organizacjami">shop</span>';
        echo '</td>
        <td width="10%">';
        if ($workers == 1 and $_COOKIE['id'] != '') echo '<a href="' . _URL . '/profil/adm_worker_delete/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85"><span class="material-icons">delete_forever</span>USUŃ</a>';
        echo '</td>

    </tr>
</table></li><Hr width="70%">';
    }
    echo '</p></span></div></div>
                <div class="card-footer">  <div class="col vr">
                    <p>Podległe organizacje</a></p>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_organizations` WHERE owner_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $org_info = System::organization_info($row['id']);
        echo '<a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . ' - ' . $row['name'] . '</a><br>';
    }
    echo '<br>
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
echo '  <p class=""><a href="' . _URL . '/profil/' . $id . '" style="text-decoration: none; color: #1d4e85"">Profil</a></p>';
if ($_COOKIE['id'] != '') {  // menu dostępne dla zalogowanych
    echo ' <p class=""><a href="' . _URL . '/profil/wniosek/' . $id . '" style="text-decoration: none; color: #1d4e85">Złóż wniosek</a></p>';
    if ($user_info['state_id'] != $id) {
        echo ' <p class=""><a href="' . _URL . '/profil/zamieszkaj/' . $id . '" style="text-decoration: none; color: #1d4e85">Zamieszkaj</a></p>';
    }
}
$sql1 = "SELECT COUNT(*) FROM `up_proposal` WHERE `organizations_id` = '$id' AND `done` = '0'";
$stmt1 = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
if ($stmt1[0] == '0') $msg1 = ''; else $msg1 = '<span class="material-icons" style="color: #f44336; ">mark_email_unread</span>';


if (($_COOKIE['id'] == $info['leader_id'] and $_COOKIE['id'] != '') or $global_admin) {
    echo '<hr><p><b>Panel administracyjny</b></p>';
    echo ($global_admin) ? '*---GLOBAL ADMIN MODE ON---*' : '';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Edycja profilu i podatku</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_dodaj_miast/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj miasto</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_dodaj_org/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj organizacje</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_edytuj_miasto/' . $id . '" style="text-decoration: none; color: #1d4e85">Zarządcy miast</a></p>';
    echo '<br>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_wnioski/' . $id . '" style="text-decoration: none; color: #1d4e85">Przeglądaj wnioski ' . $msg1 . '</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_wnioski_add/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj schemat wniosków</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_wnioski_show/' . $id . '" style="text-decoration: none; color: #1d4e85">Przeglądaj schematy wniosków</a></p>';
    echo '<br>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_prawo/' . $id . '" style="text-decoration: none; color: #1d4e85">Publikacja praw</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_prawo_edycja/' . $id . '" style="text-decoration: none; color: #1d4e85">Edytuj prawo</a></p>';
    echo '<br>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_hr/' . $id . '" style="text-decoration: none; color: #1d4e85">Kadry - dodaj</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_hr_edycja/' . $id . '" style="text-decoration: none; color: #1d4e85">Kadry - zarządzanie</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/adm_mieszkancy/' . $id . '" style="text-decoration: none; color: #1d4e85">Mieszkańcy</a></p>';
    echo '<br>';
    echo ' <p class=""><a href="' . _URL . '/profil/media_dodaj/' . $id . '" style="text-decoration: none; color: #1d4e85">Napisz artykuł</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/media_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Edytuj artykuł</a></p>';
    echo '<br>';
    echo ' <p class=""><a href="' . _URL . '/profil/probe_adm/' . $id . '" style="text-decoration: none; color: #1d4e85">Zorganizuj głosowanie</a></p>';



} else {
    $sql = "SELECT * FROM `up_countries_workers` WHERE state_id = '$id' AND until_date > '$timed' AND user_id = '$_COOKIE[id]' GROUP BY `user_id`";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        if ($row['edit'] == '1') echo ' <p class=""><a href="' . _URL . '/profil/adm_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Edycja profilu i podatku</a></p>';
        if ($row['cities'] == '1') {
            echo ' <p class=""><a href="' . _URL . '/profil/adm_dodaj_miast/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj miasto</a></p>';
            echo ' <p class=""><a href="' . _URL . '/profil/adm_edytuj_miasto/' . $id . '" style="text-decoration: none; color: #1d4e85">Uprawnienia miast</a></p>';
        }
        if ($row['law'] == '1') {
            echo ' <p class=""><a href="' . _URL . '/profil/adm_prawo/' . $id . '" style="text-decoration: none; color: #1d4e85">Publikacja praw</a></p>';
            echo ' <p class=""><a href="' . _URL . '/profil/adm_prawo_edycja/' . $id . '" style="text-decoration: none; color: #1d4e85">Edytuj prawo</a></p>';
        }
        if ($row['proposal'] == '1') echo ' <p class=""><a href="' . _URL . '/profil/adm_wnioski/' . $id . '" style="text-decoration: none; color: #1d4e85">Przeglądaj wnioski ' . $msg1 . '</a></p>';
        if ($row['workers'] == '1') {
            echo ' <p class=""><a href="' . _URL . '/profil/adm_hr/' . $id . '" style="text-decoration: none; color: #1d4e85">Kadry</a></p>';
            echo ' <p class=""><a href="' . _URL . '/profil/adm_hr_edycja/' . $id . '" style="text-decoration: none; color: #1d4e85">Kadry - zarządzanie</a></p>';
        }
        if ($row['org'] == '1') echo ' <p class=""><a href="' . _URL . '/profil/adm_dodaj_org/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj organizacje</a></p>';
        if ($row['users'] == '1') echo ' <p class=""><a href="' . _URL . '/profil/adm_mieszkancy/' . $id . '" style="text-decoration: none; color: #1d4e85">Mieszkańcy</a></p>';
        echo ' <p class=""><a href="' . _URL . '/profil/media_dodaj/' . $id . '" style="text-decoration: none; color: #1d4e85">Napisz artykuł</a></p>';
        echo ' <p class=""><a href="' . _URL . '/profil/media_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Edytuj artykuł</a></p>';
    }
}


echo '</div>
    </div>

</div>
';

?>
</html>
