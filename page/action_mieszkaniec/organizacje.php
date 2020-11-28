<?php
if (substr($_GET['typ'], 0, 2) == 'U0' or substr($_GET['typ'], 0, 2) == 'L0' or substr($_GET['typ'], 0, 2) == 'I0' or substr($_GET['typ'], 0, 2) == 'C0') $id = $_GET['typ']; else $id = $_GET['ptyp'];
?>

<div class="hero">
    <div class="hero-content">
        <h2>Rejestr mieszkańców</h2>
        <hr width="800"/>
        <p>
            Spis mieszkańców oraz obywateli Unii Państw Niepodległych
        </p>
    </div>
    <div class="hero-content-mobile"><h2>Rejestr mieszkańców</h2></div>
</div>

<div class="main">
    <div class="content">
        <div class="card"><?
            $conn = pdo_connect_mysql_up();
            $sql = "SELECT * FROM `up_organizations` WHERE owner_id = '$id'";
            $sth = $conn->query($sql);
            echo '<center><h3>Organizacje posiadane przez mieszkańca</h3><table border="0" width="90%">';
            while ($row = $sth->fetch()) {
                $land = System::user_info($row['leader_id']);
                $typ = System::orgTyp_info($row['type_id']);

                echo '
    <tr>
        <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['id'] . '</a><br><sup>ID</sup></td>
        <td width="50%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</a><br><sup>Nazwa</sup></td>
     <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"> ' . $typ['name'] . '</a><br><sup>Typ</sup></td>
    </tr></a>';
            }
            echo '</table></center><br>';
            $sql = "SELECT * FROM `up_organizations` WHERE leader_id = '$id' AND owner_id != '$id'";
            $sth = $conn->query($sql);
            echo '<center><h3>Organizacje zarządzane przez mieszkańca</h3><table border="0" width="90%">';
            while ($row = $sth->fetch()) {
                $land = System::user_info($row['leader_id']);
                $own = System::getInfo($row['owner_id']);
                if ($own['name'] == '') $owner = "Unia"; else $owner = $own['name'];
                $typ = System::orgTyp_info($row['type_id']);

                echo '
    <tr>
        <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['id'] . '</a><br><sup>ID</sup></td>
        <td width="30%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</a><br><sup>Nazwa</sup></td>
        <td width="30%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"> ' . $owner . '</a><br><sup>Właściciel</sup></td>
        <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"> ' . $typ['name'] . '</a><br><sup>Typ</sup></td>
    </tr></a>';
            }
            echo '</table></center><br>';

            $sql = "SELECT * FROM `up_countries` WHERE leader_id = '$id'";
            $sth = $conn->query($sql);
            echo '<center><h3>Kraje i miasta zarządzane przez mieszkańca</h3><table border="0" width="90%">';
            while ($row = $sth->fetch()) {
                $land = System::user_info($row['leader_id']);
                $typ = System::orgTyp_info($row['type_id']);

                echo '
    <tr>
<td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['id'] . '</a><br><sup>ID</sup></td>
        <td width="50%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</a><br><sup>Nazwa</sup></td>
     <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"> ' . $typ['name'] . '</a><br><sup>Typ</sup></td>
    </tr></a>';
            }
            echo '</center><br>';
            $sql = "SELECT * FROM `up_cities` WHERE leader_id = '$id' ";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $land = System::user_info($row['leader_id']);
                $own = System::getInfo($row['state_id']);
                if ($own['name'] == '') $owner = "Unia"; else $owner = $own['name'];
                $typ = System::orgTyp_info($row['type_id']);
                echo '
    <tr>
        <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['id'] . '</a><br><sup>ID</sup></td>
        <td width="30%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</a><br><sup>Nazwa</sup></td>
        <td width="30%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"> ' . $owner . '</a><br><sup>Właściciel</sup></td>
        <td width="20%"><a href="'._URL.'/profil/' . $row['id'] . '" style="text-decoration: none; color: black;"> ' . $typ['name'] . '</a><br><sup>Typ</sup></td>
    </tr></a>';
            }
            echo '</table></center><br>';
            ?></div>
    </div>

