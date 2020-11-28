<?php
if (in_array("9", $acces)) {
    $readOnly = (in_array("109", $acces)) ? '' : 'readonly';
    $dis = (in_array("109", $acces)) ? '' : 'disabled';
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK' and $_GET['typ'] != 'sort') {
        $build = new Investments($id);
        if ($_GET['ptyp'] == 'lvlup') {
            $build->admLvlUp();
            header('Location: ' . _URLADM . '/inwestycje/' . $id . '/OK');
        } else if ($_GET['ptyp'] == 'lvldown') {
            $build->admLvlDown();
            header('Location: ' . _URLADM . '/inwestycje/' . $id . '/OK');
        } else if (isset($_POST['id'])) {
            $build->setInvId($_POST['id']);
            $build->setUserId($_POST['user_id']);
            $build->setActualLevel($_POST['level']);
            $build->setActualMoney($_POST['money']);
            $build->setLastGet($_POST['last_get']);
            $build->setNextGet($_POST['next_get']);
            $build->setInvestmentsId($_POST['investments_id']);
            header('Location: ' . _URLADM . '/inwestycje/' . $id . '/OK');

        } else {
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>
                    
            </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $build->getInvId() . '"  value="' . $build->getInvId() . '" ' . $readOnly . '><br>
               <label for="fname">ID Mieszkańca</label><br>
                <input type="text" id="fname" name="user_id" style="width: 100%" placeholder="' . $build->getUserId() . '"  value="' . $build->getUserId() . '" ' . $readOnly . '><br>
               <label for="fname">Poziom</label><br>
                <input type="number" id="fname" name="level" style="width: 100%" placeholder="' . $build->getActualLevel() . '"  value="' . $build->getActualLevel() . '" ' . $readOnly . '><br>
               <label for="fname">Dochód</label><br>
                <input type="number" id="fname" name="money" style="width: 100%" placeholder="' . $build->getActualMoney() . '"  value="' . $build->getActualMoney() . '" ' . $readOnly . '><br>
               <label for="fname">Ostatnie zbiory</label><br>
                <input type="text" id="fname" name="last_get" style="width: 100%" placeholder="' . $build->getLastGet() . '"  value="' . $build->getLastGet() . '" ' . $readOnly . '><br>
               <label for="fname">Następne zbiory </label><br>
                <input type="text" id="fname" name="next_get" style="width: 100%" placeholder="' . $build->getNextGet() . '"  value="' . $build->getNextGet() . '" ' . $readOnly . '><br>
               <label for="fname">Typ inwestycji</label><br>
                <input type="text" id="fname" name="investments_id" style="width: 100%" placeholder="' . $build->getInvestmentsId() . '"  value="' . $build->getInvestmentsId() . '" ' . $readOnly . '><br>

                ';

            echo (in_array("109", $acces)) ? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
            echo '
             </form></div>    
                </td>
        </tr>
        
        
       
        </table>
      </div>
       </div>
    
      <div class="w3-half">
        <h5>Działanie</h5>
         </td></tr><tr> <td style="background-color: white">  
         <table class="w3-table w3-striped" >
           <td style="background-color: white">
           <table class="w3-table w3-striped w3-white">';


            echo '  <tr><form action="' . _URLADM . '/inwestycje/' . $id . '/lvlup" method="post">';

            echo (in_array("109", $acces)) ? '<button type="submit" CLASS="button" style="width: 100%">ZWIEKSZ POZIOM ( ' . number_format($build->getNextLevelMoney(), 0, ',', ' ') . ' kr)</button><br>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI</P>';

            echo ' </form></tr>';


            echo '</table>  </td></tr><tr> <td></td></tr><tr> 
            <td style="background-color: white">  
            <table class="w3-table w3-striped" >
           <td style="background-color: white">
           <table class="w3-table w3-striped w3-white">
           <tr><form action="' . _URLADM . '/inwestycje/' . $id . '/lvldown" method="post">';

            echo (in_array("109", $acces)) ? '<button type="submit" CLASS="button" style="width: 100%">ZMNIEJSZ POZIOM ( ' . number_format($build->getLastMoney(), 0, ',', ' ') . ' kr)</button><br>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI</P>';

            echo ' </form></tr></table>  


 
            </td>
          </tr>
        </table>
      </div>
      
      
    </div>
  </div>';
        }
    } else {
        $sort = $_GET['ptyp'];
        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-diamond w3-text-blue w3-large"></i> INWESTYCJE</h5><center>
            ';
        $inSort = ($_GET['typ'] == 'sort') ? 'WHERE city_id = \'' . $sort . '\' ' : '';
        echo '<hr></center><input type="text" class="search" style="min-width: 210px"  id="myInput" onkeyup="myFunction()" placeholder="Wprowadź id usera..">
<table id="myTable"  class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-diamond w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>ID Usera</b></td>
                <td><b>Poziom</b></td>
                <td><b>Dochod</b></td>
                <td><b>Typ inwestycji</b></td>


                <td></td>
            </tr>';
        $sql = 'SELECT * FROM `up_user_investments`';
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            echo '<tr>';
            echo '<td><i class="fa fa-diamond w3-text-blue w3-large"></i>  ' . $row['id'] . '</td>';

            echo '<td>' . $row['user_id'] . ' </td>
                        <td>' . $row['level'] . '</td>
                        <td>' . $row['money'] . '</td>
                        <td>' . $row['investments_id'] . '</td>

                <td></td>
                <td><a href="' . _URL . '/thkxadmin/inwestycje/' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
            </tr>';

        }
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