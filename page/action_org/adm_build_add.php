<?php
$data_dot = date("Y-m-d");

$id_org_up = $info['owner_id'];
$up_owner = System::getInfo($info['owner_id']);
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Dodawanie projektów budowlanych</h2>
</div>';
if (isset($_POST['name'])) {
    $max_rozmiar = 3024 * 3024;
    if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        if ($_FILES['plik']['size'] > $max_rozmiar) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            $file_ext = strtolower(end(explode('.', $_FILES['plik']['name'])));
            $_FILES['plik']['name'] = 'blueprint_' . $id_art . '.' . $file_ext;
            $file_name_sql = $_FILES['plik']['name'];

            echo 'ok<br/>';
            if (isset($_FILES['plik']['type'])) {

            }
            move_uploaded_file($_FILES['plik']['tmp_name'], 'user_gfx/rotator/' . $_FILES['plik']['name']);
        }
    }
    $url_awatar = _URL . '/user_gfx/rotator/' . $file_name_sql;
    if ($file_name_sql != '') {
        $duration = ($_POST['metrage'] / $oplata['m2_time'])*$info_build['time_multiplier'];
        $adm_cost = ($_POST['metrage'] * $oplata['m2_cost'])*$info_build['cost_multiplier'];
        Create::Blueprint($_POST['name'], $url_awatar, $_POST['metrage'], $_POST['price'], $duration, $adm_cost, $id, $_POST['plot_id']);
    }
    header('Location: ' . _URL . '/profil/' . $id . '/PROJ_DOD');

} else {
    if(System::blueprintsOrgCounter($id)<$info_build['build_limit']){
    echo '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
    <label class="w3-text-teal"><b>Tytuł</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="name"><br>
        <label class="w3-text-teal"><b>Powierzchnia budynku - m2</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="metrage"><br>
        <label class="w3-text-teal"><b>Cena projektu <br>(do ceny zostanie dodana opłata adm. ' . $oplata['m2_cost'] . ' kr x m2)</b></br></label>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="price"><br>
        <label class="w3-text-teal"><b>Jeżeli jest to projekt indywidualny wprowadź id działki</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="plot_id"><br>

    <label class="w3-text-teal"><b>Wgraj grafikę budynku</b></label><br><br>
  <input type="file" class="custom-file-input"  name="plik" multiple=""><br><br>
  <h3>Czas budowy wyliczany jest na podstawie wzoru: <br>dni budowy = (powierzchnia budynku / ' . $oplata['m2_time'] . ')*mnożnik czasu budowy przedsiębiorstwa  </h3>
  <button class="w3-btn w3-blue-grey">Publikuj</button>'; ?>

    <?php echo '
</form>';
} else echo '    <div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Limit projektów wykorzystany</div>';
}
echo '</div></div>';
