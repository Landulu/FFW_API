<?php

require_once("Model.php");

class Comment extends Model implements JsonSerializable{
    private $cid;
    private $content;
    private $serviceId;
    private $userId;
    private $status;

    public function __construct($fields){
        if($fields == null){
            throw new Exception('Comment data missing', 400);
        }
        $this->cid = isset($fields['cid']) ? $fields['cid'] : NULL;
        $this->content = $fields['content'];
        $this->serviceId = $fields['serviceId'];
        $this->userId = $fields['userId'];
        $this->status = $fields['status'];
    }

    public function getCid() {
        return $this->cid;
    }
    public function getContent() {
        return $this->content;
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


    public function setCid($id){
        $this->cid = $id;
    }
    public function setContent($c){
        $this->cid = $c;
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

    public function getMainId()
    {
        return $this->getCid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }

    public function __toString(){
        return $this->content.' '.$this->serviceId.' '.$this->userId.' '.$this->status;
    }


}



?>
