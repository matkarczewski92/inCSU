<style>progress-bar-stripes {

    from {
        background-position: 40px 0
    }

    to {
        background-position: 0 0
    }

    }
    @-o-keyframes progress-bar-stripes {
        from {
            background-position: 40px 0
        }
        to {
            background-position: 0 0
        }
    }

    @keyframes progress-bar-stripes {
        from {
            background-position: 40px 0
        }
        to {
            background-position: 0 0
        }
    }

    .progress {
        height: 20px;
        margin-bottom: 20px;
        overflow: hidden;
        background-color: #f5f5f5;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1)
    }

    .progress-bar {
        float: left;
        width: 0%;
        height: 100%;
        font-size: 12px;
        line-height: 20px;
        color: #fff;
        text-align: center;
        background-color: #337ab7;
        -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
        -webkit-transition: width .6s ease;
        -o-transition: width .6s ease;
        transition: width .6s ease
    }

    .progress-bar-striped, .progress-striped .progress-bar {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        -webkit-background-size: 40px 40px;
        background-size: 40px 40px
    }

    .progress-bar.active, .progress.active .progress-bar {
        -webkit-animation: progress-bar-stripes 2s linear infinite;
        -o-animation: progress-bar-stripes 2s linear infinite;
        animation: progress-bar-stripes 2s linear infinite
    }

    .progress-bar-success {
        background-color: #5cb85c
    }

    .progress-striped .progress-bar-success {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent)
    }

    .progress-bar-info {
        background-color: #5bc0de
    }

    .progress-striped .progress-bar-info {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent)
    }

    .progress-bar-warning {
        background-color: #f0ad4e
    }

    .progress-striped .progress-bar-warning {
        background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
        background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent)
    }

    .progress-bar-danger {
        background-color: #d9534f
    }

    .progress-striped </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
$plot = new Plot($id);
$user = new User($_COOKIE['id']);
$build = ($plot->getBuildingId() != '')? new PlotBuilding($plot->getBuildingId()) : '';
$city = System::getInfo($plot->getCityId());
$owner = System::getInfo($plot->getOwnerId());
$building = $plot->buildingInfo();
$building1 = ($plot->getBuildingId() != '') ? $building['name'] : 'NIEZABUDOWANA';
$dataOdbioru = ($building['date_build'] == '') ? 'W TRAKCIE BUDOWY' : timeToDate($building['date_build']);
$sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$_COOKIE[id]'  LIMIT 0,1";
$sth12 = $conn->query($sql12);
while ($row12 = $sth12->fetch()) {
    $bank_to_netto = $row12['id'];
}
$acc_info = Bank::account_info($bank_to_netto);


if ($plot->getOwnerId()==$city['id']) {
    $global_admin_plot = ($city['leader_id'] == $_COOKIE['id']) ? TRUE : '';
}
$global_admin_plot = (in_array($_COOKIE['id'], _ADMINS, true) != '0') ? TRUE : '';



if ($_GET['ptyp'] == 'buy') {
    $plot1 = new Plot($_GET['typ']);
    $owner1 = $plot1->getOwnerId();
    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$owner1'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    while ($row12 = $sth12->fetch()) {
        $bank_to_sell = $row12['id'];
    }
    echo $bank_to_sell;
    $title = 'Zakup działki nr ' . $plot1->getId();
    $bank = Bank::transfer($acc_info['id'], $bank_to_sell, $plot1->getPrice(), $title);
    if ($bank == 'OK') {
        $plot1->setPrice(NULL);
        $plot1->setOwnerId($_COOKIE['id']);
    }
    header('Location: ' . _URL . '/profil/' . $id);
}
$date_start = $building['start_build_date'];
$date_finish = $building['finish_build_date'];
$duration = number_format(($building['finish_build_date'] - $building['start_build_date']) / 86400, '2');
$sum = number_format((($date_finish / 86400) - (time() / 86400)), '2');
//
$x = ($building['start_build_date'] != '') ? number_format(100 - ($sum * 100 / $duration), '2') : '';
$x = ($x<=100)? $x : '100';


if ($_GET['ptyp'] == 'zamieszkaj') {
    $user->setPlotId($id);
    header('Location: ' . _URL . '/profil/' . $id . '/ZAM_OK');
}
if ($_GET['ptyp'] == 'odbierz') {
    if ($x==100){
    $build->setDateBuild(time());
        header('Location: ' . _URL . '/profil/' . $id . '/ODB_OK');
    }
}




?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <style>
        img {
            max-width: 90%;
            height: auto;
        }
    </style>
    <link rel="stylesheet" href="<? echo _URL; ?>/css/profil.css"/>
</head>
<div class="hero">
    <div class="hero-content">
        <h2>Profil działki</h2>
        <hr width="80%"/>
    </div>
    <div class="hero-content-mobile"><h2>Profil działki</h2></div>
