<?php

class Scanner implements JsonSerializable {
    private $scid;
    private $version;
    private $buildDate;
    private $emitDate;
    private $state;

    public function __construct(array $fields) {
        $this->scid = isset($fields['scid']) ? $fields['scid'] : NULL;
        $this->version = $fields['version'];
        $this->buildDate = $fields['buildDate'];
        $this->emitDate = $fields['emitDate'];
        $this->state = $fields['state'];
    }

    public function getScId(): ?int {return $this->scid;}
    public function getVersion(): string {return $this->version;}
    public function getBuildDate(): string {return $this->buildDate;}
    public function getEmitDate(): string {return $this->emitDate;}
    public function getState(): string {return $this->state;}

    public function setScId(int $scid) {
        $this->scid = $scid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>