<?php


class DateUtil {

    static public function isBetweenDaysInclusive($value, $dateA, $dateB) {
        if ($value <= $dateA && $value >= $dateB) {
            return TRUE;
        } else if ($value >= $dateA && $value <= $dateB) {
            return TRUE;
        }
        return FALSE;
    }
    


    // 7.1+
    
}

?>