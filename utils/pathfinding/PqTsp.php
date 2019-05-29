<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 30/05/19
 * Time: 00:37
 */

class PqTsp extends SplPriorityQueue
{
    public function compare($lhs, $rhs) {
        if ($lhs === $rhs) return 0;
        return ($lhs < $rhs) ? 1 : -1;
    }
}