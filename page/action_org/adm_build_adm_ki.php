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

if (isset($_GET['ods']) and $_GET['ods'] == 'accept') {
    $blue = System::blueprintInfo($_GET['ops']);
    update('up_plot_blueprints', 'id', $_GET['ops'], 'accept', '1');
    $text = 'Twój pojekt został zatwierdzony i wprowadzony do obiegu';
    Create::Post($id,$blue['author_id'],'Zatwierdzenie wniosku',$text);
    header('Location: ' . _URL . '/profil/adm_build_adm_ki/' . $id);
} else {
    echo '<h3>Projekty ogólnodostępne</h3>';
    $sql1 = "SELECT * FROM `up_plot_blueprints` WHERE `accept` = '0'";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $author = System::getInfo($row1['author_id']);
        $cost = $row1['price'] + $row1['adm_cost'];
        echo '<table border="0" width="90%" align="center">
    <tr>
        <td width="632" rowspan="3"><img src="' . $row1['gfx_url'] . '" style="max-width: 70%"></td>
        <td width="632" colspan="2"><h3>' . $row1['name'] . '</h3>' . $row1['plot_id'] . '</td>
        <td width="313" rowspan="3"><form action="' . _URL . '/profil/adm_build_adm_ki/' . $id . '/accept/' . $row1['id'] . '" method="post"><button>Zatwierdz</button></form></td>
    </tr>
    <tr>
        <td width="313"><b>' . $row1['price'] . ' + ' . $row1['adm_cost'] . ' kr</b><br><sup>Koszt budowy</sup></td>
        <td width="313"><b>' . $row1['metrage'] . ' m2</b><br><sup>Metraż budynku</sup></td>
    </tr>
    <tr>
        <td width="313"><b>' . $author['name'] . '</b><br><sup>Autor projektu</sup></td>
        <td width="313"><b>' . $row1['build_duration'] . ' dni</b><br><sup>Czas budowy</sup></td>
    </tr>
</table><hr>';
    }

}
echo '</div></div>';

?>

