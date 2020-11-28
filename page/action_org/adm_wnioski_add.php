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
    Create::ProposalShema($id,$_POST['name'],$_POST['opis'],0,$_POST['schemat'],'',' ','', ' ','','',0);
    echo $_POST['name'];

} else {

    echo '<form class="w3-container" method="post">';
    echo '</select><br>
    <label class="w3-text-teal"><b>Nazwa ogólna wniosku</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 80%" name="name""><br>

      <label class="w3-text-teal"><b>Zwięzły opis wniosku </b></label><br>
 <center> <textarea id="" name="opis" rows="5" cols="40" style="width: 80%"> </textarea><br></center>
  
        <label class="w3-text-teal"><b>Proponowany wzór wniosku (widoczny przez wnioskodawce) </b></label><br>
 <center> <textarea id="myTextarea4" name="schemat" rows="5" cols="40" style="width: 80%"> </textarea><br></center>

  <button class="w3-btn w3-blue-grey">Utwórz schemat</button>'; ?>

    <?php echo'
</form>';
}
echo '</div></div>';
