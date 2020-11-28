<style>
    * {
        box-sizing: border-box;
    }

    body {
        font: 16px Arial;
    }

    /*the container must be positioned relative:*/
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    option, select {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }


    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
</style><?php


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Wybierz projekt budowlany</h2>
</div>';

if (isset($_GET['ods']) AND $_GET['ods']!='EDI_OK') {
    $into = System::blueprintInfo($_GET['ods']);
    if ($_GET['ops'] == 'edytuj') {
        if ($into['author_id'] == $id) {
            update('up_plot_blueprints','id',$_GET['ods'],'price',$_POST['price']);
            update('up_plot_blueprints','id',$_GET['ods'],'plot_id',$_POST['plot_id']);
            header('Location: '._URL.'/profil/adm_build_adm/'.$id.'/EDI_OK');
        }

    } else if ($_GET['ops'] == 'usun') {
        if ($into['author_id'] == $id) {
            $sql = "DELETE FROM `up_plot_blueprints` WHERE id='$_GET[ods]'";
            $conn->exec($sql);
            header('Location: '._URL.'/profil/'.$id.'/DEL_BLU');
        }
    }

} else {
    echo '<h3>Projekty ogólnodostępne</h3>';
    if ($_GET['ods'] == 'EDI_OK') echo '
    <div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Edytowano pomyślnie
</div>';
    $sql1 = "SELECT * FROM `up_plot_blueprints` WHERE `author_id` = '$id' AND accept='1'";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $author = System::getInfo($row1['author_id']);
        $cost = $row1['price'] + $row1['adm_cost'];
        echo '<table border="0" width="90%" align="center">
    <tr>
        <td width="632" rowspan="4"><img src="' . $row1['gfx_url'] . '" style="max-width: 70%"></td>
        <td width="632" colspan="2"><h3>' . $row1['name'] . '</h3></td>
        <td width="313" > &nbsp;</td>
       
    </tr>
    <tr><form action="' . _URL . '/profil/adm_build_adm/' . $id . '/' . $row1['id'] . '/edytuj" method="post">
        
        <td width="313"><b><input type="text" name="price" value="' . $row1['price'] . '"  style="width: 75%"></b><br><sup>Cena projektu</sup></td>
        
        <td width="313"><b><input type="text" name="plot_id" value="' . $row1['plot_id'] . '" style="width: 75%"></b><br><sup>ID Działki</sup></td>
        <td width="313" ><button>Edytuj</button></td>
    </tr></form>
 <tr><form action="' . _URL . '/profil/adm_build_adm/' . $id . '/' . $row1['id'] . '/usun" method="post">
        <td width="313"><b>' . number_format($row1['adm_cost'], 0, ',', ' ') . ' kr</b><br><sup>Opłata administracyjna</sup></td>
        <td width="313"><b>' . $row1['build_duration'] . ' dni</b><br><sup>Czas budowy</sup></td>
        <td width="313" ><button>Usuń projekt</button></td>
    </tr></form>
</table><hr>';
    }

}
echo '</div></div>';

?>

