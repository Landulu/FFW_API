<?php


class CompleteRoom implements JsonSerializable {
    private $rid;
    private $name;
    private $isUnavailable;
    private $isStockroom;
    private $loid;
    private $products;

    public function __construct(array $fields) {
        $this->rid = isset($fields['rid']) ? $fields['rid'] : NULL;
        $this->name = isset($fields['name']) ? $fields['name'] : NULL;
        $this->isUnavailable = isset($fields['isUnavailable']) ? $fields['isUnavailable'] : NULL;
        $this->isStockroom = isset($fields['isStockroom']) ? $fields['isStockroom'] : NULL;
        $this->loid = isset($fields['loid']) ? $fields['loid'] : NULL;
        $this->products = isset($fields['products']) ? $fields['products'] : NULL;
    }

    /**
     * @return mixed|null
     */
    public function getRid()
    {
        return $this->rid;
    }

    /**
     * @param mixed|null $rid
     */
    public function setRid($rid): void
    {
        $this->rid = $rid;
    }

    /**
     * @return mixed|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed|null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed|null
     */
    public function getIsUnavailable()
    {
        return $this->isUnavailable;
    }

    /**
     * @param mixed|null $isUnavailable
     */
    public function setIsUnavailable($isUnavailable): void
    {
        $this->isUnavailable = $isUnavailable;
    }

    /**
     * @return mixed|null
     */
    public function getIsStockroom()
    {
        return $this->isStockroom;
    }

    /**
     * @param mixed|null $isStockroom
     */
    public function setIsStockroom($isStockroom): void
    {
        $this->isStockroom = $isStockroom;
    }

    /**
     * @return mixed|null
     */
    public function getLoid()
    {
        return $this->loid;
    }

    /**
     * @param mixed|null $loid
     */
    public function setLoid($loid): void
    {
        $this->loid = $loid;
    }

    /**
     * @return mixed|null
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed|null $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }


    public function JsonSerialize() {
        return get_object_vars($this);
    }
}

