<?php

class Skill implements JsonSerializable {
    private $skid;
    private $name;
    private $skStatus;

    public function __construct(array $fields) {
        $this->skid = isset($fields['skid']) ? $fields['skid'] : NULL;
        $this->name = isset($fields['name']) ? $fields['name'] :NULL;
        $this->skStatus = isset($fields['skStatus']) ? $fields['skStatus'] :NULL;
    }

    public function getSkId(): int { return $this->skid;}
    public function getName(): string { return $this->name;}

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



    public function setSkId(int $skid) {
        $this->skid = $skid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>