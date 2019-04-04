<?php

class Vehicle implements JsonSerializable {
    private $vid;
    private $volume;
    private $insuranceDate;
    private $lastRevision;
    private $description;

    public function __construct(array $fields){
        $this->vid = isset($fields['vid']) ? $fields['vid'] : null;
        $this->volume = $fields['volume'];
        $this->insuranceDate = $fields['insuranceDate'];
        $this->lastRevision = $fields['lastRevision'];
        $this->description = $fields['description'];
    }

    public function getVId(): ?int {return $this->vid;}

    public function getVolume() : int{return $this->volume;}

    public function getInsuranceDate() : string{return $this->insuranceDate;}

    public function getLastRevision() : string {return $this->lastRevision;}

    public function getDescription() : string{ return $this->description;}

    public function setVId(int $vid){$this->vid = $vid;}



    public function JsonSerialize() {
        return get_object_vars($this);
    }

}



?>