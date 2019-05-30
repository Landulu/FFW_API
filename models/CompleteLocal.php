<?php


class CompleteLocal implements  JsonSerializable {

    private $loid;
    private $name;
    private $adid;
    private $rooms;
    private $address;

    /**
     * CompleteLocal constructor.
     * @param $loid
     * @param $name
     * @param $adid
     * @param $rooms
     * @param $address
     */
    public function __construct($fields)
    {
        $this->loid = isset($fields['loid']) ? $fields['loid'] : NULL;
        $this->name = isset($fields['name']) ? $fields['name'] : NULL;
        $this->adid = isset($fields['adid']) ? $fields['adid'] : NULL;
        $this->rooms = isset($fields['rooms']) ? $fields['rooms'] : NULL;
        $this->address = isset($fields['address']) ? $fields['address'] : NULL;
    }


    /**
     * @return mixed
     */
    public function getLoid()
    {
        return $this->loid;
    }

    /**
     * @param mixed $loid
     */
    public function setLoid($loid): void
    {
        $this->loid = $loid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAdid()
    {
        return $this->adid;
    }

    /**
     * @param mixed $adid
     */
    public function setAdid($adid): void
    {
        $this->adid = $adid;
    }

    /**
     * @return mixed
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param mixed $rooms
     */
    public function setRooms($rooms): void
    {
        $this->rooms = $rooms;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }

}