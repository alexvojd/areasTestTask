<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Radius of Earth in meteres
define('EARTH_RADIUS', 6372795);

class AreasListController extends Controller
{
	
    public function showAreasList(Request $request)
    {
    	$isFiltered=false;
    	$currArea = "";
    	$areas = include 'areas.php';
    	$areasInFilter = array_keys($areas);
    	asort($areasInFilter);
    	if (isset($request->area)){
    		$currArea = $request->area;
    		$lat1 = $areas[$currArea]['lat'];
    		$long1 = $areas[$currArea]['long'];
    		foreach($areas as $area => $coords){
    			$lat2 = $coords['lat'];
    			$long2 = $coords['long'];
    			$distance = $this->calculateTheDistance($lat1, $long1, $lat2, $long2);
    			$tempArr[$area] = $distance;
    		}
    		arsort($tempArr);
    		$areas = $tempArr;
    		$isFiltered = true;
    	}else{
    		ksort($areas);
    	} 	
    	
    	return view('areaslist', compact('areas', 'isFiltered', 'currArea', 'areasInFilter'));
    }

    //calculate the distance between 2 points with Earth form as sphere
    //returned value rounding to integer
    public function calculateTheDistance(float $lat1, float $long1, float $lat2, float $long2): float
    {
    	//coordinates to radians
    	$radlat1 = $lat1 * M_PI / 180;
	    $radlat2 = $lat2 * M_PI / 180;
	    $radlong1 = $long1 * M_PI / 180;
	    $radlong2 = $long2 * M_PI / 180;

	    // cos and sin of Latitudes
    	$coslat1 = cos($radlat1);
    	$coslat2 = cos($radlat2);
    	$sinlat1 = sin($radlat1);
    	$sinlat2 = sin($radlat2);

    	// Longitude difference
    	$delta = $radlong2 - $radlong1;
    	$cosdelta = cos($delta);
    	$sindelta = sin($delta);

    	$y = sqrt(pow($coslat2 * $sindelta, 2) + pow($coslat1 * $sinlat2 - $sinlat1 * $coslat2 * $cosdelta, 2));
			
		$x = $sinlat1 * $sinlat2 + $coslat1 * $coslat2 * $cosdelta;

		$ad = atan2($y,$x); 

		$dist = $ad * EARTH_RADIUS / 1000;

		return round($dist);
    }
}
