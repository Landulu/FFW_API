<?php
require_once ("Model.php");


class CompleteAffectation extends Model implements  JsonSerializable {

    private $affid;
    private $role;
    private $start;
    private $end;
    private $uid;
    private $serid;
    private $skid;
    private $service;

    /**
     * Affectation constructor.
     * @param $fields
     */
    public function __construct($fields)
    {
        $this->affid = isset($fields['affid'])?$fields['affid']:NULL;
        $this->role = isset($fields['role'])?$fields['role']:NULL;
        $this->start = isset($fields['start'])?$fields['start']:NULL;
        $this->end = isset($fields['end'])?$fields['end']:NULL;
        $this->uid = isset($fields['uid'])?$fields['uid']:NULL;
        $this->serid = isset($fields['serid'])?$fields['serid']:NULL;
        $this->skid = isset($fields['skid'])?$fields['skid']:NULL;
        $this->service = isset($fields['service'])?$fields['service']:NULL;
    }

    /**
     * @return mixed
     */
    public function getAffid()
    {
        return $this->affid;
    }

    /**
     * @param mixed $affid
     */
    public function setAffid($affid): void
    {
        $this->affid = $affid;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end): void
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getSerid()
    {
        return $this->serid;
    }

    /**
     * @param mixed $serid
     */
    public function setSerid($serid): void
    {
        $this->serid = $serid;
    }

    /**
     * @return mixed
     */
    public function getSkid()
    {
        return $this->skid;
    }

    /**
     * @param mixed $skid
     */
    public function setSkid($skid): void
    {
        $this->skid = $skid;
    }

    /**
     * @return mixed|null
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed|null $service
     */
    public function setService( $service): void
    {
        $this->service = $service;
    }

    public function getMainId()
    {
        return $this->getAffid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }

}