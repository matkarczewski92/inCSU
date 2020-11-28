<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";

class Probe
{
    private $id;
    private $title;
    private $text;
    private $date_from;
    private $date_until;
    private $citizenship;
    private $target_state;
    private $organization;

    private $type_id;
    private $type_name;
    private $official;

    private $answers; // checkbox or radio
    private $question = [];

    /**
     * Probe constructor.
     * @param $id
     * @param $title
     * @param $text
     * @param $date_from
     * @param $date_until
     * @param $citizenship
     * @param $target_state
     * @param $type_id
     * @param $type_name
     */

    public function __construct($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_probe` WHERE id = '$id'";
        $data = $conn->query($sql)->fetch();

        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->text = $data['text'];
        $this->date_from = $data['date_from'];
        $this->date_until = $data['date_until'];
        $this->citizenship = $data['citizenship'];
        $this->official = $data['official'];
        $this->organization = $data['org_id'];
        $target = ($data['state_target']=='')? 'I00001' : $data['state_target'];
        $this->target_state = $target;

        $this->answers = ($data['answer_count']=='0')? 'radio' : 'checkbox';

        $sql1 = "SELECT * FROM `up_probe_type` WHERE id = '$data[probe_type_id]'";
        $data_type = $conn->query($sql1)->fetch();

        $this->type_id = $data['probe_type_id'];
        $this->type_name = $data_type['title'];

        $sql = "SELECT * FROM `up_probe_questions` WHERE probe_id='$this->id'";
        $sth = $conn->query($sql);
        while ($row = $sth->fetch()) {
        $this->question[$row['id']] = $row['answer'];
        }
    }



    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
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
    public function getDateFrom()
    {
        return $this->date_from;
    }

    /**
     * @return mixed
     */
    public function getDateUntil()
    {
        return $this->date_until;
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
    public function getTargetState()
    {
        return $this->target_state;
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
    public function getTypeName()
    {
        return $this->type_name;
    }

    /**
     * @return array
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @return mixed
     */
    public function getOfficial()
    {
        return $this->official;
    }

    /**
     * @return mixed
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }







}