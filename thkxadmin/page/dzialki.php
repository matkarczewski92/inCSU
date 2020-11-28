<?php
if (in_array("2", $acces)) {
    $readOnly = (in_array("106", $acces))? '' : 'readonly';
    $dis = (in_array("106", $acces))? '' : 'disabled';
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK' and $_GET['typ'] != 'sort') {
        $user = new Plot($id);
        $build = ($user->getBuildingId()!='')? new PlotBuilding($user->getBuildingId()): '';

        if (isset($_POST['id'])) {
            $user->setId($_POST['id']);
            $user->setCityId($_POST['city_id']);
            $user->setOwnerId($_POST['owner_id']);
            $user->setAddress($_POST['address']);
            $user->setSquareMeter($_POST['square_meter']);
            $user->setBuildingId($_POST['building_id']);
            $user->setTypeId($_POST['type_id']);
            if($_POST['price']!='') $user->setPrice($_POST['price']);
            header('Location: ' . _URLADM . '/dzialki/' . $id . '/OK');
        } else {
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>';
               echo ($user->getBuildingId()=='')? ' <center><h5>'.$user->getTypeName().'</h5>' : '<center><img src="' . $build->getAvatarUrl() . '" alt="Zdjęcie profilowe" class="profile-img" style="max-width: 150px"><br><h5>'.$build->getName().'</h5>';
               echo' </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $user->getId() . '"  value="' . $user->getId() . '" '.$readOnly.'><br>
                <label for="fname">City ID</label><br>
                <input type="text" id="fname" name="city_id" style="width: 100%" placeholder="' . $user->getCityId() . '"  value="' . $user->getCityId() . '" '.$readOnly.'><br>
                <label for="fname">Owner ID</label><br>
                <input type="text" id="fname" name="owner_id" style="width: 100%" placeholder="' . $user->getOwnerId() . '"  value="' . $user->getOwnerId() . '" '.$readOnly.'><br>
                <label for="fname">Adres</label><br>
                <input type="text" id="fname" name="address" style="width: 100%" placeholder="' . $user->getAddress() . '"  value="' . $user->getAddress() . '" '.$readOnly.'><br>
                <label for="fname">Powierzchnia</label><br>
                <input type="text" id="fname" name="square_meter" style="width: 100%" placeholder="' . $user->getSquareMeter() . '"  value="' . $user->getSquareMeter() . '" '.$readOnly.'><br>
                <label for="fname">ID Budynku</label><br>
                <input type="text" id="fname" name="building_id" style="width: 100%" placeholder="' . $user->getBuildingId() . '"  value="' . $user->getBuildingId() . '" '.$readOnly.'><br>
                <label for="fname">Cena</label><br>
                <input type="text" id="fname" name="price" style="width: 100%" placeholder="' . $user->getPrice() . '"  value="' . $user->getPrice() . '" '.$readOnly.'><br>
                <label for="fname">Typ działki</label><br>
                <select name="type_id" class="normal" style="width: 100%"  '.$dis.'>';
            echo' <option value="' . $user->getTypeId() . '" ">' . $user->getTypeId() . ' - ' . $user->getTypeName() . '<br>';

            $sql = "SELECT * FROM `up_plot_type`";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                echo ($user->getTypeId()!=$row['id'])? '<option value="' . $row['id'] . '" ">' . $row['id'] . ' - ' . $row['name'] . '<br>' : '';
            }

            echo '</select>
           
                
 ';
            echo (in_array("106", $acces))? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
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
          <tr> <td></td></tr><tr> <td style="background-color: white"><h5>Budynek</h5><table class="w3-table w3-striped w3-white">
                    <td> #ID</td>
            <td>Nazwa</td>
            <td>Powierzchnia</td>
            <td>Data wybudowania</td>
            <td>Początek budowy</td>
            <td>Koniec budowy</td>
          ';
            $bid = $user->getBuildingId();
            $sql = "SELECT * FROM `up_plot_building` WHERE id = '$bid'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $build = new PlotBuilding($row['id']);
                echo '  <tr>
            <td><a href="' . _URLADM . '/budynki/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
            <td>' . $build->getName() . '</td>
            <td>' . $build->getSquareMeter() . ' m2</td>
            <td>' . timeToDate($build->getDateBuild()) . '</td>
            <td>' . timeToDate($build->getStartBuild()) . '</td>
            <td>' . timeToDate($build->getFinishBuild()) . '</td>
          </tr>
          <tr>
          <td colspan="6"><center><img src="' . $build->getGfxUrl() . '" style="max-width: 75%"> </center></td>
</tr>
          ';
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
        $sort = $_GET['ptyp'];
        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-bullseye w3-text-blue w3-large"></i> DZIAŁKI</h5><center>
            ';
        $sql = "SELECT * FROM `up_cities`";
        echo ($_GET['typ']=='sort')? ' <a href="'._URLADM.'/dzialki" style="color:black; text-decoration: none">WSZYSTKIE</a> -' :
            ' <a href="'._URLADM.'/dzialki" style="color:red; text-decoration: none">WSZYSTKIE</a> -';
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            echo ($sort!=$row['id'])? ' <a href="'._URLADM.'/dzialki/sort/'.$row['id'].'" style="color:black; text-decoration: none">'.$row['name'].'</a> -' :
                ' <a href="'._URLADM.'/dzialki/sort/'.$row['id'].'" style="color:red; text-decoration: none">'.$row['name'].'</a> -';
        }
        $inSort = ($_GET['typ']=='sort')? 'WHERE city_id = \''.$sort.'\' ':'';
               echo '<hr></center><input type="text" class="search" style="min-width: 210px"  id="myInput" onkeyup="myFunction()" placeholder="Wprowadź id..">
<table id="myTable"  class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-bullseye w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>Miasto</b></td>
                <td><b>Właściciel</b></td>
                <td><b>Adres</b></td>
                <td><b>Typ</b></td>

                <td></td>
            </tr>';
        $sql = 'SELECT * FROM `up_plot` '.$inSort.' ORDER BY `city_id`';
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
                $city = new Plot($row['id']);
                $city_info = System::city_info($city->getCityId());
                $own_info = System::getInfo($city->getOwnerId());
                echo '<tr>';
                echo '<td><i class="fa fa-bullseye w3-text-blue w3-large"></i>  ' . $row['id'] . '</td>';
                echo '<td>' . $city->getCityId() . ' ' . $city_info['name'] . '</td>
                        <td>' . $city->getOwnerId() . ' '.$own_info['name'].'</td>
                        <td>' . $city->getAddress() . '</td>
                        <td>' . $city->getTypeName() . '</td>
                <td></td>

                <td><a href="' . _URL . '/thkxadmin/dzialki/' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
            </tr>';

        }
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
            td = tr[i].getElementsByTagName("td")[0];
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