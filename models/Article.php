<?php
require_once ("Model.php");

class Article extends Model implements JsonSerializable {
    private $aid;
    private $name;
    private $category;

    public function __construct(array $fields) {
        $this->aid = isset($fields['aid']) ? $fields['aid'] : NULL;
        $this->name = $fields['name'];
        $this->category = $fields['category'];
    }

    public function getAid():? int { return $this->aid;}
    public function getName(): string { return $this->name;}
    public function getCategory(): string { return $this->category;}


    public function setAId(int $aid) {
        $this->aid = $aid;
    }

    public function getMainId()
    {
        return $this->getAid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>