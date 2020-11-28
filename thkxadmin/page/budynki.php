<?php
if (in_array("7", $acces)) {
    $readOnly = (in_array("107", $acces))? '' : 'readonly';
    $dis = (in_array("107", $acces))? '' : 'disabled';
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK' and $_GET['typ'] != 'sort') {
        $build = new PlotBuilding($id);
        $user = new PlotBuilding($id);
        if($_GET['ptyp']=='usun'){
            $sql = "DELETE FROM `up_plot_building` WHERE id='$id'";
            $conn->exec($sql);
            header('Location: ' . _URLADM . '/budynki');
        } else if (isset($_POST['id'])) {

                $build->setId($_POST['id']);
                $build->setPlotId($_POST['plot_id']);
                $build->setName($_POST['name']);
                $build->setSquareMeter($_POST['square_meter']);
                $build->setAvatarUrl($_POST['avatar_url']);
                $build->setGfxUrl($_POST['gfx_url']);
                $build->setDateBuild($_POST['date_build']);
                $build->setStartBuild($_POST['start_build_date']);
                $build->setFinishBuild($_POST['finish_build_date']);
                $build->setBuildOrganization($_POST['build_org_id']);

                header('Location: ' . _URLADM . '/budynki/' . $id . '/OK');

        } else {
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>';
            echo '<center><img src="' . $build->getAvatarUrl() . '" alt="Zdjęcie profilowe" class="profile-img" style="max-width: 150px"><br><h5>'.$build->getName().'</h5>';
            echo' </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $user->getId() . '"  value="' . $user->getId() . '" '.$readOnly.'><br>
                <label for="fname">ID Działki</label><br>
                <input type="text" id="fname" name="plot_id" style="width: 100%" placeholder="' . $user->getPlotId() . '"  value="' . $user->getPlotId() . '" '.$readOnly.'><br>
                 <label for="fname">Nazwa</label><br>
                <input type="text" id="fname" name="name" style="width: 100%" placeholder="' . $user->getName() . '"  value="' . $user->getName() . '" '.$readOnly.'><br>
                <label for="fname">Powierzchnia</label><br>
                <input type="text" id="fname" name="square_meter" style="width: 100%" placeholder="' . $user->getSquareMeter() . '"  value="' . $user->getSquareMeter() . '" '.$readOnly.'><br>
                <label for="fname">URL Avatara</label><br>
                <input type="text" id="fname" name="avatar_url" style="width: 100%" placeholder="' . $user->getAvatarUrl() . '"  value="' . $user->getAvatarUrl() . '" '.$readOnly.'><br>
                <label for="fname">URL Grafiki</label><br>
                <input type="text" id="fname" name="gfx_url" style="width: 100%" placeholder="' . $user->getGfxUrl() . '"  value="' . $user->getGfxUrl() . '" '.$readOnly.'><br>
                <label for="fname">Data odbioru</label><br>
                <input type="text" id="fname" name="date_build" style="width: 100%" placeholder="' . $user->getDateBuild() . '"  value="' . $user->getDateBuild() . '" '.$readOnly.'><br>
                <label for="fname">Data początku budowy</label><br>
                <input type="text" id="fname" name="start_build_date" style="width: 100%" placeholder="' . $user->getStartBuild() . '"  value="' . $user->getStartBuild() . '" '.$readOnly.'><br>
                <label for="fname">Data końca budowy</label><br>
                <input type="text" id="fname" name="finish_build_date" style="width: 100%" placeholder="' . $user->getFinishBuild() . '"  value="' . $user->getFinishBuild() . '" '.$readOnly.'><br>
                <label for="fname">Przedsiebiorstwo budowlane</label><br>
                <input type="text" id="fname" name="build_org_id" style="width: 100%" placeholder="' . $user->getBuildOrganization() . '"  value="' . $user->getBuildOrganization() . '" '.$readOnly.'><br>';
            echo (in_array("107", $acces))? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
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
                  
            <td>Działka</td>
            <td>Powierzchnia</td>
            <td>Data wybudowania</td>
            <td>Początek budowy</td>
            <td>Koniec budowy</td>
          ';
            $bid = $user->getId();
            $sql = "SELECT * FROM `up_plot_building` WHERE id = '$bid'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $build = new PlotBuilding($row['id']);
                echo '  <tr>
           
            <td><a href="' . _URLADM . '/dzialki/' . $build->getPlotId() . '">' . $build->getPlotId() . '</td>
            <td>' . $build->getSquareMeter() . '</td>
            <td>' . timeToDate($build->getDateBuild()) . '</td>
            <td>' . timeToDate($build->getStartBuild()) . '</td>
            <td>' . timeToDate($build->getFinishBuild()) . '</td>
          </tr>
          <tr>
          <td colspan="6"><center><img src="' . $build->getGfxUrl() . '" style="max-width: 75%"> </center></td>
</tr>
          ';
            }

            echo '</table> </td></tr><tr> <td></td></tr><tr> <td style="background-color: white">  <table class="w3-table w3-striped" >
          <tr> <td></td></tr><tr> <td style="background-color: white"><table class="w3-table w3-striped w3-white">
                  
          ';
            $bid = $user->getId();
            $sql = "SELECT * FROM `up_plot_building` WHERE id = '$bid'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $build = new PlotBuilding($row['id']);
                echo '  <tr><form action="' . _URLADM . '/budynki/' . $build->getId() . '/usun" method="post">';
           
             echo (in_array("106", $acces))? '<button type="submit" CLASS="button" style="width: 100%">USUŃ</button><br>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI</P>';

                echo ' </form></tr>

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
        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-bank w3-text-blue w3-large"></i> BUDYNKI</h5><center>
            ';
        $inSort = ($_GET['typ']=='sort')? 'WHERE city_id = \''.$sort.'\' ':'';
        echo '<hr></center><input type="text" class="search" style="min-width: 210px"  id="myInput" onkeyup="myFunction()" placeholder="Wprowadź id..">
<table id="myTable"  class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-bank w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>ID </b></td>
                <td><b>Działka</b></td>
                <td><b>Data rozpoczecia</b></td>
                <td><b>Data zakończenia budowy</b></td>

                <td></td>
            </tr>';
        $sql = 'SELECT * FROM `up_plot_building`';
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $city = new PlotBuilding($row['id']);
            echo '<tr>';
            echo '<td><i class="fa fa-bank w3-text-blue w3-large"></i>  ' . $row['id'] . '</td>';
            echo '<td>' . $city->getName() . ' '.$own_info['name'].'</td>
                        <td>' . $city->getPlotId() . '</td>
                        <td>' . timeToDate($city->getStartBuild()) . '</td>
                        <td>' . timeToDate($city->getFinishBuild()) . '</td>
                <td></td>
                <td><a href="' . _URL . '/thkxadmin/budynki/' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
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