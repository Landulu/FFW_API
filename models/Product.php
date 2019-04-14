<?php

class Product implements JsonSerializable {

    private $prid;
    private $limitDate;
    private $state;
    private $articleId;
    private $basketId;
    private $roomId;

    public function __construct(array $fields) {
        $this->prid = isset($fields['prid']) ? $fields['prid'] : NULL;
        $this->limitDate = $fields['limitDate'];
        $this->state = $fields['state'];
        $this->articleId = $fields['articleId'];
        $this->basketId = $fields['basketId'];
        $this->roomId = $fields['roomId'];
    }

    public function getAid(): int { return $this->prid;}
    public function getLimitDate(): string { return $this->limitDate;}
    public function getState(): string { return $this->state;}
    public function getArticleId(): int { return $this->articleId;}
    public function getBasketId(): int { return $this->basketId;}
    public function getRoomId(): int { return $this->roomId;}


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