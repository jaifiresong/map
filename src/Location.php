<?php


namespace App\Common;


use LiteView\DB\SQLSuid;
use LiteView\Kernel\Lite;
use LiteView\Treasure\Log;

class Location
{
    public static function gaoDeL2Address($lat, $lng, $uid)
    {
      //  return self::tainditu($lat, $lng, $uid);
        $ak = '137ce810836b425e86266a086e3c6447';
        list($lng, $lat) = GpsUtils::wgs84ToGcj02($lng, $lat);
        $url = "https://restapi.amap.com/v3/geocode/regeo?key=$ak&location=$lng,$lat";
        $rsp = Lite::request()->get($url);

        SQLSuid::insert('gaode_map_log', ['uid' => $uid, 'url' => $url, 'rsp' => $rsp]);

        return json_decode($rsp, true);
    }

    //天地图
    //http://api.tianditu.gov.cn/geocoder?postStr={'lon':112.592568,'lat':35.059563,'ver':1}&type=geocode&tk=7bff41f2a83e549130c58d14cfb03637
    public static function tainditu($lat, $lng, $uid)
    {
        $ak = 'ab86f5092ffcf7e027d33a540c535562';
        $url = "http://api.tianditu.gov.cn/geocoder?postStr={'lon':$lng,'lat':$lat,'ver':1}&type=geocode&tk=$ak";
        $data = Lite::request()->get($url);
        SQLSuid::insert('tianditu_map_log', ['uid' => $uid, 'url' => $url, 'rsp' => $data]);
        $data = empty($data) ? [] : json_decode($data, true);
        $reArr = [];
        if (!empty($data['result']['addressComponent']['address']) and $data['status'] == 0) {
            $reArr['status'] = 1;
            $reArr['regeocode']['formatted_address'] = $data['result']['formatted_address'];
            $data1 = $data['result']['addressComponent'];
            $reArr['regeocode']['addressComponent']['country'] = !empty($data1['county']) ? $data1['county'] : '';
            $reArr['regeocode']['addressComponent']['province'] = !empty($data1['province']) ? $data1['province'] : '';
            $reArr['regeocode']['addressComponent']['city'] = !empty($data1['city']) ? $data1['city'] : '';
            $reArr['regeocode']['addressComponent']['district'] = !empty($data1['poi']) ? $data1['poi'] : '';
            $reArr['regeocode']['addressComponent']['street'] = !empty($data1['road']) ? $data1['road'] : '';
            $reArr['regeocode']['addressComponent']['street_number'] =  !empty($data1['road_distance']) ? $data1['road_distance'] : '';
            if (empty($data1['city'])) {
                $arr = explode('市', $reArr['result']['addressComponent']['province']);
                if (count($arr) >= 2) {
                    $reArr['regeocode']['addressComponent']['city'] = $reArr['result']['addressComponent']['province'];
                } else {
                    $reArr['regeocode']['addressComponent']['city'] = $reArr['result']['addressComponent']['country'];
                }
            }
        }
        SQLSuid::insert('tianditu_map_log', ['uid' => $uid, 'url' => $url, 'rsp' => json_encode($reArr, JSON_UNESCAPED_UNICODE)]);
        return $reArr;
    }
}
