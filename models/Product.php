<?php
require_once ("Model.php");

class Product extends Model implements JsonSerializable {

    private $prid;
    private $limitDate;
    private $state;
    private $quantityUnit;
    private $weightQuantity;
    private $articleId;
    private $basketId;
    private $roomId;

    public function __construct(array $fields) {
        $this->prid = isset($fields['prid']) ? $fields['prid'] : NULL;
        $this->limitDate = isset($fields['limitDate']) ? $fields['limitDate'] : null;
        $this->state = isset($fields['state'])? $fields['state'] : 'GOOD';
        $this->quantityUnit = isset($fields['quantityUnit'])? $fields['quantityUnit'] : null;
        $this->weightQuantity = isset($fields['weightQuantity']) ? $fields['weightQuantity'] : null;
        $this->articleId = $fields['articleId'];
        $this->basketId = isset($fields['basketId'])? $fields['basketId'] : NULL;
        $this->roomId = isset($fields['roomId'])? $fields['roomId'] : NULL;
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
     * @return mixed|null
     */
    public function getLimitDate()
    {
        return $this->limitDate;
    }

    /**
     * @param mixed|null $limitDate
     */
    public function setLimitDate($limitDate): void
    {
        $this->limitDate = $limitDate;
    }

    /**
     * @return mixed|string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed|string $state
     */
    public function setState($state): void
    {
        $this->state = $state;
    }

    /**
     * @return mixed|null
     */
    public function getQuantityUnit()
    {
        return $this->quantityUnit;
    }

    /**
     * @param mixed|null $quantityUnit
     */
    public function setQuantityUnit($quantityUnit): void
    {
        $this->quantityUnit = $quantityUnit;
    }

    /**
     * @return mixed|null
     */
    public function getWeightQuantity()
    {
        return $this->weightQuantity;
    }

    /**
     * @param mixed|null $weightQuantity
     */
    public function setWeightQuantity($weightQuantity): void
    {
        $this->weightQuantity = $weightQuantity;
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
     * @return mixed|null
     */
    public function getBasketId()
    {
        return $this->basketId;
    }

    /**
     * @param mixed|null $basketId
     */
    public function setBasketId($basketId): void
    {
        $this->basketId = $basketId;
    }

    /**
     * @return mixed|null
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param mixed|null $roomId
     */
    public function setRoomId($roomId): void
    {
        $this->roomId = $roomId;
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