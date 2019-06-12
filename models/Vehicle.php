<?php
require_once ("Model.php");

class Vehicle extends Model implements JsonSerializable {
    private $vid;
    private $volume;
    private $insuranceDate;
    private $lastRevision;
    private $description;

    public function __construct(array $fields){
        $this->vid = isset($fields['vid']) ? $fields['vid'] : null;
        $this->volume = $fields['volume'];
        $this->insuranceDate = $fields['insuranceDate'];
        $this->lastRevision = $fields['lastRevision'];
        $this->description = $fields['description'];
    }

    /**
     * @return mixed|null
     */
    public function getVid()
    {
        return $this->vid;
    }

    /**
     * @param mixed|null $vid
     */
    public function setVid($vid): void
    {
        $this->vid = $vid;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume): void
    {
        $this->volume = $volume;
    }

    /**
     * @return mixed
     */
    public function getInsuranceDate()
    {
        return $this->insuranceDate;
    }

    /**
     * @param mixed $insuranceDate
     */
    public function setInsuranceDate($insuranceDate): void
    {
        $this->insuranceDate = $insuranceDate;
    }

    /**
     * @return mixed
     */
    public function getLastRevision()
    {
        return $this->lastRevision;
    }

    /**
     * @param mixed $lastRevision
     */
    public function setLastRevision($lastRevision): void
    {
        $this->lastRevision = $lastRevision;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getMainId()
    {
        return $this->getVid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }

}



?>