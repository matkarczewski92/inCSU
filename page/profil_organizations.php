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
$info = System::organization_info($id);
$leader = System::user_info($info['leader_id']);
$owner = System::getInfo($info['owner_id']);
$url = _URL;
$oplata = System::config_info();
$typ_org = System::orgTyp_info($info['type_id']);
$info_build =  System::organization_infoBuild($id);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="<?php echo _URL; ?>/css/profil.css"/>
</head>
<div class="hero">
    <div class="hero-content">
        <h2>Profil organizacji</h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Profil organizacji  </h2></div>
</div>

<?php

// UPRAWNIENIA START
$law = 0; // dodawania i edycja prawa
$bank = 0; // konta bankowe
$proposals = 0; // wnioski rozpatrywanie
$profil = 0; // edycja profilu
$workers = 0; // zarzadzanie pracownikami
$organizations = 0; // zarzadzanie podległymi organizacjami
$art = 0;
$build = ($info_build['id']!='')? '0' : '0';
$user_owner_id = System::checkOwner($info['owner_id']);

// NADANIE UPRAWNIEŃ ODPOWIEDNICH DLA PRACOWNIKÓW
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_organizations_workers` WHERE organizations_id = '$owner[id]' AND until_date > '$timed' AND user_id = '$_COOKIE[id]' AND org='1' GROUP BY user_id ORDER BY until_date";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    if ($row['org_id'] == '' or $row['org_id'] == $id) {
        $law = $row['law']; // dodawania i edycja prawa
        $proposals = $row['proposal']; // wnioski rozpatrywanie
        $profil = $row['edit']; // edycja profilu
        $workers = $row['workers']; // zarzadzanie pracownikami
        $bank = $row['bank']; // konta bankowe
        $message = 1;
//        if ($info['type_id'] == '1') $org = 1;
        if ($info['article'] == '1') $art = 1; else $art = 0;
    }
}
$sql = "SELECT * FROM `up_organizations_workers` WHERE organizations_id = '$id' AND until_date > '$timed' AND user_id = '$_COOKIE[id]' GROUP BY user_id ORDER BY until_date";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $law = $row['law']; // dodawania i edycja prawa
    $proposals = $row['proposal']; // wnioski rozpatrywanie
    $profil = $row['edit']; // edycja profilu
    $workers = $row['workers']; // zarzadzanie pracownikami
    $bank = $row['bank']; // konta bankowe
    $message = 1;
//    if ($info['type_id'] == '1') $org = 1;
    if ($info['article'] == '1') $art = 1; else $art = 0;
}
// NADANIE UPRAWNIEŃ PEŁNYCH DLA PRACOWNIKÓW WŁAŚCICIELA // DLA ORG. KRAJOWYCH
if ($info['type_id'] == '1') {
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_countries_workers` WHERE `org` = '1' AND state_id = '$info[owner_id]' AND until_date > '$timed' AND user_id = '$_COOKIE[id]' GROUP BY user_id ORDER BY until_date";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        if ($row['org_id'] == '' or $row['org_id'] == $id) {
            $law = 1; // dodawania i edycja prawa
            $bank = 1; // konta bankowe
            $proposals = 1; // wnioski rozpatrywanie + wiadomosci
            $profil = 1; // edycja profilu
            $workers = 1; // zarzadzanie pracownikami
            $message = 1;
            $build = ($info_build['id']!='')? '1' : '0';
            if ($info['type_id'] == '1') $org = 1;
            if ($info['article'] == '1') $art = 1; else $art = 0;
        }
    }
}


