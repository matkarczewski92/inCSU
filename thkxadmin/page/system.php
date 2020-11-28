<?php
if (in_array("1", $acces)) {
    $config_info = System::config_info();
    echo ' <div class="w3-container" style="width: 80%; margin: auto;"><h3 align="center">Edycja konfiguracji systemowych</h3> ';

    echo ($_GET['typ'] == 'OK') ? '<div class="alert success"> <span class="closebtn" onclick="this.parentElement.style.display=none;">&times;</span>
Dane zostały zmienione pomyślnie</div>' : '';
    if (isset($_POST['org_open_charge'])) {
        update('up_config', 'id_config', '1', 'org_open_charge', $_POST['org_open_charge']);
        update('up_config', 'id_config', '1', 'bank_next_acount_charge', $_POST['bank_next_acount_charge']);
        update('up_config', 'id_config', '1', 'city_create', $_POST['city_create']);
        update('up_config', 'id_config', '1', 'coment_tantiem', $_POST['coment_tantiem']);
        update('up_config', 'id_config', '1', 'city_upgrade', $_POST['city_upgrade']);
        update('up_config', 'id_config', '1', 'city_upgrade_newPlot', $_POST['city_upgrade_newPlot']);
        update('up_config', 'id_config', '1', 'build_company_upgrade_cost', $_POST['build_company_upgrade_cost']);
        update('up_config', 'id_config', '1', 'build_company_upgrade_multi', $_POST['build_company_upgrade_multi']);
        update('up_config', 'id_config', '1', 'm2_cost', $_POST['m2_cost']);
        update('up_config', 'id_config', '1', 'm2_time', $_POST['m2_time']);
        header('Location:' . _URL . '/thkxadmin/system/OK');

    } else echo '<hr><div class="form"><h5 align="center" ><b>OPŁATY OGÓLNE</b></h5>
    <form action="" method="post">
        <label for="fname">Opłata za otwarcie organizacji</label>
        <input type="number" id="fname" name="org_open_charge"  value="' . $config_info['org_open_charge'] . '" placeholder="' . $config_info['org_open_charge'] . '"> kr <br>

        <label for="lname">Opłata za otwarcie kolejnego rachunku bankowego</label>
        <input type="number" id="lname" name="bank_next_acount_charge" value="' . $config_info['bank_next_acount_charge'] . '" placeholder="' . $config_info['bank_next_acount_charge'] . '"> kr<br>
        
        <label for="lname">Opłata za założenie miasta</label>
        <input type="number" id="lname" name="city_create" value="' . $config_info['city_create'] . '" placeholder="' . $config_info['city_create'] . '"> kr<br>
       </div><hr><div class="form"><h5 align="center" ><b>MEDIA</b></h5>
      
        <label for="lname">Tantiema za komentarz</label>
        <input type="number" id="lname" name="coment_tantiem" value="' . $config_info['coment_tantiem'] . '" placeholder="' . $config_info['coment_tantiem'] . '"> kr<br>
                <label for="lname">Tantiema za like (50% tantiemy za komentarz)</label>
        <input type="number" id="lname" name="tx" placeholder="' . $config_info['coment_tantiem'] / 2 . '" readonly> kr<br>
        </div><hr><div class="form"><h5 align="center" ><b>ROZWÓJ MIASTA</b></h5>
        <label for="lname">Koszt rozwoju miasta</label>
        <input type="number" id="lname" name="city_upgrade" value="' . $config_info['city_upgrade'] . '" placeholder="' . $config_info['city_upgrade'] . '"> kr<br>
        
        <label for="lname">Ile dodatkowych działek na jeden poziom miasta</label>
        <input type="number" id="lname" name="city_upgrade_newPlot" value="' . $config_info['city_upgrade_newPlot'] . '" placeholder="' . $config_info['city_upgrade_newPlot'] . '"> <br>
        </div><hr><div class="form"><h5 align="center" ><b>ORGANIZACJE BUDOWLANE</b></h5>
        <label for="lname">Rozwój poziomu technologicznego organizacji budowlanych</label>
        <input type="number" id="lname" name="build_company_upgrade_cost"  value="' . $config_info['build_company_upgrade_cost'] . '"placeholder="' . $config_info['build_company_upgrade_cost'] . '"> kr<br>
        
        <label for="lname">Mnożnik rozwoju  poziomu technologicznego organizacji budowlanych</label>
        <input type="number" step="0.01" min="0" max="1" id="lname" name="build_company_upgrade_multi" value="' . $config_info['build_company_upgrade_multi'] . '" placeholder="' . $config_info['build_company_upgrade_multi'] . '"><br>
        </div><hr><div class="form"><h5 align="center" ><b>BUDOWANIE</b></h5>
        <label for="lname">Opłata administracyjna za m2 budynku</label>
        <input type="number" id="lname" name="m2_cost" value="' . $config_info['m2_cost'] . '" placeholder="' . $config_info['m2_cost'] . '"> kr<br>
        
        <label for="lname">Ile m2 budowy na jeden dzień </label>
        <input type="number" id="lname" name="m2_time" value="' . $config_info['m2_time'] . '" placeholder="' . $config_info['m2_time'] . '"> m2<br>
        </div>
        <hr>
        <button class="button button1" style="width: 100%">Zatwierdź zmiany</button>

    </form>';


    echo '</div>';

} else header('Location: '._URLADM);