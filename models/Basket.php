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

    public function getBId() {return $this->bid;}
    public function getServiceId() {return $this->serviceId;}
    public function getCompanyId() {return $this->companyId;}
    public function getExternalId() {return $this->externalId;}
    public function getUserId() {return $this->userId;}
    public function getCreateTime() {return $this->createTime;}
    public function getRole() {return $this->role;}

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
    public function setOrder( $order): void
    {
        $this->order = $order;
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