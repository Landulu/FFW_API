<?php
require_once ("Model.php");

class Scanner extends Model implements JsonSerializable {
    private $scid;
    private $version;
    private $buildDate;
    private $emitDate;
    private $state;

    public function __construct(array $fields) {
        $this->scid = isset($fields['scid']) ? $fields['scid'] : NULL;
        $this->version = $fields['version'];
        $this->buildDate = $fields['buildDate'];
        $this->emitDate = $fields['emitDate'];
        $this->state = $fields['state'];
    }

    /**
     * @return mixed|null
     */
    public function getScid()
    {
        return $this->scid;
    }

    /**
     * @param mixed|null $scid
     */
    public function setScid($scid): void
    {
        $this->scid = $scid;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version): void
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getBuildDate()
    {
        return $this->buildDate;
    }

    /**
     * @param mixed $buildDate
     */
    public function setBuildDate($buildDate): void
    {
        $this->buildDate = $buildDate;
    }

    /**
     * @return mixed
     */
    public function getEmitDate()
    {
        return $this->emitDate;
    }

    /**
     * @param mixed $emitDate
     */
    public function setEmitDate($emitDate): void
    {
        $this->emitDate = $emitDate;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    public function getMainId()
    {
        $this->getScid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>