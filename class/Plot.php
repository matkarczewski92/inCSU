<?php
require_once dirname(dirname(__FILE__)) . "/controller/db_connection.php";


class Plot
{

    private $id;
    private $city_id;
    private $type_id;
    private $type_name;
    private $owner_id;
    private $squareMeter;
    private $building_id;
    private $price;
    private $address;

    /**
     * Plot constructor.
     * @param $id
     * @param $city_id
     * @param $type_id
     * @param $type_name
     * @param $owner_id
     * @param $squareMeter
     * @param $building_id
     * @param $price
     */
    public function __construct($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql = "SELECT * FROM `up_plot` WHERE id = '$id'";
        $data = $conn->query($sql)->fetch();
        $sql1 = "SELECT * FROM `up_plot_type` WHERE id = '$data[type_id]'";
        $data1 = $conn->query($sql1)->fetch();


        $this->id = $id;
        $this->city_id = $data['city_id'];
        $this->type_id = $data['type_id'];
        $this->type_name = $data1['name'];
        $this->owner_id = $data['owner_id'];
        $this->squareMeter = $data['square_meter'];
        $this->building_id = $data['building_id'];
        $this->price = $data['price'];
        $this->address = $data['address'];

    }

    public function buildingInfo()
    {
        $b_id = $this->building_id;
        $conn = pdo_connect_mysql_up();
        $sql1 = "SELECT * FROM `up_plot_building` WHERE id = '$b_id'";
        return $conn->query($sql1)->fetch();
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
    public function getCityId()
    {
        return $this->city_id;
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
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @return mixed
     */
    public function getSquareMeter()
    {
        return $this->squareMeter;
    }

    /**
     * @return mixed
     */
    public function getBuildingId()
    {

        return $this->building_id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }


    ///////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param mixed $city_id
     */
    public function setCityId($city_id)
    {
        update('up_plot', 'id', $this->id, 'city_id', $city_id);
        $this->city_id = $city_id;
    }

    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id)
    {
        update('up_plot', 'id', $this->id, 'type_id', $type_id);
        $this->type_id = $type_id;
    }

    /**
     * @param mixed $owner_id
     */
    public function setOwnerId($owner_id)
    {
        update('up_plot', 'id', $this->id, 'owner_id', $owner_id);
        $this->owner_id = $owner_id;
    }

    /**
     * @param mixed $squareMeter
     */
    public function setSquareMeter($squareMeter)
    {
        update('up_plot', 'id', $this->id, 'square_meter', $squareMeter);
        $this->squareMeter = $squareMeter;
    }

    /**
     * @param mixed $building_id
     */
    public function setBuildingId($building_id)
    {
        update('up_plot', 'id', $this->id, 'building_id', $building_id);
        $this->building_id = $building_id;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        update('up_plot', 'id', $this->id, 'price', $price);
        $this->price = $price;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        update('up_plot', 'id', $this->id, 'address', $address);
        $this->address = $address;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        update('up_plot', 'id', $this->id, 'id', $id);
        $this->id = $id;
    }



}