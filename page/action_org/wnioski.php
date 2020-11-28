<?php


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Składanie wniosków do ' . $info['name'] . '</h2>
</div>';
if (isset($_POST['text'])) {
    echo '<p>Wniosek złożono pomyślnie <br> Gdy wniosek zostanie zatwierdzony otrzymasz wiadomość <hr></p>';
    $prop = System::proposalType_info($_GET['ods']);
    $text = nl2br($_POST['text'], false);
    Create::Proposal($_GET['ods'], $_COOKIE['id'], $id, $prop['name'], $text);
    $text_post = 'Potwierdzenie złożenia wniosku<br>Rodzaj wniosku: ' . $prop['name'] . '<br> Treść wniosku:<br>' . $text;
    Create::Post($id, $_COOKIE['id'], 'Potwierdzenie złożenia wniosku', $text_post);
} else if (isset($_GET['ods'])) {
    $prop = System::proposalType_info($_GET['ods']);
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
    <textarea id="myTextarea" name="text" class="w3-input w3-border w3-light-grey" rows="10" cols="150">'.$prop['schemat'].'</textarea><br>
';
    if ($prop['citizenship'] == '1') echo '<p>Uwaga! Składasz wniosek o obywatelstwo, upewnij się, że spełniasz wszystkie warunki do tego by obywatelstwo mogło zostać nadane.<hr>' . $prop['text2'] . ' </p>';
    echo ' <p></p>
  
  
  <button class="w3-btn w3-blue-grey">Wyślij wniosek</button>
</form>';

} else {
    echo '<p>Wybierz jeden z dostępnych rodzajów wniosków poprzez kliknięcie w jego nazwe </p>
<table border="0" align="center">
   <tr>
        <td width="20" align="center" valign="top">Nr. </td>
        <td width="100" align="center" valign="top">Nazwa</td>
		<td width="400" align="center" valign="top">Opis</td>
    </tr>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_proposal_type` WHERE state_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '<tr>
        <td width="20" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/wnioski/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">#' . $row['id'] . '</a></td>
        <td width="400" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/wnioski/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . '</a></td>
		<td width="600" align="left" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/wnioski/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['text'] . '</a></td>
    </tr>';
    }
    echo '</table><p> <br></p>';
}
echo '</div></div>';
