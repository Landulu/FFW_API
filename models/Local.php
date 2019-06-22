<?php

require_once ("Model.php");

class Local extends Model implements JsonSerializable {
    private $loid;
    private $name;
    private $adid;

    public function __construct(array $fields) {
        $this->loid = isset($fields['loid']) ? $fields['loid'] : NULL;
        $this->name = $fields['name'];
        $this->adid = isset($fields['adid']) ? $fields['adid'] : NULL;
    }

    /**
     * @return mixed|null
     */
    public function getLoid()
    {
        return $this->loid;
    }

    /**
     * @param mixed|null $loid
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
     * @return mixed|null
     */
    public function getAdid()
    {
        return $this->adid;
    }

    /**
     * @param mixed|null $adid
     */
    public function setAdid($adid): void
    {
        $this->adid = $adid;
    }

    public function getMainId()
    {
        return $this->getLoid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>