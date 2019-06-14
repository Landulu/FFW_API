<?php
require_once ("Model.php");

class Company extends Model implements JsonSerializable {
    private $coid;
    private $siret;
    private $status;
    private $name;
    private $tel;
    private $addressId;
    private $userId;

    public function __construct(array $fields) {
        $this->coid = isset($fields['coid']) ? $fields['coid'] : NULL;
        $this->siret = isset($fields['siret']) ? $fields['siret']: NULL;
        $this->status = isset($fields['status']) ? $fields['status'] : NULL;
        $this->name = isset($fields['name']) ? $fields['name'] : NULL;
        $this->tel = isset($fields['tel']) ? $fields['tel'] : NULL;
        $this->addressId = isset($fields['addressId'] ) ? $fields['addressId'] : NULL;
        $this->userId = isset($fields['userId']) ? $fields['userId'] : NULL;
    }

    public function getCoId(): ?int {return $this->coid;}
    public function getSiret(): string {return $this->siret;}
    public function getStatus(): string {return $this->status;}
    public function getName(): string {return $this->name;}
    public function getTel():? string {return $this->tel;}
    public function getAddressId(): string {return $this->addressId;}
    public function getUserId(): string {return $this->userId;}

    public function setCoId(int $coid) {
        $this->coid = $coid;
    }

    /**
     * @param mixed|null $addressId
     */
    public function setAddressId(?mixed $addressId): void
    {
        $this->addressId = $addressId;
    }

    public function getMainId()
    {
        return $this->getCoId();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>