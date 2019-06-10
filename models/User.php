<?php

class User implements JsonSerializable {
    private $uid;
    private $email;
    private $tel;
    private $password;
    private $firstname;
    private $lastname;
    private $status;
    private $rights;
    private $lastSubscription;
    private $endSubscription;
    private $lastEdit;
    private $companyName;
    private $addressId;

    public function __construct(array $fields) {
        $this->uid = isset($fields['uid']) ? $fields['uid'] : NULL;
        $this->email = $fields['email'];
        $this->tel = isset($fields['tel']) ? $fields['tel'] : NULL;
        $this->password = $fields['password'];
        $this->firstname = $fields['firstname'];
        $this->lastname = $fields['lastname'];
        $this->status = isset($fields['status']) ? $fields['status'] : NULL;
        $this->rights = isset($fields['rights']) ? $fields['rights'] : NULL;
        $this->lastSubcription = isset($fields['lastSubscription']) ? $fields['lastSubscription'] : NULL;
        $this->endSubscription = isset($fields['endSubscription']) ? $fields['endSubscription'] : NULL;
        $this->lastEdit = isset($fields['lastEdit']) ? $fields['lastEdit'] : NULL;
        $this->companyName = isset($fields['companyName']) ? $fields['companyName'] : NULL;
        $this->addressId = isset($fields['addressId']) ? $fields['addressId'] : NULL;
    }

    public function getUid(): ?int {return $this->uid;}
    public function getEmail(): string {return $this->email;}
    public function getTel(): ?string {return $this->tel;}
    public function getPassword(): string {return $this->password;}
    public function getFirstname(): string {return $this->firstname;}
    public function getLastname(): string {return $this->lastname;}
    public function getStatus(): ?string {return $this->status;}
    public function getRights(): ?int {return $this->rights;}
    public function getLastSubscription(): ?string {return $this->lastSubscription;}
    public function getEndSubscription(): ?string {return $this->endSubscription;}
    public function getLastEdit(): ?string {return $this->lastEdit;}
    public function getCompanyName(): ?string {return $this->companyName;}
    public function getAddressId(): ?int {return $this->addressId;}

    public function setUId(int $uid) {
        $this->uid = $uid;
    }
    public function setEmail(string $email) {
        $this->email = $email;
    }
    public function setTel(string $tel) {
        $this->tel = $tel;
    }
    public function setPassword(string $password) {
        $this->password = $password;
    }
    public function setFirstName(string $firstname) {
        $this->firstname = $firstname;
    }
    public function setLastname(string $lastname) {
        $this->lastname = $lastname;
    }
    public function setLastSubscription(string $lastSubscription) {
        $this->lastSubscription = $lastSubscription;
    }
    public function setEndSubscription(string $endSubscription) {
        $this->endSubscription = $endSubscription;
    }
    public function setLastEdit(string $lastEdit) {
        $this->lastEdit = $lastEdit;
    }
    public function setCompanyName(string $companyName) {
        $this->companyName = $companyName;
    }
    public function setAddressId(int $addressId) {
        $this->addressId = $addressId;
    }
    public function setStatus(int $status) {
        $this->status = $status;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}



?>