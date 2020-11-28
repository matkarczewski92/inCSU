<style>
    img {
        width: 90%;
        height: auto;
    }
</style><?php
$id = $_COOKIE['id'];

?>

<div class="hero">
    <div class="hero-content">
        <h2>Poczta Unii Państw Niepodległych</h2>
        <hr width="800" />
        <p>

        </p>
    </div>
    <div class="hero-content-mobile"><h2>Poczta Unii Państw Niepodległych</h2></div>
</div>

<div class="main">
    <div class="content"><div class="card">tere<?php


            if (isset($_GET['ptyp'])) {
                if ($_POST['text'] != '') {
                    echo 'wiadomosc';
                    Create::Post($id, $_GET['ptyp'], 'Odpowiedź', $_POST['text']);
                    $url = _URL;
                    header ("Location: $url/post/$id/$_GET[ptyp]");
                } // wysw
                $info_u = System::getInfo($_GET['ptyp']);
                echo '<h3>Korespondencja z mieszkańcem <a href="' . _URL . '/profil/' . $_GET['ptyp'] . '" style="text-decoration: none; color: #1d4e85"><u>' . $info_u['name'] . '</u></a></h3>';
                echo '<form class="w3-container"  method="post">
  <label class="w3-text-teal"><b>Treść profilu <br></b></label><br><centeR>
  <textarea id="myTextarea" style="width: 1000px"  name="text" class="w3-input w3-border w3-light-grey" rows="15" cols="100"></textarea><br>
  <button class="w3-btn w3-blue-grey">Odpowiedz</button>
</form><br><hr><br>';
                update('up_post', 'to_id', $id, 'is_read', '1');
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_post` WHERE (`to_id` = '$id' AND `from_id` = '$_GET[ptyp]') OR (`to_id` = '$_GET[ptyp]' AND `from_id` = '$id') ORDER BY `date` DESC";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {

                    if ($row['from_id'] == $_GET['ptyp']) {
                        $color = "#FFFFE0";
                        $info_u = System::getInfo($_GET['ptyp']);
                    } else {
                        $info_u = System::getInfo($id);
                        $color = "#FFFACD";
                    }

                    echo '<table border="0" width="80%" align = "center" bgcolor="' . $color . '">
    <tr>
        <td>' . $info_u['name'] . ' <sub>' . timeToDateTime($row['date']) . '</sub></td>
    </tr>
    <tr>
        <td style="border-bottom: 1px solid #ddd;"><p style="margin-left: 20px;" align="justify">' . $row['text'] . '</p></td>
    </tr>
</table>
';
                }
                echo '<p> <hr></p>';

            } else {
                echo '<h3>Nowe wiadomości</h3>';
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_post` WHERE to_id='$_COOKIE[id]' AND `is_read` = 0 GROUP BY `from_id` ORDER BY `date` DESC";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    if ($row['from_id']==$_COOKIE['id']) $ans = $row['to_id']; else $ans = $row['from_id'];
                    $getInfo = System::getInfo($ans);
                    echo '<p align="left" style="margin-left: 100px;"><span class="material-icons" style="color: #f44336; ">mark_email_unread</span>
                <a href="' . _URL . '/post/' . $id . '/' . $row['from_id'] . '" style="text-decoration: none; color: #1d4e85">Korespondencja z mieszkańcem: ' . $getInfo['name'] . '</a></p>';
                }
                echo '<h3>Przeczytane wiadomości</h3>';
                $sql1 = "SELECT * FROM `up_post` WHERE `to_id` = '$id' AND `is_read` = 1 GROUP BY `from_id` ORDER BY `date` DESC";
                $sth1 = $conn->query($sql1);
                while ($row1 = $sth1->fetch()) {
                    if ($row1['from_id']==$_COOKIE['id']) $ans = $row1['to_id']; else $ans = $row1['from_id'];
                    $getInfo = System::getInfo($ans);
                    echo '<p align="left" style="margin-left: 100px;"><span class="material-icons" style="color: ; ">mark_email_unread</span>
                <a href="' . _URL . '/post/' . $id . '/' . $row1['from_id'] . '" style="text-decoration: none; color: #1d4e85">Korespondencja z mieszkańcem: ' . $getInfo['name'] . '</a></p>';
                }
            }



    echo '</div></div>
    <div class="menu">

        <div class="card menucard sticky">';
            echo '  <p class=""><a href="' . _URL . '/post/' . $id . '" style="text-decoration: none; color: #1d4e85">Poczta</a></p>';


            echo '</div>
    </div>

</div>
';
