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
  <h2><br>Edycja schematów wniosków</h2>
</div>';

if(isset($_GET['ods'])){
    if (isset($_POST['name'])) {
        $lenno = ($_POST['type']==3)? '1' : '';
        $citiz = ($_POST['type']!=3)? $_POST['type'] : '0';
        update('up_proposal_type','id',$_GET['ods'],'name',$_POST['name']);
        update('up_proposal_type','id',$_GET['ods'],'text',$_POST['opis']);
        update('up_proposal_type','id',$_GET['ods'],'schemat',$_POST['schemat']);

    } else {
        $info_b = System::proposalType_info($_GET['ods']);
        echo '<form class="w3-container" method="post">';
        echo '</select><br>
    <label class="w3-text-teal"><b>Nazwa ogólna wniosku</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 80%" name="name" value="'.$info_b['name'].'"><br>

      <label class="w3-text-teal"><b>Zwięzły opis wniosku </b></label><br>
 <center> <textarea id="" name="opis" rows="5" cols="40" style="width: 80%"> '.$info_b['text'].' </textarea><br></center>
  
        <label class="w3-text-teal"><b>Proponowany wzór wniosku (widoczny przez wnioskodawce) </b></label><br>
 <center> <textarea id="myTextarea4" name="schemat" rows="5" cols="40" style="width: 80%">'.$info_b['schemat'].' </textarea><br></center>
 

  
  <button class="w3-btn w3-blue-grey">Edytuj schemat</button>'; ?>

        <?php echo'
</form>';
    }

} else {
    echo '<p>Wybierz jeden z dostępnych rodzajów wniosków poprzez kliknięcie w jego nazwe </p>
<table border="0" align="center">
   <tr>
        <td width="10%" align="center" valign="top">Nr. </td>
        <td width="30%" align="center" valign="top">Nazwa</td>
		<td width="40%" align="center" valign="top">Opis</td>
		<td width="20%" align="center" valign="top">Koszt złożenia wniosku</td>
    </tr>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_proposal_type` WHERE state_id = '$id'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo '<tr>
        <td width="10%" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski_edit/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">#' . $row['id'] . '</a></td>
        <td width="30%" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski_edit/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['name'] . '</a></td>
		<td width="40%" align="left" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski_edit/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['text'] . '</a></td>
		<td width="20%" align="left" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski_edit/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['cost'] . ' kr</a></td>
		
    </tr>';
    }
    echo '</table><p> <br></p>';

}
echo '</div></div>';
