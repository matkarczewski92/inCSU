<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";

//Klasa systemowa z metodami statycznymi dla głównych systemowych funkcji (ogólnych)


class System
{

    public static function id_generator($type)  // generator ID 1-user (U), 2-Kraj (L), 3-Miasto (C) 4-Organizacja (I)
    {
        $conn = pdo_connect_mysql_up();
        switch ($type) {
            case  '1':
                $sql = "SELECT COUNT(*) FROM `up_users`";
                $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                $id = sprintf("%05d", $stmt[0] + 1);
                $id_e = 'U' . $id;
                break;
            case  '2': // countries L
                $sql = "SELECT COUNT(*) FROM `up_countries`";
                $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                $id = sprintf("%04d", $stmt[0] + 1);
                $id_e = 'L' . $id;
                break;
            case  '3': // cities C
                $sql = "SELECT COUNT(*) FROM `up_cities`";
                $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                $id = sprintf("%04d", $stmt[0] + 1);
                $id_e = 'C' . $id;
                break;
            case  '4': // organiz I
                $sql = "SELECT COUNT(*) FROM `up_organizations`";
                $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
                $id = sprintf("%05d", $stmt[0] + 1);
                $id_e = 'I' . $id;
                break;
            default:
                $id_e = 'Błedny typ: 1-users, 2-country, 3-city, 4-organization';
        }
        return $id_e;
    }
    public static function plotIdGenerator($city_id){
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT COUNT(*) FROM `up_plot` WHERE city_id='$city_id'";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        $id = $city_id.'-'.sprintf("%05d", $stmt[0] + 1);
        return $id;
    }

    public static function config_info() // zwraca tablice z UP_CONFIG dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_config` WHERE id_config='1'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function cut($id) // ucina prefix dla ID - zasadniczo potrzebne tylko na potrzeby forum i integracji z nim
    {
        return str_replace(substr($id, 0, 1), '', $id);
    }

    public static function getInfo($id)  // zwraca tablice z up_users dla określonego ID.
    {
        $id_cut = substr($id, 0, 2);
        switch ($id_cut) {
            case "U0":
                return self::user_info($id);
            case "L0":
                return self::land_info($id);
            case "C0":
                return self::city_info($id);
            case "I0":
                return self::organization_info($id);
        }
    }

