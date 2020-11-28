<?php
if (in_array("2", $acces)) {
    $readOnly = (in_array("103", $acces))? '' : 'readonly';
    $dis = (in_array("103", $acces))? '' : 'disabled';
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK') {
        $user = new Organizations($id);

        if (isset($_POST['id'])) {
            $user->setId($_POST['id']);
            $user->setActive($_POST['active']);
            $user->setName($_POST['name']);
            $user->setOwnerId($_POST['owner_id']);
            $user->setLeaderId($_POST['leader_id']);
            $user->setGfxUrl($_POST['gfx_url']);
            $user->setMainBankAcc($_POST['main_bank_acc']);
            $user->setStateId($_POST['state_id']);
            $user->setTypeId($_POST['type_id']);
            $user->setLaw($_POST['law']);
            $user->setLawIdMain($_POST['law_id_main']);
            $user->setProposal($_POST['proposal']);


            header('Location: ' . _URLADM . '/organizacje/' . $id . '/OK');
        } else {
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>
                <center><img src="' . $user->getGfxUrl() . '" alt="Zdjęcie profilowe" class="profile-img" style="max-width: 150px"><br><h5>'.$user->getName().'</h5>
                </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $user->getId() . '"  value="' . $user->getId() . '" '.$readOnly.'><br>
                <label for="fname">Czy aktywny</label><br>
                <select name="active" class="normal" style="width: 100%" '.$dis.'>';
            echo ($user->getActive() == '0') ? '<option value="0">TAK' : '<option value="1">NIE';
            echo ($user->getActive() == '0') ? '<option value="1">NIE' : '<option value="0">TAK';
            echo ' </select>
                <hr>
                <label for="fname">Nazwa</label><br>
                <input type="text" id="fname" name="name" style="width: 100%" placeholder="' . $user->getName() . '"  value="' . $user->getName() . '"  '.$readOnly.'><br>
                <label for="fname">ID Właściciela</label><br>
                <input type="text" id="fname" name="owner_id" style="width: 100%" placeholder="' . $user->getOwnerId() . '"  value="' . $user->getOwnerId() . '"  '.$readOnly.'><br>
                <label for="fname">ID Lidera</label><br>
                <input type="text" id="fname" name="leader_id" style="width: 100%" placeholder="' . $user->getLeaderId() . '"  value="' . $user->getLeaderId() . '"  '.$readOnly.'><br>
                 <label for="fname">URL Grafiki</label><br>
                <input type="text" id="fname" name="gfx_url" style="width: 100%" placeholder="' . $user->getGfxUrl() . '"  value="' . $user->getGfxUrl() . '"  '.$readOnly.'><br>  
                <label for="fname">Nr rachunku głównego</label><br>
                <input type="text" id="fname" name="main_bank_acc" style="width: 100%" placeholder="' . $user->getMainBankAcc() . '"  value="' . $user->getMainBankAcc() . '"  '.$readOnly.'><br>  
                <label for="fname">ID Kraju</label><br>
                <input type="text" id="fname" name="state_id" style="width: 100%" placeholder="' . $user->getStateId() . '"  value="' . $user->getStateId() . '"  '.$readOnly.'><br> 
                <label for="fname">Typ organizacji</label><br>
                <select name="type_id" class="normal" style="width: 100%" '.$dis.'> 
                "';
            $type = System::orgTyp_info($user->getTypeId());
            echo' <option value="' . $user->getTypeId() . '" ">' . $user->getTypeId() . ' - ' . $type['name'] . '<br>';


            $sql = "SELECT * FROM `up_organizations_type`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                echo ($user->getTypeId()!=$row['id'])? '<option value="' . $row['id'] . '" ">' . $row['id'] . ' - ' . $row['name'] . '<br>' : '';
            }

            echo '</select><div class="w3-half">
            <label for="fname">Publikacja prawa </label><br>
                <select name="law" class="normal" style="width: 80%; height: 45px" '.$dis.'> ';
            echo ($user->getLaw() == '1') ? '<option value="1">TAK' : '<option value="0">NIE';
            echo ($user->getLaw() == '1') ? '<option value="0">NIE' : '<option value="1">TAK';
            echo ' </select></div><div class="w3-half"> 
                    <label for="fname">Kategoria publikowanego prawa</label><br>
                    <input type="text" id="fname" name="law_id_main" style="width: 100%" placeholder="' . $user->getLawIdMain() . '"  value="' . $user->getLawIdMain() . '"  '.$readOnly.'><br>  
                </div>
                <label for="fname">Moduł wniosków</label><br>
                <select name="proposal" class="normal" style="width: 100%; height: 45px" '.$dis.'> ';
            echo ($user->getProposal() == '1') ? '<option value="1">TAK' : '<option value="0">NIE';
            echo ($user->getProposal() == '1') ? '<option value="0">NIE' : '<option value="1">TAK';
            echo ' </select>

 ';
            echo (in_array("103", $acces))? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
            echo'
             </form></div>    
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

            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Pracownicy</h5>
                <table class="w3-table w3-striped w3-white">
                            <td><i class="fa fa-user w3-text-blue w3-large"></i>ID Umowy</td>
            <td>Pracownik</td>
            <td>Pensja</td>
            <td>Częstotliwość</td>
            <td>Ost. pensja</td>
            <td>Umowa od</td>
            <td>Umowa do</td>';
            $sql = "SELECT * FROM `up_organizations_workers` WHERE `organizations_id` = '$id' ORDER BY `from_date`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $city = System::user_info($row['user_id']);
                $time = time();
                echo ($time>$row['until_date'])? '<tr style="color: silver">
            <td><i class="fa fa-user w3-text-blue w3-large"></i> #' . $row['id'] . '</td>
            <td><a href="' . _URLADM . '/mieszkancy/' . $city['id'] . '">' . $city['name'] . '</a></td>
            <td>' . $row['salary'] . ' kr</td>
            <td>' . $row['frequency_days'] . ' dni</td>
            <td>' .timeToDate( $row['last_salay_date']) . '</td>
            <td>' . timeToDate($row['from_date']) . '</td>
            <td>' . timeToDate($row['until_date']) . '</td>
            
          </tr>' : '  <tr >
            <td><i class="fa fa-user w3-text-blue w3-large"></i> #' . $row['id'] . '</td>
            <td><a href="' . _URLADM . '/mieszkancy/' . $city['id'] . '">' . $city['name'] . '</a></td>
            <td>' . $row['salary'] . ' kr</td>
            <td>' . $row['frequency_days'] . ' dni</td>
            <td>' .timeToDate( $row['last_salay_date']) . '</td>
            <td>' . timeToDate($row['from_date']) . '</td>
            <td>' . timeToDate($row['until_date']) . '</td>
            
          </tr>';
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

        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-sitemap w3-text-blue w3-large"></i> ORGANIZACJE</h5><center></center>
<input type="text" class="search" style="min-width: 210px" id="myInput" onkeyup="myFunction()" placeholder="Wprowadź nazwę..">
<table id="myTable" class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-sitemap w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>Nazwa</b></td>
                <td><b>Typ organizacji</b></td>

                <td></td>
            </tr>';
        $sql = "SELECT * FROM `up_organizations` ORDER BY `id`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $type_info = System::orgTyp_info($row['type_id']);
              echo '<tr>';
            echo '<td><i class="fa fa-sitemap w3-text-blue w3-large"></i>  ' . $row['id'] . '</td>';
            echo '<td>'.$alert.' ' . $row['name'] . '</td>
                <td>' . $type_info['name'] . '</td>

                <td><a href="' . _URL . '/thkxadmin/organizacje/' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
            </tr>';
        }
        echo System::lastLogin($row['id']);
        echo ' </table><hr></div>';


    }

} else header('Location: '._URLADM);
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