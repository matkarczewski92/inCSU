<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";
require_once dirname(dirname(__FILE__)) . "/class/System.php";

class Investments
{
    private $inv_id;
    private $user_id;
    private $actualLevel;
    private $lvlUpCost;
    private $freq;

    private $actualMoney;
    private $nextLevelMoney;

    private $lastGet;
    private $nextGet;
    private $investmentsId;

    private $lastMoney;

    /**
     * Investments constructor.
     * @param $id
     * @param $investmentsId
     */
    public function __construct($investmentsId)
    {
        $conn = pdo_connect_mysql_up();

        $sql2 = "SELECT COUNT(*) FROM `up_user_investments` WHERE id = '$investmentsId'";
        $stmt = $conn->query($sql2)->fetch(PDO::FETCH_NUM);
        if ($stmt[0] != 0) {
            $sql = "SELECT * FROM `up_user_investments` WHERE id = '$investmentsId'";
            $data = $conn->query($sql)->fetch();
            $sql1 = "SELECT * FROM `up_investments` WHERE id='$data[investments_id]'";
            $data_invest = $conn->query($sql1)->fetch();

            $this->inv_id = $investmentsId;
            $this->user_id = $data['user_id'];
            $this->actualLevel = $data['level'];
            $this->actualMoney = $data['money'];
            $this->lastGet = $data['last_get'];
            $this->nextGet = $data['next_get'];
            $this->investmentsId = $data['investments_id'];
            $this->freq = $data_invest['freq'];

            $this->lvlUpCost = ($data['money'] * $data_invest['lvl_up_cost']);
            $this->nextLevelMoney = ($data['money'] * $data_invest['money_level_multiplier']);
            $this->lastMoney = ($data['money'] / $data_invest['money_level_multiplier']);
        }
    }

    public function lvlUp($bank_from)
    {
        $bank = Bank::transfer($bank_from, _KIBANK, $this->lvlUpCost, 'Opłata za rozwój inwestycji');
        if ($bank == 'OK') {
            update('up_user_investments', 'id', $this->inv_id, 'level', ($this->actualLevel + 1));
            update('up_user_investments', 'id', $this->inv_id, 'money', $this->nextLevelMoney);
        }
        return $bank;
    }
    public function admLvlUp()
    {
            update('up_user_investments', 'id', $this->inv_id, 'level', ($this->actualLevel + 1));
            update('up_user_investments', 'id', $this->inv_id, 'money', $this->nextLevelMoney);
    }
    public function admLvlDown()
    {
        update('up_user_investments', 'id', $this->inv_id, 'level', ($this->actualLevel - 1));
        update('up_user_investments', 'id', $this->inv_id, 'money', $this->lastMoney);
    }

    public function moneyGet()
    {
        $brutto = $this->actualMoney;
        $freq_day = ($this->getFreq()/(60*60*24));
        $bonus1 = System::czyLogowal($this->user_id, $freq_day);
        if ($bonus1 == '1') $brutto += $brutto * 0.10;
        $user_info = System::user_info($this->user_id);
        $tax_state = System::land_info($user_info['state_id']);
        $tax = $tax_state['tax_personal'];
        $tax_to_pay = $brutto * $tax; // kwota podatku dla kraju
        $netto = $brutto - $tax_to_pay; // kwota netto do wypłaty dla usera
        $conn = pdo_connect_mysql_up();
        $sql1 = "SELECT * FROM `bank_account` WHERE owner_id = '$user_info[state_id]'";
        $sth1 = $conn->query($sql1);
        while ($row1 = $sth1->fetch()) {
            $bank_to_tax = $row1['id'];
        }
        $sql12 = "SELECT * FROM `bank_account` WHERE owner_id = '$this->user_id'  LIMIT 0,1";
        $sth12 = $conn->query($sql12);
        while ($row12 = $sth12->fetch()) {
            $bank_to_netto = $row12['id'];
        }
        $times = time();
        $time = ($times + ($this->freq));
        if ($this->nextGet < $times) {
            update('up_user_investments', 'id', $this->inv_id, 'last_get', time());
            update('up_user_investments', 'id', $this->inv_id, 'next_get', $time);
            $title_tax = 'Podatek od dochodów z inwestycji. Mieszkaniec ID: ' . $this->user_id;
            if ($bonus1 == '1') $title_netto = 'Wypłata z tytułu inwestycji + premia za codzienne logowania'; else $title_netto = 'Wypłata z tytułu inwestycji';
            $bank_tax = ($tax_to_pay != 0) ? Bank::transfer(_KIBANK, $bank_to_tax, $tax_to_pay, $title_tax) : '';
            $bank_netto = Bank::transfer(_KIBANK, $bank_to_netto, $netto, $title_netto);
            return $bonus1;
        } else return 'NOT_YET';

    }


    /**
     * @return mixed
     */
    public function getActualLevel()
    {
        return $this->actualLevel;
    }

    /**
     * @return float|int
     */
    public function getLvlUpCost()
    {
        return $this->lvlUpCost;
    }

    /**
     * @return mixed
     */
    public function getActualMoney()
    {
        return $this->actualMoney;
    }

    /**
     * @return float|int
     */
    public function getNextLevelMoney()
    {
        return $this->nextLevelMoney;
    }

    /**
     * @return mixed
     */
    public function getLastGet()
    {
        return $this->lastGet;
    }

    /**
     * @return mixed
     */
    public function getInvestmentsId()
    {
        return $this->investmentsId;
    }

    /**
     * @return mixed
     */
    public function getNextGet()
    {
        return $this->nextGet;
    }

    /**
     * @return mixed
     */
    public function getInvId()
    {
        return $this->inv_id;
    }

    /**
     * @return mixed
     */
    public function getFreq()
    {
        return $this->freq;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return float|int
     */
    public function getLastMoney()
    {
        return $this->lastMoney;
    }





///////////////////// settery


    /**
     * @param mixed $inv_id
     */
    public function setInvId($inv_id)
    {
        update('up_user_investments', 'id', $this->inv_id, 'id', $inv_id);
        $this->inv_id = $inv_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        update('up_user_investments', 'id', $this->inv_id, 'user_id', $user_id);
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $actualLevel
     */
    public function setActualLevel($actualLevel)
    {
        update('up_user_investments', 'id', $this->inv_id, 'level', $actualLevel);
        $this->actualLevel = $actualLevel;
    }


    /**
     * @param mixed $actualMoney
     */
    public function setActualMoney($actualMoney)
    {
        update('up_user_investments', 'id', $this->inv_id, 'money', $actualMoney);
        $this->actualMoney = $actualMoney;
    }

    /**
     * @param mixed $lastGet
     */
    public function setLastGet($lastGet)
    {
        update('up_user_investments', 'id', $this->inv_id, '	last_get', $lastGet);
        $this->lastGet = $lastGet;
    }

    /**
     * @param mixed $nextGet
     */
    public function setNextGet($nextGet)
    {
        update('up_user_investments', 'id', $this->inv_id, 'next_get', $nextGet);
        $this->nextGet = $nextGet;
    }

    /**
     * @param mixed $investmentsId
     */
    public function setInvestmentsId($investmentsId)
    {
        update('up_user_investments', 'id', $this->inv_id, 'investments_id', $investmentsId);
        $this->investmentsId = $investmentsId;
    }



}