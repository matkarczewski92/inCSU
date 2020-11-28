<?php
    $user_info = new User($_COOKIE['id']);
    $avatar = $user_info->getAvatarUrl();
    $name = ($_COOKIE['id']!='')? $user_info->getName() : 'Nieznajomy';
    ?>
    <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
        <div class="w3-container w3-row">
            <div class="w3-col s4">
                <img src="<? echo $avatar; ?>" class="w3-circle w3-margin-right" style="width:80px">
            </div>
            <div class="w3-col s8 w3-bar">
                <span>Witaj, <strong><? echo $name; ?></strong></span><br>
                <a href="#" class="w3-bar-item w3-button"><B>WYJŚCIE</B> <i class="fa fa-sign-out"></i></a>
            </div>
        </div>
        <hr>
        <div class="w3-container">   <?php
            $act_home = ($_GET['page'] == '') ? 'w3-blue' : '';
            $act_adm = ($_GET['page'] == 'adm') ? 'w3-blue' : '';
            $act_mies = ($_GET['page'] == 'mieszkancy') ? 'w3-blue' : '';
            $act_org = ($_GET['page'] == 'organizacje') ? 'w3-blue' : '';
            $act_kraj = ($_GET['page'] == 'kraje') ? 'w3-blue' : '';
            $act_miasta = ($_GET['page'] == 'miasta') ? 'w3-blue' : '';
            $act_dzialki = ($_GET['page'] == 'dzialki') ? 'w3-blue' : '';
            $act_budynki = ($_GET['page'] == 'budynki') ? 'w3-blue' : '';
            $act_projekty = ($_GET['page'] == 'projekty') ? 'w3-blue' : '';
            $act_inwestycje = ($_GET['page'] == 'inwestycje') ? 'w3-blue' : '';
            $act_akty = ($_GET['page'] == 'akty') ? 'w3-blue' : '';
            $act_kat_main = ($_GET['page'] == 'kat_main') ? 'w3-blue' : '';
            $act_kat_low = ($_GET['page'] == 'kat_low') ? 'w3-blue' : '';
            $act_config = ($_GET['page'] == 'system') ? 'w3-blue' : '';
            $waliduj = ($_GET['page'] == 'bank_waliduj') ? 'w3-blue' : '';
            $act_bank = ($_GET['page'] == 'bank') ? 'w3-blue' : '';
            $glosowania = ($_GET['page'] == 'glosowania') ? 'w3-blue' : '';

            $sql = "SELECT COUNT(*) FROM `up_plot_blueprints` WHERE accept =  0";
            $stmt_blueprints = $conn->query($sql)->fetch(PDO::FETCH_NUM);
            $icon_blueprints = ($stmt_blueprints[0]!=0)? '<i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red"></i>' : '';

            $sql = "SELECT COUNT(*) FROM `up_user_login_data_cookies` WHERE active =  0";
            $stmt_ip = $conn->query($sql)->fetch(PDO::FETCH_NUM);
            $alert_ipp = ($stmt_ip[0] != 0) ? '<i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red"></i> ' : '';


            echo '</div>
    <div class="w3-bar-block">';
            echo '    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black"
           onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>';


            echo '<a href="'._URL.'/thkxadmin/" class="w3-bar-item w3-button w3-padding ' . $act_home . '"><i class="fa fa-users fa-fw"></i> HOME</a>';
            echo (in_array("1", $acces)) ? '<a href="'._URL.'/thkxadmin/system" class="w3-bar-item w3-button w3-padding ' . $act_config . '"><i class="fa fa-cog fa-fw"></i>[1] SYSTEM</a> ' : ''; // 1
            echo (in_array("1", $acces)) ? '<a href="'._URL.'/thkxadmin/adm" class="w3-bar-item w3-button w3-padding ' . $act_adm . '"><i class="fa fa-cog fa-fw"></i>[1] ADMINISTRACJA</a> ' : ''; // 1
            echo '  <center><b>PROFILE</b></center>';
            echo (in_array("2", $acces)) ? '  <a href="'._URL.'/thkxadmin/mieszkancy" class="w3-bar-item w3-button w3-padding ' . $act_mies . '"><i class="fa fa-users fa-fw"></i>[2] Mieszkańcy '.$alert_ipp.'</a>' : ''; // 2
            echo (in_array("3", $acces)) ? '  <a href="'._URL.'/thkxadmin/organizacje" class="w3-bar-item w3-button w3-padding ' . $act_org . '"><i class="fa fa-sitemap fa-fw"></i>[3] Organizacje</a>' : ''; // 3
            echo (in_array("4", $acces)) ? ' <a href="'._URL.'/thkxadmin/kraje" class="w3-bar-item w3-button w3-padding ' . $act_kraj . '"><i class="fa fa-map fa-fw"></i>[4] Kraje</a>' : ''; // 4
            echo (in_array("5", $acces)) ? ' <a href="'._URL.'/thkxadmin/miasta" class="w3-bar-item w3-button w3-padding ' . $act_miasta . '"><i class="fa fa-bandcamp fa-fw"></i>[5] Miasta</a>' : ''; // 5
            echo (in_array("6", $acces)) ? ' <a href="'._URL.'/thkxadmin/dzialki" class="w3-bar-item w3-button w3-padding ' . $act_dzialki . '"><i class="fa fa-bullseye fa-fw"></i>[6] Działki</a>' : '';// 6
            echo '  <center><b>POSIADANIE</b></center>';
            echo (in_array("7", $acces)) ? '  <a href="'._URL.'/thkxadmin/budynki" class="w3-bar-item w3-button w3-padding ' . $act_budynki . '"><i class="fa fa-bank fa-fw"></i>[7] Budynki</a>' : ''; // 7
            echo (in_array("8", $acces)) ? '  <a href="'._URL.'/thkxadmin/projekty" class="w3-bar-item w3-button w3-padding ' . $act_projekty . '"><i class="fa fa-bell fa-fw"></i>[8] Projekty '.$icon_blueprints.'</a>' : ''; // 8
            echo (in_array("9", $acces)) ? '  <a href="'._URL.'/thkxadmin/inwestycje" class="w3-bar-item w3-button w3-padding ' . $act_inwestycje . '"><i class="fa fa-diamond fa-fw"></i>[9] Inwestycje</a>' : ''; // 9
            echo '  <center><b>PRAWO</b></center>';
            echo (in_array("10", $acces)) ? '  <a href="'._URL.'/thkxadmin/akty" class="w3-bar-item w3-button w3-padding ' . $act_akty . '"><i class="fa fa-history fa-fw"></i>[10] Akty</a>' : ''; // 10
            echo (in_array("11", $acces)) ? '  <a href="'._URL.'/thkxadmin/kat_main" class="w3-bar-item w3-button w3-padding ' . $act_kat_main . '"><i class="fa fa-cog fa-fw"></i>[11] Kategorie wyższe</a>' : ''; // 11
            echo (in_array("12", $acces)) ? '  <a href="'._URL.'/thkxadmin/kat_low" class="w3-bar-item w3-button w3-padding ' . $act_kat_low . '"><i class="fa fa-cog fa-fw"></i>[12] Kategorie niższe</a> ' : ''; // 12
            echo '  <center><b>BANK</b></center>';
            echo (in_array("13", $acces)) ? '  <a href="'._URL.'/thkxadmin/bank" class="w3-bar-item w3-button w3-padding ' . $act_bank . '"><i class="fa fa-cog fa-fw"></i>[13] Rachunki bankowe</a> ' : ''; // 13
            echo (in_array("14", $acces)) ? '  <a href="'._URL.'/thkxadmin/bank_waliduj" class="w3-bar-item w3-button w3-padding ' . $waliduj . '"><i class="fa fa-cog fa-fw"></i>[14] Walidacja</a> ' : ''; // 14
            echo '  <center><b>GŁOSOWANIA</b></center>';
            echo (in_array("16", $acces)) ? '  <a href="'._URL.'/thkxadmin/glosowania" class="w3-bar-item w3-button w3-padding ' . $glosowania . '"><i class="fa fa-cog fa-fw"></i>[16] GŁOSOWANIA</a> ' : ''; // 13
            echo '  <center><b>KONTROLA</b></center>';
            echo (in_array("15", $acces)) ? '  <a href="'._URL.'/thkxadmin/ipalert" class="w3-bar-item w3-button w3-padding ' . $act_kat_low . '"><i class="fa fa-cog fa-fw"></i>[15] IP/HOST</a> ' : ''; // 15
            echo '<br><hr><BR>';
            echo '</div>';

            ?>
    </nav>

    <?php
