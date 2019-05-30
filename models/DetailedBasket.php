<?php

class DetailedBasket implements JsonSerializable {

    private $bid;
    private $createTime;
    private $status;
    private $role;
    private $order;
    private $serviceId;
    private $companyId;
    private $externalId;
    private $entityName;
    private $tel;
    private $addressId;
    private $addressZipCode;
    private $addressName;
    private $userId;

    public function __construct(array $fields) {
        $this->bid = isset($fields['bid']) ? $fields['bid'] : NULL;
        $this->createTime = isset($fields['createTime'])? $fields['createTime'] : NULL;
        $this->status = isset($fields['status'])? $fields['status'] : NULL;
        $this->role = isset($fields['role'])? $fields['role'] : NULL;  // inport or export or transfert
        $this->order = isset($fields['order'])? $fields['order'] : NULL;
        $this->serviceId = isset($fields['serviceId']) ? $fields['serviceId'] : NULL;
        $this->companyId = isset($fields['companyId']) ? $fields['companyId'] : NULL;
        $this->externalId = isset($fields['externalId']) ? $fields['externalId'] : NULL;
        $this->entityName = $fields['entityName'];
        $this->tel = isset($fields['tel']) ? $fields['tel'] : null;
        $this->addressId = $fields['addressId'];
        $this->addressZipCode = $fields['addressZipCode'];
        $this->addressName = $fields['addressName'];
        $this->userId = isset($fields['userId']) ? $fields['userId'] : NULL;
    }

    public function getBId() {return $this->bid;}
    public function getServiceId() {return $this->serviceId;}
    public function getCompanyId() {return $this->companyId;}
    public function getExternalId() {return $this->externalId;}
    public function getUserId() {return $this->userId;}

    /**
     * @return mixed|null
     */
    public function getTel(): ?mixed
    {
        return $this->tel;
    }

    /**
     * @param mixed|null $tel
     */
    public function setTel(?mixed $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @param mixed $addressId
     */
    public function setAddressId($addressId): void
    {
        $this->addressId = $addressId;
    }

    /**
     * @return mixed
     */
    public function getAddressZipCode()
    {
        return $this->addressZipCode;
    }

    /**
     * @param mixed $addressZipCode
     */
    public function setAddressZipCode($addressZipCode): void
    {
        $this->addressZipCode = $addressZipCode;
    }

    /**
     * @return mixed
     */
    public function getAddressName()
    {
        return $this->addressName;
    }

    /**
     * @param mixed $addressName
     */
    public function setAddressName($addressName): void
    {
        $this->addressName = $addressName;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param mixed $createTime
     */
    public function setCreateTime($createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed|null
     */
    public function getOrder(): ?mixed
    {
        return $this->order;
    }

    /**
     * @param mixed|null $order
     */
    public function setOrder(?mixed $order): void
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param mixed $entityName
     */
    public function setEntityName($entityName): void
    {
        $this->entityName = $entityName;
    }

    public function setBId($id) {
        $this->bid = $id;
    }
    public function setServiceId($id) {
        $this->serviceId = $id;
    }
    public function setCompanyId($id) {
        $this->companyId = $id;
    }
    public function setExternalId($id) {
        $this->externalId = $id;
    }
    public function setUserId($id) {
        $this->userId = $id;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>