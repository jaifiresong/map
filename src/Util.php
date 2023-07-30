<?php

class Util
{
    /**
     * @desc 根据两点间的经纬度计算距离
     * @param array $A [104.145759, 30.634445]
     * @param array $B [104.153808, 30.681665]
     * @return float 单位米
     */
    public static function distance2l(array $A, array $B): float
    {
        list($longitude1, $latitude1) = $A;
        list($longitude2, $latitude2) = $B;
        $longitude1 = ($longitude1 * pi()) / 180;
        $latitude1 = ($latitude1 * pi()) / 180;
        $longitude2 = ($longitude2 * pi()) / 180;
        $latitude2 = ($latitude2 * pi()) / 180;
        $calcLongitude = $longitude2 - $longitude1;
        $calcLatitude = $latitude2 - $latitude1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($latitude1) * cos($latitude2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = 6367000 * $stepTwo;//approximate radius of earth in meters：6367000
        return round($calculatedDistance);
    }
}