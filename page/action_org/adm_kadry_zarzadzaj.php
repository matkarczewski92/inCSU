 <?php


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Zarządzanie kadrą</h2>
</div>';
 if ($_GET['ods'] == 'HR_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Dane zostały zmienione pomyślnie
</div>';
 if(isset($_GET['ods']) AND $_GET['ods']!='HR_OK'){

     update('up_organizations_workers','id',$_GET['ods'],'law',$law2 = ($_POST['law']=='on')? '1' : '0');
     update('up_organizations_workers','id',$_GET['ods'],'proposal',$proposal2 = ($_POST['proposal']=='on')? '1' : '0');
     update('up_organizations_workers','id',$_GET['ods'],'edit',$edit2 = ($_POST['edit']=='on')? '1' : '0');
     update('up_organizations_workers','id',$_GET['ods'],'bank',$bank2 = ($_POST['bank']=='on')? '1' : '0');
     update('up_organizations_workers','id',$_GET['ods'],'org',$org2 = ($_POST['org']=='on')? '1' : '0');
     update('up_organizations_workers','id',$_GET['ods'],'workers',($workers2 = ($_POST['workers']=='on')? '1' : '0'));
     update('up_organizations_workers','id',$_GET['ods'],'org_id',$_POST['org_id']);
     update('up_organizations_workers','id',$_GET['ods'],'salary',$_POST['salary']);
     update('up_organizations_workers','id',$_GET['ods'],'frequency_days',$_POST['frequency_days']);
     update('up_organizations_workers','id',$_GET['ods'],'name',$_POST['name_of']);
    $url = _URL;
    header("Location: $url/profil/adm_kadry_zarzadzaj/$_GET[ptyp]/HR_OK");

 } else {
echo'<table width="95%^" cellpadding="0" cellspacing="0" ALIGN="CENTER">
    <tr>
        <td width="3%">ID</td>
        <td width="25%">IMIE I NAZWISKO</td>
        <td width="25%">STANOWISKO</td>
        <td width="10%">OD</td>
        <td width="10%">DO</td>
        <td width="3%"><span class="material-icons" title="Zdolnośc publikacji i edycji praw organizacji">gavel</span></td>
        <td width="3%"><span class="material-icons"  title="Dostęp do rachunków bankowych organizacji">account_balance</span></td>
        <td width="3%"><span class="material-icons"  title="Zdolność rozpatrywania wniosków i czytania wiadomości PW">description</span></td>
        <td width="3%"><span class="material-icons"  title="Możliwość edycji profilu">create</span></td>
        <td width="3%"><span class="material-icons" title="Możliwość zarządzania pracownikami">engineering</span></td>
        <td width="3%"><span class="material-icons" title="Możliwość zarządzania organizacjami">shop</span></td>
        <td width="10%">ID ORG</td>
        <td width="10%">&nbsp;</td>
    </tr>';

    $sql = "SELECT * FROM `up_organizations_workers` WHERE organizations_id = '$id' AND until_date > '$timed' GROUP BY user_id ORDER BY `id`";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $usr1 = System::user_info($row['user_id']);
        $law1 = ($row['law'] == 1) ? 'checked' : '';
        $proposal1 = ($row['proposal'] == 1) ? 'checked' : '';
        $edit1 = ($row['edit'] == 1) ? 'checked' : '';
        $bank1 = ($row['bank'] == 1) ? 'checked' : '';
        $workers1 = ($row['workers'] == 1) ? 'checked' : '';
        $org1 = ($row['org'] == 1) ? 'checked' : '';


        echo '<form action="' . _URL . '/profil/adm_kadry_zarzadzaj/' . $_GET['ptyp'] . '/' . $row['id'] . '" method="post">
    <tr>
        <td width="3%">' . $row['id'] . '</td>
        <td width="25%">' . $usr1['name'] . '</td>
        <td width="25%"><input class="w3-input w3-border w3-light-grey" type="text" name="name_of" value="' . $row['name'] . '" style="width: 250px"></td>
        <td width="10%">' . timeToDate($row['from_date']) . '</td>
        <td width="10%">' . timeToDate($row['until_date']) . '</td>
        <td width="3%"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="law" ' . $law1 . '></td>
        <td width="3%"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="bank" ' . $bank1 . '></td>
        <td width="3%"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="proposal" ' . $proposal1 . '></td>
        <td width="3%"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="edit" ' . $edit1 . '></td>
        <td width="3%"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="workers" ' . $workers1 . '></td>
        <td width="3%"><input class="w3-input w3-border w3-light-grey" type="checkbox" name="org" ' . $org1 . '></td>
        <td width="10%"><input class="w3-input w3-border w3-light-grey" type="text" name="org_id" value="' . $row['org_id'] . '" style="width: 50px"></td>
        <td width="10%" rowspan="2"> <button class="w3-btn w3-blue-grey" >Zapisz</button></td>
    </tr>    <tr>
        <td width="30%" colspan="2" style="border-bottom-width:1px; border-bottom-style:solid;">Następna wypłata: <b>'.timeToDate(($row['last_salay_date'])+($row['frequency_days']*60*60*24)).'</b></td>
        <td width="10%" colspan="1" style="border-bottom-width:1px; border-bottom-style:solid;">Wysokość wynagrodzenia</td>
        <td width="10%" colspan="2" align="left" style="border-bottom-width:1px; border-bottom-style:solid;"><input class="w3-input w3-border w3-light-grey" type="text" name="salary" value="' . $row['salary'] . '" style="width: 100px">kr</td>
        <td width="10%" colspan="4" style="border-bottom-width:1px; border-bottom-style:solid;">Częstotliwość</td>
        <td width="10%" colspan="3"  style="border-bottom-width:1px; border-bottom-style:solid;">co &nbsp;&nbsp; <input class="w3-input w3-border w3-light-grey" type="text" name="frequency_days" value="' . $row['frequency_days'] . '" style="width: 25px"> dni</td>
        

    </tr></form>';

    }
    echo '</table>';
}
echo '</div></div>';
?>
