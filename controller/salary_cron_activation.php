<?php
date_default_timezone_set("Poland");
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";
require_once dirname(dirname(__FILE__)) . "/class/User.php";
require_once dirname(dirname(__FILE__)) . "/class/System.php";
require_once dirname(dirname(__FILE__)) . "/class/Bank.php";
require_once dirname(dirname(__FILE__)) . "/class/Create.php";
$time = time();
$time112=$time-4200;

/// pracownicy krajow
echo 'prac kraj<br>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_countries_workers` WHERE until_date > '$time' AND last_salary_date < '$time'  AND salary != 0";
$sth = $conn->query($sql);
$licznik = 0;
while ($row = $sth->fetch()) {
    $info = System::user_info($row['user_id']);
    $tax_land = System::land_info($info['state_id']);
    $tax = $tax_land['tax_personal'];
    $next_sal = ($row['period_day'] * 60 * 60 * 24) + $row['last_salary_date'];
    if ($next_sal <= $time and $row['period_day'] != 0) {
        $salary_time = '0';
    } else  $salary_time = '1';
    echo $row['user_id'] . ' - ' . $row['salary'] . ' kr brutto -  ' . ($row['salary'] * (1 - $tax)) . ' kr netto - ' . ($row['salary'] * ($tax)) . ' kr podatek - co ' . $row['period_day'] . ' dni - ' . timeToDate($row['last_salary_date']) . ' ost. wyplata - ' . timeToDate($next_sal) . ' nast wypl -  ' . ($tax * 100) . '% (' . $tax_land['name'] . ')<br>
    Czy wyplata teraz : ' . $salary_time . '<bR>';
    $sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$row[state_id]'";
    $sth1 = $conn->query($sql1);
    $licznik = 0;
    while ($row1 = $sth1->fetch()) {
        echo ' Rachunek należący do kraju : ' . $row1['id'] . '<Br><br>';
        $bank_from = $row1['id'];
    }
    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$row[user_id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        echo ' Rachunek należący do pracownika : ' . $row12['id'] . '<Br><br>';
        $bank_to = $row12['id'];
    }

    $title = 'Wynagrodzenie za okres od ' . timeToDate($row['last_salary_date']) . ' do ' . timeToDate($next_sal) . ' stanowisko: ' . $row['name'] . ' (PODATEK: ' . $row['state_id'] . ' - ' . $tax_land['name'] . ') ';
    $title_tax = "Podatek dochodowy $tax_land[name]";
    if ($salary_time == 0) {
        $salary_value = $row['salary'];
        $tax_value = ($row['salary'] * ($tax));
        echo $tax_value . 'kr <br>';
    $land = Bank::transfer($bank_from,$bank_to,$salary_value, $title);
    if ($land =='OK') {
        Bank::transfer($bank_to, $bank_from, $tax_value, $title_tax);
        update('up_countries_workers', 'id', $row['id'], 'last_salary_date', $time112);
    } else {
        $title_no = 'Brak środków na koncie do realizacji wynagrodzenia dla umowy nr '.$row['id'];
        Create::Post('I00002',$row['state_id'],' ',$title_no);
        Create::Post('I00002',$row['user_id'],' ',$title_no);
    }
    }
}


/// pracownicy miast


