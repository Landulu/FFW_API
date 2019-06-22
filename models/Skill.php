<?php

require_once ("Model.php");

class Skill extends Model implements JsonSerializable {
    private $skid;
    private $name;
    private $skStatus;

    public function __construct(array $fields) {
        $this->skid = isset($fields['skid']) ? $fields['skid'] : NULL;
        $this->name = isset($fields['name']) ? $fields['name'] :NULL;
        $this->skStatus = isset($fields['skStatus']) ? $fields['skStatus'] :NULL;
    }

    /**
     * @return mixed|null
     */
    public function getSkid()
    {
        return $this->skid;
    }

    /**
     * @param mixed|null $skid
     */
    public function setSkid( $skid): void
    {
        $this->skid = $skid;
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed|null $name
     */
    public function setName( $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed|null
     */
    public function getSkStatus()
    {
        return $this->skStatus;
    }

    /**
     * @param mixed|null $skStatus
     */
    public function setSkStatus( $skStatus): void
    {
        $this->skStatus = $skStatus;
    }

    public function getMainId()
    {
        return $this->getSkid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>