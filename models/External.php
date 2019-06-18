<?php

require_once ("Model.php");

class External extends Model  implements JsonSerializable {

    private $exid;
    private $name;
    private $tel;
    private $email;
    private $addressId;

    /**
     * External constructor.
     * @param $fields
     */
    public function __construct(array $fields)
    {
        $this->exid = isset($fields['exid'])? $fields['exid'] : null;
        $this->name = isset($fields['name'])? $fields['name'] : null;
        $this->tel = isset($fields['tel'])? $fields['tel'] : null;
        $this->email = isset($fields['email'])? $fields['email'] : null;
        $this->addressId = $fields['addressId'];
    }


    /**
     * @return mixed
     */
    public function getExid()
    {
        return $this->exid;
    }

    /**
     * @param mixed $exid
     */
    public function setExid($exid)
    {
        $this->exid = $exid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setMail($email)
    {
        $this->email = $email;
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
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;
    }

    public function getMainId()
    {
        return $this->getExid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
    

}

