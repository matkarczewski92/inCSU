<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";

class Bank
{

    public static function account_info($id)  // informacje o koncie bankowym na podstawie ID Rachunku
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `bank_account` WHERE id='$id'";
        return $conn->query($sql)->fetch();
    }

    public static function transfer($from_id, $to_id, $value, $title)  // wykonanie przelewu
    {
        $conn = pdo_connect_mysql_up();
        $data_from = self::account_info($from_id);
        $data_to = self::account_info($to_id);
        $ki_bank = self::account_info(_KIBANK);
        $value_a = str_replace(",", ".", $value);
        if (!is_null($data_to['id'])) {
            $data_from_value = $data_from['balance'];
            $data_to_value = $data_to['balance'];
            if ($data_from_value >= $value_a) {
                if ($from_id != $to_id) {
                    $new_balance = $data_from_value - $value_a;
                    update('bank_account', 'id', $from_id, 'balance', $new_balance);
                    $get_debet = $data_to['debit'];  // 0
                    if($get_debet=='0'){
                        $new_balance_to = $data_to_value + $value_a;
                        update('bank_account', 'id', $to_id, 'balance', $new_balance_to);
                    } else {
                        if ($get_debet >= $value_a) {     //1000 >= 500 (kwota przelewu)
                            $new_balance_to = $get_debet - $value_a;
                            $ki_balance = $ki_bank['balance'] + $value_a;
                            update('bank_account', 'id', $to_id, 'debit', $new_balance_to);
                            update('bank_account', 'id', _KIBANK, 'balance', $ki_balance);

                            $sql = "INSERT INTO bank_statement (from_id, to_id, value, date, title) VALUES (:from_id, :to_id, :value, :date, :title)";
                            $sth = $conn->prepare($sql);
                            $sth->execute(array(
                                    ':from_id' => $from_id,
                                    ':to_id' => $to_id,
                                    ':value' => $value_a,
                                    ':date' => time(),
                                    ':title' => 'Zwrot zajecia')
                            );

                        } else if ($get_debet < $value_a) {   // 0 < 500
                            $new_balance_to = $data_to_value + $value_a - $get_debet;
                            $ki_balance = $ki_bank['balance'] - ($value_a + $get_debet);
                            update('bank_account', 'id', $to_id, 'debit', 0);
                            update('bank_account', 'id', _KIBANK, 'balance', $ki_balance);
                            update('bank_account', 'id', $to_id, 'balance', $new_balance_to);

                            $sql = "INSERT INTO bank_statement (from_id, to_id, value, date, title) VALUES (:from_id, :to_id, :value, :date, :title)";
                            $sth = $conn->prepare($sql);
                            $sth->execute(array(
                                    ':from_id' => $from_id,
                                    ':to_id' => $to_id,
                                    ':value' => $get_debet,
                                    ':date' => time(),
                                    ':title' => 'Zwrot zajecia')
                            );


                        }
                    }
                    $sql = "INSERT INTO bank_statement (from_id, to_id, value, date, title) VALUES (:from_id, :to_id, :value, :date, :title)";
                    $sth = $conn->prepare($sql);
                    $sth->execute(array(
                            ':from_id' => $from_id,
                            ':to_id' => $to_id,
                            ':value' => $value,
                            ':date' => time(),
                            ':title' => $title)
                    );
                    $bank = self::account_info($from_id);
                    $info = System::getInfo($bank['owner_id']);
                    $alert_title = 'Otrzymałeś przelew od <b>'.$info['name'].'</b> w kwocie <b>'.$value.'</b> kr Tytuł: <i>'.$title.'</i> ';
                    Create::Alert($data_to['owner_id'],$alert_title);
                    return 'OK';  // ok
                }
                return 'OWN';  // błąd - brak mozliwosci przelewu na konto z którego wykonuje sie przelew
            } else {
                return 'MONEY';  // brak srodkow na koncie
            }
        } else {
            return 'ACCOUNT';  // brak konta obiorcy lub błedne konto odbiorcy
        }
    }

    public static function transfer_s($from_id, $to_id, $value, $title)  // wykonanie przelewu specjalnego - gdy brak kasy na koncie nadawcy dodaje do jego debetu
    {
        $conn = pdo_connect_mysql_up();
        $data_from = self::account_info($from_id);
        $data_to = self::account_info($to_id);
        $ki_bank = self::account_info(_KIBANK);
        $value_a = str_replace(",", ".", $value);
        if (!is_null($data_to['id'])) {
            $data_from_value = $data_from['balance'];
            $data_to_value = $data_to['balance'];

                if ($from_id != $to_id) {
                    if ($data_from_value <= $value_a) { // 100 <= 50 / Fałsz
                        $new_balance = $data_from['debit'] + ($value_a-$data_from_value);
                        update('bank_account', 'id', $from_id, 'debit', $new_balance);
                        update('bank_account', 'id', $from_id, 'balance', 0);
                    } else if ($data_from_value > $value_a) { // 100 > 50 / prawda
                        $new_balance = $data_from_value - $value_a;
                        update('bank_account', 'id', $from_id, 'balance', $new_balance);
                    }
                    $new_balance = $data_to_value + $value_a;
                    $ki_balance = $ki_bank['balance']-$value_a;
                    update('bank_account', 'id', $to_id, 'balance', $new_balance);
                    update('bank_account', 'id', _KIBANK, 'balance', $ki_balance);

                    $sql = "INSERT INTO bank_statement (from_id, to_id, value, date, title) VALUES (:from_id, :to_id, :value, :date, :title)";
                    $sth = $conn->prepare($sql);
                    $sth->execute(array(
                            ':from_id' => $from_id,
                            ':to_id' => $to_id,
                            ':value' => $value,
                            ':date' => time(),
                            ':title' => $title)
                    );
                    $sql = "INSERT INTO bank_statement (from_id, to_id, value, date, title) VALUES (:from_id, :to_id, :value, :date, :title)";
                    $sth = $conn->prepare($sql);
                    $sth->execute(array(
                            ':from_id' => _KIBANK,
                            ':to_id' => '0',
                            ':value' => $value_a,
                            ':date' => time(),
                            ':title' => 'Pobór w poczet zajęcia')
                    );


                    return 'OK';  // ok
                }
                return 'OWN';  // błąd - brak mozliwosci przelewu na konto z którego wykonuje sie przelew

        } else {
            return 'ACCOUNT';  // brak konta obiorcy lub błedne konto odbiorcy
        }
    }

    public static function controll()   // sprawdzanie / walidacja rachunków pod względem środków na koncie - porównanie stanu konta z wyciagiem
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `bank_account`";
        $sth = $conn->query($sql);
        $licz = 0;
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

            $info = self::account_info($row['id']);
            $balance = $value_plus - $value_minus;
            $balance_acc = $info['balance'] - $info['debit'];
            if ($balance != $balance_acc) {
                echo '<p>Rozbierzność dla konta: <a href="' . _URLADM . '/bank/' . $row['id'] . '">' . $row['id'] . '</a>
                        , stan konta ' . $balance_acc . ' stan wg. wyciagów: ' . $balance . ' </p>';
                $licz++;
            }

        }
        echo ($licz==0)? '<i>NIE WYKRYTO NIEPRAWIDŁOŚCI</i>' : '';
    }

    public static function transferFromForeign($user_id, $foreign_id) // przelew z banku KS i KD do CSU
    {
        $conn = pdo_connect_mysql_up();
        $fr = $foreign_id[0];

        if ($fr == 'A' or $fr == 'T') {  // bank Sarmacji
            $sql12 = "SELECT * FROM `TABLE 15` WHERE id = '$foreign_id'";
            $sth12 = $conn->query($sql12);
            while ($row12 = $sth12->fetch()) {
                $sql = "SELECT * FROM `bank_account` WHERE owner_id = '$user_id' LIMIT 0,1";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    if ($row12['value'] != '0') {
                        $new_value = $row['balance'] + $row12['value'];
                        Bank::transfer('00000', $row['id'], $new_value, 'Transfer z banku KS');
                        update('TABLE 15', 'id', $foreign_id, 'value', '0');
                    }
                }
            }
        } else if ($fr != 'A' or $fr != 'T') { // bank Dreamlandu - dodać jak będzie tabela z banku KD

        }
    }

}