    <script type="text/javascript">
        tinymce.init({
            selector: '#myText',

            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'emoticons template paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor',
            menu: {},
            menubar: 'favs file edit view insert format',
            content_css: 'http://uniapanstw.pl/js/tinymce/css/content.css'
        });
    </script><?php
$data_dot = date("Y-m-d");

echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Dodawanie schematów wniosków</h2>
</div>';
if (isset($_POST['name'])) {
$lenno = ($_POST['type']==3)? '1' : '';
$citiz = ($_POST['type']!=3)? $_POST['type'] : '0';
Create::ProposalShema($id,$_POST['name'],$_POST['opis'],$citiz,$_POST['schemat'],$_POST['text_apr'],' ',$_POST['title_apr'], ' ',$_POST['law_cat'],$_POST['cost'],$lenno);
echo $_POST['name'];

} else {

    echo '<form class="w3-container" method="post">';
    echo '</select><br>
    <label class="w3-text-teal"><b>Nazwa ogólna wniosku</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 80%" name="name""><br>
        <label class="w3-text-teal"><b>Koszt wniosku (wstaw 0 gdy darmowy/brak opłaty)</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 40%" name="cost""><br>
    
        <label class="w3-text-teal"><b>Rodzaj wniosku - specjalnego</b></label><br>
 <select name="type"  style="width: 40%">
 <option value="0">Zwykły</option>
 <option value="1">Nadanie obywatelstwa</option>
 <option value="2">Pozbawienie obywatelstwa</option>
 <option value="3">Wniosek o nadanie lenna</option>
 </select>
  <br>
      <label class="w3-text-teal"><b>Zwięzły opis wniosku </b></label><br>
 <center> <textarea id="" name="opis" rows="5" cols="40" style="width: 80%"> </textarea><br></center>
  
        <label class="w3-text-teal"><b>Proponowany wzór wniosku (widoczny przez wnioskodawce) </b></label><br>
 <center> <textarea id="myTextarea4" name="schemat" rows="5" cols="40" style="width: 80%"> </textarea><br></center>
 
     <br><BR><BR><BR>
     <H3>----------TYLKO JEŻELI MA PUBLIKOWAĆ AKT PO ROZPATRZENIU----------</H3><label class="w3-text-teal"><b>Umiejscowienie aktu prawnego - </b></label><br>
    <select name="law_cat" style="width: 70%">';
    echo'<option value="">WNIOSEK NIE PUBLIKUJE AKTU PRAWNEGO</option>';
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
 echo'</select><br>
    <label class="w3-text-teal"><b>Tytuł aktu gdy ZATWIERDZONY</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 80%" name="title_apr""><br>
        <label class="w3-text-teal"><b>Treść aktu gdy ZATWIERDZONY (ID mieszkańca zastąp :user_id:, imie i nazwisko zastąp :user_name:)</b></label><br>
  <center> <textarea id="myTextarea3" name="text_apr" rows="5" cols="20" style="width: 80%"> </textarea><br></center>
  
  
  <button class="w3-btn w3-blue-grey">Utwórz schemat</button>'; ?>

    <?php echo'
</form>';
}
echo '</div></div>';
