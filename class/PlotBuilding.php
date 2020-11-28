<?php


class PlotBuilding
{
    private $id;
    private $name;
    private $text;
    private $avatarUrl;
    private $gfxUrl;
    private $dateBuild;
    private $startBuild;
    private $finishBuild;
    private $buildOrganization;
    private $squareMeter;
    private $plotId;

    /**
     * PlotBuilding constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $conn = pdo_connect_mysql_up();
        $sql1 = "SELECT * FROM `up_plot_building` WHERE id = '$id'";
        $date = $conn->query($sql1)->fetch();

        $this->id = $id;
        $this->name = $date['name'];
        $this->text = $date['text'];
        $this->avatarUrl = $date['avatar_url'];
        $this->gfxUrl = $date['gfx_url'];
        $this->dateBuild = $date['date_build'];
        $this->startBuild = $date['start_build_date'];
        $this->finishBuild = $date['finish_build_date'];
        $this->buildOrganization = $date['build_org_id'];
        $this->squareMeter = $date['square_meter'];
        $this->plotId = $date['plot_id'];
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * @return mixed
     */
    public function getGfxUrl()
    {
        return $this->gfxUrl;
    }

    /**
     * @return mixed
     */
    public function getDateBuild()
    {
        return $this->dateBuild;
    }

    /**
     * @return mixed
     */
    public function getStartBuild()
    {
        return $this->startBuild;
    }

    /**
     * @return mixed
     */
    public function getFinishBuild()
    {
        return $this->finishBuild;
    }

    /**
     * @return mixed
     */
    public function getBuildOrganization()
    {
        return $this->buildOrganization;
    }

    /**
     * @return mixed
     */
    public function getSquareMeter()
    {
        return $this->squareMeter;
    }/**
 * @return mixed
 */
public function getPlotId()
{
    return $this->plotId;
}





/////////////////////////////////////////// setery
///
///
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        update('up_plot_building', 'id', $this->id, 'name', $name);
        $this->name = $name;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        update('up_plot_building', 'id', $this->id, 'text', $text);
        $this->text = $text;
    }

    /**
     * @param mixed $avatarUrl
     */
    public function setAvatarUrl($avatarUrl)
    {
        update('up_plot_building', 'id', $this->id, 'avatar_url', $avatarUrl);
        $this->avatarUrl = $avatarUrl;
    }

    /**
     * @param mixed $gfxUrl
     */
    public function setGfxUrl($gfxUrl)
    {
        update('up_plot_building', 'id', $this->id, 'gfx_url', $gfxUrl);
        $this->gfxUrl = $gfxUrl;
    }

    /**
     * @param mixed $dateBuild
     */
    public function setDateBuild($dateBuild)
    {
        update('up_plot_building', 'id', $this->id, 'date_build', $dateBuild);
        $this->dateBuild = $dateBuild;
    }

    /**
     * @param mixed $startBuild
     */
    public function setStartBuild($startBuild)
    {
        update('up_plot_building', 'id', $this->id, 'start_build_date', $startBuild);
        $this->startBuild = $startBuild;
    }

    /**
     * @param mixed $finishBuild
     */
    public function setFinishBuild($finishBuild)
    {
        update('up_plot_building', 'id', $this->id, 'finish_build_date', $finishBuild);
        $this->finishBuild = $finishBuild;
    }

    /**
     * @param mixed $buildOrganization
     */
    public function setBuildOrganization($buildOrganization)
    {
        update('up_plot_building', 'id', $this->id, 'build_org_id', $buildOrganization);
        $this->buildOrganization = $buildOrganization;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        update('up_plot_building', 'id', $this->id, 'id', $id);
        $this->id = $id;
    }

    /**
     * @param mixed $squareMeter
     */
    public function setSquareMeter($squareMeter)
    {
        update('up_plot_building', 'id', $this->id, 'square_meter', $squareMeter);
        $this->squareMeter = $squareMeter;
    }
    /**
     * @param mixed $plotId
     */
    public function setPlotId($plotId)
    {
        update('up_plot_building', 'id', $this->id, 'plot_id', $plotId);
        $this->plotId = $plotId;
    }













}