<?php


namespace App\Common;


use LiteView\DB\SQLSuid;
use LiteView\Kernel\Lite;
use LiteView\Treasure\Log;

class Location
{
    //高德地图,经纬度转地址
    public static function gaoDeL2Address($lat, $lng, $uid)
    {
        $ak = '';
        list($lng, $lat) = GpsUtils::wgs84ToGcj02($lng, $lat);
        $url = "https://restapi.amap.com/v3/geocode/regeo?key=$ak&location=$lng,$lat";
        $rsp = Lite::request()->get($url);
    }

    //天地图,经纬度转地址
    public static function tainditu($lat, $lng, $uid)
    {
        $ak = '';
        $url = "http://api.tianditu.gov.cn/geocoder?postStr={'lon':$lng,'lat':$lat,'ver':1}&type=geocode&tk=$ak";
        $data = Lite::request()->get($url);
    }
}
