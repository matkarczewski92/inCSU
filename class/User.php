<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";

// Klasa - model danych użytkownika, nie zmieniac niczego, w przypadku dodania kolumny w tabelu up_users dodać
// zmienną klasy private, pobranie w kontruktorze oraz getter i setter - o ile potrzeba settera (brak settera dla ID)


class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $register_date;
    private $citizenship;
    private $sex;
    private $state_id;
    private $city_id;
    private $avatar_url;
    private $arms_url;
    private $exp_points;
    private $title_id;
    private $title_u_id;
    private $title_academic;
    private $title_rank;
    private $foreign_id;
    private $last_ip;
    private $text;
    private $honor_title;
    private $main_account;
    private $global_admin;
    private $global_admin_opt;
    private $plotId;
    private $active;

    /**
     * user constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_users` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();

        $this->id = $id;
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->register_date = $data['register_date'];
        $this->citizenship = $data['citizenship'];
        $this->sex = $data['sex'];
        $this->state_id = $data['state_id'];
        $this->city_id = $data['city_id'];
        $this->avatar_url = $data['avatar_url'];
        $this->arms_url = $data['arms_url'];
        $this->exp_points = $data['exp_points'];
        $this->title_id = $data['title_id'];
        $this->title_u_id = $data['title_u_id'];
        $this->title_academic = $data['title_academic'];
        $this->title_rank = $data['title_rank'];
        $this->foreign_id = $data['foreign_id'];
        $this->text = $data['text'];
        $this->honor_title = $data['honor_title'];
        $this->main_account = $data['main_account'];
        $this->global_admin = $data['global_admin'];
        $this->global_admin_opt = $data['global_admin_opt'];
        $this->plotId = $data['plot_id'];
        $this->active = $data['active'];

        if ($_COOKIE['id'] == ($this->id)) {

            if ($data['last_ip'] == $_SERVER['REMOTE_ADDR']) {
                $this->last_ip = $data['last_ip'];
            } else {
                $this->setLastIp($_SERVER['REMOTE_ADDR']);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getRegisterDate()
    {
        return $this->register_date;
    }

    /**
     * @return mixed
     */
    public function getCitizenship()
    {
        return $this->citizenship;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return mixed
     */
    public function getStateId()
    {
        return $this->state_id;
    }

    /**
     * @return mixed
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * @return mixed
     */
    public function getAvatarUrl()
    {
        return $this->avatar_url;
    }

    /**
     * @return mixed
     */
    public function getExpPoints()
    {
        return $this->exp_points;
    }

    /**
     * @return mixed
     */
    public function getTitleId()
    {
        return $this->title_id;
    }

    /**
     * @return mixed
     */
    public function getTitleUId()
    {
        return $this->title_u_id;
    }

    /**
     * @return mixed
     */
    public function getGoreignId()
    {
        return $this->foreign_id;
    }

    /**
     * @return mixed
     */
    public function getLatIp()
    {
        return $this->last_ip;
    }

    /**
     * @return mixed
     */
    public function getArmsUrl()
    {
        return $this->arms_url;
    }

    /**
     * @return mixed
     */
    public function getTitleAcademic()
    {
        return $this->title_academic;
    }

    /**
     * @return mixed
     */
    public function getTitleRank()
    {
        return $this->title_rank;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getHonorTitle()
    {
        return $this->honor_title;
    }

    /**
     * @return mixed
     */
    public function getMainAccount()
    {
        return $this->main_account;
    }

    /**
     * @return mixed
     */
    public function getGlobalAdmin()
    {
        return $this->global_admin;
    }

    /**
     * @return mixed
     */
    public function getGlobalAdminOpt()
    {
        return $this->global_admin_opt;
    }
    /**
     * @return mixed
     */
    public function getPlotId()
    {
        return $this->plotId;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }














    ///////////////////////////////////////////////////////////////////////// SETTERY --------------------------
    ///
    ///
    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        update('up_users', 'id', $this->id, 'email', $email);
        $this->email = $email;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        update('up_users', 'id', $this->id, 'name', $name);
        $this->name = $name;
    }

    /**
     * @param mixed $register_date
     */
    public function setRegisterDate($register_date)
    {
        update('up_users', 'id', $this->id, 'register_date', $register_date);
        $this->register_date = $register_date;
    }

    /**
     * @param mixed $citizenship
     */
    public function setCitizenship($citizenship)
    {
        update('up_users', 'id', $this->id, 'citizenship', $citizenship);
        $this->citizenship = $citizenship;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        update('up_users', 'id', $this->id, 'sex', $sex);
        $this->sex = $sex;
    }

    /**
     * @param mixed $state_id
     */
    public function setStateId($state_id)
    {
        update('up_users', 'id', $this->id, 'state_id', $state_id);
        $this->state_id = $state_id;
    }

    /**
     * @param mixed $city_id
     */
    public function setCityId($city_id)
    {
        update('up_users', 'id', $this->id, 'city_id', $city_id);
        $this->city_id = $city_id;
    }

    /**
     * @param mixed $avatar_url
     */
    public function setAvatarUrl($avatar_url)
    {
        update('up_users', 'id', $this->id, 'avatar_url', $avatar_url);
        $this->avatar_url = $avatar_url;
    }

    /**
     * @param mixed $exp_points
     */
    public function setExpPoints($exp_points)
    {
        update('up_users', 'id', $this->id, 'exp_points', $exp_points);
        $this->exp_points = $exp_points;
    }

    /**
     * @param mixed $title_id
     */
    public function setTitleId($title_id)
    {
        update('up_users', 'id', $this->id, 'title_id', $title_id);
        $this->title_id = $title_id;
    }

    /**
     * @param mixed $title_u_id
     */
    public function setTitleUId($title_u_id)
    {
        update('up_users', 'id', $this->id, 'title_u_id', $title_u_id);
        $this->title_u_id = $title_u_id;
    }

    /**
     * @param mixed foreign_id
     */
    public function setForeignId($foreign_id)
    {
        update('up_users', 'id', $this->id, 'foreign_id', $foreign_id);
        $this->foreign_id = $foreign_id;
    }

    /**
     * @param mixed $last_ip
     */
    public function setLastIp($last_ip)
    {
        update('up_users', 'id', $this->id, 'last_ip', $last_ip);
        $this->last_ip = $last_ip;
    }


    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $hash_password = hash('sha256', $password);
        update('up_users', 'id', $this->id, 'password', $hash_password);
        $this->password = $password;
    }

    /**
     * @param mixed $arms_url
     */
    public function setArmsUrl($arms_url)
    {
        update('up_users', 'id', $this->id, 'arms_url', $arms_url);
        $this->arms_url = $arms_url;
    }

    /**
     * @param mixed $title_academic
     */
    public function setTitleAcademic($title_academic)
    {
        update('up_users', 'id', $this->id, 'title_academic', $title_academic);
        $this->title_academic = $title_academic;
    }

    /**
     * @param mixed $title_rank
     */
    public function setTitleRank($title_rank)
    {
        update('up_users', 'id', $this->id, 'title_rank', $title_rank);
        $this->title_rank = $title_rank;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        update('up_users', 'id', $this->id, 'text', $text);
        $this->text = $text;
    }

    /**
     * @param mixed $honor_title
     */
    public function setHonorTitle($honor_title)
    {
        update('up_users', 'id', $this->id, 'honor_title', $honor_title);
        $this->honor_title = $honor_title;
    }

    /**
     * @param mixed $main_account
     */
    public function setMainAccount($main_account)
    {
        update('up_users', 'id', $this->id, 'main_account', $main_account);
        $this->main_account = $main_account;
    }

    /**
     * @param mixed global_admin_opt
     */
    public function setGlobalAdminOpt()
    {
        $adm = (self::getGlobalAdminOpt() == 1) ? '0' : '1';
        update('up_users', 'id', $this->id, 'global_admin_opt', $adm);
        $this->global_admin_opt = $adm;
    }

    /**
     * @param mixed $plotId
     */
    public function setPlotId($plotId)
    {
        update('up_users', 'id', $this->id, 'plot_id', $plotId);
        $this->plotId = $plotId;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        update('up_users', 'id', $this->id, 'active', $active);
        $this->active = $active;
    }














}