<?php
/**
 * Created by PhpStorm.
 * User: sbailleu
 * Date: 18/06/2019
 * Time: 08:06
 */
namespace services;

Class Service
{

    protected  function getAndSql($arraySqlClauses){

        $i=0;
        $finalSql=null;
        foreach($arraySqlClauses as $sqlClause){
            $finalSql=$finalSql.$sqlClause;
            if($i<count($arraySqlClauses)-1){
                $finalSql=$finalSql." AND ";
            }
            $i++;
        }
        return $finalSql;
    }

}