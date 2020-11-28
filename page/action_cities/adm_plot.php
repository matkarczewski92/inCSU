<?php
$data_dot = date("Y-m-d");
$id_org_up = $info['owner_id'];
$up_owner = System::getInfo($info['owner_id']);
$city_info = System::city_info($id);
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Dodawanie działek</h2>
</div>';
if (isset($_POST['address'])) {
    $id_dz = System::plotIdGenerator($id);
    Create::Plot($id_dz, $id, $_POST['type_id'], $_POST['address'], $_POST['metrage'], $_POST['price']);
    if ($_POST['type_id'] == '2') {
        $plots = new Plot($id_dz);
        $plots->setOwnerId($id);
    }
    header('Location: ' . _URL . '/profil/adm_plot/' . $id . '/DODANO');


} else {
    $id_dz = System::plotIdGenerator($id);
    if ($_GET['ods'] == 'DODANO') echo '<div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Działka została dodana poprawnie - możesz dodać kolejną</div>';

    $idz = explode("-", $id_dz);
    $id_last = $id . '-' . sprintf("%05d", $idz[1] - 1);
    $info_d = System::plotInfo($id_last);
    $plot_counter = System::plotCityCounter($id);
    if ($plot_counter < $city_info['plot_limit']) {
        echo '<div class="alert success">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;
    </span>Poprzednio dodany adres to: <b>' . $info_d['address'] . '</b>, cena: <b>' . $info_d['price'] . ' kr</b> , metraż: <b>' . $info_d['square_meter'] . ' m2</b></div>';

        echo '<form class="w3-container" method="post">
    <label class="w3-text-teal"><b>Numer działki</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="title" value="' . $id_dz . '" disabled><br>  
    <label class="w3-text-teal"><b>Nazwa ulicy + numer</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="address"><br>    
    <label class="w3-text-teal"><b>Cena sprzedaży <br>(wpisz 0 lub pozostaw puste by nie wystawić działki na sprzedaż)</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="price"><br>
    <label class="w3-text-teal"><b>Metraż działki (m2)</b></label><br>
    <input class="w3-input w3-border w3-light-grey" type="text" style="width: 50%" name="metrage"><br>
    <label class="w3-text-teal"><b>Typ działki</b></label><br>
    <select name="type_id" style="width: 50%">';
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_plot_type`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }


        echo '</select><br>
 
  
  <button class="w3-btn w3-blue-grey">Publikuj</button>'; ?>

        <?php echo '
</form>';
    } else echo '<div class="alert">  <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>Osiągnięto maksymalną ilość działek</div>';
}
echo '</div></div>';
