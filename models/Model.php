<?php
/**
 * Created by PhpStorm.
 * User: sbailleu
 * Date: 11/06/2019
 * Time: 18:00
 */
require_once ("Model.php");

abstract class Model
{


    /**
     * Model constructor.
     */
    public function __construct()
    {
    }

    public abstract function getMainId();
}