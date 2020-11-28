<?php
$cash = $oplata['city_create'];
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Tworzenie miasta</h2>
</div>';
if (isset($_POST['name'])) {


    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `bank_account` WHERE owner_id='$id' LIMIT 0,1";
    $from_id = $conn->query($sql)->fetch();

    $status = Bank::transfer($from_id['id'],_KIBANK,$cash,'Opłata za rejestracje miasta w systemie');
    if ($status == 'OK') {
        Create::City($_POST['name'], $info['id'], $info['id'], '', '');
        echo '<p>Dane zostały zmienione pomyślnie<br> Miast '.$_POST['name'].' zostało dodane do profilu kraju</p><br>';
    } else echo'<p>Brak środków na koncie '.$from_id['id'].' <hr></p>';
} else {

    echo '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
  <label class="w3-text-teal"><b>Nazwa miasta</b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="name""><br>
  <p>Wszelki pozostałe dane będą możliwe do edytowania po utworzeniu miasta w jego panelu. <br> Początkowym ID Lidera miasta jest ID Kraju. <Br><br>
   Rejestracja miasta w systemie wiąże się z opłatą techniczną w wysokości: ' . $oplata['city_create'] . ' kr</p>
  
  <button class="w3-btn w3-blue-grey">Dodaj miasto</button>
</form>';
}
echo '</div></div>';