</div>
<?php
if ($_GET['ptyp'] == 'sprzedaj') {
    require_once 'action_plot/sprzedaj.php';
} else if ($_GET['ptyp'] == 'edytuj') {
    require_once 'action_plot/edytuj.php';
} else if ($_GET['ptyp'] == 'zabuduj') {
    require_once 'action_plot/zabuduj.php';
} else {

echo '<div class="main">
    <div class="content"> <div class="card">
            ';
echo ($plot->getBuildingId() != '') ? '<div class="card-header">
                <img src="' . $building['avatar_url'] . '" alt="Zdjęcie profilowe" class="profile-img">
            </div>' : '';
echo '<div class="card-body">
                <p class="full-name">';
echo ($plot->getBuildingId() == '') ? 'NIEZABUDOWANA' : $building1;
echo ' </p>
                <p class="username">' . $plot->getTypeName() . '<br> Adres: <b>' . $plot->getAddress() . ', ' . $city['name'] . '</b></p>              
                <p class="desc" >';





$transfer = $_GET['ptyp'];
if ($transfer == 'ZAM_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Miejsce zamieszkania zmienione pomyślnie
</div>';
    if ($transfer == 'BUI_STA') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Rozpoczęto budowę
</div>';
    if ($transfer == 'BUI_MON') echo '
    <div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak środków do budowy
</div>';




echo ($plot->getBuildingId() != '') ? $building['text'] : '';
echo '</p>
            </div>
            <div class="card-footer">
                <div class="col vr">
                    <p><span class="count">' . $plot->getId() . '<br>  </span> ID</p>
                </div>
                                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $city['id'] . '" style="text-decoration: none; color: #1d4e85">(' . $city['id'] . ') ' . $city['name'] . '</a> </span> Miasto</p>
                </div>
                
                <div class="col vr">
                    <p><span class="count"><a href="' . _URL . '/profil/' . $plot->getOwnerId() . '" style="text-decoration: none; color: #1d4e85">(' . $plot->getOwnerId() . ') ' . $owner['name'] . '</a></span> Właściciel</p>
                </div>
<div class="col vr">
                    <p><span class="count">' . $plot->getSquareMeter() . ' m2</a></span>Powierzchnia działki</p>
                </div>
            </div>
            <div class="card-footer">';

if ($plot->getPrice() != '' and $_COOKIE['id'] != '') {
    echo '<div class="col vr">';
    echo ($acc_info['balance'] >= $plot->getPrice()) ? ' 
        <form action="' . _URL . '/profil/' . $id . '/buy" method="post">
        <button class="w3-button"><span class="count">' . $plot->getPrice() . ' kr</span> KUP DZIAŁKE</button>
        </form>
        
                ' : '<button class="w3-button"><span class="count">' . $plot->getPrice() . ' kr</span> NIE MASZ WYSTARCZAJĄCYCH ŚRODKÓW DO ZAKUPU TEJ DZIAŁKI '.$acc_info['balance'].'</button>';
    echo '</div>';
}
echo '</div>
      
            <div class="card-footer">';

echo ($plot->getBuildingId() != '') ? '
                <div class="col vr">
                     <p><span class="count">' . $building['square_meter'] . ' m2</span> Powierzchnia budynku</p>
                </div>                <div class="col vr">
                     <p><span class="count">' . $dataOdbioru . '</span> Data odbioru</p>
                </div> ' : '';


echo ($building['start_build_date'] != '') ? '
                <div class="col vr">
                     <p><span class="count">' . timeToDateTime($building['start_build_date']) . '</span> Data rozpoczęcia budowy</p>
                </div>
                <div class="col vr">
                     <p><span class="count">' . timeToDateTime($building['finish_build_date']) . '</span> Data zakończenia budowy</p>
                </div>
                ' : '';
echo '</div>';

    $color = ($x<5)? 'black' :'';
echo ($building['start_build_date'] != '' AND $build->getDateBuild()=='') ? '

<div class="card-footer">
                <div class="col vr">
                <sub>BUDYNEK ZBUDOWANY W:</sub><p>
                   <div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:' . $x . '%; height: 90px; font-size: 16px; color: ' . $color . '">
      ' . $x . '%     </div>
  </div></p>
</div></div>' : '';
    echo ($x == '100'  AND $build->getDateBuild()=='') ? '
<div class="card-footer">
                <div class="col vr">
                <p><form action="'._URL.'/profil/'.$id.'/odbierz" method="post">
                <button>Odbierz budynek</button></form></p>
</div></div>' : '';

echo ($building['date_build'] != '') ? '
<div class="card-footer">
                <div class="col vr">
                <img src="' . $building['gfx_url'] . '" style="max-width: 60%">
</div></div>' : '';

echo '
        </div></div>
';

}
echo '
<div class="menu">
        <div class="card menucard sticky">';
echo '  <p class=""><a href="' . _URL . '/profil/' . $id . '" style="text-decoration: none;  color: #1d4e85">Profil</a></p>';
$user = new User($_COOKIE['id']);
echo ($_COOKIE['id'] == $plot->getOwnerId() or $global_admin_plot == TRUE) ? '<p>----ZARZADZANIE----</p>' : '';
echo ($_COOKIE['id'] == $plot->getOwnerId() and $plot->getBuildingId() != '' or $global_admin_plot == TRUE) ? '<p class=""><a href="' . _URL . '/profil/' . $id . '/edytuj" style="text-decoration: none;  color: #1d4e85">Edytuj profil</a></p>' : '';
echo ($_COOKIE['id'] == $plot->getOwnerId() or $global_admin_plot == TRUE) ? '<p class=""><a href="' . _URL . '/profil/' . $id . '/sprzedaj" style="text-decoration: none;  color: #1d4e85">Sprzedaj</a></p>' : '';
echo (($_COOKIE['id'] == $plot->getOwnerId() and $id != $user->getPlotId()) or $global_admin_plot == TRUE) ? '<p class=""><a href="' . _URL . '/profil/' . $id . '/zamieszkaj" style="text-decoration: none;  color: #1d4e85">Zamieszkaj</a></p>' : '';
echo (($_COOKIE['id'] == $plot->getOwnerId() or $global_admin_plot == TRUE) and $plot->getBuildingId() == '' ) ? '<p class=""><a href="' . _URL . '/profil/' . $id . '/zabuduj" style="text-decoration: none;  color: #1d4e85">Zabuduj</a></p>' : '';


echo '</div>
    </div>
</div>

';

?>
</html>
