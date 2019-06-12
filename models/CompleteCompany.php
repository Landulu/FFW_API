<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 26/05/19
 * Time: 22:48
 */
require_once ("Model.php");

class CompleteCompany extends Model implements JsonSerializable {
    private $coid;
    private $siret;
    private $status;
    private $name;
    private $tel;
    private $userId;
    private $address;

    public function __construct(array $fields) {
        $this->coid = isset($fields['coid']) ? $fields['coid'] : NULL;
        $this->siret = isset($fields['siret']) ? $fields['siret']: NULL;
        $this->status = isset($fields['status']) ? $fields['status'] : NULL;
        $this->name = isset($fields['name']) ? $fields['name'] : NULL;
        $this->tel = isset($fields['tel']) ? $fields['tel'] : NULL;
        $this->userId = isset($fields['userId']) ? $fields['userId'] : NULL;
        $this->address = isset($fields['address']) ? $fields['address'] : NULL;
    }

    /**
     * @return mixed|null
     */
    public function getCoid(): ?mixed
    {
        return $this->coid;
    }

    /**
     * @param mixed|null $coid
     */
    public function setCoid(?mixed $coid): void
    {
        $this->coid = $coid;
    }

    /**
     * @return mixed|null
     */
    public function getSiret(): ?mixed
    {
        return $this->siret;
    }

    /**
     * @param mixed|null $siret
     */
    public function setSiret(?mixed $siret): void
    {
        $this->siret = $siret;
    }

    /**
     * @return mixed|null
     */
    public function getStatus(): ?mixed
    {
        return $this->status;
    }

    /**
     * @param mixed|null $status
     */
    public function setStatus(?mixed $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed|null
     */
    public function getName(): ?mixed
    {
        return $this->name;
    }

    /**
     * @param mixed|null $name
     */
    public function setName(?mixed $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed|null
     */
    public function getTel(): ?mixed
    {
        return $this->tel;
    }

    /**
     * @param mixed|null $tel
     */
    public function setTel(?mixed $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed|null
     */
    public function getUserId(): ?mixed
    {
        return $this->userId;
    }

    /**
     * @param mixed|null $userId
     */
    public function setUserId(?mixed $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed|null
     */
    public function getAddress(): ?mixed
    {
        return $this->address;
    }

    /**
     * @param mixed|null $address
     */
    public function setAddress(?mixed $address): void
    {
        $this->address = $address;
    }

    public function getMainId()
    {
        return $this->getCoid();
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

}