<?php
require_once ("Model.php");

class CompleteArticle extends Model implements JsonSerializable {
    private $aid;
    private $name;
    private $ingredientId;
    private $ingredient;

    public function __construct(array $fields) {
        $this->aid = isset($fields['aid']) ? $fields['aid'] : NULL;
        $this->name = $fields['name'];
        $this->ingredientId = $fields['ingredientId'];
        $this->ingredient = $fields['ingredient'];
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

    /**
     * @return mixed
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * @param mixed $ingredient
     */
    public function setIngredient($ingredient): void
    {
        $this->ingredient = $ingredient;
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