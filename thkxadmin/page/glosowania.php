<?php
if (in_array("16", $acces)) {
    $readOnly = (in_array("116", $acces)) ? '' : 'readonly';
    $dis = (in_array("116", $acces)) ? '' : 'disabled';
    $id = $_GET['typ'];

    if (isset($_GET['typ']) and $_GET['typ'] != 'OK') {
        $data = new Probe($id);
        if ($_GET['ptyp'] == 'end') {
            $time_end = time() - 10;
            update('up_probe', 'id', $id, 'date_until', $time_end);
            header('Location: ' . _URLADM . '/glosowania/' . $id . '/OK');
        }
        if (isset($_POST['id'])) {

            header('Location: ' . _URLADM . '/glosowania/' . $id . '/OK');
        } else {
            echo '<div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
    
      <div class="w3-half" >
        <h5>Profil</h5>
        <div class="w3" style="background-color: white; width: 100%; min-height: 500px">
                    <div class="card-header"><br>
                <center><h5>' . $data->getTitle() . '</h5>
                </center>
            </div>
        <table class="w3-table w3-striped w3-white">
           
            <tr>
            <td style="background-color: white">
            <div class="form" style="background-color: white"><form action="" method="post" >
                <label for="fname">ID</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getId() . '"  value="' . $data->getId() . '" ' . $readOnly . '><br>
                <label for="fname">Tytł</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getTitle() . '"  value="' . $data->getTitle() . '" ' . $readOnly . '><br>
                <label for="fname">Treść</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getText() . '"  value="' . $data->getText() . '" ' . $readOnly . '><br>
                <label for="fname">Data od</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getDateFrom() . '"  value="' . $data->getDateFrom() . '" ' . $readOnly . '><br>
                <label for="fname">Data do</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getDateUntil() . '"  value="' . $data->getDateUntil() . '" ' . $readOnly . '><br>
                <label for="fname">Target</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getTargetState() . '"  value="' . $data->getTargetState() . '" ' . $readOnly . '><br>
                <label for="fname">Czy obywatelstwo</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getCitizenship() . '"  value="' . $data->getCitizenship() . '" ' . $readOnly . '><br>
                <label for="fname">Typ </label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getTypeId() . '"  value="' . $data->getTypeId() . '" ' . $readOnly . '><br>
                <label for="fname">Ilosc głosów</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getAnswers() . '"  value="' . $data->getAnswers() . '" ' . $readOnly . '><br>
                <label for="fname">Organizator</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getOrganization() . '"  value="' . $data->getOrganization() . '" ' . $readOnly . '><br>
                <label for="fname">Rodzaj wyników</label><br>
                <input type="text" id="fname" name="id" style="width: 100%" placeholder="' . $data->getOfficial() . '"  value="' . $data->getOfficial() . '" ' . $readOnly . '><br>
                
                
                
                
                ';


            echo (in_array("116", $acces)) ? '<button type="submit" CLASS="button" style="width: 100%">EDYTUJ</button><br><hr>' : '<P ALIGN="CENTER">BRAK MOŻLIWOŚCI EDYCJI PROFILÓW</P>';
            echo '
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
                    <h5>Możliwe odpowiedzi</h5>
            <table class="w3-table w3-striped w3-white">';
            $sum = 0;
            $sql = "SELECT * FROM `up_probe_questions` WHERE probe_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $sql1 = "SELECT COUNT(*) FROM `up_user_probe_vote` WHERE answer_id = '$row[id]'";
                $stmt_users = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
                $answers[$row['id']] = $stmt_users[0];
                $sum += $stmt_users[0];
            }
            $sql = "SELECT * FROM `up_probe_questions` WHERE probe_id = '$id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $percent = ($answers[$row['id']] * 100) / $sum;
                echo '  <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i><a href="' . _URLADM . '/bank/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
            <td>' . $row['answer'] . '</td>
            <td>' . number_format($percent, 2, ',', ' ') . '%</td>

        </tr>';
            }
//            print_r($answers);
//            echo $sum;
            if (($data->getAnswers() != 'checkbox')) {
                $count = 0;
                echo '<tr><td>(Oddano ' . $sum . ' głosów)</td></tr></table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Wyniki aktualne (Oddano ' . $sum . ' głosów)</h5><table class="w3-table w3-striped w3-white">';
                $sql = "SELECT * FROM `up_user_probe_vote` WHERE probe_id = '$id' ORDER BY `answer_id`";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $count++;
                    $info = System::getAnswerProbe($row['answer_id']);
                    $user_info = System::user_info($row['user_id']);
                    echo '  <tr>
            <td><a href="' . _URLADM . '/mieszkancy/' . $user_info['id'] . '">' . $row['user_id'] . '</a> : ' . $user_info['name'] . '</td>
            <td>' . $info . '</td>
            
          </tr>';
                }
            } else {
                $count = 0;
                echo '<tr><td>(Oddano łącznie ' . $sum . ' głosów)</td></tr></table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Wyniki aktualne (Oddano ' . $sum . ' głosów)</h5><table class="w3-table w3-striped w3-white">';
                $sql = "SELECT * FROM `up_user_probe_vote` WHERE probe_id = '$id'  GROUP BY user_id";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $count++;
                    $user_info = System::user_info($row['user_id']);
                    echo '  <tr>
           
            <td><a href="' . _URLADM . '/mieszkancy/' . $user_info['id'] . '">' . $row['user_id'] . '</a> : ' . $user_info['name'] . '</td>
            <td>';
                    $sql1 = "SELECT * FROM `up_user_probe_vote` WHERE probe_id = '$id' AND user_id = '$row[user_id]'";
                    $sth1 = $conn->query($sql1);
                    while ($row1 = $sth1->fetch()) {
                        $info_v = System::getAnswerProbe($row1['answer_id']);
                        echo $info_v . ', ';
                    }
                    echo '</td>
            
            
          </tr>';
                }
            }
            echo '<tr><td colspan="3">(Głos oddało łącznie ' . $count . ' ankietowanych)</td></tr></table></td></tr><tr> <td></td></tr><tr> <td style="background-color: white"><h5>Działania</h5><table class="w3-table w3-striped w3-white">';

            echo ($data->getDateUntil() > time() and in_array("116", $acces)) ? '  <tr>
            <td><form action="' . _URL . '/thkxadmin/glosowania/' . $id . '/end" method="post"><button type="submit" CLASS="button" style="width: 100%">ZAKOŃCZ</button></form></td>
            
          </tr>' : '';

            echo '</table>


 
            </td>
          </tr>
        </table>
      </div>
      
      
    </div>
  </div>';
        }
    } else {

        echo '<div class="w3-panel" style="width: 100%" ><h5><i class="fa fa-map w3-text-blue w3-large"></i> KRAJE</h5><center></center>

<input type="text" class="search" style="min-width: 210px"  id="myInput" onkeyup="myFunction()" placeholder="Wprowadź nazwę..">
<table id="myTable" class="w3-table w3-striped w3-white"><tr>
                <td><i class="fa fa-map w3-text-blue w3-large"></i><b> ID</b></td>
                <td><b>Nazwa</b></td>
                <td><b>Rodzaj</b></td>

                <td></td>
            </tr>';
        $sql = "SELECT * FROM `up_probe` ORDER BY `id` desc";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $type_info = new Probe($row['id']);

            echo '<tr>';
            echo '<td><i class="fa fa-map w3-text-blue w3-large"></i>  ' . $type_info->getId() . '</td>';
            echo '<td> ' . $type_info->getTitle() . '</td>
                <td>' . $type_info->getTypeName() . '</td>

                <td><a href="' . _URL . '/thkxadmin/glosowania/' . $row['id'] . '"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
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
