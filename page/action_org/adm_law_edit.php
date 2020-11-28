<?php

$law_info = System::getLaw($_GET['ods']);
$data_dot = date("Y-m-d",$law_info['date']);
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Edycja aktu prawnego</h2>
</div>';
if(isset($_GET['ods'])){
    if($_GET['ptyp']==$law_info['state_id']){
        if (isset($_POST['name'])) {
            $text = $_POST['editor1'];
            if ($_POST['uchyl']=='on') $uchyl = '1'; else  $uchyl = '0';
            $data_pub = strtotime($_POST['data_p']);
            echo'<p>Edytowano pomyślnie <Br>
    <a href="'._URL.'/prawo/pokaz/'.$_GET['ods'].'">Zobacz swój dokument</a><hr></p>';
            update('law_article','id',$_GET['ods'],'id_cat_low',$_POST['id_cat_low']);
            update('law_article','id',$_GET['ods'],'name',$_POST['name']);
            update('law_article','id',$_GET['ods'],'text',$_POST['editor1']);
            update('law_article','id',$_GET['ods'],'date',$data_pub);
            update('law_article','id',$_GET['ods'],'actual',$uchyl);

        } else {
            $law_id_cat = System::getLawCatLow($law_info['id_cat_low']);

            echo '<form class="w3-container" method="post">
    <label class="w3-text-teal"><b>Umiejscowienie aktu prawnego </b></label><br>
    <select name="id_cat_low">
    <option value="' . $law_id_cat['id'] . '"><p align="left">&nbsp;&nbsp;-&nbsp;&nbsp;' . $law_id_cat['name'] . '</p></option>';
            $conn = pdo_connect_mysql_up();
            $sql = "SELECT * FROM `law_category_main` WHERE state_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {

                $sql = "SELECT * FROM `law_category_low` WHERE id_main = '$row[id]'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    echo '<option value="' . $row['id'] . '"><p align="left">&nbsp;&nbsp;-&nbsp;&nbsp;' . $row['name'] . '</p></option>';
                }
            }



            echo '</select><br>
    <label class="w3-text-teal"><b>Nazwa aktu prawnego</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="name" value="'.$law_info['name'].'"><br>
    
      <label class="w3-text-teal"><b>Treść aktu </b></label><br>
  <textarea id="myTextarea" name="editor1" rows="44" cols="20"> '.$law_info['text'].'</textarea><br>

<label class="w3-text-teal"><b>Data publblikacji</b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="date" style="width: 350px" name="data_p" value="'.$data_dot.'"><br>

<label class="w3-text-teal"><b>Uchylenie  aktu</b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="checkbox" style="width: 350px" name="uchyl"><br>
  
  
  <button class="w3-btn w3-blue-grey">Edytuj</button><hr>'; ?>

            <?php echo'
</form>';
        }
    } else echo '<p>Brak uprawnien do edycji prawa innego kraju <hr></p>';
} else {
    echo '<form class="w3-container" method="post">
<br>
    <label class="w3-text-teal"><b>ID aktu prawnego do edycji </b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="xcvb""><br>
    
  <button class="w3-btn w3-blue-grey">Szukaj</button>';

    if(isset($_POST['xcvb'])){
        $law_info_s = System::getLaw($_POST['xcvb']);
        if($law_info_s['name']!='' AND $law_info_s['state_id']==$id) {
            echo '<a href="'._URL.'/profil/adm_law_edit/'.$id.'/'.$_POST['xcvb'].'">'.$law_info_s['name'] . ' - kliknij by edytować</a>';
        } else if($law_info_s['name']!='' AND $law_info_s['state_id']!=$id) {
            echo '<b>Brak możliwości edycji praw innego kraju</b>';
        } else echo '<b>Nie znaleziono takiego aktu</b><hr>';
    }
}

echo '</div></div>';
