<?php
require_once ("Model.php");

class Room extends Model implements JsonSerializable {
    private $rid;
    private $name;
    private $isUnavailable;
    private $isStockroom;
    private $loid;

    public function __construct(array $fields) {
        $this->rid = isset($fields['rid']) ? $fields['rid'] : NULL;
        $this->name = $fields['name'];
        $this->isUnavailable = $fields['isUnavailable'];
        $this->isStockroom = $fields['isStockroom'];
        $this->loid = isset($fields['loid']) ? $fields['loid'] : NULL;
    }

    /**
     * @return mixed|null
     */
    public function getRid()
    {
        return $this->rid;
    }

    /**
     * @param mixed|null $rid
     */
    public function setRid($rid): void
    {
        $this->rid = $rid;
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
    public function getisUnavailable()
    {
        return $this->isUnavailable;
    }

    /**
     * @param mixed $isUnavailable
     */
    public function setIsUnavailable($isUnavailable): void
    {
        $this->isUnavailable = $isUnavailable;
    }

    /**
     * @return mixed
     */
    public function getisStockroom()
    {
        return $this->isStockroom;
    }

    /**
     * @param mixed $isStockroom
     */
    public function setIsStockroom($isStockroom): void
    {
        $this->isStockroom = $isStockroom;
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

    public function getMainId()
    {
        return $this->getRid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>