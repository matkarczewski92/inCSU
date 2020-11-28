<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";
require_once dirname(dirname(__FILE__)) . "/class/System.php";


// W tej klasie znajdują się wszystkie INSERTy dot systemu (poza kwestiami bankowymi)


class Create
{

    public static function Organization($type_id, $name, $text, $owner_id, $gfx_url, $law, $proposal, $leader_id, $state_id, $article, $article_salary_user)
    {
        $id = System::id_generator(4);
        $id_b = self::Account($id);
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_organizations` (`id`, `type_id`, `name`, `text`, `owner_id`, `gfx_url`, `law`, `proposal`, main_bank_acc, `leader_id`, `state_id`, `article`, `article_salary_user`)
 VALUES (:id, :type_id, :name, :text, :owner_id, :gfx_url, :law, :proposal, :main_bank_acc, :leader_id, :state_id, :article, :article_salary_user)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
            ':id' => $id,
            ':type_id' => $type_id,
            ':name' => $name,
            ':text' => $text,
            ':owner_id' => $owner_id,
            ':gfx_url' => $gfx_url,
            ':law' => $law,
            ':proposal' => $proposal,
            ':main_bank_acc' => $id_b,
            ':leader_id' => $leader_id,
            ':article' => $article,
            ':article_salary_user' => $article_salary_user,
            ':state_id' => $state_id));
        if ($type_id == 4) {

            $sql1 = "INSERT INTO `up_organizations_building` (`organization_id`) VALUES (:organization_id)";
            $sth1 = $conn->prepare($sql1);
            $sth1->execute(array(
                    ':organization_id' => $id)
            ) or die(print_r($sth1->errorInfo(), true));
        }
        return $id;
    }

    public static function Account($id_owner)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `bank_account` (owner_id, balance, debit) VALUES (:owner_id, :balance, :debit)";
        $sth = $conn->prepare($sql);

        $sql1 = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'bank_account'";
        $stmt1 = $conn->query($sql1)->fetch(PDO::FETCH_NUM);

        $sth->execute(array(
                ':owner_id' => $id_owner,
                ':balance' => '0',
                ':debit' => '0')
        ) or die(print_r($sth->errorInfo(), true));
        return $stmt1[0];
    }

    public static function Citizenship($user_id, $state_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_user_citizenship` (user_id, state_id, form_date) VALUES (:user_id, :state_id, :form_date)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':user_id' => $user_id,
                ':state_id' => $state_id,
                ':form_date' => time())
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function User($id_user, $name, $password, $email, $sex, $state_id, $city_id, $foreign_id)
    {
        $id = System::id_generator(1);
        $bank_cc = self::Account($id);
        $hash_password = hash('sha256', $password);
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_users` (id, `name`, `password`, email, sex, state_id, city_id, foreign_id, last_ip, main_account, register_date) 
VALUES (:id, :name, :password, :email, :sex, :state_id, :city_id, :foreign_id, :last_ip, :main_account, :register_date)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':id' => $id_user,
                ':name' => $name,
                ':password' => $hash_password,
                ':email' => $email,
                ':sex' => $sex,
                ':state_id' => $state_id,
                ':city_id' => $city_id,
                ':foreign_id' => $foreign_id,
                ':last_ip' => $_SERVER['REMOTE_ADDR'],
                ':main_account' => $bank_cc,
                ':register_date' => time())
        ) or die(print_r($sth->errorInfo(), true));
        return $id;
    }

    public static function City($name, $state_id, $leader_id, $gfx_url, $webpage_url)
    {
        $id = System::id_generator(3);
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_cities` (`id`, `state_id`, `name`, leader_id, gfx_url, webpage_url) VALUES (:id, :state_id, :name, :leader_id, :gfx_url, :webpage_url)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':id' => $id,
                ':state_id' => $state_id,
                ':name' => $name,
                ':leader_id' => $leader_id,
                ':gfx_url' => $gfx_url,
                ':webpage_url' => $webpage_url)
        ) or die(print_r($sth->errorInfo(), true));
        self::Account($id);
    }


    public static function Law($id_cat_main, $id_cat_low, $name, $text, $id_user, $state_id, $data)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `law_article` (`id_cat_main`, `id_cat_low`, `name`, `text`, `id_user`, `date`, `state_id`) 
                    VALUES (:id_cat_main, :id_cat_low, :name, :text, :id_user, :date, :state_id)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':id_cat_main' => $id_cat_main,
                ':id_cat_low' => $id_cat_low,
                ':name' => $name,
                ':text' => $text,
                ':id_user' => $id_user,
                ':date' => $data,
                ':state_id' => $state_id)
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function WorkerCountry($user_id, $state_id, $until_date, $name, $salary, $period_day, $law, $bank, $users, $cities, $proposal, $edit, $workers, $org, $org_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_countries_workers` (`user_id`, `state_id`, `until_date`, `name`, `salary`, `period_day`, `law`, `bank`, `users`, `cities`, `proposal`, `edit`, `workers`, `from_date`, `last_salary_date`, `org`, `org_id`) 
                    VALUES (:user_id, :state_id, :until_date, :name, :salary, :period_day, :law, :bank, :users, :cities, :proposal, :edit, :workers, :from_date, :last_salary_date, :org, :org_id)";
        $sth = $conn->prepare($sql);
        $tims = time() + ($until_date * 60 * 60 * 24);
        $sth->execute(array(
                ':user_id' => $user_id,
                ':state_id' => $state_id,
                ':until_date' => $tims,
                ':name' => $name,
                ':salary' => $salary,
                ':period_day' => $period_day,
                ':law' => $law,
                ':bank' => $bank,
                ':users' => $users,
                ':cities' => $cities,
                ':proposal' => $proposal,
                ':edit' => $edit,
                ':workers' => $workers,
                ':org' => $org,
                ':org_id' => $org_id,
                ':from_date' => time(),
                ':last_salary_date' => (time() + ($period_day * 60 * 60 * 24)))
        ) or die(print_r($sth->errorInfo(), true));
    }


    public static function WorkerOrg($user_id, $organizations_id, $frequency_days, $name, $salary, $until_date, $law, $bank, $proposal, $edit, $workers, $org, $org_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_organizations_workers` 
                  (`user_id`, `organizations_id`, `frequency_days`, `name`, `salary`, `until_date`, `law`, `bank`,`proposal`, `edit`, `workers`, `from_date`, `last_salay_date`, `org`, `org_id`) 
                    VALUES (:user_id, :organizations_id, :frequency_days, :name, :salary, :until_date, :law, :bank, :proposal, :edit, :workers, :from_date, :last_salay_date, :org, :org_id)";
        $sth = $conn->prepare($sql);
        $tims = time() + ($until_date * 60 * 60 * 24);
        $sth->execute(array(
                ':user_id' => $user_id,
                ':organizations_id' => $organizations_id,
                ':frequency_days' => $frequency_days,
                ':name' => $name,
                ':salary' => $salary,
                ':until_date' => $tims,
                ':law' => $law,
                ':bank' => $bank,
                ':proposal' => $proposal,
                ':edit' => $edit,
                ':workers' => $workers,
                ':from_date' => time(),
                ':org' => $org,
                ':org_id' => $org_id,
                ':last_salay_date' => time())
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function Proposal($proposal_id, $user_id, $organizations_id, $title, $text)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_proposal` (`proposal_id`, `date`, `user_id`, `organizations_id`, `title`, `text`) 
                    VALUES (:proposal_id, :date, :user_id, :organizations_id, :title, :text)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':proposal_id' => $proposal_id,
                ':date' => time(),
                ':user_id' => $user_id,
                ':organizations_id' => $organizations_id,
                ':title' => $title,
                ':text' => $text)
        ) or die(print_r($sth->errorInfo(), true));
        $owner = System::checkOwner($organizations_id);
        $x = System::getInfo($organizations_id);
        $echo = ($owner == '') ? $x[leader_id] : $owner;
        $alert_title = '<a href="' . _URL . '/profil/adm_wnioski/' . $organizations_id . '" style="text-decoration: none; color: #1d4e85">Organizacja ' . $organizations_id . ' otrzymała nowy wniosek</a>';
        ($echo != '') ? Create::Alert($echo, $alert_title) : '';

    }

    public static function Post($from_id, $to_id, $title, $text)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_post` (`from_id`, `to_id`, `title`, `text`, `date`) 
                    VALUES (:from_id, :to_id, :title, :text, :date)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':from_id' => $from_id,
                ':to_id' => $to_id,
                ':title' => $title,
                ':text' => $text,
                ':date' => time())
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function MediaArticle($organization_id, $users_id, $title, $text)
    {
        $conn = pdo_connect_mysql_up();
        $sql1 = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'up_media_article'";
        $stmt1 = $conn->query($sql1)->fetch(PDO::FETCH_NUM);
        $sql = "INSERT INTO `up_media_article` (`organizations_id`, `users_id`, `title`, `text`, `data`) 
                    VALUES (:organizations_id, :users_id, :title, :text, :date)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':organizations_id' => $organization_id,
                ':users_id' => $users_id,
                ':title' => $title,
                ':text' => $text,
                ':date' => time())
        ) or die(print_r($sth->errorInfo(), true));
        return $stmt1[0];
    }

    public static function MediaArticleComment($user_id, $article_id, $text)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_media_article_coment` (`user_id`, `article_id`, `text`, `date`) 
                    VALUES (:user_id, :article_id,  :text, :date)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':user_id' => $user_id,
                ':article_id' => $article_id,
                ':text' => $text,
                ':date' => time())
        ) or die(print_r($sth->errorInfo(), true));
        $art_info = System::getMediaArcitleInfo($article_id);
        $alert_title = '<a href="' . _URL . '/media/' . $article_id . '" style="text-decoration: none; color: #1d4e85">Otrzymałeś komentarz do artykułu nr ' . $article_id . '</a>';
        Create::Alert($art_info['users_id'], $alert_title);
    }

    public static function Log($user_id, $title)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_user_log` (`user_id`, `ip`, `title`, `datetime`) 
                    VALUES (:user_id, :ip, :title, :datetime)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':user_id' => $user_id,
                ':ip' => $_SERVER['REMOTE_ADDR'],
                ':title' => $title,
                ':datetime' => time())
        ) or die(print_r($sth->errorInfo(), true));
    }


    public static function Alert($user_id, $title)
    {
        $uid = substr($user_id, 0, 2);
        if ($uid == 'U0') {
            $conn = pdo_connect_mysql_up();
            $sql = "INSERT INTO `up_alerts` (`user_id`, `title`, `data`) 
                    VALUES (:user_id, :title, :data)";
            $sth = $conn->prepare($sql);
            $sth->execute(array(
                    ':user_id' => $user_id,
                    ':title' => $title,
                    ':data' => time())
            ) or die(print_r($sth->errorInfo(), true));
        }
    }

    public static function ProposalShema($state_id, $name, $text, $citizenship, $schemat, $tresc_aktu_zatwierdzenie, $tresc_aktu_odrzucenie, $tytul_zatwierdzenie, $tytul_odmowa, $kat_aktu, $cost, $lenno)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_proposal_type` 
(`state_id`, `name`, `text`,`citizenship`,`schemat`,`tresc_aktu_zatwierdzenie`,`tresc_aktu_odrzucenie`,`tytul_zatwierdzenie`,`tytul_odmowa`,`kat_aktu`,`cost`,`lenno`) 
                    VALUES (:state_id, :name, :text, :citizenship, :schemat, :tresc_aktu_zatwierdzenie, :tresc_aktu_odrzucenie, :tytul_zatwierdzenie, :tytul_odmowa, :kat_aktu, :cost, :lenno)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':state_id' => $state_id,
                ':name' => $name,
                ':text' => $text,
                ':citizenship' => $citizenship,
                ':schemat' => $schemat,
                ':tresc_aktu_zatwierdzenie' => $tresc_aktu_zatwierdzenie,
                ':tresc_aktu_odrzucenie' => $tresc_aktu_odrzucenie,
                ':tytul_zatwierdzenie' => $tytul_zatwierdzenie,
                ':tytul_odmowa' => $tytul_odmowa,
                ':kat_aktu' => $kat_aktu,
                ':cost' => $cost,
                ':lenno' => $lenno)
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function Like($article_id, $user_id, $like)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_media_article_like` (article_id, user_id, `like`, `time`) VALUES (:article_id, :user_id, :like, :time)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':article_id' => $article_id,
                ':user_id' => $user_id,
                ':like' => $like,
                ':time' => time())
        ) or die(print_r($sth->errorInfo(), true));
        $user_info = System::user_info($user_id);
        $title = ($like == '1') ? '<a href="' . _URL . '/media/' . $article_id . '">' . $user_info['name'] . ' polubił Twój artykuł</a>' : '<a href="' . _URL . '/media/' . $article_id . '">' . $user_info['name'] . ' nie lubi Twojego artykułu</a>';
        $article_info = System::getMediaArcitleInfo($article_id);
        self::Alert($article_info['users_id'], $title);

    }

    public static function AddFamily($user_id1, $id1_for_id2, $user_id2, $id2_for_id1)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_users_family` (`user_id1`, `id1_for_id2`, `user_id2`, `id2_for_id1`, `confirmed`) 
                    VALUES (:user_id1, :id1_for_id2, :user_id2, :id2_for_id1, :confirmed)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':user_id1' => $user_id1,
                ':id1_for_id2' => $id1_for_id2,
                ':user_id2' => $user_id2,
                ':id2_for_id1' => $id2_for_id1,
                ':confirmed' => '0')
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function AddRotator($article_id, $gfx_url, $active)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_media_rotator` (`article_id`, `gfx_url`, `until_date`, `active`) 
                    VALUES (:article_id, :gfx_url, :until_date, :active)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':article_id' => $article_id,
                ':gfx_url' => $gfx_url,
                ':until_date' => (time() + 604800),
                ':active' => $active)
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function Investment($user_id, $invest_id, $bank_acc)
    {
        $conn = pdo_connect_mysql_up();
        $sql1 = "SELECT * FROM `up_investments` WHERE id='$invest_id'";
        $data_invest = $conn->query($sql1)->fetch();
        $bank = Bank::transfer($bank_acc, _KIBANK, $data_invest['create_cost'], 'Opłata za otwarcie inwestycji');
        if ($bank == 'OK') {
            $sql = "INSERT INTO `up_user_investments` (`user_id`, `level`, `money`, `last_get`, `next_get`, `investments_id`) 
                    VALUES (:user_id, :level, :money, :last_get, :next_get, :investments_id)";
            $sth = $conn->prepare($sql);
            $sth->execute(array(
                    ':user_id' => $user_id,
                    ':level' => 1,
                    ':money' => $data_invest['start_money'],
                    ':last_get' => time(),
                    ':next_get' => (time() + 432000),
                    ':investments_id' => $invest_id)
            ) or die(print_r($sth->errorInfo(), true));
        }
    }

    public static function Vote($user_id, $probe_id, $answer_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_user_probe_vote` (probe_id, user_id, `answer_id`) VALUES (:probe_id, :user_id, :answer_id)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':probe_id' => $probe_id,
                ':user_id' => $user_id,
                ':answer_id' => $answer_id)
        ) or die(print_r($sth->errorInfo(), true));
    }

    public static function Probe($title, $text, $date_from, $date_until, $state_target, $citizenship, $probe_type_id, $answer_count, $answers, $org_id, $official)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_probe` (title, text, `date_from`, date_until, state_target, citizenship, probe_type_id, answer_count, org_id, official) 
            VALUES (:title, :text, :date_from, :date_until, :state_target, :citizenship, :probe_type_id, :answer_count, :org_id, :official)";
        $sth = $conn->prepare($sql);
        $sql1 = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'up_probe'";
        $stmt1 = $conn->query($sql1)->fetch(PDO::FETCH_NUM);

        $sth->execute(array(
                ':title' => $title,
                ':text' => $text,
                ':date_from' => $date_from,
                ':date_until' => $date_until,
                ':state_target' => $state_target,
                ':citizenship' => $citizenship,
                ':probe_type_id' => $probe_type_id,
                ':answer_count' => $answer_count,
                ':org_id' => $org_id,
                ':official' => $official)
        ) or die(print_r($sth->errorInfo(), true));

        while (list($klucz, $wartosc) = each($answers)) {
            $sql = "INSERT INTO `up_probe_questions` (probe_id, answer) VALUES (:probe_id, :answer)";
            $sth = $conn->prepare($sql);
            $sth->execute(array(
                    ':probe_id' => $stmt1[0],
                    ':answer' => $wartosc)
            ) or die(print_r($sth->errorInfo(), true));
        }
        return $stmt1[0];
    }

    public static function Building($plot_id, $metrage, $gfx_url, $start, $finish)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_plot_building` (`plot_id`, `square_meter`, `gfx_url`, `start_build_date`, `finish_build_date`) 
                        VALUES (:plot_id, :square_meter, :gfx_url, :start_build_date, :finish_build_date)";
        $sth = $conn->prepare($sql);
        $sql1 = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'up_plot_building'";
        $stmt1 = $conn->query($sql1)->fetch(PDO::FETCH_NUM);

        $sth->execute(array(
                ':plot_id' => $plot_id,
                ':square_meter' => $metrage,
                ':gfx_url' => $gfx_url,
                ':start_build_date' => $start,
                ':finish_build_date' => $finish)
        ) or die(print_r($sth->errorInfo(), true));
        return $stmt1[0];
    }

    public static function Plot($id, $city, $type, $address, $metrage, $price)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_plot` (`id`, `city_id`, `type_id`, `address`, `square_meter`, `price`) 
                        VALUES (:id, :city_id, :type_id, :address, :square_meter, :price)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':id' => $id,
                ':city_id' => $city,
                ':type_id' => $type,
                ':address' => $address,
                ':square_meter' => $metrage,
                ':price' => $price)
        ) or die(print_r($sth->errorInfo(), true));

    }

    public static function Blueprint($name, $gfx_url, $metrage, $price, $build_duration, $adm_cost, $author_id, $plot_id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "INSERT INTO `up_plot_blueprints` (`name`, `gfx_url`, `metrage`, `price`, `build_duration`, `adm_cost`, `author_id`, `plot_id`) 
                        VALUES (:name, :gfx_url, :metrage, :price, :build_duration, :adm_cost, :author_id, :plot_id)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':name' => $name,
                ':gfx_url' => $gfx_url,
                ':metrage' => $metrage,
                ':price' => $price,
                ':build_duration' => $build_duration,
                ':adm_cost' => $adm_cost,
                ':author_id' => $author_id,
                ':plot_id' => $plot_id)
        ) or die(print_r($sth->errorInfo(), true));

    }
    public static function Stats($type, $value)
    {
        $r = date("Y");
        $m = date("m");
        $d = date("d");
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT COUNT(*) FROM `stats` WHERE `year` = '$r' AND `month` = '$m' AND `day` = '$d' AND `data_type` = '$type'";
        $stmt_users = $conn->query($sql)->fetch(PDO::FETCH_NUM);
        $r = date("Y");
        $m = date("m");
        $d = date("d");
        if ($stmt_users[0]==0){
        $sql = "INSERT INTO `stats` (`year`, `month`, `day`, `data_type`, `values`) VALUES (:year, :month, :day, :data_type, :values)";
        $sth = $conn->prepare($sql);
        $sth->execute(array(
                ':year' => $r,
                ':month' => $m,
                ':day' => $d,
                ':data_type' => $type,
                ':values' => $value)
        ) or die(print_r($sth->errorInfo(), true));
        } echo 'Już dodano<br>';
    }
}