    public static function user_info($user_id)  // zwraca tablice z up_users dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_users` WHERE id='$user_id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function organization_info($up_organizations) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_organizations` WHERE id='$up_organizations'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }
    public static function organization_infoBuild($up_organizations) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_organizations_building` WHERE organization_id='$up_organizations'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function land_info($ip_land) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_countries` WHERE id='$ip_land'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function city_info($ip_land) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_cities` WHERE id='$ip_land'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function proposalType_info($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_proposal_type` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function proposal_info($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_proposal` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function orgTyp_info($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_organizations_type` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function getTitleName($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_user_title` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data['name'];
    }

    public static function getTitleAcademicName($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_user_title_academic` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data['name'];
    }

    public static function getTitleSec($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_user_title_sec` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function getTitleRank($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_user_title_rank` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data['name'];
    }

    public static function getOrderInfo($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_orders` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function id_leader($id)
    {
        $id_f_lider = substr($id, 0, 1);
        switch ($id_f_lider) {
            case 'L':
                $id = self::land_info($id);
                return $id['leader_id'];
                break;
            case 'C':
                $id = self::city_info($id);
                return $id['leader_id'];
                break;
        }
    }

    public static function getLaw($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `law_article` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function getMediaArcitleInfo($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_media_article` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function getMediaArcitleComment($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT COUNT(*) FROM `up_media_article_coment` WHERE article_id=$id";
        $stmt = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        return $stmt[0];
    }

    public static function getMediaComment($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_media_article_coment` WHERE article_id=$id";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function getLawCatLow($id) // zwraca tablice z up_organizations dla określonego ID.
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `law_category_low` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function checkOwner($owner_id)
        // funkcja sprawdza kto jest właścicielem nadrzędnym (sprawdza organizacje, miasta, kraje) jeżeli brak USERA , szuka zarządcy pierwotnego właściciela
    {
        do {
            $owner_acces1 = substr($owner_id, 0, 2);
            if ($owner_acces1 != 'U0') {
                if ($owner_acces1 == 'L0' or $owner_acces1 == 'C0') {
                    $owner_idp = System::getInfo($owner_id);
                    $owner_id = $owner_idp['leader_id'];
                    return $owner_id;
                }
                if ($owner_acces1 == 'I0') {
                    if ($owner_id == 'I00001') {
                        return $owner_id = 'I00001';
                    } else {
                        $owner_acces = substr($owner_id, 0, 2);
                        if ($owner_acces == 'I0') {
                            $owner_idp = System::getInfo($owner_id);
                            $owner_id = $owner_idp['leader_id'];
                            return $owner_id;
                        }
                    }
                }
            } else return $owner_id;
        } while ($owner_acces1 == 'U0');
    }

    public static function lastLogin($user_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_user_login_data` WHERE user_id = '$user_id' ORDER BY data DESC LIMIT 0,1";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            return $row['data'];
        }
    }

    public static function getMediaRotator()
    {
        $time = time();
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_media_rotator` WHERE `active` = '0' AND `until_date` > '$time'";
        $sth = $conn->query($sql);
        $count = $sth->rowCount();
        while ($row = $sth->fetch()) {
            $media[] = $row;
        }
        $x = rand(1, $count);
        return $media[$x - 1];
    }


    public static function userInvest($user_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT COUNT(*) FROM `up_user_investments` WHERE user_id = '$user_id'";
        $stmt = $conn->query($sql2)->fetch(PDO::FETCH_NUM);
        return $stmt[0];
    }
    public static function plotInfo($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT * FROM `up_plot` WHERE id = '$id'";
        $data = $conn->query($sql2)->fetch();
        return $data;
    }
    public static function blueprintInfo($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT * FROM `up_plot_blueprints` WHERE id = '$id'";
        $data = $conn->query($sql2)->fetch();
        return $data;
    }
    public static function plotCityCounter($city_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT COUNT(*) FROM `up_plot` WHERE city_id = '$city_id'";
        $stmt = $conn->query($sql2)->fetch(PDO::FETCH_NUM);
        return $stmt[0];
    }
    public static function blueprintsOrgCounter($org_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT COUNT(*) FROM `up_plot_blueprints` WHERE author_id = '$org_id'";
        $stmt = $conn->query($sql2)->fetch(PDO::FETCH_NUM);
        return $stmt[0];
    }
    public static function plotMetrageCounter($city_id)
    {
        $square = 0;
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_plot` WHERE city_id = '$city_id'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $square+=$row['square_meter'];
        }
        return $square;
    }

    public static function projectInfo($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT * FROM `up_plot_blueprints` WHERE id = '$id'";
        $data = $conn->query($sql2)->fetch();
        return $data;
    }

