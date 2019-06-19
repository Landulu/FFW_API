<?php

require_once("Model.php");

class Favorite extends Model implements JsonSerializable{
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

    public function setServiceId($serid){
        $this->cid = $serid;
    }
    public function setUserId($uid){
        $this->cid = $uid;
    }
    public function setStatus($status){
        $this->status = $status;
    }

}



?>