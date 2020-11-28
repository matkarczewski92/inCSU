<?php
$conn = pdo_connect_mysql_up();
if (substr($_GET['typ'], 0, 2) == 'U0' or substr($_GET['typ'], 0, 2) == 'L0' or substr($_GET['typ'], 0, 2) == 'I0' or substr($_GET['typ'], 0, 2) == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];
$user = new User($id);
$plot = System::plotInfo($user->getPlotId());
$city = System::city_info($user->getCityId());
$county = System::land_info($user->getStateId());
$title_sec = System::getTitleSec($user->getTitleUId());
?><!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="<? echo _URL; ?>/css/profil.css"/>
</head>
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
    }</style>
<div class="hero">
    <div class="hero-content">
        <h2>Profil u&#x017Cytkownika</h2>
        <hr width="800"/>
    </div>
    <div class="hero-content-mobile"><h2>Profil u&#x017Cytkownika</h2></div>
</div>
<?php


if ($_GET['typ'] == 'edytuj' && $_COOKIE['id'] == $_GET['ptyp']) {
    require_once 'action_mieszkaniec/adm_edytuj_user.php';
} else if ($_GET['typ'] == 'zatrudnienia') {
    require_once 'action_mieszkaniec/zatrudnienia.php';
}else if ($_GET['typ'] == 'investments') {
    require_once 'action_mieszkaniec/investments.php';
} else if ($_GET['typ'] == 'alerts') {
    require_once 'action_mieszkaniec/alerts.php';
} else if ($_GET['typ'] == 'wiadomosc') {
    require_once 'action_mieszkaniec/wiadomosc.php';
} else if ($_GET['typ'] == 'organizacje') {
    require_once 'action_mieszkaniec/organizacje.php';
} else if ($_GET['typ'] == 'dodaj_organizacje') {
    require_once 'action_mieszkaniec/nowa_organizacja.php';
} else if ($_GET['typ'] == 'dodaj_rodzine') {
    require_once 'action_mieszkaniec/dodaj_rodzine.php';
} else if ($_GET['typ'] == 'dzialki') {
    require_once 'action_mieszkaniec/dzialki.php';
} else if (substr($id, 0, 2) == 'U0') {
    if($_GET['ptyp']=='family_ok'){
        update('up_users_family','id',$_GET['ods'],'confirmed','1');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    if($_GET['ptyp']=='family_del'){
        $sql = "DELETE FROM `up_users_family` WHERE id='$_GET[ods]'";
        $conn->query($sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    $acc = Bank::account_info($user->getMainAccount());
    $balance_acc = number_format($acc['balance'], 0, ',', ' ') . ' kr';
    $inwest = (System::userInvest($id)!=0)? number_format(System::sumInvestUser($id)/System::userInvest($id), 0, ',', ' ') : '0';
    echo '<div class="main">
    <div class="content"> 
         <div class="card">
            <div class="card-header">
                <img src="' . $user->getAvatarUrl() . '" alt="Zdjęcie profilowe" class="profile-img">
            </div>
            <div class="card-body">
                <p class="full-name">' . $user->getName() . '</p>
                <p class="username"><b>' . $user->getHonorTitle() . '</b></p>
                <div class="cityrow"><p class="city"><a href="' . _URL . '/profil/' . $plot['id'] . '" style="text-decoration: none; color: #1d4e85">' . $plot['address'] . '</a>, <a href="' . _URL . '/profil/' . $city['id'] . '" style="text-decoration: none; color: #1d4e85">' . $city['name'] . '</a>, <a href="' . _URL . '/profil/' . $county['id'] . '" style="text-decoration: none; color: #1d4e85">' . $county['name'] . '</a></p><i class="material-icons">home</i></div>
                <p class="desc">' . $user->getText() . '</p>
            </div>
            <div class="card-footer">
                <div class="col vr">
                    <p><span class="count">' . $user->getId() . ' </span> ID</p>
                </div>
                <div class="col vr">
                    <p><span class="count">' . timeToDate($user->getRegisterDate()) . '</span> Data wydania paszportu</p>
                </div>';
                echo ($plot['id']!='')? '                                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $plot['id'] . '" style="text-decoration: none; color: #1d4e85">' . $plot['address'] . ',  <a href="' . _URL . '/profil/' . $city['id'] . '" style="text-decoration: none; color: #1d4e85">' . $city['name'] . '</a></a></span> Adres zamieszkania</p>
                </div>' : '';
                echo'<div class="col vr">
                    <p><span class="count">' . $title_sec['name'] . '</span> Ranga urzędnicza</p>
                </div>

                <div class="col">
                    <p><span class="count">' . $user->getTitleId() . '</span> Tytuł</p>
                </div>
            </div>
            <div class="card-footer">
                          <div class="col vr">
                    <p><span class="count">' . $balance_acc . '</span> Stan konta głównego #' . $acc['id'] . '</p>
                </div>
                <div class="col vr">
                    <p><span class="count">' . timeToDateTime(System::lastLogin($user->getId())) . '</span> Ostatnie logowanie</p>
                </div>
                <div class="col vr">
                    <p><span class="count">' . System::getTitleRank($user->getTitleRank()) . '</span> Stopień naukowy</p>
                </div>
                <div class="col">
                    <p><span class="count">' . System::getTitleAcademicName($user->getTitleAcademic()) . '</span> Stopień wojskowy</p>
                </div>
            </div>
               <div class="card-footer">
                          <div class="col vr">
                    <p><span class="count">'. System::userInvest($id).'</span> Liczba posiadanych Inwestycji</p>
                </div>
                <div class="col vr">
                    <p><span class="count">' .  number_format(System::sumInvestUser($id), 0, ',', ' ')  . ' kr</span>Cykliczny dochód brutto z Inwestycji</p>
                </div>
       <div class="col vr">
                    <p><span class="count">' .  $inwest  . ' kr</span>Średni dochód brutto na Inwestycje </p>
                </div>
            </div>

            <div class="card-footer herbobyw">
                <div class="col vr obywatelstwa">
                    <p><span class="count"><ul>
                    ';


    $sql = "SELECT * FROM `up_user_citizenship` WHERE user_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $county_citz = System::land_info($row['state_id']);
        echo '<li>' . $county_citz['name'] . '</li>';
    }
    echo ' </ul></span> Posiadane Obywatelstwa</p>
                </div>
                <div class="col herbdiv">
                    <p><span class="count">';

    $sql = "SELECT * FROM `up_user_orders` WHERE user_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $info = System::getOrderInfo($row['id']);
        echo '<img src = "' . $info['gfx'] . '" alt = "' . $info['name'] . '" > ';
    }

    echo '</span> Posiadane Odznaczenia</p>
                </div>
            </div>

            <div class="card-footer">
                 <p><span class="count"><ul>Członkowie rodziny</p>';

    $sql = "SELECT * FROM `up_users_family` WHERE confirmed = '1' AND (`user_id1` = '$id' OR `user_id2` = '$id')";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $info = ($row['user_id1']== $id)? System::getInfo($row['user_id2']) : System::getInfo($row['user_id1']);
        $name = ($row['user_id1']!= $id)? $row['id1_for_id2'] : $row['id2_for_id1'];
        echo '<a href="'._URL.'/profil/'.$info['id'].'" style="text-decoration: none; color: #1d4e85;">'.$info['name'].' ('.$name.')</a>, ';
    }
    echo ' </div>';
    if($_GET['typ']==$_COOKIE['id']){
    echo '<div class="card-footer">

                 <p><span class="count"><ul>Członkowie rodziny - do akceptacji</p>';

    $sql = "SELECT * FROM `up_users_family` WHERE confirmed = '0' AND (`user_id2` = '$id')";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $info = ($row['user_id1']== $id)? System::getInfo($row['user_id2']) : System::getInfo($row['user_id1']);
        $name = ($row['user_id1']== $id)? $row['id1_for_id2'] : $row['id2_for_id1'];
        echo '<a href="'._URL.'/profil/'.$info['id'].'" style="text-decoration: none; color: #1d4e85;">'.$info['name'].' ('.$name.' dla '.$row['user_id1'].') </a>
        <a href="'._URL.'/profil/'.$_GET['typ'].'/family_ok/'.$row['id'].'" style="text-decoration: none; color: #1d4e85;"><span class="material-icons" style="color: green">check</span></a>
        <a href="'._URL.'/profil/'.$_GET['typ'].'/family_del/'.$row['id'].'" style="text-decoration: none; color: #1d4e85;"><span class="material-icons" style="color: red">close</span></a><br>';
    }
    echo ' </div>  ';
    }
    echo'
            <div class="card-footer herbobyw">
                <div class="col herbdiv">
                    <p><span class="count"><img src="' . $user->getArmsUrl() . '" alt="Przysługujący herb szlachecki." class="herb"></span> Herb</p>
                </div>
            </div>

        </div>
        
  
        
        </div>
