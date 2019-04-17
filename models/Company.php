<?php

class Company implements JsonSerializable {
    private $coid;
    private $siret;
    private $status;
    private $name;
    private $tel;
    private $addressId;
    private $userId;

    public function __construct(array $fields) {
        $this->coid = isset($fields['coid']) ? $fields['coid'] : NULL;
        $this->siret = $fields['siret'];
        $this->status = $fields['status'];
        $this->name = $fields['name'];
        $this->name = $fields['tel'];
        $this->addressId = $fields['addressId'];
        $this->userId = $fields['userId'];
    }

    public function getCoId(): ?int {return $this->coid;}
    public function getSiret(): string {return $this->siret;}
    public function getStatus(): string {return $this->status;}
    public function getName(): string {return $this->name;}
    public function getTel(): string {return $this->tel;}
    public function getAddressId(): string {return $this->addressId;}
    public function getUserId(): string {return $this->userId;}

    public function setCoId(int $coid) {
        $this->coid = $coid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>