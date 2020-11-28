<?php
$time = time();
echo ' <div class="main">
    <div class="content"> <div class="card">
<div class="w3-container w3-teal">
  <h2><br>Miejsce pracy mieszkańca</h2>
</div>';


echo '<table border="0" width="90%" align="center">
 <tr><td width="4%"  align="center">ID</td>
        <td width="25%"  align="center">Miejsce pracy</td>
        <td width="35%"  align="center">Stanowisko</td>
        <td width="15%"  align="center">Od</td>
        <td width="20%"  align="center">Do</td>
    </tr>';
echo '<tr><td width="4%"  align="center" colspan="5"><h5>Zatrudnienia w krajach i miastach</h5></td>
    </tr></table>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_countries_workers` WHERE until_date > '$time' AND user_id = '$id'";
$sth = $conn->query($sql);
$licznik = 0;
while ($row = $sth->fetch()) {
    $info = System::getInfo($row['state_id']);
    echo '<table border="0" width="90%" align="center" style="border: 1px solid black; border-color: #1d4e85;"><tr><td width="4%"  align="center">'.$row['id'].'</td>
       <td width="25%"  align="center"><a href="' . _URL . '/profil/' . $info['id'] . '" style="text-decoration: none; color: #1d4e85">'.$info['name'].'</a></td>
        <td width="35%"  align="center">'.$row['name'].'</td>
        <td width="15%"  align="center">'.timeToDate($row['from_date']).'</td>
        <td width="20%"  align="center">'.timeToDate($row['until_date']).'</td>
    </tr>';
    if ($id == $_COOKIE['id']){
        $days = $row['period_day']*60*60*24;
        echo '<tr><td width="4%" align="center" colspan="2">'.timeToDate($row['last_salary_date']).'<br><sup>Ostatnie wynagrodzenie</sup></td>
        <td width="35%"  align="center">'.($row['period_day']).'<br><sup>Częstotliwośc wynagrodzenia (dni)</sup></td>
        <td width="15%"  align="center">&nbsp;</td>
        <td width="20%"  align="center">&nbsp;</td>
    </tr>';
        echo '<tr><td width="4%" align="center" colspan="2">'.($row['salary']).' kr<br><sup>Wysokość wynagr. (co '.$row['period_day'].' dni) </sup></td>
        <td width="35%"  align="center">'.timeToDate($row['last_salary_date']+$days).'<br><sup>Następne wynagrodzeni</sup></td>
        <td width="15%"  align="center">&nbsp;</td>
        <td width="20%"  align="center">&nbsp;</td>
    </tr>';



    }
        echo '</table><br>';
}
echo '<tr><td width="4%"  align="center" colspan="5"><h5>Zatrudnienia w organizacjach</h5></td>
    </tr>';
$sql = "SELECT * FROM `up_organizations_workers` WHERE until_date > '$time' AND user_id = '$id'";
$sth = $conn->query($sql);
$licznik = 0;
while ($row = $sth->fetch()) {
    $info = System::getInfo($row['organizations_id']);
    echo '<table border="0" width="90%" align="center" style="border: 1px solid black; border-color: #1d4e85;"><tr><td width="4%"  align="center">'.$row['id'].'</td>
       <td width="25%"  align="center"><a href="' . _URL . '/profil/' . $info['id'] . '" style="text-decoration: none; color: #1d4e85">'.$info['name'].'</a></td>
        <td width="35%"  align="center">'.$row['name'].'</td>
        <td width="15%"  align="center">'.timeToDate($row['from_date']).'</td>
        <td width="20%"  align="center">'.timeToDate($row['until_date']).'</td>
    </tr>';
    if ($id == $_COOKIE['id']){
        $days = $row['frequency_days']*60*60*24;
        echo '<tr><td width="4%" align="center" colspan="2">'.timeToDate($row['last_salay_date']).'<br><sup>Ostatnie wynagrodzenie</sup></td>
        <td width="35%"  align="center">'.($row['frequency_days']).'<br><sup>Częstotliwośc wynagrodzenia (dni)</sup></td>
        <td width="15%"  align="center">&nbsp;</td>
        <td width="20%"  align="center">&nbsp;</td>
    </tr>';
        echo '<tr><td width="4%" align="center" colspan="2">'.($row['salary']).' kr<br><sup>Wysokość wynagr. (co '.$row['frequency_days'].' dni) </sup></td>
        <td width="35%"  align="center">'.timeToDate($row['last_salay_date']+$days).'<br><sup>Następne wynagrodzeni</sup></td>
        <td width="15%"  align="center">&nbsp;</td>
        <td width="20%"  align="center">&nbsp;</td>
    </tr>';



    }
    echo '</table><br>';
}

echo '<hr></div></div>';