// NADANIE UPRAWNIEŃ PEŁNYCH WŁAŚCICIELOWI
if ($user_owner_id == $_COOKIE['id']) {
    $law = 1; // dodawania i edycja prawa
    $bank = 1; // konta bankowe
    $proposals = 1; // wnioski rozpatrywanie + wiadomosci
    $profil = 1; // edycja profilu
    $workers = 1; // zarzadzanie pracownikami
    $message = 1;
    $build = ($info_build['id']!='')? '1' : '0';
    if ($info['type_id'] == '1') $org = 1;
    if ($info['article'] == '1') $art = 1; else $art = 0;
}
// NADANIE UPRAWNIEŃ PEŁNYCH ZARZĄDCY
if ($info['leader_id'] == $_COOKIE['id']) {
    $law = 1; // dodawania i edycja prawa
    $bank = 1; // konta bankowe
    $proposals = 1; // wnioski rozpatrywanie + wiadomosci
    $profil = 1; // edycja profilu
    $workers = 1; // zarzadzanie pracownikami
    $message = 1;
    $build = ($info_build['id']!='')? '1' : '0';
    if ($info['type_id'] == '1') $org = 1;
    if ($info['article'] == '1') $art = 1; else $art = 0;
}
if (in_array($_COOKIE['id'],_ADMINS, true)!='0') {
    $law = 1; // dodawania i edycja prawa
    $bank = 1; // konta bankowe
    $proposals = 1; // wnioski rozpatrywanie + wiadomosci
    $profil = 1; // edycja profilu
    $workers = 1; // zarzadzanie pracownikami
    $message = 1;
    $build = ($info_build['id']!='')? '1' : '0';
    if ($info['type_id'] == '1') $org = 1;
    if ($info['article'] == '1') $art = 1; else $art = 0;
    $global_admin = TRUE;
}

// UPRAWNIENIA KONIEC


