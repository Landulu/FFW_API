<?php

class Product implements JsonSerializable {

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
        $this->state = isset($fields['quantityUnit'])? $fields['quantityUnit'] : null;
        $this->state = isset($fields['weightQuantity']) ? $fields['weightQuantity'] : null;
        $this->articleId = $fields['articleId'];
        $this->basketId = isset($fields['basketId'])? $fields['basketId'] : NULL;
        $this->roomId = isset($fields['roomId'])? $fields['roomId'] : NULL;
    }

    public function getPrid(): ?int { return $this->prid;}
    public function getLimitDate(): ?string { return $this->limitDate;}
    public function getState(): ?string { return $this->state;}
    public function getArticleId(): string { return $this->articleId;}
    public function getBasketId(): ?int { return $this->basketId;}
    public function getRoomId(): ?int { return $this->roomId;}

    /**
     * @return mixed
     */
    public function getQuantityUnit()
    {
        return $this->quantityUnit;
    }

    /**
     * @param mixed $quantityUnit
     */
    public function setQuantityUnit($quantityUnit): void
    {
        $this->quantityUnit = $quantityUnit;
    }

    /**
     * @return mixed
     */
    public function getWeightQuantity()
    {
        return $this->weightQuantity;
    }

    /**
     * @param mixed $weightQuantity
     */
    public function setWeightQuantity($weightQuantity): void
    {
        $this->weightQuantity = $weightQuantity;
    }


    public function setPrId(int $prid) {
        $this->prid = $prid;
    }

    public function setLimitDate(string $limitDate) {
        $this->limitDate = $limitDate;
    }

    public function setState(string $state) {
        $this->state = $state;
    }


    public function setArticleId(int $articleId) {
        $this->articleId = $articleId;
    }

    public function setBasketId(int $basketId) {
        $this->basketId = $basketId;
    }
    public function setRoomId(int $roomId) {
        $this->roomId = $roomId;
    }

    public function JsonSerialize() {
        return get_object_vars($this);
    }
}


?>