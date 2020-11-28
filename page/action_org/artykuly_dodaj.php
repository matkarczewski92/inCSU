<?php
$data_dot = date("Y-m-d");
$id_org_up = $info['owner_id'];
$up_owner = System::getInfo($info['owner_id']);
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Dodawanie artykułów prasowych</h2>
</div>';
if (isset($_POST['title'])) {

    $text = $_POST['text'];
    $data_pub = strtotime($_POST['data_p']);
    $link = _URL;
     $id_art = Create::MediaArticle($id,$_COOKIE['id'],$_POST['title'],$text);
    $max_rozmiar = 3024*3024;
    if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        if ($_FILES['plik']['size'] > $max_rozmiar) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            $file_ext=strtolower(end(explode('.',$_FILES['plik']['name'])));
            $_FILES['plik']['name'] = 'rotator_'.$id_art.'.'.$file_ext;
            $file_name_sql = $_FILES['plik']['name'];

            echo 'ok<br/>';
            if (isset($_FILES['plik']['type'])) {

            }
            move_uploaded_file($_FILES['plik']['tmp_name'],'user_gfx/rotator/'.$_FILES['plik']['name']);
        }
    }
    $url_awatar = _URL.'/user_gfx/rotator/'.$file_name_sql;
    if ($file_name_sql!= '') Create::AddRotator($id_art,$url_awatar,'0');
    header("Location: $link/profil/$id/ART_OK");

} else {
    echo '<form class="w3-container" method="post" ENCTYPE="multipart/form-data">
    <label class="w3-text-teal"><b>Tytuł</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="title""><br>
    
      <label class="w3-text-teal"><b>Treść</b></label><br>
  <textarea id="myTextarea" name="text" rows="44" cols="20"> </textarea><br>';

    echo ' <label class="w3-text-teal"><b>Wgraj grafikę do rotatora</b></label><br><br>
  <input type="file" class="custom-file-input"  name="plik" multiple=""><br><br>
  
  <button class="w3-btn w3-blue-grey">Publikuj</button>'; ?>

    <?php echo'
</form>';
}
echo '</div></div>';
