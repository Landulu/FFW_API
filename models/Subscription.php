<?php

require_once ("Model.php");

class Subscription extends Model implements JsonSerializable{

    private $suid;
    private $uid;
    private $goal;
    private $startSuDate;
    private $endSuDate;
    private $isAccepted;


    /**
     * Affectation constructor.
     * @param $fields
     */
    public function __construct($fields)
    {
        $this->suid = isset($fields["suid"]) ? $fields["suid"] : null;
        $this->uid = isset($fields["uid"]) ? $fields["uid"] : null;
        $this->goal = isset($fields["goal"]) ? $fields["goal"] : null;
        $this->startSuDate = isset($fields["startSuDate"]) ? $fields["startSuDate"] : null;
        $this->endSuDate = isset($fields["endSuDate"]) ? $fields["endSuDate"] : null;
        $this->isAccepted = isset($fields["isAccepted"]) ? $fields["isAccepted"] : null;
    }

    /**
     * @return mixed
     */
    public function getSuid()
    {
        return $this->suid;
    }

    /**
     * @param mixed $suid
     */
    public function setSuid($suid): void
    {
        $this->suid = $suid;
    }

    /**
     * @return null
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param null $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * @param mixed $goal
     */
    public function setGoal($goal): void
    {
        $this->goal = $goal;
    }

    /**
     * @return mixed
     */
    public function getStartSuDate()
    {
        return $this->startSuDate;
    }

    /**
     * @param mixed $startSuDate
     */
    public function setStartSuDate($startSuDate): void
    {
        $this->startSuDate = $startSuDate;
    }

    /**
     * @return mixed
     */
    public function getEndSuDate()
    {
        return $this->endSuDate;
    }

    /**
     * @param mixed $endSuDate
     */
    public function setEndSuDate($endSuDate): void
    {
        $this->endSuDate = $endSuDate;
    }

    /**
     * @return mixed
     */
    public function getisAccepted()
    {
        return $this->isAccepted;
    }

    /**
     * @param mixed $isAccepted
     */
    public function setIsAccepted($isAccepted): void
    {
        $this->isAccepted = $isAccepted;
    }

    public function getMainId()
    {
        return $this->getSuid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }


}