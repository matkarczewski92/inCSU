<?php
$data_dot = date("Y-m-d");
$id_org_up = $info['owner_id'];
$up_owner = System::getInfo($info['owner_id']);
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Dodawanie aktów prawnych</h2>
</div>';
if (isset($_POST['name'])) {
    $text = $_POST['editor1'];
    $data_pub = strtotime($_POST['data_p']);
    Create::Law('',$_POST['id_cat_low'],$_POST['name'],$text,$_COOKIE['id'], $id, $data_pub);
    echo'<p>Dodano pomyślnie </p>';

} else {

    echo '<form class="w3-container" method="post">
    <label class="w3-text-teal"><b>Umiejscowienie aktu prawnego '.$up_owner['name'].'</b></label><br>
    <select name="id_cat_low">';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `law_category_main` WHERE state_id = '$id_org_up'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $sql1 = "SELECT * FROM `law_category_low` WHERE id_main = '$row[id]'";
        $sth1 = $conn->query($sql1);
        while ($row1 = $sth1->fetch()) {
            echo '<option value="' . $row1['id'] . '"><p align="left">&nbsp;&nbsp;-&nbsp;&nbsp;' . $row1['name'] . '</p></option>';
        }
    }


    echo '</select><br>
    <label class="w3-text-teal"><b>Nazwa aktu prawnego</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="name""><br>
    
      <label class="w3-text-teal"><b>Treść aktu </b></label><br>
  <textarea id="myTextarea" name="editor1" rows="44" cols="20"> </textarea><br>

<label class="w3-text-teal"><b>Data publblikacji</b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="date" style="width: 350px" name="data_p" value="'.$data_dot.'"><br>
  
  
  <button class="w3-btn w3-blue-grey">Publikuj akt</button>'; ?>

    <?php echo'
</form>';
}
echo '</div></div>';
