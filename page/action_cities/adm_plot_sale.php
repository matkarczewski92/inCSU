<?php
$conn = pdo_connect_mysql_up();

echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Zarządzanie działkami</h2>
</div>';

if ($_GET['ods'] == 'OK') echo '<div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Działka została edytowana poprawnie</div>';
if (isset($_POST['address'])) {
    $plot_update = new Plot($_GET['ods']);
    $plot_update->setAddress($_POST['address']);
    $price = ($_POST['price']=='' OR $_POST['price']=='0')? NULL : $_POST['price'];
    $plot_update->setPrice($price);
    header('Location: ' . _URL . '/profil/adm_plot_sale/' . $_GET['ptyp'] . '/OK/'.$_GET['ods']);
} else {
    echo '<table width="90%" align="center">  <tr>
        <td width="20%">ID</td>
        <td width="40%">Adres</td>
        <td width="15%">Cena</td>
        <td width="15%">Powierzchnia</td>
        <td width="10%">&nbsp;</td>
    </tr>';


    $sql = "SELECT * FROM `up_plot` WHERE city_id = '$id' AND (owner_id = '$id' OR owner_id = '')";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        echo ' <form action="' . _URL . '/profil/adm_plot_sale/' . $id . '/' . $row['id'] . '" method="post" ENCTYPE="multipart/form-data">  <tr>
        <td width="20%"><a href="' . _URL . '/profil/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . '</a></td>
        <td width="40%"><input type="text" name="address" value="' . $row['address'] . '" style="width: 80%"></td>
        <td width="15%"><input type="text" name="price" value="' . $row['price'] . '" style="width: 80%"></td>
        <td width="15%"><input type="text" name="square_meter" value="' . $row['square_meter'] . '" style="width: 80%" disabled></td>
        <td width="10%"><button class="w3-btn w3-blue-grey" >Zapisz</button></td>
    </tr>

    </tr>
    </form>';
    }
}


echo '</table><br>';


echo '</div></div>';