// pracownicy organizacji
echo '<hr>prac org<br>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_organizations_workers` WHERE until_date > '$time' AND last_salay_date < '$time'  AND salary != 0";
$sth = $conn->query($sql);
$licznik = 0;
while ($row = $sth->fetch()) {
    $info = System::user_info($row['user_id']);
    $org = System::organization_info($row['organizations_id']);
    $tax_land = System::land_info($info['state_id']);
    $tax = $tax_land['tax_personal'];
    $next_sal = ($row['frequency_days'] * 60 * 60 * 24) + $row['last_salay_date'];
    if ($next_sal <= $time and $row['frequency_days'] != '0') {
        $salary_time = '0';
    } else  $salary_time = '1';
    echo $row['organizations_id'] . ' - #' . $org['main_bank_acc'] . ' | ' . $row['user_id'] . ' - ' . $row['salary'] . ' kr brutto -  ' . ($row['salary'] * (1 - $tax)) . ' kr netto - ' . ($row['salary'] * ($tax)) . ' kr podatek - co ' . $row['frequency_days'] . ' dni - ' . timeToDate($row['last_salay_date']) . ' ost. wyplata - ' . timeToDate($next_sal) . ' nast wypl -  ' . ($tax * 100) . '%<br>
    Czy wyplata teraz : ' . $salary_time . '<bR>';
    $sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$tax_land[id]'";
    $sth1 = $conn->query($sql1);
    $licznik = 0;
    while ($row1 = $sth1->fetch()) {
        echo ' Rachunek należący do kraju  do podatku: ' . $row1['id'] . '<Br><br>';
        $tax_account = $row1['id'];
    }
    $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$row[user_id]'  LIMIT 0,1";
    $sth12 = $conn->query($sql12);
    $licznik = 0;
    while ($row12 = $sth12->fetch()) {
        echo ' Rachunek należący do pracownika : ' . $row12['id'] . '<Br><br>';
        $bank_to = $row12['id'];
    }
    $bank_from = $org['main_bank_acc'];

    $title = 'Wynagrodzenie za okres od ' . timeToDate($row['last_salay_date']) . ' do ' . timeToDate($next_sal) . ' stanowisko: ' . $row['name'] . ' (PODATEK ' . $tax_land['id'] . ' - ' . $tax_land['name'] . ') ';
    $title_tax = 'Podatek dochodowy '.$tax_land['name'];
    if ($salary_time == 0) {
        $salary_value = $row['salary'];
        $tax_value = ($row['salary'] * ($tax));
//        echo $title.'kr <br>';
        $transfer_ac = Bank::transfer($bank_from, $bank_to, $salary_value, $title);
        if($transfer_ac=='OK') {
            Bank::transfer($bank_to,$tax_account,$tax_value,$title_tax);
            update('up_organizations_workers', 'id', $row['id'], 'last_salay_date', $time112);
        } else {
            $title_no = 'Brak środków na koncie do realizacji wynagrodzenia dla umowy nr '.$row['id'];
            Create::Post('I00002',$row['organizations_id'],' ',$title_no);
            Create::Post('I00002',$row['user_id'],' ',$title_no);
        }
        echo '<h5>'.$transfer_ac.'</h5>';
    }
}
echo '<hr>';

// wypłata dla umów wygasających w okresie pomiędzy wynagrodzeniami
//land


