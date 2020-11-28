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
  <h2><br>Przeglądaj wiadomości</h2>
</div>';

if (isset($_GET['ods'])) {
    if ($_POST['text'] != '') {
        echo 'wiadomosc';
$url=_URL;
        Create::Post($id, $_GET['ods'], 'Odpowiedź', $_POST['text']);
        header ("Location: $url/profil/adm_wiadomosci/$id/$_GET[ods]");
    }
    $info_u = System::user_info($_GET['ods']);
    echo '<h3>Korespondencja z mieszkańcem <a href="' . _URL . '/profil/' . $_GET['ods'] . '" style="text-decoration: none; color: #1d4e85"><u>' . $info_u['name'] . '</u></a></h3>';
    echo '<form class="w3-container"  method="post">
  <label class="w3-text-teal"><b>Treść wiadomosci <br></b></label><br><centeR>
  <textarea id="myTextarea" style="width: 1000px"  name="text" class="w3-input w3-border w3-light-grey" rows="15" cols="100"></textarea><br>
  <button class="w3-btn w3-blue-grey">Odpowiedz</button>
</form><br><hr><br>';
    update('up_post', 'to_id', $id, 'is_read', '1');
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_post` WHERE `to_id` = '$id' AND `from_id` = '$_GET[ods]'  OR `from_id` = '$id' AND `to_id` = '$_GET[ods]' ORDER BY `date` DESC";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        if ($row['from_id'] == $_GET['ods']) {
            $color = "#F0FFF0";
            $info_u = System::getInfo($_GET['ods']);
        } else {
            $info_u = System::getInfo($id);
            $color = "#FFDAB9";
        }
        echo '<table border="0" width="80%" align = "center" bgcolor="' . $color . '">
    <tr>
        <td><a href="' . _URL . '/profil/adm_wiadomosci/' . $id . '/' . $_GET['ods'] . '" style="color: #1d4e85">' . $info_u['name'] . '</a> <sub>' . timeToDateTime($row['date']) . '</sub></td>
    </tr>
    <tr>
        <td><p style="margin-left: 20;" align="justify">' . $row['text'] . '</p></td>
    </tr></table>
';
    }
    echo '<p> <hr></p>';

} else {
    echo '<h3>Nowe wiadomości</h3>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_post` WHERE `to_id` = '$id' AND `is_read` = 0 GROUP BY `from_id` ORDER BY `date`";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $info_u = System::getInfo($row['from_id']);
        echo '<p align="left" style="margin-left: 100px;"><span class="material-icons" style="color: #f44336; ">mark_email_unread</span>
                <a href="' . _URL . '/profil/adm_wiadomosci/' . $id . '/' . $row['from_id'] . '" style="text-decoration: none; color: #1d4e85">Korespondencja z mieszkańcem: ' . $info_u['name'] . '</a></p>';
    }
    echo '<h3>Przeczytane wiadomości</h3>';
    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_post` WHERE `to_id` = '$id' AND `is_read` = 1 GROUP BY `from_id` ORDER BY `date`";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $info_u = System::getInfo($row['from_id']);
        echo '<p align="left" style="margin-left: 100px;"><span class="material-icons" style="color: ; ">mark_email_unread</span>
                <a href="' . _URL . '/profil/adm_wiadomosci/' . $id . '/' . $row['from_id'] . '" style="text-decoration: none; color: #1d4e85">Korespondencja z mieszkańcem: ' . $info_u['name'] . '</a></p>';
    }
}
echo '<p><hr></p></div></div>';
