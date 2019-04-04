<?php

class Address implements JsonSerializable {
    private $adid;
    private $streetAddress;
    private $cityName;
    private $cityCode;
    private $country;

    public function __construct(array $fields) {
        $this->adid = isset($fields['adid']) ? $fields['adid'] : NULL;
        $this->streetAddress = $fields['streetAddress'];
        $this->cityName = $fields['cityName'];
        $this->cityCode = $fields['cityCode'];
        $this->country = $fields['country'];
    }

    public function getAdId(): ?int {return $this->adid;}
    public function getStreetAddress(): string {return $this->streetAddress;}
    public function getCityName(): string {return $this->cityName;}
    public function getCityCode(): string {return $this->cityCode;}
    public function getCountry(): string {return $this->country;}

    public function setAdId(int $adid) {
        $this->adid = $adid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>