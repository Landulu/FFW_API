<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 30/05/19
 * Time: 00:36
 */

class TspLocation
{
    public $latitude;
    public $longitude;
    public $id;

    public function __construct($latitude, $longitude, $id = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->id = $id;
    }

    public static function getInstance($location)
    {
        $location = (array) $location;
        if (empty($location['latitude']) || empty($location['longitude']))
        {
            throw new RuntimeException('TspLocation::getInstance could not load location');
        }

        // Instantiate the TspLocation.
        $id = isset($location['id']) ? $location['id'] : null;
        $tspLocation = new TspLocation($location['latitude'], $location['longitude'], $id);

        return $tspLocation;
    }

//    public static function distance($lat1, $lon1, $lat2, $lon2, $unit = 'M')
//    {
//        if ($lat1 == $lat2 && $lon1 == $lon2) return 0;
//
//        $theta = $lon1 - $lon2;
//        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
//        $dist = acos($dist);
//        $dist = rad2deg($dist);
//        $miles = $dist * 60 * 1.1515;
//        $unit = strtoupper($unit);
//
//        if ($unit == "K")
//            return ($miles * 1.609344);
//        else if ($unit == "N")
//            return ($miles * 0.8684);
//        else
//            return $miles;
//    }

    public function distance(
        $lat1, $lon1, $lat2, $lon2
    ) {
        // api key for now
        $key ="AIzaSyAl0p7YX_rNrezTd_A4VOjvW0-cIKHbPo0";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins="
            . $lat1 . "," . $lon1 . "&destinations=" . $lat2 . "," . $lon2 . "&key=" . $key;
//            . "48.8223325,2.3611967&destinations=48.7716862,2.3267193&key=" .$key;
        $response = json_decode(CurlManager::getManager()->curlGet($url));

//        return CurlManager::getManager()->curlGet($url);
//        return $response['status'];
        if ($response['status'] == 'OK') {
            return $response['rows'][0]['elements'][0]['duration']['value'];
        } else {
            return -1;
        }

    }


}

