 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geolocation {

    private $lattitude = '';
    private $longitude = '';
    
    function __construct()
    {
    }
    
    public function setAddress($address)
    {
        
        $geocode            = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');

        $output             = json_decode($geocode);

        $this->lattitude    = $output->results[0]->geometry->location->lat;
        $this->longitude    = $output->results[0]->geometry->location->lng;
    }
    
    public function getLattitude()
    {
        return $this->lattitude;
    }
    
    public function getLongitude()
    {
        return $this->longitude;
    }
    
}

class RadiusCheck extends GeoLocation {
    private $maxLat;
    private $minLat;
    private $maxLong;
    private $minLong;
    
    function RadiusCheck($Latitude, $Longitude, $Miles) {
        
        $EQUATOR_LAT_MILE = 69.172;
        
        $this->maxLat = $Latitude + $Miles / $EQUATOR_LAT_MILE;
        
        $this->minLat = $Latitude - ($this->maxLat - $Latitude);
        
        $this->maxLong = $Longitude + $Miles / (cos($this->minLat * M_PI / 180) * $EQUATOR_LAT_MILE);
        
        $this->minLong = $Longitude - ($this->maxLong - $Longitude);
        
    }
    
    function MaxLatitude() {
        
        return $this->maxLat;
        
    }
    
    function MinLatitude() {
        
        return $this->minLat;
        
    }
    
    function MaxLongitude() {
        
        return $this->maxLong;
        
    }
    
    function MinLongitude() {
        
        return $this->minLong;
        
    }
    
}

class DistanceCheck {
    
    function DistanceCheck() {
    }
    
    function Calculate(
        $dblLat1,
        $dblLong1,
        $dblLat2,
        $dblLong2
    ) {
        
        $EARTH_RADIUS_MILES = 3963;
        $dist = 0;
        //convert degrees to radians
        $dblLat1 = $dblLat1 * M_PI / 180;
        $dblLong1 = $dblLong1 * M_PI / 180;
        $dblLat2 = $dblLat2 * M_PI / 180;
        $dblLong2 = $dblLong2 * M_PI / 180;
        
        if ($dblLat1 != $dblLat2 && $dblLong1 != $dblLong2)
        {
            //the two points are not the same
            $dist =
            sin($dblLat1) * sin($dblLat2)
            + cos($dblLat1) * cos($dblLat2)
            * cos($dblLong2 - $dblLong1);
            $dist =
            $EARTH_RADIUS_MILES
            * (-1 * atan($dist / sqrt(1 - $dist * $dist)) + M_PI / 2);
        }
        return $dist;
    }
}

?>  