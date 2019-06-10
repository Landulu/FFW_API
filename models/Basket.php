<?php

class Basket implements JsonSerializable {

    private $bid;
    private $createTime;
    private $status;
    private $role;
    private $order;
    private $serviceId;
    private $companyId;
    private $externalId;
    private $userId;

    public function __construct(array $fields) {
        $this->bid = isset($fields['bid']) ? $fields['bid'] : NULL;
        $this->createTime = isset($fields['createTime'])?$fields['createTime'] : NULL;
        $this->status = isset($fields['status'])?$fields['status'] : NULL;
        $this->role = isset($fields['role'])?$fields['role'] : NULL;  // in or out or trans
        $this->order = isset($fields['order'])?$fields['order'] : NULL;  // in or out or trans
        $this->serviceId = isset($fields['serviceId']) ? $fields['serviceId'] : NULL;
        $this->companyId = isset($fields['companyId']) ? $fields['companyId'] : NULL;
        $this->externalId = isset($fields['externalId']) ? $fields['externalId'] : NULL;
        $this->userId = isset($fields['userId']) ? $fields['userId'] : NULL;
    }

    /**
     * @return mixed|null
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * @param mixed|null $bid
     */
    public function setBid($bid): void
    {
        $this->bid = $bid;
    }

    /**
     * @return mixed|null
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param mixed|null $createTime
     */
    public function setCreateTime($createTime): void
    {
        $this->createTime = $createTime;
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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed|null $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed|null $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

    /**
     * @return mixed|null
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param mixed|null $serviceId
     */
    public function setServiceId($serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    /**
     * @return mixed|null
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param mixed|null $companyId
     */
    public function setCompanyId($companyId): void
    {
        $this->companyId = $companyId;
    }

    /**
     * @return mixed|null
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param mixed|null $externalId
     */
    public function setExternalId($externalId): void
    {
        $this->externalId = $externalId;
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



    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>