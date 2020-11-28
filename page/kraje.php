<?php
$id = $_COOKIE['id'];

?>

<div class="hero">
    <div class="hero-content">
        <h2>Rada Unii Krajów Niepodległych</h2>
        <hr width="800"/>
        <p>
            Państwa członkowskie Unii Niepodległych Państw
        </p>
    </div>
    <div class="hero-content-mobile"><h2>Rada Unii Niepodległych Państw</h2></div>
</div>

<div class="main">
    <div class="content">
        <div class="card">
            <p>Państwa stowarzyczone Unii Niepodległych Państw</p><?
                $conn = pdo_connect_mysql_up();
                $sql = "SELECT * FROM `up_countries`";
                $sth = $conn->query($sql);
                echo '<center><table border="0" width="90%"><tr>
        <td width="10%">ID Kraju</td>
        <td width="40%">Nazwa kraju</td>
        <td width="50%">Zarządca</td>
    </tr>';
                while ($row = $sth->fetch()) {
                    $land = System::user_info($row['leader_id']);
                    $land = ($land['name']=='')? System::getInfo($row['leader_id']) : System::user_info($row['leader_id']);;
                    echo '
    <tr>
        <td width="10%"><a href="profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['id'] . '</td>
        <td width="40%"><a href="profil/' . $row['id'] . '" style="text-decoration: none; color: black;">' . $row['name'] . '</td>
        <td width="50%"><a href="profil/' . $row['id'] . '" style="text-decoration: none; color: black;">'.$land['honor_title'].'<b> ' . $land['name'] . '</b></td>
    </tr></a>';
                }
                echo '</table></center><br>';

             ?></div>
    </div>
    <div class="menu">

            <div class="card menucard sticky">
                <p class=""><a href="<?php echo _URL; ?>/mieszkancy" style="text-decoration: none; color: black;">Mieszkańcy</a></a></p>
                <p class=""><a href="<?php echo _URL; ?>/organizacje" style="text-decoration: none; color: black;">Organizacje</a></a></p>
                <p class=""><a href="<?php echo _URL; ?>/wladze" style="text-decoration: none; color: black;">Wladze</a></a></p>

            </div>

    </div>
</div>
