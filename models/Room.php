<?php

class Room implements JsonSerializable {
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

    public function getRId(): ?int {return $this->rid;}
    public function getName(): string {return $this->name;}
    public function getIsUnavailable(): boolval {return $this->isUnavailable;}
    public function getIsStockroom(): boolval {return $this->isStockroom;}
    public function getLoId(): ?int {return $this->loid;}

    public function setLoId(int $loid) {
        $this->loid = $loid;
    }

    public function setRId(int $rid) {
        $this->rid = $rid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>