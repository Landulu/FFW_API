<?php

class Skill implements JsonSerializable {
    private $skid;
    private $name;

    public function __construct(array $fields) {
        $this->skid = isset($fields['skid']) ? $fields['skid'] : NULL;
        $this->name = $fields['name'];
    }

    public function getSkId(): int { return $this->skid;}
    public function getName(): string { return $this->name;}


    public function setSkId(int $skid) {
        $this->skid = $skid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>