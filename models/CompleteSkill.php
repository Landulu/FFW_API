<?php

class CompleteSkill implements JsonSerializable {
    private $skid;
    private $name;
    private $status;

    public function __construct(array $fields) {
        $this->skid = isset($fields['skid']) ? $fields['skid'] : NULL;
        $this->name = isset($fields['name'])? $fields['name'] : NULL;
        $this->status = isset($fields['status']) ? $fields['status']:NULL;
    }

    public function getSkId(): int { return $this->skid;}
    public function getName(): string { return $this->name;}

    /**
     * @return mixed|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed|null $status
     */
    public function setStatus( $status): void
    {
        $this->status = $status;
    }


    public function setSkId(int $skid) {
        $this->skid = $skid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}