if ($_GET['typ'] == 'wiadomosc') {
    require_once 'action_org/wiadomosc.php';
} else if ($_GET['typ'] == 'adm_edytuj' && ($profil == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/edycja.php';
} else if ($_GET['typ'] == 'adm_artykul_dodaj' && ($art == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/artykuly_dodaj.php';
} else if ($_GET['typ'] == 'adm_artykul_edytuj' && ($art == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/artykul_edytuj.php';
} else if ($_GET['typ'] == 'adm_kadry' && ($workers == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/adm_kadry.php';
} else if ($_GET['typ'] == 'adm_kadry_zarzadzaj' && ($workers == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/adm_kadry_zarzadzaj.php';
} else if ($_GET['typ'] == 'adm_law_edit' && ($law == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/adm_law_edit.php';
} else if ($_GET['typ'] == 'adm_law' && ($law == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/adm_law.php';
} else if ($_GET['typ'] == 'adm_dodaj_org' && ($info['leader_id'] == $_COOKIE['id'] or $info['owner_id'] == $_COOKIE['id'] or $org = 1)) {
    require_once 'action_org/adm_dodaj_org.php';
} else if ($_GET['typ'] == 'adm_wnioski_add' && ($info['leader_id'] == $_COOKIE['id'] or $info['owner_id'] == $_COOKIE['id'] or $org = 1)) {
    require_once 'action_org/adm_wnioski_add.php';
} else if ($_GET['typ'] == 'adm_wnioski_edit' && ($info['leader_id'] == $_COOKIE['id'] or $info['owner_id'] == $_COOKIE['id'] or $org = 1)) {
    require_once 'action_org/adm_wnioski_edit.php';
} else if ($_GET['typ'] == 'wnioski') {
    require_once 'action_org/wnioski.php';
}  else if ($_GET['typ'] == 'adm_build_lvlup' AND $build == '1') {
    require_once 'action_org/adm_build_lvlup.php';
} else if ($_GET['typ'] == 'adm_build_add' AND $build == '1') {
    require_once 'action_org/adm_build_add.php';
}else if ($_GET['typ'] == 'adm_build_adm_ki' AND $id == 'I00002') {
    require_once 'action_org/adm_build_adm_ki.php';
} else if ($_GET['typ'] == 'adm_build_adm' AND $build == '1') {
    require_once 'action_org/adm_build_adm.php';
} else if ($_GET['typ'] == 'adm_build_works' AND $build == '1') {
    require_once 'action_org/adm_build_works.php';
} else if ($_GET['typ'] == 'adm_wnioski' && ($proposals == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/adm_wnioski.php';
} else if ($_GET['typ'] == 'adm_dodaj_bank_p' && ($bank == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    Create::Account($_GET['ptyp']);
    Bank::transfer($info['main_bank_acc'], _KIBANK, $oplata['bank_next_acount_charge'], 'Założenie rachunku bankowego organizacji');
    header("Location: $url/profil/$_GET[ptyp]/ACC_OK");
} else if ($_GET['typ'] == 'adm_dodaj_bank' && ($bank == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    Create::Account($_GET['ptyp']);
    header("Location: $url/profil/$_GET[ptyp]/ACC_OK");
} else if ($_GET['typ'] == 'adm_wiadomosci' && ($message == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/adm_wiadomosci.php';
} else if ($_GET['typ'] == 'adm_worker_delete' && ($workers == 1 or $info['leader_id'] == $_COOKIE['id'])) {
    require_once 'action_org/workers_del.php';
} else if (substr($id, 0, 2) == 'I0') {
    $transfer = $_GET['ptyp'];
    echo '<div class="main">
    <div class="content"> <div class="card">
            <div class="card-header">
                <img src="' . $info['gfx_url'] . '" alt="Zdjęcie profilowe" class="profile-img">
            </div>
            <div class="card-body">
                <p class="full-name">' . $info['name'] . '</p>
                <p class="username">Organizacja <span class="count"><b>' . $typ_org['name'] . '</b></span></p>

                <p class="desc">' . $info['text'] . '</p>
                ';

    if ($transfer == 'ACC_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Rachunek bankowy został dodany
</div>';
    if ($transfer == 'LVL_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Poziom technologiczny został podniesiony
</div>';
    if ($transfer == 'ART_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Materiał prasowy został dodany
</div>';
    if ($transfer == 'MONEY') echo '
    <div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak wystarczających środków na koncie organizacji
</div>';
    if ($transfer == 'DEL_BLU') echo '
    <div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Projekt został usunięty
</div>';


    echo '
            </div>
            <div class="card-footer">
                <div class="col vr">
                    <p><span class="count">' . $info['id'] . ' </span> ID</p>
                </div>
                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $info['owner_id'] . '" style="text-decoration: none; color: #1d4e85">(' . $owner['id'] . ') ' . $owner['name'] . '</a></span> Właściciel organizacji '.$info_build['id'].'</p>
                </div>
                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $info['leader_id'] . '" style="text-decoration: none; color: #1d4e85">(' . $leader['id'] . ') ' . $leader['name'] . '</a></span> Zarządca organizacji</p>
                </div>
            </div>

                        <div class="card-footer">
                <div class="col vr">
                    <p>Rachunki bankowe</a></p>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `bank_account` WHERE owner_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '#' . $row['id'] . ' - Stan konta: ' . number_format($row['balance'], 0, ',', ' ') . ' kr<br>';
    }
    echo '</div>

                <div class="col vr">
                    <p>Podległe organizacje</a></p>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_organizations` WHERE owner_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $org_info = System::organization_info($row['id']);
        echo '<a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . ' - ' . $row['name'] . '</a><br>';
    }
    echo '
                </div> 
            </div>
            
           
                        <div class="card-footer">
                <div class="col vr"><p>Pracownicy<span class="count"></span>';
    $sql = "SELECT * FROM `up_organizations_workers` WHERE organizations_id = '$id' AND until_date > '$timed' GROUP BY user_id ORDER BY id";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $usr = System::user_info($row['user_id']);
        echo '<table border="0" align="center">
    <tr>
        <td width="59">' . $row['user_id'] . '</td>
        <td width="189">' . $usr['name'] . '</td>
        <td width="214">' . $row['name'] . '</td>
        <td width="125">' . timeToDate($row['from_date']) . '</td>
        <td width="125">' . timeToDate($row['until_date']) . '</td>
        <td width="25">';
        if ($row['law'] == 1) echo '<span class="material-icons" title="Zdolnośc publikacji i edycji praw organizacji">gavel</span>';
        echo '</td>
        <td width="25">';
        if ($row['bank'] == 1) echo '<span class="material-icons"  title="Dostęp do rachunków bankowych organizacji">account_balance</span>';
        echo '</td> ';
        echo '<td width="25">';
        if ($row['proposal'] == 1) echo '<span class="material-icons"  title="Zdolność rozpatrywania wniosków i czytania wiadomości PW">description</span>';
        echo '</td>
        <td width="25">';
        if ($row['edit'] == 1) echo '<span class="material-icons"  title="Możliwość edycji profilu">create</span>';
        echo '</td>
        <td width="25">';
        if ($row['workers'] == 1) echo '<span class="material-icons" title="Możliwość zarządzania pracownikami">engineering</span>';
        echo '</td>
              <td width="25">';
        if ($row['workers'] == 1) echo '<span class="material-icons" title="Możliwość zarządzania organizacjami">shop</span>';
        echo '</td>
        <td width="25">';
        if ($workers == 1 AND $_COOKIE['id']!='') echo '<a href="' . _URL . '/profil/adm_worker_delete/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85"><span class="material-icons">delete_forever</span>USUŃ</a>';
        echo '</td>

    </tr>
</table>';
    }

    echo ($info_build['id']!='') ?' <div class="card-footer">
                <div class="col vr">
                    <p><span class="count">' . $info_build['level'] . ' </span> Poziom technologiczny</p>
                </div>
                <div class="col vr">
                    <p><span class="count"> x ' . $info_build['time_multiplier'] . '</a></span> Mnożnik czasu budowy</p>
                </div>
                <div class="col vr">
                    <p><span class="count"> x ' . $info_build['cost_multiplier'] . '</a></span> Mnożnik kosztów budowy</p>
                </div>
                                <div class="col vr">
                    <p><span class="count">'.System::blueprintsOrgCounter($id).' / ' . $info_build['build_limit'] . '</a></span> Limit projektów na rynku</p>
                </div>
            </div>' : '';


    echo '</div></div>

        </div></div>
';

}


// /////////////////////////////////////////   MENU

$sql = "SELECT COUNT(*) FROM `up_post` WHERE `to_id` = '$id' AND `is_read` = '0'";
$stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql1 = "SELECT COUNT(*) FROM `up_proposal` WHERE `organizations_id` = '$id' AND `done` = '0'";
$stmt1 = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
if ($stmt1[0] == '0') $msg1 = ''; else $msg1 = '<span class="material-icons" style="color: #f44336; ">mark_email_unread</span>';
if ($stmt[0] == '0') $msg = ''; else $msg = '<span class="material-icons" style="color: #f44336; ">mark_email_unread</span>';

echo '

<div class="menu"><div class="card menucard sticky">';
echo '  <p class=""><a href="' . _URL . '/profil/' . $id . '" style="text-decoration: none; color: #1d4e85" >Profil</a></p>';


if ($_COOKIE['id'] != '') {  // menu dostępne dla zalogowanych
    echo ' <p class=""><a href="' . _URL . '/profil/wiadomosc/' . $id . '" style="text-decoration: none; color: #1d4e85">Wyślij wiadomość</a></p>';
}

if ($info['proposal'] == 1) {
    echo ' <p class=""><a href="' . _URL . '/profil/wnioski/' . $id . '" style="text-decoration: none; color: #1d4e85">Złóż wniosek</a></p>';
}
echo '<hr>';
echo ($global_admin)? '*---GLOBAL ADMIN MODE ON---*' : '';
if (($info['leader_id'] == $_COOKIE['id'] or $info['owner_id'] == $_COOKIE['id'] or $org = 1) and $_COOKIE['id'] != '' and $info['type_id'] == '0') {
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_dodaj_org/' . $id . '" style="text-decoration: none; color: #1d4e85">Otwórz organizacje </a></p>';
}
if (($info['leader_id'] == $_COOKIE['id'] or $info['owner_id'] == $_COOKIE['id'] or $org = 1) and $_COOKIE['id'] != '' and $info['type_id'] == '0' OR $info['type_id'] == '1') {
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_wnioski_add/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj shemat wniosku </a></p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_wnioski_edit/' . $id . '" style="text-decoration: none; color: #1d4e85">Edytuj shemat wniosku </a></p>';
}

if ($profil == '1' and $_COOKIE['id'] != '') {
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Edycja profilu </a></p>';
}
if ($art == '1' and $_COOKIE['id'] != '') {
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_artykul_dodaj/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj artykuł </a></p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_artykul_edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Edytuj artykuł </a></p>';
}
if ($workers == '1' and $_COOKIE['id'] != '') {
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_kadry/' . $id . '" style="text-decoration: none; color: #1d4e85">Kadry - dodaj pracownika</a></p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_kadry_zarzadzaj/' . $id . '" style="text-decoration: none; color: #1d4e85">Kadry - zarzadzaj</a></p>';
}
if ($proposals == '1' and $_COOKIE['id'] != '') {
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_wiadomosci/' . $id . '" style="text-decoration: none; color: #1d4e85">Wiadomosci</a>' . $msg . '</p>';
}
if ($law == '1' and $_COOKIE['id'] != '' and $info['law'] == 1) {

    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_law/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj akt prawny</a></p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_law_edit/' . $id . '" style="text-decoration: none; color: #1d4e85">Edytuj akt prawny</a></p>';
}
if ($proposals == '1' and $_COOKIE['id'] != '' and ($info['type_id'] == 0 or $info['type_id'] == 1)) {

    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_wnioski/' . $id . '" style="text-decoration: none; color: #1d4e85">Wnioski</a>' . $msg1 . '</p>';
}
if ($bank == '1' and $_COOKIE['id'] != '' and ($info['type_id'] != 0 and $info['type_id'] != 1)) {
    $check_money = Bank::account_info($info['main_bank_acc']);
    if ($check_money['balance'] >= $oplata['bank_next_acount_charge']) {
        echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_dodaj_bank_p/' . $id . '" style="text-decoration: none; color: #1d4e85">Otwórz rachunek bankowy (' . $oplata['bank_next_acount_charge'] . ' kr)</a></p>';
    } else {
        echo ' <p class=""></p><p class="">Otwórz rachunek bankowy (' . $oplata['bank_next_acount_charge'] . ' kr)</p>';
    }
} else if ($bank == '1' and $_COOKIE['id'] != '' and ($info['type_id'] == 0 or $info['type_id'] == 1)) {
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_dodaj_bank/' . $id . '" style="text-decoration: none; color: #1d4e85">Otwórz rachunek bankowy</a></p>';
}
$costs = System::config_info();
if($build=='1' AND $_COOKIE['id']!=''){
    echo ' <p class=""><br> </p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_build_lvlup/' . $id . '" style="text-decoration: none; color: #1d4e85">
            Zwiększ poziom technologiczny <br>('.number_format($costs['build_company_upgrade_cost'], 0, ',', ' ').' kr)</a></p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_build_add/' . $id . '" style="text-decoration: none; color: #1d4e85">
            Dodaj projekt</a></p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_build_adm/' . $id . '" style="text-decoration: none; color: #1d4e85">
            Zarządzaj projektami</a></p>';
}
if ($id == 'I00002'){
    echo ' <p class=""><br> </p>';
    echo ' <p class=""></p><p class=""><a href="' . _URL . '/profil/adm_build_adm_ki/' . $id . '" style="text-decoration: none; color: #1d4e85">
            Projekty do zatwierdzenia</a></p>';
}


echo '<hr></div>
    </div>

</div>
';

?>
