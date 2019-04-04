<?php

class Local implements JsonSerializable {
    private $loid;
    private $name;
    private $adid;

    public function __construct(array $fields) {
        $this->loid = isset($fields['loid']) ? $fields['loid'] : NULL;
        $this->name = $fields['name'];
        $this->adid = isset($fields['adid']) ? $fields['adid'] : NULL;
    }

    public function getLoId(): ?int {return $this->loid;}
    public function getName(): string {return $this->name;}
    public function getAdId(): ?int {return $this->adid;}

    public function setLoId(int $loid) {
        $this->loid = $loid;
    }

    public function setAdId(int $adid) {
        $this->adid = $adid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>