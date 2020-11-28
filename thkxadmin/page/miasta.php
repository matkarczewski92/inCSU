<?php
if (in_array("2", $acces)) {
    $readOnly = (in_array("105", $acces))? '' : 'readonly';
    $dis = (in_array("105", $acces))? '' : 'disabled';
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK') {
        $user = System::city_info($id);

        if (isset($_POST['id'])) {
            update('up_cities','id',$id,'id',$_POST['id']);
            update('up_cities','id',$id,'name',$_POST['name']);
            update('up_cities','id',$id,'leader_id',$_POST['leader_id']);
            update('up_cities','id',$id,'webpage_url',$_POST['webpage_url']);
            update('up_cities','id',$id,'gfx_url',$_POST['gfx_url']);
            update('up_cities','id',$id,'arm_url',$_POST['arm_url']);





            header('Location: ' . _URLADM . '/miasta/' . $id . '/OK');
        } else {
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>
                <center><img src="' . $user['gfx_url'] . '" alt="Zdjęcie profilowe" class="profile-img" style="max-width: 150px"><br><h5>'.$user['name'].'</h5>
                </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $user['id'] . '"  value="' . $user['id'] . '" '.$readOnly.'><br>
                <label for="fname">Nazwa</label><br>
                <input type="text" id="fname" name="name" style="width: 100%" placeholder="' . $user['name'] . '"  value="' . $user['name'] . '"  '.$readOnly.'><br>
                <label for="fname">ID Lidera</label><br>
                <input type="text" id="fname" name="leader_id" style="width: 100%" placeholder="' . $user['leader_id'] . '"  value="' . $user['leader_id'] . '"  '.$readOnly.'><br>
                <label for="fname">Adres WWW</label><br>
                <input type="text" id="fname" name="webpage_url" style="width: 100%" placeholder="' . $user['webpage_url'] . '"  value="' . $user['webpage_url'] . '"  '.$readOnly.'><br>
                <label for="fname">URL avatara </label><br>
                <input type="text" id="fname" name="gfx_url" style="width: 100%" placeholder="' . $user['gfx_url'] . '"  value="' . $user['gfx_url'] . '"  '.$readOnly.'><br>
                 <label for="fname">URL herbu</label><br>
                <input type="text" id="fname" name="arm_url" style="width: 100%" placeholder="' . $user['arm_url'] . '"  value="' . $user['arm_url'] . '"  '.$readOnly.'><br>  
                
 ';
            echo (in_array("105", $acces))? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
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
            echo '</table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Posiadane działki</h5><table class="w3-table w3-striped w3-white">';
            $sql = "SELECT * FROM `up_plot` WHERE city_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $city = System::city_info($row['city_id']);
                echo '  <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i><a href="' . _URLADM . '/dzialki/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
            <td>' . $row['address'] . '</td>
            <td>' . $row['owner_id'] . '</td>
            
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

        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-bandcamp w3-text-blue w3-large"></i> MIASTA</h5><center></center>
<input type="text" class="search" style="min-width: 210px"  id="myInput" onkeyup="myFunction()" placeholder="Wprowadź nazwę..">
<table id="myTable" class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-bandcamp w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>Nazwa</b></td>
                <td><b>Zarządca</b></td>

                <td></td>
            </tr>';
        $sql = "SELECT * FROM `up_countries`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $sql1 = "SELECT * FROM `up_cities` WHERE state_id = '$row[id]' ORDER BY `id`";
            $sth1 = $conn->query($sql1);
            echo '<tr><td colspan="4"><h5>'.$row['name'].'</h5></td></tr>';
            while ($row1 = $sth1->fetch()) {
                $leader = System::user_info($row1['leader_id']);
                echo '<tr>';
                echo '<td><i class="fa fa-bandcamp w3-text-blue w3-large"></i>  ' . $row1['id'] . '</td>';
                echo '<td>' . $alert . ' ' . $row1['name'] . '</td>
                <td><a href="'._URLADM.'/mieszkancy/'.$leader['id'].'">' . $leader['id'] . ' ' . $leader['name'] . ' </td>

                <td><a href="' . _URL . '/thkxadmin/miasta/' . $row1['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
            </tr>';
            }
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