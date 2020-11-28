<?php
if (in_array("8", $acces)) {
    $readOnly = (in_array("108", $acces))? '' : 'readonly';
    $dis = (in_array("108", $acces))? '' : 'disabled';
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK' and $_GET['typ'] != 'sort') {
        $build = System::blueprintInfo($id);
        $user = new PlotBuilding($id);
        if($_GET['ptyp']=='usun'){
            $sql = "DELETE FROM `up_plot_blueprints` WHERE id='$id'";
            $conn->exec($sql);
            header('Location: ' . _URLADM . '/projekty');
        } else if($_GET['ptyp']=='accept'){
            update('up_plot_blueprints','id',$id,'accept','1');
            header('Location: ' . _URLADM . '/projekty/' . $id . '/OK');
        } else if($_GET['ptyp']=='reject'){
            update('up_plot_blueprints','id',$id,'accept','0');
            header('Location: ' . _URLADM . '/projekty/' . $id . '/OK');
        } else if (isset($_POST['id'])) {
            update('up_plot_blueprints','id',$id,'accept',$_POST['']);
            update('up_plot_blueprints','id',$id,'name',$_POST['name']);
            update('up_plot_blueprints','id',$id,'gfx_url',$_POST['gfx_url']);
            update('up_plot_blueprints','id',$id,'metrage',$_POST['metrage']);
            update('up_plot_blueprints','id',$id,'price',$_POST['price']);
            update('up_plot_blueprints','id',$id,'build_duration',$_POST['build_duration']);
            update('up_plot_blueprints','id',$id,'plot_id',$_POST['plot_id']);
            update('up_plot_blueprints','id',$id,'author_id',$_POST['author_id']);
            update('up_plot_blueprints','id',$id,'adm_cost',$_POST['adm_cost']);


            header('Location: ' . _URLADM . '/projekty/' . $id . '/OK');

        } else {
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>
                    <center><img src="' . $build['gfx_url'] . '" alt="Zdjęcie profilowe" class="profile-img" style="max-width: 75%"><br>';
            echo' </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $build['id'] . '"  value="' . $build['id'] . '" '.$readOnly.'><br>
               <label for="fname">Nazwa</label><br>
                <input type="text" id="fname" name="name" style="width: 100%" placeholder="' . $build['name'] . '"  value="' . $build['name'] . '" '.$readOnly.'><br>
               <label for="fname">URL Grafiki</label><br>
                <input type="text" id="fname" name="gfx_url" style="width: 100%" placeholder="' . $build['gfx_url'] . '"  value="' . $build['gfx_url'] . '" '.$readOnly.'><br>
               <label for="fname">Powierzchnia</label><br>
                <input type="text" id="fname" name="metrage" style="width: 100%" placeholder="' . $build['metrage'] . '"  value="' . $build['metrage'] . '" '.$readOnly.'><br>
               <label for="fname">Czas budowy</label><br>
                <input type="text" id="fname" name="build_duration" style="width: 100%" placeholder="' . $build['build_duration'] . '"  value="' . $build['build_duration'] . '" '.$readOnly.'><br>
               <label for="fname">ID Działki </label><br>
                <input type="text" id="fname" name="plot_id" style="width: 100%" placeholder="' . $build['plot_id'] . '"  value="' . $build['plot_id'] . '" '.$readOnly.'><br>
               <label for="fname">ID Autora</label><br>
                <input type="text" id="fname" name="author_id" style="width: 100%" placeholder="' . $build['author_id'] . '"  value="' . $build['author_id'] . '" '.$readOnly.'><br>
               <label for="fname">Koszt administracyjny</label><br>
                <input type="text" id="fname" name="adm_cost" style="width: 100%" placeholder="' . $build['adm_cost'] . '"  value="' . $build['adm_cost'] . '" '.$readOnly.'><br>
               
                ';

            echo (in_array("108", $acces))? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
            echo'
             </form></div>    
                </td>
        </tr>
        
        
       
        </table>
      </div>
       </div>
    
      <div class="w3-half">
        <h5>Działanie</h5>
         </td></tr><tr> <td></td></tr><tr> <td style="background-color: white">  <table class="w3-table w3-striped" >
          <tr> <td></td></tr><tr> <td style="background-color: white"><table class="w3-table w3-striped w3-white">
                  
          ';

            $sql = "SELECT * FROM `up_plot_blueprints` WHERE id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                echo '  <tr><form action="' . _URLADM . '/projekty/' . $id . '/usun" method="post">';

                echo (in_array("108", $acces))? '<button type="submit" CLASS="button" style="width: 100%">USUŃ</button><br>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI</P>';

                echo ' </form></tr>

          ';
            }

            echo '</table>  </td></tr><tr> <td></td></tr><tr> <td style="background-color: white">  <table class="w3-table w3-striped" >
           <td style="background-color: white"><table class="w3-table w3-striped w3-white">
                  
          ';

            $sql = "SELECT * FROM `up_plot_blueprints` WHERE id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                echo '  <tr>';

                echo (in_array("108", $acces) AND $build['accept']!=1)? '<form action="' . _URLADM . '/projekty/' . $id . '/accept" method="post"><button type="submit" CLASS="button" style="width: 100%">ZATWIERDŹ</button></form><br>' : '';
                echo (in_array("108", $acces) AND $build['accept']==1)? '<form action="' . _URLADM . '/projekty/' . $id . '/reject" method="post"><button type="submit" CLASS="button" style="width: 100%">WYCOFAJ</button></form><br>' : '';

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
        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-bell w3-text-blue w3-large"></i> PROJEKTY</h5><center>
            ';
        $inSort = ($_GET['typ']=='sort')? 'WHERE city_id = \''.$sort.'\' ':'';
        echo '<hr></center><input type="text" class="search" style="min-width: 210px"  id="myInput" onkeyup="myFunction()" placeholder="Wprowadź id..">
<table id="myTable"  class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-bell w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>Nazwa</b></td>
                <td><b>Działka</b></td>
                <td><b>Autor</b></td>


                <td></td>
            </tr>';
        $sql = 'SELECT * FROM `up_plot_blueprints` ORDER BY `accept` ';
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            echo '<tr>';
            echo ($row['accept']=='1')? '<td><i class="fa fa-bell w3-text-blue w3-large"></i>  ' . $row['id'] . '</td>' :
                '<td><i class="fa fa-bell w3-text-red w3-large"></i>  ' . $row['id'] . '</td>';
            echo '<td>' . $row['name'] . ' </td>
                        <td>' . $row['plot_id'] . '</td>
                        <td>' . $row['author_id'] . '</td>

                <td></td>
                <td><a href="' . _URL . '/thkxadmin/projekty/' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
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