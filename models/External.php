<?php
require_once ("Model.php");

class External extends Model  implements JsonSerializable {

    private $exid;
    private $name;
    private $tel;
    private $mail;
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
        $this->mail = isset($fields['mail'])? $fields['mail'] : null;
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
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
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

