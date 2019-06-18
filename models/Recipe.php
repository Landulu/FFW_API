<?php

require_once ("Model.php");


class Recipe extends Model implements JsonSerializable {
    private $reid;
    private $title;
    private $content;

    /**
     * Recipe constructor.
     */
    public function __construct(array $fields){
        $this->reid = isset($fields['reid']) ? $fields['reid'] : NULL;
//        $this->title = isset($fields['title']) ? utf8_encode($fields['title']) : NULL;
//        $this->content = isset($fields['content']) ? utf8_encode($fields['content']) : NULL;
        $this->title = isset($fields['title']) ? $fields['title'] : NULL;
        $this->content = isset($fields['content']) ? $fields['content'] : NULL;
    }

    /**
     * @return mixed|null
     */
    public function getReid()
    {
        return $this->reid;
    }

    /**
     * @param mixed|null $reid
     */
    public function setReid($reid)
    {
        $this->reid = $reid;
    }

    /**
     * @return mixed|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed|null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed|null $content
     */
    public function setContent( $content)
    {
        $this->content = $content;
    }


    public function getMainId() {
        return $this->reid;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}