';


}
$id = $_GET['typ'];
$typ = substr($id, 0, 2);
if ($typ == 'U0' or $typ == 'L0' or $typ == 'I0' or $typ == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];
echo '
<div class="menu">

        <div class="card menucard sticky">';
echo '  <p class=""><a href="' . _URL . '/profil/' . $id . '" style="text-decoration: none; color: #1d4e85">Profil</a></p>';
echo '  <p class=""><a href="' . _URL . '/profil/zatrudnienia/' . $id . '" style="text-decoration: none; color: #1d4e85">Miejsca zatrudnienia</a></p>';
echo '  <p class=""><a href="' . _URL . '/profil/organizacje/' . $id . '" style="text-decoration: none; color: #1d4e85">Organizacje </a></p>';
echo '  <p class=""><a href="' . _URL . '/profil/dzialki/' . $id . '" style="text-decoration: none; color: #1d4e85">Nieruchomości </a></p>';
if ($_COOKIE['id'] != '') {
    echo ' <p class=""><a href="' . _URL . '/profil/wiadomosc/' . $id . '" style="text-decoration: none; color: #1d4e85">Wyślij wiadomość</a></p>';
}


if ($_COOKIE['id'] == $id) {
    echo '<P><BR> </P><p><B>ADMINISTRACJA</B></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/edytuj/' . $id . '" style="text-decoration: none; color: #1d4e85">Edycja profilu</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/dodaj_organizacje/' . $id . '" style="text-decoration: none; color: #1d4e85">Otwórz organizacje</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/dodaj_rodzine/' . $id . '" style="text-decoration: none; color: #1d4e85">Dodaj członka rodziny</a></p>';
    echo ' <p class=""><a href="' . _URL . '/profil/investments/' . $id . '" style="text-decoration: none; color: #1d4e85">Moje inwestycje</a></p>';

}


echo '</div>
    </div>

</div>
';
