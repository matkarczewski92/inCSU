<?php
$data_dot = date("Y-m-d");
$id_org_up = $info['owner_id'];
$up_owner = System::getInfo($info['owner_id']);
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Organizacja głosowania</h2>
</div>';
if (isset($_POST['title'])) {
    $answers = [];
    for($i = 1; $i <= 10 ; $i++){
        if ($_POST['answer'.$i]!='') $answers[] = $_POST['answer'.$i];
    }
    $data_from = strtotime($_POST['data_from']);
    $data_until = strtotime($_POST['data_until']);

    Create::Probe($_POST['title'],$_POST['text'],$data_from,$data_until,$_POST['state_target'],$_POST['citizenship'],$_POST['probe_type_id'],$_POST['answer_count'],$answers, $id, $_POST['official']);
    $link = _URL;
    header("Location: $link/profil/$id/OK");

} else {
    $conn = pdo_connect_mysql_up();
    echo '<form class="w3-container" method="post">
    <label class="w3-text-teal"><b>Tytuł - ogólny</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="title""><br>
    
      <label class="w3-text-teal"><b>Opis - pytanie</b></label><br>
  <center><textarea id="myTextarea" name="text" rows="20" cols="20" style="width: 70%"> </textarea><br></center>
  <label class="w3-text-teal"><b>Uprawnieni do oddania głosu</b></label><br>
  <select name="state_target" style="width: 70%">
  <option value="' . $id . '">' . $info['name'] . '</option>  ';
    $sql = "SELECT * FROM `up_organizations` WHERE owner_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $org_info = System::organization_info($row['id']);
        echo'<option value="' . $org_info[id] . '">' . $org_info['name'] . '</option>  ';
    }
    echo'
</select><br>
  <label class="w3-text-teal"><b>Grupa oprawnionych do oddania głosu (nie dotyczy organizacji)</b></label><br>
<select name="citizenship" style="width: 70%">
  <option value="0">Mieszkańcy</option>
  <option value="1">Obywatele</option>
</select><br>
 <label class="w3-text-teal"><b>Rodzaj głosowania</b></label><br>
<select name="probe_type_id" style="width: 70%">';

    $sql = "SELECT * FROM `up_probe_type`";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '<option value="' . $row['id'] . '">' . $row['title'] . ' </option>';
    }
    echo '</select><br>
 <label class="w3-text-teal"><b>Sposób oddawania głosów</b></label><br>
<select name="answer_count" style="width: 70%">
     <option value="0">Możliwość wyboru jednej odpowiedzi</option>
     <option value="1">Możliwość wyboru wielu odpowiedzi</option>
</select><br>
 <label class="w3-text-teal"><b>Jawność wyników</b></label><br>
<select name="official" style="width: 70%">
     <option value="0">Wyniki ogólne bez danych personalnych</option>
     <option value="1">Wyniki z danymi personalnymi</option>
</select><br>
<label class="w3-text-teal"><b>Data początku </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="datetime-local" style="width: 350px" name="data_from" value="'.$time.'"><br>
  <label class="w3-text-teal"><b>Data zakończenia </b></label><br>
  <input class="w3-input w3-border w3-light-grey" type="datetime-local" style="width: 350px" name="data_until" value="'.$data_dot.'"><br><br>
 <label class="w3-text-teal"><b> ODPOWIEDZI </b></label><br>
 
    #1 &nbsp;&nbsp;<input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer1""><br>
    #2 &nbsp;&nbsp;<input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer2""><br>
    #3&nbsp;&nbsp; <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer3""><br>
    #4 &nbsp;&nbsp;<input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer4""><br>
    #5&nbsp;&nbsp; <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer5""><br>
    #6&nbsp;&nbsp; <input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer6""><br>
    #7 &nbsp;&nbsp;<input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer7""><br>
    #8 &nbsp;&nbsp;<input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer8""><br>
    #9 &nbsp;&nbsp;<input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer9""><br>
    #10 &nbsp;&nbsp;<input class="w3-input w3-border w3-light-grey" type="text" style="width: 350px" name="answer10""><br>
  
 
  
  <button class="w3-btn w3-blue-grey">Organizuj</button>'; ?>

    <?php echo '
</form>';
}
echo '</div></div>';
