<?php

require_once ("Model.php");

class Article extends Model implements JsonSerializable {
    private $aid;
    private $name;
    private $ingredientId;

    public function __construct(array $fields) {
        $this->aid = isset($fields['aid']) ? $fields['aid'] : NULL;
        $this->name = $fields['name'];
        $this->ingredientId = $fields['ingredientId'];
    }

    /**
     * @return mixed|null
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * @param mixed|null $aid
     */
    public function setAid($aid): void
    {
        $this->aid = $aid;
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
     * @return mixed
     */
    public function getIngredientId()
    {
        return $this->ingredientId;
    }

    /**
     * @param mixed $ingredientId
     */
    public function setIngredientId($ingredientId): void
    {
        $this->ingredientId = $ingredientId;
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