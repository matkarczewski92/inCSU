<!DOCTYPE html>
<html>
<head>
    <style>
        table, td, th {
            padding: 5px;
        }
        th {
            text-align: left;
            min-width: 125px;
        }

    </style>
</head>
<body>
<?php
require_once dirname(dirname(dirname(__FILE__))) . "/controller/db_connection.php";
$q = intval($_GET['typ']);
$q = ($q=='')? intval($_GET['q']) : intval($_GET['typ']);
?>
<h5>Zestawienie miesięczne</h5>
<div class="w3-responsive" style="overflow-x:auto;">
    <table class="w3-table-all" style="width: 100%">
                <tr>
                    <th>Tytuł \ Dzień</th>
                    <?php
                    $sql = "SELECT * FROM `stats` WHERE `month` = '$q'  GROUP BY `day` ORDER BY `day` desc";
                    $sth = $conn->query($sql);
                    while ($row = $sth->fetch()) {
                        echo '<th>'.$row['day'].'</th>';
                    }
                    ?>
                </tr>
        <?php
        $licz[] = [];
        $sql = "SELECT * FROM `stats_type`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $sql12 = "SELECT * FROM `stats` WHERE data_type='$row[id]' AND `month` = '$q' ";
            $sth12 = $conn->query($sql12);
            while ($row12 = $sth12->fetch()) {
                $licz[$row12['day']][$row12['data_type']] = $row12['values'];
            }
        }

        $sql = "SELECT * FROM `stats_type`";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            echo '  <tr>
                    <th>'.$row['name'].'</th>';
            $sql1 = "SELECT * FROM `stats` WHERE data_type='$row[id]' AND `month` = '$q' ORDER BY `day` desc";
            $sth1 = $conn->query($sql1);
            while ($row1 = $sth1->fetch()) {
                $d = ($row1['day']-1);
                $p = ($row['id']);
                if($licz[$d][$p]==$row1['values']) $color = 'black';
                if($licz[$d][$p]>$row1['values']) $color = 'red';
                if($licz[$d][$p]<$row1['values']) $color = 'green';

                    echo ($row['id'] == 1 or $row['id'] == 2 or $row['id'] == 11 or $row['id'] == 10 or $row['id'] == 12) ?
                        '<th style="color: '.$color.'">' . number_format($row1['values'], 0, ',', ' ') . ' kr </th>' :
                        '<th style="color: '.$color.'">' . $row1['values'] . ' </th>';


            }

            echo'</tr>';
        }

//
        ?>
    </table>
</div>
</body>
</html>