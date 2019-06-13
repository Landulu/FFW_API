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
    private $products;
    private $local;
    private $srcAddress;
    private $dstAddress;

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
        $this->products = isset($fields["products"] )? $fields["products"] : NULL;
    }

    private function chooseAddressByRole(){

        if(!$this->role){
            return null;
        }

        $getObjMethodsArr=["getUser","getExternal","getCompany"];

        foreach($getObjMethodsArr as $getObjMethod){
            if($this->{$getObjMethod}()&&($address=$this->{$getObjMethod}()->getAddress())){
                break;
            }
        }
        if($this->role==="import"){
            $this->srcAddress=$address;
            $this->dstAddress=$this->getLocal() instanceof CompleteLocal ?$this->getLocal()->getAddress():null;
        }
        else if($this->role==="export"){
            $this->dstAddress=$address;
            $this->dstAddress=$this->getLocal() instanceof CompleteLocal ?$this->getLocal()->getAddress():null;

        }
    }

    /**
     * @return mixed
     */
    public function getSrcAddress()
    {
        return $this->srcAddress;
    }

    /**
     * @param mixed $srcAddress
     */
    public function setSrcAddress($srcAddress): void
    {
        $this->srcAddress = $srcAddress;
    }

    /**
     * @return mixed
     */
    public function getDstAddress()
    {
        return $this->dstAddress;
    }

    /**
     * @param mixed $dstAddress
     */
    public function setDstAddress($dstAddress): void
    {
        $this->dstAddress = $dstAddress;
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
    public function setProducts(array $products): void
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
    public function setService($service=null): void
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
    public function setCompany($company=null): void
    {
        $this->controlSet($company,"company");

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
    public function setExternal($external=null): void
    {
        $this->controlSet($external,"external");

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
    public function setUser($user=null): void
    {
        $this->controlSet($user,"user");
    }

    /**
     * @return mixed
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * @param mixed $local
     */
    public function setLocal($local=null ): void
    {
        $this->controlSet($local,"local");
    }

    private function controlSet($arg,$argName){


        $controlArgNameArr=["local","user","external","company"];

        foreach($controlArgNameArr as $controlArgName){
            if($controlArgName==$argName){
                if(is_array($arg)){
                    $arg=$arg[0];
                }

                $this->{$argName}=$arg;
                $this->chooseAddressByRole();
                break;
            }
        }
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