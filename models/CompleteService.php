<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 27/05/19
 * Time: 17:24
 */
require_once ("Model.php");

class CompleteService extends Model implements JsonSerializable{
    private $serid;
    private $name;
    private $description;
    private $createTime;
    private $type;
    private $capacity;
    private $isPublic;
    private $status;
    private $isPremium;
    private $serviceTime;
    private $routeState;
    private $vehicleId;
    private $localId;
    private $skills;
    private $affectations;
    private $comments;
    private $baskets;
    private $vehicle;


    public function __construct(array $fields) {
        $this->serid = isset($fields['serid']) ? $fields['serid'] : NULL;
        $this->name = isset($fields['name']) ? $fields['name'] : null;
        $this->description = isset($fields['description']) ? $fields['description'] : null;
        $this->createTime = isset($fields['createTime']) ? $fields['createTime'] : null;
        $this->type = isset($fields['type']) ? $fields['type'] : null;
        $this->capacity = isset($fields['capacity']) ? $fields['capacity'] : null;
        $this->isPublic = isset($fields['isPublic']) ? $fields['isPublic'] : null;
        $this->status = isset($fields['status']) ? $fields['status'] : null;
        $this->isPremium = isset($fields['isPremium']) ? $fields['isPremium'] : null;
        $this->serviceTime = isset($fields['serviceTime']) ? $fields['serviceTime'] : null;
        $this->routeState = isset($fields['routeState']) ? $fields['routeState']: null;
        $this->vehicleId = isset($fields['vehicleId']) ? $fields['vehicleId'] : null;
        $this->localId = isset($fields['localId']) ? $fields['localId'] : null;
        $this->skills = isset($fields["skills"]) ? $fields["skills"] : null ;
        $this->affectations = isset($fields["affectations"]) ? $fields["affectations"] : null ;
        $this->comments = isset($fields["comments"]) ? $fields["comments"] : null ;
        $this->baskets = isset($fields["baskets"]) ? $fields["baskets"] : null ;
        $this->vehicle = isset($fields["vehicle"]) ? $fields["vehicle"] : null ;
    }

    /**
     * @return mixed|null
     */
    public function getSerid()
    {
        return $this->serid;
    }

    /**
     * @param mixed|null $serid
     */
    public function setSerid($serid): void
    {
        $this->serid = $serid;
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed|null $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param mixed $createTime
     */
    public function setCreateTime($createTime): void
    {
        $this->createTime = $createTime;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed|null
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed|null $capacity
     */
    public function setCapacity($capacity): void
    {
        $this->capacity = $capacity;
    }

    /**
     * @return mixed|null
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param mixed|null $isPublic
     */
    public function setIsPublic($isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed|null
     */
    public function getisPremium()
    {
        return $this->isPremium;
    }

    /**
     * @param mixed|null $isPremium
     */
    public function setIsPremium($isPremium): void
    {
        $this->isPremium = $isPremium;
    }

    /**
     * @return mixed|null
     */
    public function getServiceTime()
    {
        return $this->serviceTime;
    }

    /**
     * @param mixed|null $serviceTime
     */
    public function setServiceTime($serviceTime): void
    {
        $this->serviceTime = $serviceTime;
    }

    /**
     * @return mixed|null
     */
    public function getRouteState()
    {
        return $this->routeState;
    }

    /**
     * @param mixed|null $routeState
     */
    public function setRouteState($routeState): void
    {
        $this->routeState = $routeState;
    }

    /**
     * @return mixed|null
     */
    public function getVehicleId()
    {
        return $this->vehicleId;
    }

    /**
     * @param mixed|null $vehicleId
     */
    public function setVehicleId($vehicleId): void
    {
        $this->vehicleId = $vehicleId;
    }

    /**
     * @return mixed|null
     */
    public function getLocalId()
    {
        return $this->localId;
    }

    /**
     * @param mixed|null $localId
     */
    public function setLocalId($localId): void
    {
        $this->localId = $localId;
    }

    /**
     * @return mixed|null
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed|null $skills
     */
    public function setSkills($skills): void
    {
        $this->skills = $skills;
    }

    /**
     * @return mixed|null
     */
    public function getAffectations()
    {
        return $this->affectations;
    }

    /**
     * @param mixed|null $affectations
     */
    public function setAffectations($affectations): void
    {
        $this->affectations = $affectations;
    }

    /**
     * @return mixed|null
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed|null $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed|null
     */
    public function getBaskets()
    {
        return $this->baskets;
    }

    /**
     * @param mixed|null $baskets
     */
    public function setBaskets($baskets): void
    {
        $this->baskets = $baskets;
    }

    /**
     * @return mixed|null
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param mixed|null $vehicle
     */
    public function setVehicle($vehicle): void
    {
        $this->vehicle = $vehicle;
    }



    public function getMainId()
    {
        return $this->getSerid();
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}