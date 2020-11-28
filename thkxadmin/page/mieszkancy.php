<?php
if (in_array("2", $acces)) {
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK') {
        $user = new User($id);
        if ($_GET['ptyp'] == 'ALERT_OK') {
            update('up_user_login_data_cookies', 'id', $_GET['ods'], 'active', '1');
            header('Location: ' . _URLADM . '/mieszkancy/' . $id . '/OK');
        }
        if (isset($_POST['id'])) {
            if ($_POST['password'] != '') {
                $user->setPassword($_POST['password']);
            }
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setStateId($_POST['state_id']);
            $user->setCityId($_POST['city_id']);
            $user->setAvatarUrl($_POST['avatar_url']);
            $user->setArmsUrl($_POST['herb_url']);
            $user->setTitleId($_POST['title_id']);
            $user->setHonorTitle($_POST['honor_title']);
            $user->setPlotId($_POST['plot_id']);
            $user->setActive($_POST['active']);
            update('up_users', 'id', $id, 'id', $_POST['id']);
            header('Location: ' . _URLADM . '/mieszkancy/' . $id . '/OK');
        } else {
            $readOnly = (in_array("102", $acces)) ? '' : 'readonly';
            $dis = (in_array("102", $acces)) ? '' : 'disabled';
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>
                <center><img src="' . $user->getAvatarUrl() . '" alt="Zdjęcie profilowe" class="profile-img" style="max-width: 150px"><br>' . $user->getName() . '
                </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $user->getId() . '"  value="' . $user->getId() . '" ' . $readOnly . '><br>
                <label for="fname">Czy aktywny</label><br>
                <select name="active" class="normal" style="width: 100%" ' . $dis . '>';
            echo ($user->getActive() == '0') ? '<option value="0">TAK' : '<option value="1">NIE';
            echo ($user->getActive() == '0') ? '<option value="1">NIE' : '<option value="0">TAK';
            echo ' </select>
                <hr>
                <label for="fname">Nazwa</label><br>
                <input type="text" id="fname" name="name" style="width: 100%" placeholder="' . $user->getName() . '"  value="' . $user->getName() . '" ' . $readOnly . '><br>
                <label for="fname">Email</label><br>
                <input type="text" id="fname" name="email" style="width: 100%" placeholder="' . $user->getEmail() . '"  value="' . $user->getEmail() . '" ' . $readOnly . '><br>
                <label for="fname">Nowe hasło</label><br>
                <input type="text" id="fname" name="password" style="width: 100%" ' . $readOnly . '><br><hr>
                <label for="fname">Kraj zamieszkania</label><br>
                 <select name="state_id" class="normal" style="width: 100%"  ' . $dis . '>';
            $country = System::getInfo($user->getStateId());
            echo ' <option value="' . $user->getStateId() . '" ">' . $user->getStateId() . ' - ' . $country['name'] . '<br>';


            $sql = "SELECT * FROM `up_countries`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $country = System::getInfo($row['id']);
                echo ($user->getStateId() != $row['id']) ? '<option value="' . $row['id'] . '" ">' . $row['id'] . ' - ' . $country['name'] . '<br>' : '';
            }

            echo '</select><br><select name="city_id" class="normal" style="width: 100%"  ' . $dis . '>';
            $country = System::getInfo($user->getCityId());
            echo '<option value="' . $user->getCityId() . '" ">' . $user->getCityId() . ' - ' . $country['name'] . '<br>';
            $sql = "SELECT * FROM `up_cities`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $country = System::getInfo($row['id']);
                echo ($user->getCityId() != $row['id']) ? '<option value="' . $row['id'] . '" ">' . $row['id'] . ' - ' . $country['name'] . '<br>' : '';
            }

            echo '</select><br><hr>
                <label for="fname">URL Avatara</label><br>
                <input type="text" id="fname" name="avatar_url" style="width: 100%" placeholder="' . $user->getAvatarUrl() . '" value="' . $user->getAvatarUrl() . '"  ' . $readOnly . '><br>
                <label for="fname">URL Herbu</label><br>
                <input type="text" id="fname" name="herb_url" style="width: 100%" placeholder="' . $user->getArmsUrl() . '" value="' . $user->getArmsUrl() . '"  ' . $readOnly . '><br>
                <hr>
                <label for="fname">Tytuł</label><br>
                <input type="text" id="fname" name="title_id" style="width: 100%" placeholder="' . $user->getTitleId() . '" value="' . $user->getTitleId() . '"  ' . $readOnly . '><br>
                <label for="fname">Tytuł honorowy</label><br>
                <input type="text" id="fname" name="honor_title" style="width: 100%" placeholder="' . $user->getHonorTitle() . '" value="' . $user->getHonorTitle() . '"  ' . $readOnly . '><br>
                <hr>
                <label for="fname">Działka zameldowania</label><br>
                <input type="text" id="fname" name="plot_id" style="width: 100%" placeholder="' . $user->getPlotId() . '" value="' . $user->getPlotId() . '"  ' . $readOnly . '><br>
                ';
            echo (in_array("102", $acces)) ? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
            echo ' </form></div>    
                </td>
        </tr>
        
        
       
        </table>
      </div>
       </div>
    
      <div class="w3-half">
        <h5>Dane</h5>
        <table class="w3-table w3-striped" >
          <tr>
            <td style="background-color: white">
                    <h5>Rachunki bankowe</h5>
            <table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `bank_account` WHERE owner_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                echo '  <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i><a href="' . _URLADM . '/bank/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
            <td>' . number_format($row['balance'], 0, ',', ' ') . ' kr</td>

        </tr>';
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Posiadane organizacje</h5><table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `up_organizations` WHERE owner_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $info = System::orgTyp_info($row['type_id']);
                echo '  <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i><a href="' . _URLADM . '/organizacje/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
            <td>' . $row['name'] . '</td>
            <td>' . $info['name'] . '</td>
            
          </tr>';
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Posiadane działki</h5><table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `up_plot` WHERE owner_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $city = System::city_info($row['city_id']);
                echo '  <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i><a href="' . _URLADM . '/dzialki/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
            <td>' . $row['address'] . '</td>
            <td>' . $city['name'] . '</td>
            
          </tr>';
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Posiadane inwestycje</h5><table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `up_user_investments` WHERE user_id = '$id' GROUP BY `investments_id`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                echo '  <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i><a href="' . _URLADM . '/inwestycje/' . $id . '"> #' . $row['id'] . '</a></td>
            <td>' . System::userInvest($id) . ' szt</td>
            <td>' . System::sumInvestUser($id) . ' kr</td>
            <td>' . $row['investments_id'] . '</td>
            
          </tr>';
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Posiadane obywatelstwa</h5><table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `up_user_citizenship` WHERE user_id = '$id' order BY `form_date`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $land = System::land_info($row['state_id']);
                echo '  <tr>
  
            <td><i class="fa fa-user w3-text-blue w3-large"></i><a href="' . _URLADM . '/kraje/' . $row['state_id'] . '"> ' . $land['name'] . '</a></td>
            <td>Data nadania: ' . timeToDate($row['form_date']) . '</td>
            
          </tr>';
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Zatrudnienie w organizacjach</h5>
                <table class="w3-table w3-striped w3-white">
                            <td>ID</td>
            <td>Organizacja</td>
            <td>Pensja</td>
            <td>Częstotli.</td>
            <td>Ost. pensja</td>
            <td>Umowa od</td>
            <td>Umowa do</td>';
            $sql = "SELECT * FROM `up_organizations_workers` WHERE user_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $city = System::getInfo($row['organizations_id']);
                $time = time();
                if ($time < $row['until_date']) {
                    echo '  <tr>
            <td> #' . $row['id'] . '</td>
            <td><i class="fa fa-user w3-text-blue w3-large"></i> <a href="' . _URLADM . '/organizacje/' . $city['id'] . '">' . $city['name'] . '</a></td>
            <td>' . $row['salary'] . ' kr</td>
            <td>' . $row['frequency_days'] . ' dni</td>
            <td>' . timeToDate($row['last_salay_date']) . '</td>
            <td>' . timeToDate($row['from_date']) . '</td>
            <td>' . timeToDate($row['until_date']) . '</td>
            
          </tr>';
                }
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Zatrudnienie w krajach</h5>
                <table class="w3-table w3-striped w3-white">
                            <td>ID</td>
            <td>Kraj</td>
            <td>Pensja</td>
            <td>Częstotliwość</td>
            <td>Ost. pensja</td>
            <td>Umowa od</td>
            <td>Umowa do</td>';
            $sql = "SELECT * FROM `up_countries_workers` WHERE user_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $city = System::getInfo($row['state_id']);
                $time = time();
                if ($time < $row['until_date']) {
                    echo '  <tr>
            <td> #' . $row['id'] . '</td>
            <td><i class="fa fa-user w3-text-blue w3-large"></i> <a href="' . _URLADM . '/mieszkancy/' . $city['id'] . '">' . $city['name'] . '</a></td>
            <td>' . $row['salary'] . ' kr</td>
            <td>' . $row['period_day'] . ' dni</td>
            <td>' . timeToDate($row['last_salary_date']) . '</td>
            <td>' . timeToDate($row['from_date']) . '</td>
            <td>' . timeToDate($row['until_date']) . '</td>
            
          </tr>';
                }
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>IP/Hosts</h5><table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `up_user_login_data` WHERE user_id = '$id' GROUP BY `ip`";
            $sth = $conn->query($sql);
            echo '  <tr>
            <td>IP/host  </td>
            <td>Ilośc wystąpień w tego ID</td>
            <td>Wystąpienia u innych ID</td>
          </tr>';
            while ($row = $sth->fetch()) {
                $sql = "SELECT COUNT(*) FROM `up_user_login_data` WHERE ip =  '$row[ip]' AND user_id = '$id'";
                $stmt_users = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                $sql1 = "SELECT COUNT(*) FROM `up_user_login_data` WHERE ip =  '$row[ip]' AND user_id != '$id'";
                $stmt_users_o = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
                echo '  <tr>
            <td>' . $row['ip'] . ' </td>
            <td>' . $stmt_users[0] . ' wystąpień</td>
            <td><div class="tooltip">' . $stmt_users_o[0] . ' wystąpień
  <span class="tooltiptext">';
                $sql1 = "SELECT * FROM `up_user_login_data` WHERE ip =  '$row[ip]' AND user_id != '$id' GROUP BY `user_id`";
                $sth1 = $conn->query($sql1);
                while ($row1 = $sth1->fetch()) {
                    echo ($row1['user_id'] == $id) ? '<a href="' . _URLADM . '/mieszkancy/' . $row1['user_id2'] . '">' . $row1['user_id2'] . ', ' : '<a href="' . _URLADM . '/mieszkancy/' . $row1['user_id'] . '">' . $row1['user_id'] . ', ';
                }
                echo '</span>
 </div>
            </td>
          </tr>';
            }

            $sql = "SELECT * FROM `up_user_login_data` WHERE user_id = '$id' GROUP BY `ip`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $sql = "SELECT COUNT(*) FROM `up_user_login_data` WHERE host =  '$row[host]' AND user_id = '$id'";
                $stmt_users = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                $sql1 = "SELECT COUNT(*) FROM `up_user_login_data` WHERE host =  '$row[host]' AND user_id != '$id'";
                $stmt_users_o = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
                echo '  <tr>
            <td>' . $row['host'] . ' </td>
            <td>' . $stmt_users[0] . ' wystąpień</td>
            <td><div class="tooltip">' . $stmt_users_o[0] . ' wystąpień
  <span class="tooltiptext">';
                $sql1 = "SELECT * FROM `up_user_login_data` WHERE ip =  '$row[ip]' AND user_id != '$id' GROUP BY `user_id`";
                $sth1 = $conn->query($sql1);
                while ($row1 = $sth1->fetch()) {
                    echo ($row1['user_id'] == $id) ? '<a href="' . _URLADM . '/mieszkancy/' . $row1['user_id2'] . '">' . $row1['user_id2'] . ', ' : '<a href="' . _URLADM . '/mieszkancy/' . $row1['user_id'] . '">' . $row1['user_id'] . ', ';
                }
                echo '</span>
 </div>
            </td>
          </tr>';
            }
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Okruszki ciastka innego mieszkańca</h5>
                    <table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `up_user_login_data_cookies` WHERE user_id = '$id' OR user_id2 = '$id' ORDER BY `time` desc";
            $sth = $conn->query($sql);
            echo '  <tr>
            <td>ID </td>
            <td>Data alertu</td>
            <td></td>
          </tr>';
            while ($row = $sth->fetch()) {
                $sql = "SELECT COUNT(*) FROM `up_user_login_data` WHERE ip =  '$row[ip]' AND user_id = '$id'";
                $stmt_users = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                $sql1 = "SELECT COUNT(*) FROM `up_user_login_data` WHERE ip =  '$row[ip]' AND user_id != '$id'";
                $stmt_users_o = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
                $color = ($row['active'] == 0) ? 'red' : 'black';
                echo '  <tr style="color: ' . $color . '">';
                echo ($row['user_id2'] == $id) ? '<td><a href="' . _URLADM . '/mieszkancy/' . $row['user_id'] . '">' . $row['user_id'] . '</a> </td>' :
                    '<td><a href="' . _URLADM . '/mieszkancy/' . $row['user_id2'] . '">' . $row['user_id2'] . '</a> </td>';
                echo '  <td>' . timeToDateTime($row['time']) . ' </td>';
                echo (in_array("102", $acces)) ? '   <td>  <a href="' . _URLADM . '/mieszkancy/' . $user->getId() . '/ALERT_OK/' . $row['id'] . '"><i class="fa fa-check" aria-hidden="true"></i></a> </td>' : '<td> </td>';
                echo '  </tr>';
                $color = 'black';
            }

            echo '</table>      


 
            </td>
          </tr>
        </table>
      </div>
      
      
    </div>
  </div>';
        }
    } else {

        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-user w3-text-blue w3-large"></i> MIESZKAŃCY</h5><center></center>';


        echo '<input type="text" class="search" style="min-width: 210px"  id="myInput" onkeyup="myFunction()" placeholder="Wprowadź nazwę..">
<table id="myTable" class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-user w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>Nazwa</b></td>
                <td><b>Ostatnie logowanie</b></td>
                <td><i><b>IP</b></i></td>
                <td></td>
            </tr>';
        $sql = "SELECT * FROM `up_users` ORDER BY `id`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $alert_ip_id='';
            $warn = 0;

            $sql1 = "SELECT COUNT(*) FROM `up_user_login_data_cookies` WHERE (user_id = '$row[id]' OR user_id2 = '$row[id]') AND active = 0";
            $alerts = $conn->query($sql1)->fetch(PDO::FETCH_NUM);


            $sql11 = "SELECT * FROM `up_user_login_data` WHERE user_id = '$row[id]' GROUP BY `ip`";
            $sth11 = $conn->query($sql11);
            while ($row11 = $sth11->fetch()) {
                $sql12 = "SELECT COUNT(*) FROM `up_user_login_data` WHERE ip =  '$row11[ip]' AND user_id != '$row[id]'";
                $stmt_users_o = $conn->query($sql12)->fetch(PDO::FETCH_NUM);
                $warn += $stmt_users_o[0];

                $sql1 = "SELECT * FROM `up_user_login_data` WHERE ip =  '$row11[ip]' AND user_id != '$row[id]' GROUP BY `user_id`";
                $sth1 = $conn->query($sql1);
                while ($row1a = $sth1->fetch()) {
                    $alert_ip_id .= ($row1a['user_id']==$row['id'])
                        ? '<a href="'._URLADM.'/mieszkancy/'.$row1a['user_id2'].'">'.$row1a['user_id2'].', '
                        : '<a href="'._URLADM.'/mieszkancy/'.$row1a['user_id'].'">'.$row1a['user_id'].', ';
                }

            }

            $alert = ($alerts[0] != 0) ? '<i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red"></i>' : '';
            $alert_ip = ($warn != 0) ? '<div class="tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: orange"></i>
                    <span class="tooltiptext">'.$alert_ip_id.'</span> </div>' : '';



            echo '<tr>';
            echo ($row['active'] == 0 and $row['last_ip'] != '') ? '<td><i class="fa fa-user w3-text-blue w3-large"></i>  ' . $row['id'] . '</td>'
                : '<td><i class="fa fa-user w3-text-red w3-large"></i> ' . $row['id'] . '</td>';
            echo '<td>' . $alert . ' ' . $alert_ip . ' ' . $row['name'] . '</td>
                <td>' . timeToDateTime(System::lastLogin($row['id'])) . '</td>
                <td><i>' . $row['last_ip'] . '</i></td>
                <td><a href="' . _URL . '/thkxadmin/mieszkancy/' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
            </tr>';
        }
        echo System::lastLogin($row['id']);
        echo ' </table><hr></div>';


    }

} else header('Location: ' . _URLADM);
?>
<script>
    function myFunction() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>