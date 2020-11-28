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

if (isset($_GET['ods'])) {
    $info = System::projectInfo($_GET['ods']);
    $plot = new Plot($_GET['typ']);
    $time_start = time();
    $time_finish = ($time_start + ($info['build_duration'] * 60 * 60 * 24));
    $cost = $info['price'] + $info['adm_cost'];
    $bank_author_id = System::organization_info($info['author_id']);

//    echo $info['adm_cost'];
    $title1 = 'Opłata za projekt budowlany nr ' . $info['id'] . ' dla działki nr' . $id;
    $title2 = 'Opłata administracyjna, rozpoczęcie budowy na działce nr ' . $id;
$bank_author = Bank::transfer($acc_info['id'], $bank_author_id['main_bank_acc'], $info['price'], $title1);
$bank_administration = Bank::transfer($acc_info['id'], _KIBANK, $info['adm_cost'], $title2);
//
if ($bank_author == 'OK' and $bank_administration == 'OK') {
    $build = Create::Building($_GET['typ'], $info['metrage'], $info['gfx_url'], $time_start, $time_finish);
    $plot->setBuildingId($build);
    header('Location: '._URL.'/profil/'.$id.'/BUI_STA');
} else header('Location: ' . _URL . '/profil/' . $id . '/BUI_MON');

echo $build;

} else {
    echo '<h3>Projekty indywidualne</h3>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_plot_blueprints` WHERE `plot_id` = '$id' AND accept = '1'";
    $sth = $conn->query($sql);

    $sql1 = "SELECT COUNT(*) FROM `up_plot_blueprints` WHERE `plot_id` = '$id' AND accept = '1'";
    $stmt1 = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
    if($stmt1[0]=='0'){
        echo'<h5>Możesz zlecić zaprojektowanie indywidualnego projektu przedsiębiorstwu budowlanemu. </h5><h5>Wybierają przedsiębiorstwo budowlane zwóć uwagę na poziom przedsiębiorstwa, im wyższy tym krótszy czas budowy oraz mniejszy jej koszt.</h5>';
    } else {
        while ($row = $sth->fetch()) {
            $author = System::getInfo($row['author_id']);
            $cost = $row['price'] + $row['adm_cost'];
            echo '<table border="0" width="90%" align="center">
    <tr>
        <td width="632" rowspan="3"><img src="' . $row['gfx_url'] . '" style="max-width: 70%"></td>
        <td width="632" colspan="2"><h3>' . $row['name'] . '</h3></td>
        <td width="313" rowspan="3">';

            echo ($acc_info['balance'] >= $cost) ? '<form action="' . _URL . '/profil/' . $id . '/zabuduj/' . $row['id'] . '" method="post"><button>Zbuduj</button></form>' : '';

            echo '</td>
    </tr>
    <tr>
        <td width="313"><b>' . $cost . ' kr</b><br><sup>Koszt budowy</sup></td>
        <td width="313"><b>' . $row['metrage'] . ' m2</b><br><sup>Metraż budynku</sup></td>
    </tr>
    <tr>
        <td width="313"><b>' . $author['name'] . '</b><br><sup>Autor projektu</sup></td>
        <td width="313"><b>' . $row['build_duration'] . ' dni</b><br><sup>Czas budowy</sup></td>
    </tr>
</table><hr>';
        }
    }

    echo '<h3>Projekty ogólnodostępne</h3>';
    $sql1 = "SELECT * FROM `up_plot_blueprints` WHERE `plot_id` != '$id' AND accept = '1'";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        $author = System::getInfo($row1['author_id']);
        $cost = $row1['price'] + $row1['adm_cost'];
        echo '<table border="0" width="90%" align="center">
    <tr>
        <td width="632" rowspan="3"><img src="' . $row1['gfx_url'] . '" style="max-width: 70%"></td>
        <td width="632" colspan="2"><h3>' . $row1['name'] . '</h3></td>
        <td width="313" rowspan="3">';

        echo ($acc_info['balance'] >= $cost) ? '<form action="' . _URL . '/profil/' . $id . '/zabuduj/' . $row1['id'] . '" method="post"><button>Zbuduj</button></form>' : '';

        echo '</td>
    </tr>
    <tr>
        <td width="313"><b>' . $cost . ' kr</b><br><sup>Koszt budowy</sup></td>
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

