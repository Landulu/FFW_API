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

    /**
     * @return mixed|null
     */
    public function getCoid()
    {
        return $this->coid;
    }

    /**
     * @param mixed|null $coid
     */
    public function setCoid($coid): void
    {
        $this->coid = $coid;
    }

    /**
     * @return mixed|null
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param mixed|null $siret
     */
    public function setSiret($siret): void
    {
        $this->siret = $siret;
    }

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
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed|null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed|null
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed|null $tel
     */
    public function setTel($tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed|null
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @param mixed|null $addressId
     */
    public function setAddressId($addressId): void
    {
        $this->addressId = $addressId;
    }

    /**
     * @return mixed|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed|null $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
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