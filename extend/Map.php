<?php
/**
 * 百度地图业务封装
 */
class Map{

	/**
	 * 获取经纬度
	 * @param  [type] $address 结构化地址
	 * @return [type]          [description]
	 */
	static public function getLngLat($address){
		if(!$address){
			return '';
		}
		
		$data = [
			'address' => $address,
			'output'  => config('map.output'),
			'ak'      => config('map.ak'),
		];
		$url = config('map.domain_name') . '/' . config('map.geocoder') . '/' . config('map.geo_ver') . '/?' . http_build_query($data);
		
		$result = curlRequest($url);
		$result = json_decode($result, true);
		
		return $result;
	}

	/**
	 * 获取静态图
	 * @param  string $center 图中心点位置，参数可以为经纬度坐标或名称。坐标格式：lng<经度>，lat<纬度>
	 * @return [type]         [description]
	 */
	static public function staticImage($center){
		if(!$center){
			return '';
		}

		$data = [
			'ak'      => config('map.ak'),
			'width'   => config('map.width'),
			'height'  => config('map.height'),
			'zoom'    => config('map.zoom'),
			'center'  => $center,
			'markers' => $center, // 标注
		];
		$url = config('map.domain_name') . '/' . config('map.staticimage') . '/' . config('map.static_ver') . '?' . http_build_query($data);


		$result = curlRequest($url);
		return $result;
	}
}