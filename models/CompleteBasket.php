<?php
require_once ("Model.php");

class CompleteBasket  extends Model implements JsonSerializable {

    private $bid;
    private $createTime;
    private $status;
    private $role;
    private $order;
    private $serviceId;
    private $companyId;
    private $externalId;
    private $userId;
    private $service;
    private $company;
    private $external;
    private $user;
    private $address;

    public function __construct(array $fields) {
        $this->bid = isset($fields['bid']) ? $fields['bid'] : NULL;
        $this->createTime = isset($fields['createTime'])? $fields['createTime'] : NULL;
        $this->status = isset($fields['status'])? $fields['status'] : NULL;
        $this->role = isset($fields['role'])? $fields['role'] : NULL;  // inport or export or transfert
        $this->order = isset($fields['order'])? $fields['order'] : NULL;
        $this->serviceId = isset($fields['serviceId']) ? $fields['serviceId'] : NULL;
        $this->companyId = isset($fields['companyId']) ? $fields['companyId'] : NULL;
        $this->externalId = isset($fields['externalId']) ? $fields['externalId'] : NULL;
        $this->userId = isset($fields['userId']) ? $fields['userId'] : NULL;
        $this->service =  isset($fields["service"]) ? $fields["service"] : NULL;
        $this->company = isset($fields["company"]) ? $fields["company"] : NULL;
        $this->external = isset($fields["external"]) ? $fields["external"] : NULL;
        $this->user = isset($fields["user"]) ? $fields["user"] : NULL;
        $this->products = isset($fields["baskets"] )? $fields["baskets"] : NULL;
        $this->address = isset($fields["baskets"] )? $fields["baskets"] : NULL;
    }

    /**
     * @return mixed|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed|null $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }


    /**
     * @return mixed|null
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed|null $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
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

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service): void
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company): void
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getExternal()
    {
        return $this->external;
    }

    /**
     * @param mixed $external
     */
    public function setExternal($external): void
    {
        $this->external = $external;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getMainId()
    {
        return $this->getBid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>