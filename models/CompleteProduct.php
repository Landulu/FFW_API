<?php
require_once ("Model.php");

class CompleteProduct extends Model implements JsonSerializable {

    private $prid;
    private $limitDate;
    private $state;
    private $articleId;
    private $basketId;
    private $roomId;
    private $articleName;
    private $articleCategory;

    public function __construct(array $fields) {
        $this->prid = isset($fields['prid']) ? $fields['prid'] : NULL;
        $this->limitDate = $fields['limitDate'];
        $this->state = $fields['state'];
        $this->articleId = $fields['articleId'];
        $this->basketId = $fields['basketId'];
        $this->roomId = $fields['roomId'];
        $this->articleName = $fields['articleName'];
        $this->articleCategory = $fields['articleCategory'];
    }

    /**
     * @return mixed|null
     */
    public function getPrid()
    {
        return $this->prid;
    }

    /**
     * @param mixed|null $prid
     */
    public function setPrid($prid): void
    {
        $this->prid = $prid;
    }

    /**
     * @return mixed
     */
    public function getLimitDate()
    {
        return $this->limitDate;
    }

    /**
     * @param mixed $limitDate
     */
    public function setLimitDate($limitDate): void
    {
        $this->limitDate = $limitDate;
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

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param mixed $articleId
     */
    public function setArticleId($articleId): void
    {
        $this->articleId = $articleId;
    }

    /**
     * @return mixed
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @param mixed $basketId
     */
    public function setBasketId($basketId): void
    {
        $this->basketId = $basketId;
    }

    /**
     * @return mixed
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param mixed $roomId
     */
    public function setRoomId($roomId): void
    {
        $this->roomId = $roomId;
    }

    /**
     * @return mixed
     */
    public function getArticleName()
    {
        return $this->articleName;
    }

    /**
     * @param mixed $articleName
     */
    public function setArticleName($articleName): void
    {
        $this->articleName = $articleName;
    }

    /**
     * @return mixed
     */
    public function getArticleCategory()
    {
        return $this->articleCategory;
    }

    /**
     * @param mixed $articleCategory
     */
    public function setArticleCategory($articleCategory): void
    {
        $this->articleCategory = $articleCategory;
    }

    public function getMainId()
    {
        return $this->getPrid();
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>