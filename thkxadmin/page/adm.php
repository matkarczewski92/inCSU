<?php
if (in_array("1", $acces)) {

    echo ' <div class="w3-container" style="width: 90%; margin: auto;"><h3 align="center">Edycja uprawnień administracyjnych</h3> ';

    if (isset($_GET['typ'])) {
        if ($_GET['ptyp'] == 'add') {
            if ($_POST['target'] != '1' or $_COOKIE['id'] == 'U00001' and $_POST['target'] != '0' and $_POST['target'] != '') {
                $conn = pdo_connect_mysql_up();
                $sql = "INSERT INTO `up_admin_access` (`user_id`, `module`) VALUES (:user_id, :module)";
                $sth = $conn->prepare($sql);
                $sth->execute(array(
                        ':user_id' => $_GET['typ'],
                        ':module' => $_POST['target'])
                ) or die(print_r($sth->errorInfo(), true));
            }
            header('Location: ' . _URLADM . '/adm');

        } else if ($_GET['ptyp'] == 'delete') {

            $sql = "DELETE FROM `up_admin_access` WHERE `user_id` = '$_GET[typ]'";
            $conn->exec($sql);
            $sql = "DELETE FROM `up_admin` WHERE `user_id` = '$_GET[typ]'";
            $conn->exec($sql);
            header('Location: ' . _URLADM . '/adm');

        } else if ($_GET['typ'] == 'dodaj') {
            $conn = pdo_connect_mysql_up();
            $sql = "INSERT INTO `up_admin` (`user_id`, `type_id`) VALUES (:user_id, :type_id)";
            $sth = $conn->prepare($sql);
            $sth->execute(array(
                    ':user_id' => $_POST['uid'],
                    ':type_id' => $_POST['type_id'])
            ) or die(print_r($sth->errorInfo(), true));

//            header('Location: ' . _URLADM . '/adm');

        } else if ($_GET['ptyp'] != '1' or $_COOKIE['id'] == 'U00001') {
            $sql = "DELETE FROM `up_admin_access` WHERE `user_id` = '$_GET[typ]' AND `module` = '$_GET[ptyp]'";
            $conn->exec($sql);
            header('Location: ' . _URLADM . '/adm');
        }

    }


    ?>
    <div class="w3-responsive" style="overflow-x:auto;">
        <table class="w3-table-all w3-card-2" style="width: 100%" >
            <tr>
                <th style="width: 25%">Nazwa</th>
                <th>Dodaj moduł</th>
                <th>Uprawnienia</th>
                <th></th>
            </tr>
            <?php

            $sql = "SELECT * FROM `up_admin`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $sql1 = "SELECT * FROM `up_admin_type` WHERE id = '$row[type_id]'";
                $data1 = $conn->query($sql1)->fetch();
                $user_info = System::user_info($row['user_id']);
                $minimum = ($_COOKIE['id'] == 'U00001') ? '1' : '2';
                echo '        <tr>
            <th style="width: 20%; vertical-align: middle"><img src="' . $user_info['avatar_url'] . '" class="w3-left w3-circle w3-margin-right" style="width:45px"> ' . $user_info['name'] . '</th>
            <th style="width: 15%; vertical-align: middle">
                 <form action="' . _URLADM . '/adm/' . $row['user_id'] . '/add" method="post">
                 <input type="number" name="target" class="normal" min="' . $minimum . '" value="' . $minimum . '" style="width: 70%;  height: 30px"> 
                     <button class="w3-button w3-teal">+</button></form></th>
            <th style="vertical-align: middle">';
                $sql1 = "SELECT * FROM `up_admin_access` WHERE user_id = '$row[user_id]' ORDER BY `module`";
                $sth1 = $conn->query($sql1);
                while ($row1 = $sth1->fetch()) {
                    echo ($row1['module']<100)? '<a href="' . _URLADM . '/adm/' . $row['user_id'] . '/' . $row1['module'] . '">' . $row1['module'] . '</a>, '
                    : '<a href="' . _URLADM . '/adm/' . $row['user_id'] . '/' . $row1['module'] . '" style="color: red">' . $row1['module'] . '</a>, ';
                }
                echo '<th><a href="' . _URLADM . '/adm/' . $row['user_id'] . '/delete"><i class="fa fa-trash" aria-hidden="true"></i></a></th></th>
        </tr>';
            }
            ?>
        </table>
    </div>
    </div>
    <hr>
    <div class="w3-container" style="width: 50%; margin: auto;"><h3 align="center">Dodawanie administratorów</h3>
    <table class="w3-table-all  w3-card-2" style="width: 100%">
    <form action="<?php  echo _URLADM . '/adm/' . $row['user_id'] . '/dodaj' ; ?>" method="post">
    <tr>
    <th style="width: 90%; vertical-align: middle">
    <input type="text" name="uid" class="normal" style="width: 50%;  height: 30px" placeholder="Podaj id mieszkańca...">
        <select name="type_id" class="none" style="width: 45%;">
    <?php
    $sql1 = "SELECT * FROM `up_admin_type` ORDER BY id desc";
    $sth1 = $conn->query($sql1);
    while ($row1 = $sth1->fetch()) {
        echo '<option value="'.$row1['id'].'">'.$row1['name'];
    }
        ?>
        </select>
        </th>
        <th>
            <button class="w3-button w3-teal">Dodaj</button>
        </th>
        <th></th>
        </tr>
        </form></table>
        </div>

    <div class="w3-container">
        <h2>Tabela uprawnień krytycznych</h2>
        <table class="w3-table-all w3-card-2">
            <tr>
                <th>NR i nazwa modułu</th>
                <th>Opis</th>
            </tr>
            <tr>
                <td><b>1</b> - System i Administracja</td>
                <td>Opcja wyłącznie dla HEAD ADMINÓW, edycja głównych zmiennych systemowych oraz nadawanie uprawnień do panelu - <b>Nadanie możliwe wyłącznie przez U00001</b></td>
            </tr>
            <tr>
                <td><b>10x</b> - Uprawnienia do edycji</td>
                <td>Gdzie <b>x</b> to nr modułu. Możliwość edycji danych. Bez uprawnienia <b>10x</b> użytkownik może wyłącznie przeglądać Profile, Posiadanie, Prawo, Bank</td>
            </tr>
        </table>
    </div>
<hr><BR><BR>
        <?php


    }