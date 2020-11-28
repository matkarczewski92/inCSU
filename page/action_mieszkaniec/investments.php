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
<style>
    a {
        text-decoration: none;
        color: #1d4e85;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font: 16px Arial;
    }

    /*the container must be positioned relative:*/
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    option, select {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }


    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
</style><?php
$user_inv = System::userInvest($id);
$conn = pdo_connect_mysql_up();
$sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$_COOKIE[id]'  LIMIT 0,1";
$sth12 = $conn->query($sql12);
while ($row12 = $sth12->fetch()) {
    $bank_to_netto = $row12['id'];
}

echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal w3-white">
  <h2><br>Moje inwestycje</h2>
</div><p align="justify" style="margin-left: 10px; margin-right: 10px">Inwestycje to system zarobkowy w Centralnym Systemie Unii, który gwarantuje Tobie stały dopływ gotówki, którą będziesz mógł wypłacić w określonych odstępach czasu. 
Aby wykupić Inwestycje kliknij dodaj, na chwile obecną dostępna jest tylko jedna opcja. Okres zwrotu inwestycji na poziomie 1, 
gwarantuje zwrot zainwestowanych środków już po 100 dniach, każdy poziom zwiększa kwotę wypłaty. </p>';


    $idp = explode(":::", $_GET['ods']);


if ($idp[0] == 'add_in') {
    $ac = Bank::account_info($bank_to_netto);
    if ($ac['balance']>='10000'){
        Create::Investment($_COOKIE['id'],'1', $bank_to_netto);
        header('Location: '._URL.'/profil/investments/'.$_GET['ptyp']);
    } else header('Location: '._URL.'/profil/investments/'.$_GET['ptyp'].'/MONEY');

} else if ($idp[0] == 'lvl_up') {
        $inv = new Investments($idp[1]);
        $bank = $inv->lvlUp($bank_to_netto);
        $res = ($bank=='OK')? 'UP_OK' : $bank;
        header('Location: '._URL.'/profil/investments/'.$_GET['ptyp'].'/'.$res);
    } else if ($idp[0] == 'get') {
    $timest = time();
        $inv1 = new Investments($idp[1]);
        if($inv1->getNextGet() <= $timest){
            $x = $inv1->moneyGet();
            header('Location: '._URL.'/profil/investments/'.$_GET['ptyp'].'/GET_OK/'.$idp[1]);
        } else header('Location: '._URL.'/profil/investments/'.$_GET['ptyp'].'/GET_ERR/'.$inv1->getNextGet().'/'.$timest);

    }else {
        $transfer = $_GET['ods'];
        if ($transfer == 'UP_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Poziom inwestycji został zwiększony
</div>';
        if ($transfer == 'MONEY') echo '
    <div class="alert alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak wystarczających środków na koncie głównym
</div>';
        if ($transfer == 'GET_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Przychód z inwestycji został zebrany pomyślnie
</div>';
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_user_investments` WHERE user_id = '$_COOKIE[id]'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $user_inv = new Investments($row['id']);
            $last_get = $user_inv->getLastGet();
            $next_get = $user_inv->getNextGet();
            $x = number_format(((($user_inv->getFreq()-($next_get - time())) * 100) / 604800), '2');
            echo '<br><table border="0" width="95%" align="center" style=" border: 1px solid black;">
    <tr>
        <td width="20%" valign="middle">#' . $user_inv->getInvId() . '<br><sup>ID Inwestycji</sup> </td>
        <td width="20%" valign="middle">' . $user_inv->getActualLevel() . '<br><sup>Poziom</sup> </td>
        <td width="20%" valign="middle">'.($user_inv->getFreq()/(60*60*24)).'<br><sup>Częstotliwość:</sup> </td>
        <td width="20%" valign="middle"> ' . $user_inv->getActualMoney() . ' kr<br><sup>Kwota:</sup></td>
        <td width="20%" valign="middle" rowspan="2">';
        $ac = Bank::account_info($bank_to_netto);
            echo ($user_inv->getLvlUpCost()<=$ac['balance'])? '<form action="' . _URL . '/profil/investments/' . $_GET['ptyp'] . '/lvl_up:::' . $row['id'] . '" method="post"><button class="w3-btn w3-green" style="height: 80px; font-size: 16px;"><b>Zwiększ poziom<br>(' . $user_inv->getLvlUpCost() . ' kr)</b></button></form>': '<button class="w3-btn w3-green" style="height: 90px; font-size: 16px;"><b>BRAK ŚRODKÓW NA KONCIE<br>(' . $user_inv->getLvlUpCost() . ' kr)</b></button>';

            echo '</td>
        
    </tr>
    <tr>
        <td width="20%" bgcolor="#4CAF50"" style="color: white" valign="middle">' . $user_inv->getLvlUpCost() . ' kr<br><sup>Koszt zwiększenia poziomu</sup></td>
        <td width="20%" bgcolor="#4CAF50"" style="color: white" valign="middle">' . $user_inv->getNextLevelMoney() . ' kr <br><sup>Przychód na następnym poziomie</sup></td>
        <td width="20%" valign="middle">' . timeToDateTime($user_inv->getLastGet()) . '<br><sup>Ostatnia wypłata</sup></td>
        <td width="20%" valign="middle">' . timeToDateTime($user_inv->getNextGet()) . '<br><sup>Następna wypłata</sup></td>
    </tr>
    <tr>
        <td width="100%" colspan="5">';
            if ($x<'100') {
                $color = ($x<4)? 'black' : 'white';
                echo ' <br> <div class="progress">    
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:' . $x . '%; height: 90px; font-size: 16px; color: '.$color.'">
      ' . $x . '%     </div>
  </div>';
            } else echo '<form action="' . _URL . '/profil/investments/' . $_GET['ptyp'] . '/get:::' . $row['id'] . '" method="post"><button class="w3-btn w3-green" style="font-size: 16px;"><b>Zbierz ( ' . $user_inv->getActualMoney() . ' kr )</b></button></form>';
            $bonus = (System::czyLogowal($id, ($user_inv->getFreq()/(60*60*24)))==1)? 'TAK +10%' : 'NIE';
            echo '<p>Premia za codzienne logowanie: '.$bonus.'</p></td>

    </tr>
</table>';

        }


    }


echo (System::userInvest($id)<10)? '<br><table border="0" width="95%" align="center">
    <tr>
        <td width="100%" align="center" valign="middle"><a href="' . _URL . '/profil/investments/' . $_GET['ptyp'] . '/add_in"> <H5><img src="'._URL.'/img/plus.png" width="50px" height="50px" align="middle"> <BR><BR> DODAJ INWESTYCJE (10 000 KR)</H5></a></td> 
    </tr>
</table>' : '<table border="0" width="95%" align="center">
    <tr>
        <td width="100%" align="center" valign="middle"><h5>Osiągnięto limit 10 inwestycji<br>Brak możliwość założenia kolejnej inwestycji</h5></td> 
    </tr>
</table>';


echo '<hr></div></div>';
