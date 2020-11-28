<?php
$conn = pdo_connect_mysql_up();
$sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$_COOKIE[id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        $bank_to = $row12['id'];
    }
$sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$_GET[ptyp]'";
$sth1 = $conn->query($sql1);
$licznik = 0;
while ($row1 = $sth1->fetch()) {
    $tax_account = $row1['id'];
}
    $acc_info = Bank::account_info($bank_to);


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Składanie wniosków do ' . $info['name'] . '</h2>
</div>';

if (isset($_POST['text']) AND $_GET['ods']!='MONEY') {
    $prop = System::proposalType_info($_GET['ods']);

        $bank =  Bank::transfer($bank_to,$tax_account,$prop['cost'],'Opłata za złożenie wniosku');
        if($bank == 'OK'){
         echo '<p>Wniosek złożono pomyślnie <br> Gdy wniosek zostanie zatwierdzony otrzymasz wiadomość <hr></p>';
        $text = nl2br($_POST['text'], false);
        Create::Proposal($_GET['ods'], $_COOKIE['id'], $id, $prop['name'], $text);
        $text_post = 'Potwierdzenie złożenia wniosku<br>Rodzaj wniosku: ' . $prop['name'] . '<br> Treść wniosku:<br>' . $text;
        Create::Post($id, $_COOKIE['id'], 'Potwierdzenie złożenia wniosku', $text_post);
    } else header('Location: '._URL.'/profil/wniosek/'.$_GET['ptyp'].'/MONEY/'.$tax_account);
} else if (isset($_GET['ods'])  AND $_GET['ods']!='MONEY') {
    $prop = System::proposalType_info($_GET['ods']);
    if($acc_info['balance']>=$prop['cost']) {
        echo '<form class="w3-container" method="post"
  
    <label class="w3-text-teal"><b>Rodzaj wniosku </b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="name" value="' . $prop['name'] . '" disabled><br>
    
    <label class="w3-text-teal"><b>ID składającego</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="id" value="' . $_COOKIE['id'] . ' ' . $user_info['name'] . '" disabled><br>
    
    <label class="w3-text-teal"><b>Odbiorca</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="from_id" value="' . $id . ' - ' . $info['name'] . '" disabled><br>
    
    <label class="w3-text-teal"><b>Data złożenia wniosku</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="salary" value="' . timeToDateTime(time()) . '" disabled><br>  
    
    <label class="w3-text-teal"><b>Treść wniosku:</b></label><br>
    <textarea id="myTextarea" name="text" class="w3-input w3-border w3-light-grey" rows="10" cols="150">' . $prop['schemat'] . '</textarea><br>
';
        echo ($prop['citizenship'] == '1') ? '<p>Uwaga! Składasz wniosek o obywatelstwo, upewnij się, że spełniasz wszystkie warunki do tego by obywatelstwo mogło zostać nadane. </p>' : '';
        echo ($prop['citizenship'] == '2') ? '<p>Uwaga! Składasz wniosek o pozbawienie tytułu i praw obywatela  </p>' : '';
        echo ($prop['cost'] != '0')?  '<center>
<div class="alert warning" style="width: 80%;">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Wysyłając wniosek system automatycznie pobierze wymaganą kowtę ('.$prop['cost'].' kr) z twojego konta. W przypadku braku środków na koncie, wniosek nie zostanie wysłany.</div></center>' : '';



        echo ' <p></p>
  <button class="w3-btn w3-blue-grey">Wyślij wniosek</button>
</form>';
    } else header('Location: '._URL.'/profil/wniosek/'.$_GET['ptyp'].'/MONEY');
} else {
    $transfer = $_GET['ods'];
    if ($transfer == 'MONEY') echo '
<div class="alert warning">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Brak środków na koncie do złożenia tego wniosku</div>';
    echo '<p>Wybierz jeden z dostępnych rodzajów wniosków poprzez kliknięcie w jego nazwe </p>
<table border="0" align="center">
   <tr>
        <td width="10%" align="center" valign="top">Nr. </td>
        <td width="30%" align="center" valign="top">Nazwa</td>
		<td width="40%" align="center" valign="top">Opis</td>
		<td width="20%" align="center" valign="top">Koszt złożenia wniosku</td>
    </tr>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_proposal_type` WHERE state_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '<tr>
        <td width="10%" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/wniosek/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">#' . $row['id'] . '</a></td>
        <td width="30%" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/wniosek/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . '</a></td>
		<td width="40%" align="left" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/wniosek/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['text'] . '</a></td>
		<td width="20%" align="left" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/wniosek/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['cost'] . ' kr</a></td>
		
    </tr>';
    }
    echo '</table><p> <br></p>';
}
echo '</div></div>';
