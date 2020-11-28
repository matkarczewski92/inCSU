<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";

// Model danych - klasa dla Organizacji. Bie zmieniac niczego, w przypadku dodania kolumny w tabelu up_organizations dodać
// zmienną klasy `private`, pobranie w kontruktorze oraz getter i setter - o ile potrzeba settera (brak settera dla ID)


class Organizations
{
    private $id;
    private $type_id;
    private $name;
    private $text;
    private $leader_id;
    private $gfx_url;
    private $law;
    private $law_id_main;
    private $proposal;
    private $bank_acc;
    private $active;
    private $owner_id;
    private $state_id;
    private $article_salary_user;
    private $main_bank_acc;


    /**
     * Organizations constructor.
     * @param $id
     * @param $type_id
     * @param $name
     * @param $text
     * @param $leader_id
     * @param $gfx_url
     */
    public function __construct($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_organizations` WHERE id='$id'";
        $data = $conn->query($sql)->fetch();

        $this->id = $id;
        $this->type_id = $data['type_id'];
        $this->name = $data['name'];
        $this->text = $data['text'];
        $this->leader_id = $data['leader_id'];
        $this->gfx_url = $data['gfx_url'];
        $this->law = $data['law'];
        $this->proposal = $data['proposal'];
        $this->active = $data['active'];
        $this->owner_id = $data['owner_id'];
        $this->state_id = $data['state_id'];
        $this->article_salary_user = $data['article_salary_user'];
        $this->main_bank_acc = $data['main_bank_acc'];
        $this->law_id_main = $data['law_id_main'];

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
    public function getTypeId()
    {
        return $this->type_id;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getLeaderId()
    {
        return $this->leader_id;
    }

    /**
     * @return mixed
     */
    public function getGfxUrl()
    {
        return $this->gfx_url;
    }

    /**
     * @return mixed
     */
    public function getLaw()
    {
        return $this->law;
    }

    /**
     * @return mixed
     */
    public function getProposal()
    {
        return $this->proposal;
    }

    /**
     * @return mixed
     */
    public function getBankAcc()
    {
        return $this->bank_acc;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
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
    public function getArticleSalaryUser()
    {
        return $this->article_salary_user;
    }

    /**
     * @return mixed
     */
    public function getMainBankAcc()
    {
        return $this->main_bank_acc;
    }

    /**
     * @return mixed
     */
    public function getLawIdMain()
    {
        return $this->law_id_main;
    }







    ////////////////////////////////////////////// SETTERS


    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id)
    {
        update('up_organizations', 'id', $this->id, 'type_id', $type_id);
        $this->type_id = $type_id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        update('up_organizations', 'id', $this->id, 'name', $name);
        $this->name = $name;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        update('up_organizations', 'id', $this->id, 'text', $text);
        $this->text = $text;
    }

    /**
     * @param mixed $leader_id
     */
    public function setLeaderId($leader_id)
    {
        update('up_organizations', 'id', $this->id, 'leader_id', $leader_id);
        $this->leader_id = $leader_id;
    }

    /**
     * @param mixed $gfx_url
     */
    public function setGfxUrl($gfx_url)
    {
        update('up_organizations', 'id', $this->id, 'gfx_url', $gfx_url);
        $this->gfx_url = $gfx_url;
    }

    /**
     * @param mixed $law
     */
    public function setLaw($law)
    {
        update('up_organizations', 'id', $this->id, 'law', $law);
        $this->law = $law;
    }

    /**
     * @param mixed $proposal
     */
    public function setProposal($proposal)
    {
        update('up_organizations', 'id', $this->id, 'proposal', $proposal);
        $this->proposal = $proposal;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        update('up_organizations', 'id', $this->id, 'active', $active);
        $this->active = $active;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        update('up_organizations', 'id', $this->id, 'id', $id);
        $this->id = $id;
    }

    /**
     * @param mixed $bank_acc
     */
    public function setBankAcc($bank_acc)
    {
        update('up_organizations', 'id', $this->id, 'bank_acc', $bank_acc);
        $this->bank_acc = $bank_acc;
    }

    /**
     * @param mixed $owner_id
     */
    public function setOwnerId($owner_id)
    {
        update('up_organizations', 'id', $this->id, 'owner_id', $owner_id);
        $this->owner_id = $owner_id;
    }

    /**
     * @param mixed $state_id
     */
    public function setStateId($state_id)
    {
        update('up_organizations', 'id', $this->id, 'state_id', $state_id);
        $this->state_id = $state_id;
    }

    /**
     * @param mixed $article_salary_user
     */
    public function setArticleSalaryUser($article_salary_user)
    {
        update('up_organizations', 'id', $this->id, 'article_salary_user', $article_salary_user);
        $this->article_salary_user = $article_salary_user;
    }

    /**
     * @param mixed $main_bank_acc
     */
    public function setMainBankAcc($main_bank_acc)
    {
        update('up_organizations', 'id', $this->id, 'main_bank_acc', $main_bank_acc);
        $this->main_bank_acc = $main_bank_acc;
    }

    /**
     * @param mixed $law_id_main
     */
    public function setLawIdMain($law_id_main)
    {
        update('up_organizations', 'id', $this->id, 'law_id_main', $law_id_main);
        $this->law_id_main = $law_id_main;
    }





}