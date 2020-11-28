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
    Create::MediaArticle($id,$_COOKIE['id'],$_POST['title'],$text);
    $link = _URL;
    header("Location: $link/profil/$id/ART_OK");

} else {

    echo '<form class="w3-container" method="post">
    <label class="w3-text-teal"><b>Tytuł</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="title""><br>
    
      <label class="w3-text-teal"><b>Treść</b></label><br>
  <textarea id="myTextarea" name="text" rows="44" cols="20"> </textarea><br>
 
  
  <button class="w3-btn w3-blue-grey">Publikuj</button>'; ?>

    <?php echo'
</form>';
}
echo '</div></div>';
