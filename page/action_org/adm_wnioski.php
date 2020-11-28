<?php


echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Wnioski</h2>
</div><br>';
if (!isset($_GET['ods'])) {
    echo '<p>Wnioski nowe</p>
<table border="0" align="center">
    <tr>
        <td width="40" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">ID</td>
        <td width="308"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">Tytuł wniosku</td>
		        <td width="416"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">Nadawca wniosku:</td>
        <td width="100" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">&nbsp;</td>
    </tr>';

    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_proposal` WHERE organizations_id = '$id' AND done = '0'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $props = System::proposalType_info($row['proposal_id']);
        $inf = System::user_info($row['user_id']);

        echo '    <tr>
        <td width="40"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['id'] . '</a></td>
        <td width="308"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">' . $row['title'] . '</a></td>
		        <td width="416"align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;"><a href="' . _URL . '/profil/adm_wnioski/' . $id . '/' . $row['id'] . '" style="text-decoration: none; color: #1d4e85">(' . $inf['id'] . ') ' . $inf['name'] . ' </a></td>
        <td width="100"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">&nbsp;</td>
    </tr>
';

    }

    echo '</table><p>Wnioski archiwalne</p>
<table border="0" align="center">
    <tr>
        <td width="40" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">ID</td>
        <td width="308"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">Tytuł wniosku</td>
		        <td width="416"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">Nadawca wniosku:</td>
        <td width="100" align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">&nbsp;</td>
    </tr>';

    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_proposal` WHERE organizations_id = '$id' AND done != '0'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        if ($row['done'] == 1) $opti = 'zatwierdzony';
        if ($row['done'] == 2) $opti = 'odrzucony';
        $props = System::proposalType_info($row['proposal_id']);
        $inf = System::user_info($row['user_id']);
        echo '    <tr>
        <td width="40"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">' . $row['id'] . '</td>
        <td width="308"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">' . $row['title'] . '</td>
		        <td width="416"align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">(' . $inf['id'] . ') ' . $inf['name'] . ' </td>
        <td width="100"  align="center" valign="top" style="border-bottom-width:1px; border-bottom-color:rgb(0,0,153); border-bottom-style:solid;">' . $opti . '</td>
    </tr>
';

    }

    echo '</table>';
} else {
    if (isset($_POST['option'])) {
        $proposal_info = System::proposal_info($_GET['ods']);
        $proposal_type_info = System::proposalType_info($proposal_info['proposal_id']);

        if ($proposal_type_info['citizenship'] == 1) {
            if ($_POST['option'] == 2) {

                $sql = "SELECT COUNT(*) FROM `up_user_citizenship` WHERE user_id = '$proposal_info[user_id]' AND state_id = '$id'";
                $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                if ($stmt[0] == 0) {
                    update('up_proposal', 'id', $_GET['ods'], 'done', '1');
                    update('up_proposal', 'id', $_GET['ods'], 'approved_date', time());
                    echo '<p>Wniosek przyjęty pomyślnie. <br>Wnioskodawca został powiadomiony o akceptacji wniosku<br>Wniosek zarchiwizowano<Br>Obywatelstwo zostało nadane</p>';
                    Create::Post($id, $proposal_info['user_id'], 'Zatwierdzenie wniosku "' . $proposal_info['title'] . '"', 'Twój wniosek nr. '.$_GET['ods'].' został zatwierdzony');
                    Create::Citizenship($proposal_info['user_id'], $id);
                } else echo '<p>Mieszkaniec posiada już obywatelstwo tego kraju</p>';
            }
            if ($_POST['option'] == 4) {
                echo '<p>Wniosek odrzucony pomyślnie</p>';
                update('up_proposal', 'id', $_GET['ods'], 'done', '2');
                update('up_proposal', 'id', $_GET['ods'], 'approved_date', time());
                Create::Post($id, $proposal_info['user_id'], 'Odrzucenie wniosku "' . $proposal_info['title'] . '"', 'Twój wniosek nr. '.$_GET['ods'].' został <B>ODRZUCONY</B><BR> W przypadku dalszych pytań skontaktuj się z zarządcą instytucji');
            }
        } else {
            if ($_POST['option'] == 4) {
                echo '<p>Wniosek odrzucony pomyślnie</p>';
                update('up_proposal', 'id', $_GET['ods'], 'done', '2');
                update('up_proposal', 'id', $_GET['ods'], 'approved_date', time());
                Create::Post($id, $proposal_info['user_id'], 'Odrzucenie wniosku "' . $proposal_info['title'] . '"', 'Twój wniosek nr. '.$_GET['ods'].' został <B>ODRZUCONY</B><BR> W przypadku dalszych pytań skontaktuj się z zarządcą instytucji');
            } else if ($_POST['option'] == 1) {
                echo '<p>Wniosek przyjęty pomyślnie. <br>Wnioskodawca został powiadomiony o akceptacji wniosku<br>Wniosek zarchiwizowano</p>';
                update('up_proposal', 'id', $_GET['ods'], 'done', '1');
                update('up_proposal', 'id', $_GET['ods'], 'approved_date', time());
                Create::Post($id, $proposal_info['user_id'], 'Zatwierdzenie wniosku "' . $proposal_info['title'] . '"', 'Twój wniosek nr. '.$_GET['ods'].' został zatwierdzony');
            }
        }

    } else {
        $proposal_info = System::proposal_info($_GET['ods']);
        $proposal_type_info = System::proposalType_info($proposal_info['proposal_id']);
        $user_info = System::user_info($proposal_info['user_id']);
        if ($proposal_type_info['citizenship'] == 1) $special_p = 'TAK'; else $special_p = 'NIE';
        echo '<table border="0" width="755" align="center">
    <tr>
        <td width="276">ID wniosku</td>
        <td width="463">#' . $proposal_info['id'] . '</td>
    </tr>
    <tr>
        <td width="276">Wnioskodawca</td>
        <td width="463">' . $user_info['id'] . ' ' . $user_info['name'] . '</td>
    </tr>
    <tr>
        <td width="276">Tytuł wniosku:</td>
        <td width="463">' . $proposal_info['title'] . '</td>
    </tr>
    <tr>
        <td width="276">Treść wniosku</td>
        <td width="463">' . $proposal_info['text'] . '</td>
    </tr>
        <tr>
        <td width="276">Czy wniosek specjalny</td>
        <td width="463">' . $special_p . '</td>
    </tr>
</table>';

        if ($proposal_info['done'] == 0) {
            echo '<form class="w3-container" method="post">
<select name="option">
<option value="1">Zatwierdź</option>';
            if ($proposal_type_info['citizenship'] != 0) {
                echo ' <option value = "2" > Zatwierdź i wykonaj(jeżeli specjalny)</option >
<option value = "3" > Zatwierdź, wykonaj, wydaj akt prawny(jeżeli specjalny) - NIEDOSTĘPNE</option >';
            }

            echo '<option value="4">Odrzuć</option></select>
<button class="w3-btn w3-blue-grey">Zatwierdź wniosek </button>
</form>
';
        } else {
            if ($proposal_info['done'] == 1) $opti = 'zatwierdzony';
            if ($proposal_info['done'] == 2) $opti = 'odrzucony';
            echo '<p>Wniosek został ' . $opti . ' w dniu ' . timeToDateTime($proposal_info['approved_date']) . '</p>';
        }
    }
}

echo '<p><hr></p></div></div>';
