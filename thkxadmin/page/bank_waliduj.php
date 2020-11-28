<?php


if (isset($_GET['typ']) and $_GET['typ'] != 'OK') {
    $sql = "SELECT * FROM `bank_account`";
    $sth = $conn->query($sql);
    while ($row = $sth->fetch()) {
        $balance = 0;
        $value_plus = 0;
        $value_minus = 0;

        $sql1 = "SELECT * FROM `bank_statement` WHERE from_id='$row[id]'";
        $sth1 = $conn->query($sql1);
        while ($row1 = $sth1->fetch()) {
            $value_minus += $row1['value'];
        }

        $sql2 = "SELECT * FROM `bank_statement` WHERE to_id='$row[id]'";
        $sth2 = $conn->query($sql2);
        while ($row2 = $sth2->fetch()) {
            $value_plus += $row2['value'];
        }

        $info = Bank::account_info($row['id']);
        $balance = $value_plus - $value_minus;
        $balance_acc = $info['balance'] - $info['debit'];
        if ($balance != $balance_acc) {
            update('bank_account', 'id', $row['id'], 'balance', $balance);
        }

    }
    header('Location: ' . _URLADM . '/bank_waliduj/OK');
}


echo '<div class="w3-panel">
    <h3>Walidacja kont bankowych</h3>
    <form action="' . _URLADM . '/bank_waliduj/waliduj"><button type="submit" CLASS="button">DOKONAJ AUTOKOREKTY STANU KONT</button></form><br>
        ';
Bank::controll();
?>

</div>
