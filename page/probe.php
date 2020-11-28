<style>
    img {
        width: 90%;
        height: auto;

    }

    a {
        text-decoration: none;
        color: #1d4e85;
    }
</style><?php
$id = $_COOKIE['id'];

?>

<div class="hero">
    <div class="hero-content">
        <h2>Moduł głosowania </h2>
        <hr width="800"/>
        <p>

        </p>
    </div>
    <div class="hero-content-mobile"><h2>Moduł głosowania</h2></div>
</div>

<div class="main">
    <div class="content">
        <div class="card"><?php

if (isset($_GET['typ']) and $_GET['typ'] != 'NO_ACCES' and $_GET['typ'] != 'arch') {
    $acces = System::ProbeUserVoteAcces($_COOKIE['id'], $_GET['typ']);

    if (isset($_POST['glos'])) {
        $probe = new Probe($_GET['typ']);
        $probe_id_global = $_GET['typ'];
        $user_id_global = $_COOKIE['id'];
        echo '<br>oddane głosy na <br>';
        $tablica = $probe->getQuestion();
        if ($probe->getAnswers() == 'radio') {
            echo 'Odpowiedź: ' . $_POST['answers'] . ' - ' . System::getAnswerProbe($_POST['answers']);
            Create::Vote($user_id_global, $probe_id_global, $_POST['answers']);
            $leader = System::id_leader($probe->getOrganization());
            $title = 'Oddano głos w głosowaniu nr '.$_GET['typ'].' Mieszkaniec '.$_COOKIE['id'].' oddał głos na '.System::getAnswerProbe($_POST['answers']);
            Create::Alert($leader,$title);
        } else {
            while (list($klucz, $wartosc) = each($tablica)) {
                echo ($_POST[$klucz] == $klucz) ? $wartosc . '<br>' : '';
                if ($_POST[$klucz] == $klucz) {
                    Create::Vote($user_id_global, $probe_id_global, $_POST[$klucz]);
                    $leader = System::id_leader($probe->getOrganization());
                    $title = 'Oddano głos w głosowaniu nr '.$_GET['typ'].' Mieszkaniec '.$_COOKIE['id'].' oddał głos na '.System::getAnswerProbe($_POST[$klucz]);
                    Create::Alert($leader,$title);
                }
            }
        }
        header('Location: ' . _URL . '/probe');

    } else {
        $probe = new Probe($_GET['typ']);
        $name = System::getInfo($probe->getTargetState());
        echo '.<h3>' . $probe->getTypeName() . ' - ' . $probe->getTitle() . '</h3>';
        echo '<table  width="90%" align="center">
    <tr>
        <td width="25%">Grupa przeznaczenia</td>
        <td width="25%"><b>' . $name['name'] . '</b></td>
        <td width="25%">Wymagane obywatelstwo</td>
        <td width="25%"><B>';
        echo ($probe->getCitizenship() != '0') ? 'TAK' : 'NIE';
        echo '</B></td>
    </tr>
    <tr>
        <td width="25%">Początek</td>
        <td width="25%"><b>' . timeToDateTime($probe->getDateFrom()) . '</b></td>
        <td width="25%">Koniec</td>
        <td width="25%"><b>' . timeToDateTime($probe->getDateUntil()) . '</b></td>
    </tr>
    <tr>
        <td width="25%">Możliwość wyboru</td>
        <td width="25%"><b>';
        echo ($probe->getAnswers() == 'radio') ? 'jedna opcja' : 'wiele opcji ';

        echo '</b></td>
        <td width="25%">Nr. głosowania</td>
        <td width="25%">#' . $_GET['typ'] . '</td>
    </tr>
    <tr>
        <td width="100%" colspan="4"><p align="justify">' . $probe->getText() . '</p></td>
    </tr>
    <tr>
        <td width="100%" colspan="4">';
        $vots = System::ProbeUserVote($_COOKIE['id'], $_GET['typ']);
        if ($acces == 'TAK' and $vots == 'NIE') {
            $tablica = $probe->getQuestion();
            echo ($probe->getOfficial() == 1) ? '<h5>W wynikach zostaną opublikowane dane personalne głosujących</h5>' : '<h5>W wynikach NIE zostaną opublikowane dane personalne głosujących</h5>';
            echo '<form action="' . _URL . '/probe/' . $_GET['typ'] . '" method="post">
                    <table  width="40%" align="center">';
            while (list($klucz, $wartosc) = each($tablica)) {

                if ($probe->getAnswers() == 'radio') {
                    echo '<tr>
                        <td width="90%" align="right">' . $wartosc . '</td>
                        <td width="10%"><input type="radio" value="' . $klucz . '" name="answers"></td>
                     </tr>';
                } else {
                    echo '<tr>
                        <td width="90%">' . $wartosc . '</td>
                        <td width="10%"><input type="checkbox" value="' . $klucz . '" name="' . $klucz . '"></td>
                     </tr>';
                }
            }
            echo '</table> <button name="glos" value="glos">Oddaj głos</button>
</form>';
        } else {
            $vots = System::ProbeUserVote($_COOKIE['id'], $_GET['typ']);

            echo ($vots == 'TAK') ? '<h5>Twój głos został już zarejestrowany</h5>' : '<h5>Brak możliwości oddania głosu</h5>';

        }
        echo '</td>
    </tr>
</table>';

    }

} else if (isset($_GET['typ']) and $_GET['typ'] != 'NO_ACCES' and $_GET['typ'] == 'arch') {////////////////// ARCHIWUM
    if (isset($_GET['ptyp'])) {

        $probe = new Probe($_GET['ptyp']);
        $name = System::getInfo($probe->getTargetState());
        echo '.<h3>' . $probe->getTypeName() . ' - ' . $probe->getTitle() . '</h3>';
        echo '<table  width="90%" align="center">
    <tr>
        <td width="25%">Grupa przeznaczenia</td>
        <td width="25%"><b>' . $name['name'] . '</b></td>
        <td width="25%">Wymagane obywatelstwo</td>
        <td width="25%"><B>';
        echo ($probe->getCitizenship() != '0') ? 'TAK' : 'NIE';
        echo '</B></td>
    </tr>
    <tr>
        <td width="25%">Początek</td>
        <td width="25%"><b>' . timeToDateTime($probe->getDateFrom()) . '</b></td>
        <td width="25%">Koniec</td>
        <td width="25%"><b>' . timeToDateTime($probe->getDateUntil()) . '</b></td>
    </tr>
    <tr>
        <td width="25%">Możliwość wyboru</td>
        <td width="25%"><b>';
        echo ($probe->getAnswers() == 'radio') ? 'jedna opcja' : 'wiele opcji ';

        echo '</b></td>
        <td width="25%">Nr. głosowania</td>
        <td width="25%">#' . $_GET['ptyp'] . '</td>
    </tr>
    <tr>
        <td width="100%" colspan="4"><p align="justify">' . $probe->getText() . '</p></td>
    </tr>
    <tr>
        <td width="100%" colspan="4">';

        /////////////////////////////////////////////////////////////// wyniki
        $tablica = $probe->getQuestion();
        echo '<hr><h3>WYNIKI:</h3>';
        $tabsy = System::Stats($_GET['ptyp']);
        if ($tabsy != 'NOT_YET') {
            while (list($klucz, $wartosc) = each($tabsy)) {
                $x = System::getAnswerProbe($klucz);
                echo 'Odpowiedź <b>' . $x . '</b> wystąpiła <b>' . $wartosc . '</b> razy <br>';
            }
            echo '<br> <hr>';
            if ($probe->getOfficial()==1) {
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_user_probe_vote` WHERE probe_id = '$_GET[ptyp]'  GROUP BY `user_id` ORDER by `answer_id`";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $get_info = System::user_info($row['user_id']);
                    echo $get_info['name'] . ': ';
                    $sql1 = "SELECT * FROM `up_user_probe_vote` WHERE probe_id = '$_GET[ptyp]' AND user_id = '$row[user_id]'";
                    $sth1 = $conn->query($sql1);
                    while ($row1 = $sth1->fetch()) {
                        $answer = System::getAnswerProbe($row1['answer_id']);
                        echo '<b>'.$answer . '</b>, ';
                    }
                    echo '<br>';
                }
            }
        } else echo 'Głosowanie nie zostało jeszcze zakończone';


        echo '</td>
    </tr>
</table>';
    } else {
        echo '<h3>Archiwalne głosowania - wyniki</h3>';
        echo '<table border="0" width="90%" align="center">
<tr>
        <td width="3%"><p>#ID</p></td>
        <td width="55%"><p>Tytuł</p></td>
        <td width="20%"><p>Ważne do</p></td>
        <td width="22%"><p>Możliwość oddania głosu</p></td>
    </tr>';
        $time = time();
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_probe` WHERE date_until < '$time'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $vote = System::ProbeUserVoteAcces($_COOKIE['id'], $row['id']);

            echo '<tr>
        <td width="3%"><a href="' . _URL . '/probe/arch/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
        <td width="55%"><a href="' . _URL . '/probe/arch/' . $row['id'] . '">' . $row['title'] . '</a></td>
        <td width="20%"><a href="' . _URL . '/probe/arch/' . $row['id'] . '">' . timeToDateTime($row['date_until']) . '</a></td>
        <td width="22%"><a href="' . _URL . '/probe/arch/' . $row['id'] . '">' . $vote . '</a></td>
    </tr>';
        }
        echo '</table> ';
    }
} else {
    echo '<h3>Aktualnie przeprowadzane głosowania - możliwość oddania głosu</h3>';
    echo '<table border="0" width="90%" align="center">
<tr>
        <td width="3%"><p>#ID</p></td>
        <td width="55%"><p>Tytuł</p></td>
        <td width="20%"><p>Ważne do</p></td>
        <td width="22%"><p>Możliwość oddania głosu</p></td>
    </tr>';
    $time = time();


    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_probe` WHERE date_until>='$time'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $vote = System::ProbeUserVoteAcces($_COOKIE['id'], $row['id']);
        $votes = System::ProbeUserVote($_COOKIE['id'], $row['id']);

        echo ($vote == 'TAK' and $votes == 'NIE' and $_COOKIE['id'] != '') ? '<tr>
        <td width="3%"><a href="' . _URL . '/probe/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
        <td width="55%"><a href="' . _URL . '/probe/' . $row['id'] . '">' . $row['title'] . '</a></td>
        <td width="20%"><a href="' . _URL . '/probe/' . $row['id'] . '">' . timeToDateTime($row['date_until']) . '</a></td>
        <td width="22%"><a href="' . _URL . '/probe/' . $row['id'] . '">' . $vote . '</a></td>
    </tr>' : '';
    }
    echo '</table>';

    echo '<h3>Aktualnie przeprowadzane głosowania - brak możliwości oddania głosu</h3>';
    echo '<table border="0" width="90%" align="center">
<tr>
        <td width="3%"><p>#ID</p></td>
        <td width="55%"><p>Tytuł</p></td>
        <td width="20%"><p>Ważne do</p></td>
        <td width="22%"><p>Możliwość oddania głosu</p></td>
    </tr>';
    $time = time();


    $conn = pdo_connect_mysql_up();
    $sql = "SELECT * FROM `up_probe` WHERE date_until>='$time'";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $vote = System::ProbeUserVoteAcces($_COOKIE['id'], $row['id']);

        echo ($vote == 'NIE' and $_COOKIE['id'] != '') ? '<tr>
        <td width="3%"><a href="' . _URL . '/probe/' . $row['id'] . '"> #' . $row['id'] . '</a></td>
        <td width="55%"><a href="' . _URL . '/probe/' . $row['id'] . '">' . $row['title'] . '</a></td>
        <td width="20%"><a href="' . _URL . '/probe/' . $row['id'] . '">' . timeToDateTime($row['date_until']) . '</a></td>
        <td width="22%"><a href="' . _URL . '/probe/' . $row['id'] . '">' . $vote . '</a></td>
    </tr>' : '';
    }
    echo '</table>';
}


echo '</div></div>
    <div class="menu">

        <div class="card menucard sticky">';
echo '  <p class=""><a href="' . _URL . '/probe" style="text-decoration: none; color: #1d4e85">Aktualne głosowania</a></p>';
echo '  <p class=""><a href="' . _URL . '/probe/arch" style="text-decoration: none; color: #1d4e85">Archiwum głosowań - wyniki</a></p>';


echo '</div>
    </div>

</div>
';
