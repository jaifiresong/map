<?php


namespace App\Common;


use LiteView\DB\SQLSuid;
use LiteView\Kernel\Lite;
use LiteView\Treasure\Log;

class Location
{
    public static function gaoDeL2Address($lat, $lng, $uid)
    {
        $ak = '';
        list($lng, $lat) = GpsUtils::wgs84ToGcj02($lng, $lat);
        $url = "https://restapi.amap.com/v3/geocode/regeo?key=$ak&location=$lng,$lat";
        $rsp = Lite::request()->get($url);
    }

    //天地图
    //http://api.tianditu.gov.cn/geocoder?postStr={'lon':112.592568,'lat':35.059563,'ver':1}&type=geocode&tk=7bff41f2a83e549130c58d14cfb03637
    public static function tainditu($lat, $lng, $uid)
    {
        $ak = '';
        $url = "http://api.tianditu.gov.cn/geocoder?postStr={'lon':$lng,'lat':$lat,'ver':1}&type=geocode&tk=$ak";
        $data = Lite::request()->get($url);
    }
}
