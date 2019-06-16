<?php
require_once ("Model.php");

class CompleteExternal extends Model implements JsonSerializable {

    private $exid;
    private $name;
    private $tel;
    private $email;
    private $addressId;
    private $address;

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
        $this->addressId = isset($fields["addressId"]) ? $fields['addressId']: null;
        $this->address = isset($fields['address']) ? $fields["address"] : null;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
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