echo '<br> wypłata dla umów wygasających w okresie pomiędzy wynagrodzeniami <br>';
echo '<hr>prac kraj<br>';
//brak
echo '<hr>prac org<br>';
$conn = pdo_connect_mysql_up();
$sql = "SELECT * FROM `up_organizations_workers` WHERE until_date >= '$time' AND last_salay_date < '$time' AND salary != 0";
$sth = $conn->query($sql);
$licznik = 0;
while ($row = $sth->fetch()) {
    if ($row['until_date'] < ($time + 86400)) {

        $info = System::user_info($row['user_id']);
        $org = System::organization_info($row['organizations_id']);
        $tax_land = System::land_info($info['state_id']);
        $tax = $tax_land['tax_personal'];
        $next_sal = ($row['frequency_days'] * 60 * 60 * 24) + $row['last_salay_date'];
        if (($next_sal <= $time or $row['until_date'] < ($time + 86400))) {
            $salary_time = '0';
        } else  $salary_time = '1';
        echo $row['organizations_id'] . ' - #' . $org['main_bank_acc'] . ' | ' . $row['user_id'] . ' - ' . $row['salary'] . ' kr brutto -  ' . ($row['salary'] * (1 - $tax)) . ' kr netto - ' . ($row['salary'] * ($tax)) . ' kr podatek - co ' . $row['frequency_days'] . ' dni - ' . timeToDate($row['last_salay_date']) . ' ost. wyplata - ' . timeToDate($next_sal) . ' nast wypl -  ' . ($tax * 100) . '% umowa do '.timeToDate($row['until_date']).' <br>
    Czy wyplata teraz : ' . $salary_time . '<bR>';
        $sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$tax_land[id]'";
        $sth1 = $conn->query($sql1);
        $licznik = 0;
        while ($row1 = $sth1->fetch()) {
            echo ' Rachunek należący do kraju  do podatku: ' . $row1['id'] . '<Br><br>';
            $tax_account = $row1['id'];
        }
        $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$row[user_id]'  LIMIT 0,1";
        $sth12 = $conn->query($sql12);
        $licznik = 0;
        while ($row12 = $sth12->fetch()) {
            echo ' Rachunek należący do pracownika : ' . $row12['id'] . '<Br><br>';
            $bank_to = $row12['id'];
        }
        $bank_from = $org['main_bank_acc'];

        $title = 'Wynagrodzenie za okres od ' . timeToDate($row['last_salay_date']) . ' do ' . timeToDate($next_sal) . ' stanowisko: ' . $row['name'] . ' (PODATEK ' . $tax_land['id'] . ' - ' . $tax_land['name'] . ') ';
        $title_tax = "Podatek dochodowy $tax_land[name]";

        $salary_per_day = $row['salary']/$row['frequency_days'];
        $days =floor((time()-$row['last_salay_date'])/86400);

        if ($salary_time == 0) {
            $salary_value = $salary_per_day*$days;
            $tax_value = ($salary_value * ($tax));
        echo $tax_value.'<br>';

        $transfer_ac1 =  Bank::transfer($bank_from, $bank_to, $salary_value, $title);
        if($transfer_ac1=='OK') {
            Bank::transfer($bank_to,$tax_account,$tax_value,$title_tax);
            update('up_organizations_workers', 'id', $row['id'], 'last_salay_date', $time112);
        } else {
            $title_no = 'Brak środków na koncie do realizacji wynagrodzenia dla umowy nr '.$row['id'];
            Create::Post('I00002',$row['organizations_id'],' ',$title_no);
            Create::Post('I00002',$row['user_id'],' ',$title_no);
        }
        }
    }
}



$time = time();
$sql = "SELECT COUNT(*) FROM `up_users` WHERE active=  0";
$stmt_users = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_media_article`";
$stmt_article = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_organizations`";
$stmt_org = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_media_article_coment`";
$stmt_com = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `bank_account`";
$stmt_acc = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_plot` WHERE owner_id != ''";
$stmt_plot = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_user_investments`";
$stmt_inv = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_organizations_workers` WHERE until_date > '$time'";
$stmt_work_o = $conn->query($sql)->fetch(PDO::FETCH_NUM);
$sql = "SELECT COUNT(*) FROM `up_countries_workers` WHERE until_date > '$time'";
$stmt_work_c = $conn->query($sql)->fetch(PDO::FETCH_NUM);


$bank = 0;
$sql = "SELECT * FROM `bank_account`";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $bank+=$row['balance'];
}
$bank1 = 0;
$sql = "SELECT * FROM `bank_account` WHERE id = '00118 ' OR id = '00014' OR id = '00108' OR id = '00093' OR id = '00094' OR id = '00141'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $bank1+=$row['balance'];
}
$inwest = 0;
$sql = "SELECT * FROM `up_user_investments`";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $inwest+=$row['money'];
}
$salary = 0;
$sql = "SELECT * FROM `up_organizations_workers` WHERE until_date > '$time'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $salary+=$row['salary'];
}
$sql = "SELECT * FROM `up_countries_workers` WHERE until_date > '$time'";
$sth = $conn->query($sql);
while ($row = $sth->fetch()) {
    $salary+=$row['salary'];
    echo $row['salary'].' ';
}
$rSalary =  $salary/($stmt_work_o[0]+$stmt_work_c[0]);
$investm = $inwest/$stmt_inv[0];
$rc = $bank-$bank1;
Create::Stats('1',$bank);
Create::Stats('2',$bank1);
Create::Stats('3',$stmt_org[0]);
Create::Stats('4',$stmt_article[0]);
Create::Stats('5',$stmt_users[0]);
Create::Stats('6',$stmt_acc[0]);
Create::Stats('7',$stmt_plot[0]);
Create::Stats('8',$stmt_com[0]);
Create::Stats('9',$stmt_inv[0]);
Create::Stats('10',$investm);
Create::Stats('11',$rSalary);
Create::Stats('12',$rc);