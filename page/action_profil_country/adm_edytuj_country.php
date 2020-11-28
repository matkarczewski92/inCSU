<?php


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Edycja danych profilu kraju/miasta</h2>
</div>';

if (isset($_POST['tax_personal'])) {
    $max_rozmiar = 1024 * 1024;
    if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        if ($_FILES['plik']['size'] > $max_rozmiar) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            $file_ext = strtolower(end(explode('.', $_FILES['plik']['name'])));
            $_FILES['plik']['name'] = 'herb_' . $id . '.' . $file_ext;
            $file_name_sql = $_FILES['plik']['name'];

            echo '<br/>';
            if (isset($_FILES['plik']['type'])) {

            }
            move_uploaded_file($_FILES['plik']['tmp_name'], 'user_gfx/' . $_FILES['plik']['name']);
        }
    }
    if (is_uploaded_file($_FILES['plik2']['tmp_name'])) {
        if ($_FILES['plik2']['size'] > $max_rozmiar) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            $file_ext = strtolower(end(explode('.', $_FILES['plik2']['name'])));
            $_FILES['plik2']['name'] = 'avatar_' . $id . '.' . $file_ext;
            $file_name_sql2 = $_FILES['plik2']['name'];

            echo $file_name_sql2.'<br/>';
            if (isset($_FILES['plik2']['type'])) {

            }
            move_uploaded_file($_FILES['plik2']['tmp_name'], 'user_gfx/' . $file_name_sql2);
        }
    }
    echo '<p>Dane zostały zmienione pomyślnie</p><br>';
    $text = $_POST['text'];
    update('up_countries', 'id', $_GET['ptyp'], 'tax_personal', $_POST['tax_personal']);
    update('up_countries', 'id', $_GET['ptyp'], 'text', $text);
    update('up_countries', 'id', $_GET['ptyp'], 'webpage_url', $_POST['webpage_url']);

    $url_awatar = _URL . '/user_gfx/' . $file_name_sql;
    if ($file_name_sql != '') {
        update('up_countries', 'id', $_GET['ptyp'], 'arm_url', $url_awatar);
    }
    $url_awatar2 = _URL . '/user_gfx/' . $file_name_sql2;
    if ($file_name_sql2 != '') {
        update('up_countries', 'id', $_GET['ptyp'], 'gfx_url', $url_awatar2);
    }

} else {

    echo '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
  <label class="w3-text-teal"><b>Adres strony WWW</b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="webpage_url" value="' . $info['webpage_url'] . '"><br>
  
  <label class="w3-text-teal"><b>Wysokosc podatku (1% = 0.01, 10% = 0.1) - niedostepne dla miast </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="tax_personal" value="' . $info['tax_personal'] . '"><br>
  
  <label class="w3-text-teal"><b>Treść profilu </b></label><br>
  <textarea id="myTextarea" name="text" class="w3-input w3-border w3-light-grey" rows="4" cols="150">' . $info['text'] . '</textarea><br>
  
  <label class="w3-text-teal"><b>Wgraj herb</b></label><br>
  <input type="file" class="custom-file-input"  name="plik" multiple="">
  <p> </p>
    <label class="w3-text-teal"><b>Wgraj avatar</b></label><br>
  <input type="file" class="custom-file-input"  name="plik2" multiple="">
  <p> </p>
  <p> </p>
  <button class="w3-btn w3-blue-grey">Dokonaj edycji</button>
</form>';
}
echo '</div></div>';
