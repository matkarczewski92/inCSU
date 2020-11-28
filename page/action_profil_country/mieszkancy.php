<?php
$conn = pdo_connect_mysql_up();

echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Zarządzanie mieszkańcami</h2>
</div><p><b>Tytuł honorowy </b>- tytuł wyświetlający się pod imieniem i nazwiskiem na czerwono w profilu mieszkańca. <br>
<b>Tytuł </b>- wpisać tytuł mieszkańca (sir, kawaler, hrabia itp.itd)</p>';
echo ($_GET['ods'] == 'OK') ? '<div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Dane mieszkańca o ID <b><a href="'._URL.'/profil/'. $_GET['ops'].'" style="text-decoration: none; color: #1d4e85">' . $_GET['ops'] . '</a><b> zostały zmienione pomyślnie
</div>' : '';
if (isset($_POST['name'])) {
    if ($_POST['citizenship'] != 'on') {
        $sql = "DELETE FROM `up_user_citizenship` WHERE user_id='$_GET[ods]' AND state_id='$_GET[ptyp]'";
        $conn->query($sql);
    } else {
        $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id='$_GET[ods]' AND state_id='$_GET[ptyp]'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        if ($stmt[0] == 0) Create::Citizenship($_GET['ods'], $_GET['ptyp']);
    }
    $max_rozmiar = 2024 * 2024;
    if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        if ($_FILES['plik']['size'] > $max_rozmiar) {
            echo 'Błąd! Plik jest za duży!';
        } else {
            $file_ext = strtolower(end(explode('.', $_FILES['plik']['name'])));
            $_FILES['plik']['name'] = 'herb_' . $_GET['ods'] . '.' . $file_ext;
            $file_name_sql = $_FILES['plik']['name'];

            echo $file_ext.'<br/>';
            if (isset($_FILES['plik']['type'])) {

            }
            move_uploaded_file($_FILES['plik']['tmp_name'], 'user_gfx/' . $_FILES['plik']['name']);
        }

    }
    $url_awatar = _URL . '/user_gfx/' . $file_name_sql;
    $user_up = new User($_GET['ods']);
    if ($user_up->getArmsUrl()!=$file_name_sql OR $file_name_sql!='') $user_up->setArmsUrl($url_awatar);
    $user_up->setName($_POST['name']);
    $user_up->setTitleId($_POST['title_id']);
    $user_up->setHonorTitle($_POST['honor_title']);
    $title_log = ' Zmiana danych mieszkańca ID:'.$_GET['ods'];
    Create::Log($_COOKIE['id'],$title_log);
    header('Location: ' . _URL . '/profil/adm_mieszkancy/' . $_GET['ptyp'] . '/OK/' . $_GET['ods']);
} else {
    echo '<table width="90%" align="center">  <tr>
        <td width="5%">ID</td>
        <td width="30%">Imie i nazwisko</td>
        <td width="10%">Obywatelstwo</td>
        <td width="15%">Tytuł</td>
        <td width="20%">Tytuł honorowy</td>
        <td width="10%">&nbsp;</td>
    </tr>';


    $sql = "SELECT * FROM `up_users` WHERE state_id = '$id' AND active = '0'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id = '$row[id]' AND state_id = '$info[id]'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        $check = ($stmt[0] == 1) ? 'checked' : '';
        echo ' <form action="' . _URL . '/profil/adm_mieszkancy/' . $id . '/' . $row['id'] . '" method="post" ENCTYPE="multipart/form-data">  <tr>
        <td width="5%"><a href="'._URL.'/profil/'.$row['id'].'" style="text-decoration: none; color: #1d4e85">' . $row['id'] . '</a></td>
        <td width="30%"><input type="text" name="name" value="' . $row['name'] . '" style="width: 80%"></td>
        <td width="10%"><input type="checkbox" name="citizenship" ' . $check . '></td>
        <td width="15%"><input type="text" name="title_id" value="' . $row['title_id'] . '" style="width: 80%"></td>
        <td width="10%"><input type="text" name="honor_title" value="' . $row['honor_title'] . '" style="width: 80%"></td>
        <td width="10%" rowspan="2"><button class="w3-btn w3-blue-grey" >Zapisz</button></td>
    </tr>
    <tr>
           <td width="100%" colspan="5">
             <b>Wgraj herb</b>
  <input type="file" class="custom-file-input"  name="plik" multiple=""><hr>
           
</td>
    </tr>
    </form>';
    }
}


echo '</table><br>';


echo '</div></div>';






