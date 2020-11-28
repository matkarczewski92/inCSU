<?php
$conn = pdo_connect_mysql_up();
$time_ss = timeToDate(time());
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class=" ">
  <h2><br>Wnioski</h2>
</div>';


if (isset($_GET['ods']) AND $_GET['ods']!='APPR' AND $_GET['ods']!='DEC') {
    $proposal_info = System::proposal_info($_GET['ods']);
    $user_info = System::getInfo($proposal_info['user_id']);
    $proposal_type = System::proposalType_info($proposal_info['proposal_id']);
    if (isset($_POST['submit'])) {
        $akt_title = ($_POST['submit'] == 'appr') ? $proposal_type['tytul_zatwierdzenie'] : $proposal_type['tytul_odmowa'];
        $akt = ($_POST['submit'] == 'appr') ? 'tresc_aktu_zatwierdzenie' : 'tresc_aktu_odrzucenie';
        $tresc = str_replace(':user_name:', $user_info['name'], $proposal_type[$akt]);
        $tresc = str_replace(':user_id:', $proposal_info['user_id'], $tresc);
        $tresc = str_replace(':data:', $time_ss, $tresc);

        if ($proposal_type['citizenship'] == '1' AND $_POST['submit']=='appr' ) {
            $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id='$user_info[id]' AND state_id='$_GET[ptyp]'";
            $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
            if ($stmt[0] == 0) Create::Citizenship($user_info['id'], $_GET['ptyp']);
        } else if ($proposal_type['citizenship'] == '2' AND $_POST['submit']=='appr') {
            $sql = "DELETE FROM `up_user_citizenship` WHERE user_id='$user_info[id]' AND state_id='$_GET[ptyp]'";
            $conn->query($sql);
        }

        if($proposal_type['lenno']==1 AND $_POST['submit']=='appr'){
            Create::Organization('3',$_POST['lenno'],' ',$user_info['id'],' ','0','0',$user_info['id'],$_GET['ptyp'],'','');
        }

        if ($_POST['law']=='on' AND $_POST['submit']=='appr'){
            Create::Law(' ',$proposal_type['kat_aktu'],$akt_title,$tresc,$_COOKIE['id'],$_GET['ptyp'],time());
        }

        $count = ($_POST['submit'] == 'appr')? '1' : '2';
        update('up_proposal','id',$_GET['ods'],'done',$count);
        $post_tresc = ($_POST['submit'] == 'appr')? 'Twój wniosek został rozpatrzony POZYTYWNIE' : 'Twój wniosek rostał ODRZUCONY';
        Create::Post($_GET['ptyp'],$user_info['id'],' ',$post_tresc);
        header('Location: '._URL.'/profil/adm_wnioski/'.$_GET['ptyp'].'/APPR');

    } else {
        echo ($proposal_type['cost'] != 0) ? '<h5>Wniosek został opłacony przez wnioskodawcę kwotą ' . $proposal_type['cost'] . ' kr</h5>' : '';
        echo ' <form method="post"><table width="95%" align="center" height="119">
    <tr>
        <td width="50%" height="26">#' . $proposal_info['id'] . ' - ' . $proposal_info['title'] . '</td>
        <td width="30%" height="26">' . $user_info['id'] . ' - ' . $user_info['name'] . '</td>
        <td width="20%" height="26">' . timeToDateTime($proposal_info['date']) . '</td>
    </tr>
    <tr>
        <td width="100%" colspan="3" align="left">' . $proposal_info['text'] . '</td>
    </tr>
    <tr><td width="100%" colspan="3" align="center" >';

        if($proposal_type['lenno']==1){
            echo 'Podaj nazwę nadawanego lenna: &nbsp;&nbsp;<input type="text" name="lenno" style="width: 50%">';
        }
           if ($proposal_type['kat_aktu']!='0' AND $proposal_type['kat_aktu']!='') echo'<br>Czy opublikować akt prawny zgodnie ze schematem?  <input type="checkbox" name="law">';
   echo' </td></tr>
    <tr>
        <td width="100%" colspan="3">';

        echo ($proposal_type['citizenship'] == 1) ? ' <button class="w3-button w3-green" name="submit" value="appr" style="width: 20%">Zatwierdź i nadaj</button>' : '';
        echo ($proposal_type['citizenship'] == 2) ? ' <button class="w3-button w3-dark-grey" name="submit" value="appr" style="width: 20%">Zatwierdź i odbierz</button>' : '';
        echo ($proposal_type['citizenship'] == 0) ? '  <button class="w3-button w3-green" name="submit" value="appr" style="width: 20%">Zatwierdź</button>' : '';
        echo ' <button class="w3-button w3-red" name="submit" value="dec" style="width: 20%">Odrzuć</button>';
        echo '</form></td>
    </tr>
</table> ';

    }
} else {


    echo '<h5>Wnioski nowe</h5><table width="80%" align="center"><tr>
        <td width="10%" style="border-bottom-width:1px; border-bottom-style:solid;">ID</td>
        <td width="25%" style="border-bottom-width:1px; border-bottom-style:solid;">Wnioskodawca</td>
        <td width="50%" style="border-bottom-width:1px; border-bottom-style:solid;">Tytuł</td>
        <td width="15%" style="border-bottom-width:1px; border-bottom-style:solid;">&nbsp;</td>
    </tr>';
    $sql = "SELECT * FROM `up_proposal` WHERE organizations_id = '$id' AND `done` = '0'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $user = ($row['user_id']!='')? System::getInfo($row['user_id']) :'';
        echo '<tr>
        <td width="10%" style="border-bottom-width:1px; border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski/' . $_GET['ptyp'] . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">#' . $row['id'] . '</a></td>
        <td width="25%" style="border-bottom-width:1px; border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski/' . $_GET['ptyp'] . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $user['id'] . ' - ' . $user['name'] . '</a></td>
        <td width="50%" style="border-bottom-width:1px; border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski/' . $_GET['ptyp'] . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['title'] . '</a></td>
        <td width="15%" style="border-bottom-width:1px; border-bottom-style:solid;">&nbsp;</td>
    </tr>';
    }
    echo '</table><h5>Wnioski archiwalne</h5>';

    echo '<table width="80%" align="center"><tr>
        <td width="10%" style="border-bottom-width:1px; border-bottom-style:solid;">ID</td>
        <td width="25%" style="border-bottom-width:1px; border-bottom-style:solid;">Wnioskodawca</td>
        <td width="50%" style="border-bottom-width:1px; border-bottom-style:solid;">Tytuł</td>
        <td width="15%" style="border-bottom-width:1px; border-bottom-style:solid;">&nbsp;</td>
    </tr>';
    $sql = "SELECT * FROM `up_proposal` WHERE organizations_id = '$id' AND `done`!='0'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $user = ($row['user_id']!='')? System::getInfo($row['user_id']) :'';
        echo '<tr>
        <td width="10%" style="border-bottom-width:1px; border-bottom-style:solid;">$' . $row['id'] . '</td>
        <td width="25%" style="border-bottom-width:1px; border-bottom-style:solid;">' . $user['id'] . ' - ' . $user['name'] . '</td>
        <td width="50%" style="border-bottom-width:1px; border-bottom-style:solid;">' . $row['title'] . '</td>
        <td width="15%" style="border-bottom-width:1px; border-bottom-style:solid;">&nbsp;</td>
    </tr>';
    }
    echo '</table>';
}
echo '<p><hr></p></div></div>';
