<?php

$plot = new Plot($id);
$build = new PlotBuilding($plot->getBuildingId());

echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Edycja danych profilu kraju/miasta </h2>
</div>';


if (isset($_POST['text'])) {
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
    echo '<p>Dane zostały zmienione pomyślnie</p><br><form action="'._URL.'/profil/'.$id.'"><button>Wróc do profilu</button></form>';
    $text = $_POST['text'];

    $build->setText($text);
    $build->setName($_POST['name']);

    $url_awatar = _URL . '/user_gfx/' . $file_name_sql;
    if ($file_name_sql != '') {
        $build->setAvatarUrl($url_awatar);
    }
    echo $url_awatar;

} else {

    echo '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
  <label class="w3-text-teal"><b>Nazwa budynku</b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="name" value="' . $build->getName() . '"><br>

  
  <label class="w3-text-teal"><b>Treść profilu </b></label><br>
  <textarea id="myTextarea" name="text" class="w3-input w3-border w3-light-grey" rows="4" cols="150">' . $build->getText() . '</textarea><br>
  
  <label class="w3-text-teal"><b>Wgraj avatar</b></label><br>
  <input type="file" class="custom-file-input"  name="plik" multiple="">
  <p> </p>

  <p> </p>
  <button class="w3-btn w3-blue-grey">Dokonaj edycji</button>
</form>';
}
echo '</div></div>';
