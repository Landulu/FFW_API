<?php

class Article implements JsonSerializable {
    private $aid;
    private $name;
    private $category;
    private $limitDate;
    private $suggestedDate;

    public function __construct(array $fields) {
        $this->aid = isset($fields['aid']) ? $fields['aid'] : NULL;
        $this->name = $fields['name'];
        $this->category = $fields['category'];
        $this->limitDate = $fields['limitDate'];
        $this->suggestedDate = $fields['suggestedDate'];
    }

    public function getAid(): int { return $this->aid;}
    public function getName(): string { return $this->name;}
    public function getCategory(): string { return $this->category;}
    public function getLimitDate(): string { return $this->limitDate;}
    public function getSuggestedDate(): string { return $this->suggestedDate;}


    public function setAId(int $aid) {
        $this->aid = $aid;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>