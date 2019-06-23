<?php

require_once("Model.php");

class Favorite extends Model implements JsonSerializable{
    private $id;
    private $serviceId;
    private $userId;
    private $status;

    public function __construct($fields){
        if($fields == null){
            throw new Exception('Favorite data missing', 400);
        }
        $this->serviceId = $fields['serviceId'];
        $this->userId = $fields['userId'];
        $this->status = $fields['status'];
        $this->id = isset($fields['f_id'])?$fields['f_id']:NULL;
    }

    public function getServiceId() {
        return $this->serviceId;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getStatus() {
        return $this->status;
    }
    public function getId(){
        return $this->id;
    }

    public function setServiceId($serid){
        $this->cid = $serid;
    }
    public function setUserId($uid){
        $this->cid = $uid;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function setId($id){
        $this->id = $id;
    }


    public function getMainId()
    {
        return $this->getServiceId();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }

}



?>