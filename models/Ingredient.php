<?php

require_once ("Model.php");

class Ingredient extends Model implements JsonSerializable{

    private $inid;
    private $name;



    /**
     * Ingredient constructor.
     * @param $fields
     */
    public function __construct($fields)
    {
        $this->inid = isset($fields['inid'])?$fields['inid']:NULL;
        $this->name =  isset($fields['name'])?$fields['name']:NULL;
    }

    /**
     * @return null
     */
    public function getInid()
    {
        return $this->inid;
    }

    /**
     * @param null $inid
     */
    public function setInid($inid): void
    {
        $this->inid = $inid;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }



    public function getMainId()
    {
        return $this->getAffid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }


}