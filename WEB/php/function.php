<?php
function distanceBetween($lat1, $lon1, $lat2, $lon2) {
    if($lat1 AND $lon1 AND $lat2 AND $lon2){
        $pi80 = pi() / 180;
        $lat1 *= $pi80;
        $lon1 *= $pi80;
        $lat2 *= $pi80;
        $lon2 *= $pi80;
        // echo "lat1 : ".$lat1;
        // echo "lon2 : ".$lon1;
        // echo "lat2 : ".$lat2;
        // echo "lon2 : ".$lon2;
    
        $r = 6372.797;
        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;
        
        return round($km, 2);
    } else {
        return 0;
    }
    
}