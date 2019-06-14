<?php
require_once ("Model.php");

class CompleteProduct extends Model implements JsonSerializable {

    private $prid;
    private $limitDate;
    private $state;
    private $articleId;
    private $basketId;
    private $roomId;
    private $article;

    public function __construct(array $fields) {
        $this->prid = isset($fields['prid']) ? $fields['prid'] : NULL;
        $this->limitDate = isset($fields['limitDate']) ? $fields['limitDate'] : NULL;
        $this->state = isset($fields['state']) ? $fields['state'] : NULL;
        $this->articleId = isset($fields['articleId']) ? $fields['articleId'] : NULL;
        $this->basketId = isset($fields['basketId']) ? $fields['basketId'] : NULL;
        $this->roomId = isset($fields['roomId']) ? $fields['roomId'] : NULL;
        $this->article = isset($fields['article']) ? $fields['article'] : NULL;
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
     * @return mixed|null
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed|null $article
     */
    public function setArticle($article,$controlFlag=false): void
    {
        if(!$controlFlag){
            $this->controlSetArr($article,"article",["article"]);
        }
        else{
            $this->article=$article;
        }
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