    public static function Invest_info($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_investments` WHERE id = '$id'";
        $data = $conn->query($sql)->fetch();
        return $data;
    }

    public static function sumInvestUser($user_id)
    {
        $sum = 0;
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_user_investments` WHERE user_id = '$user_id'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $sum += $row['money'];
        }
        return $sum;
    }


    public static function czyLogowal($user_id, $ile_dni)  // funkcja sprawdza czy user logował się codziennie przez $ile_dni dni
    {
        $time = time();
        $ile_dni_time = $time - (($ile_dni + 1) * 60 * 60 * 24);
        $tx = date('d', $time);
        $tablica = [];
        $conn = pdo_connect_mysql_up();
        $sql12 = "SELECT * FROM `up_user_login_data` WHERE user_id = '$user_id' AND `data` > '$ile_dni_time' AND `data` < '$time' ORDER BY `data`";
        $sth12 = $conn->query($sql12);
        while ($row12 = $sth12->fetch()) {
            for ($i = 0; $i < $ile_dni; $i++) {
                if ($tablica[$i] != 1) {
                    if ($tx - $i == date('d', $row12['data'])) {
                        $tablica[$i] = '1';
                    } else $tablica[$i] = '2';
                }
            }
        }
        $banan = array_count_values($tablica);
        $ret = ($banan[1] >= $ile_dni - 1) ? '1' : '0';
        return $ret;
    }

    public static function ProbeUserVote($user_id, $probe_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT COUNT(*) FROM `up_user_probe_vote` WHERE probe_id = '$probe_id' AND user_id = '$user_id'";
        $stmt = $conn->query($sql2)->fetch(PDO::FETCH_NUM);
        return ($stmt[0] == '0') ? 'NIE' : 'TAK';
    }

    public static function ProbeUserVoteAcces($user_id, $probe_id)
    {
        $timed = time();
        $conn = pdo_connect_mysql_up();
        $sql2 = "SELECT COUNT(*) FROM `up_user_probe_vote` WHERE probe_id = '$probe_id' AND user_id = '$user_id'";
        $stmt = $conn->query($sql2)->fetch(PDO::FETCH_NUM);

        $sql = "SELECT * FROM `up_probe` WHERE id = '$probe_id'";
        $data = $conn->query($sql)->fetch();

        $targetPrefix = substr($data['state_target'], 0, 1);
        if ($data['date_until'] > $timed) {


            if ($targetPrefix == 'L' or $targetPrefix == '') {
                $citizen = [];
                $sql = "SELECT * FROM `up_user_citizenship` WHERE user_id = '$user_id'";
                $sth = $conn->query($sql);
                while ($row = $sth->fetch()) {
                    $citizen[] = $row['state_id'];
                }
                if ($data['citizenship'] != '0') {
                    $citi_acces = (in_array($data['state_target'], $citizen)) ? '1' : '0';
                    if ($targetPrefix=='') $citi_acces = (count($citizen) > 0 )? '1' : '0';
                } else $citi_acces = 1;
                $user_info = System::user_info($user_id);
                if (($user_info['state_id'] == $data['state_target'] or $data['state_target'] == '') and $stmt[0] == '0' and $citi_acces == '1') {
                    return 'TAK';
                } else return 'NIE';
            }

            if ($targetPrefix == 'I') {

                $sqls = "SELECT * FROM `up_organizations_workers` WHERE organizations_id = '$data[state_target]' AND user_id = '$user_id' AND until_date > '$timed' GROUP BY user_id ORDER BY id";
                $stmts = $conn->query($sqls)->fetch(PDO::FETCH_NUM);
                if (($stmts[0] != 0 or $data['state_target'] == '') and $stmt[0] == '0') {
                    return 'TAK';
                } else return 'NIE';
            } else if ($targetPrefix == '') {
                return 'TAK';
            } else return 'NIE';

        } else return 'NIE';
    }

    public static function getAnswerProbe($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_probe_questions` WHERE id = '$id'";
        $data = $conn->query($sql)->fetch();
        return $data['answer'];
    }

    public static function ActiveVote($user_id): int
    {
        $timed = time();
        $tp = 0;
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_probe` WHERE date_until > '$timed'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
            $acc = System::ProbeUserVoteAcces($user_id, $row['id']);
            if ($acc == 'TAK') $tp++;
        }
        return $tp;

    }

    public static function Stats($probe_id)
    {
        $probe = new Probe($probe_id);
        $time = time();
        if ($probe->getDateUntil() < $time) {
            $tablica = [];
            $conn = pdo_connect_mysql_up();
            $sql = "SELECT * FROM `up_probe_questions` WHERE probe_id='$probe_id'";
            $sth = $conn->query($sql);
            while ($row = $sth->fetch()) {
                $sql2 = "SELECT COUNT(*) FROM `up_user_probe_vote` WHERE `probe_id` = '$probe_id' AND `answer_id` = '$row[id]'";
                $stmt = $conn->query($sql2)->fetch(PDO::FETCH_NUM);
                $tablica[$row['id']] = $stmt[0];
            }
            return $tablica;
        } else return 'NOT_YET';
    }


}