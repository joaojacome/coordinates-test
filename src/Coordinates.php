<?php
namespace CoordinatesTest;

use CoordinatesTest\Exceptions\InvalidParameterException;
use CoordinatesTest\Exceptions\CoordinateOutOfRangeException;

class Coordinates
{
    const EARTH_RADIUS = 6371;

    private $_latitude;
    private $_longitude;

    public function __construct($latitude, $longitude)
    {
        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            throw new InvalidParameterException();
        }

        if ($latitude > 90 || $latitude < -90 || $longitude > 180 || $longitude < -180) {
            throw new CoordinateOutOfRangeException();
        }

        $this->_latitude = $latitude;
        $this->_longitude = $longitude;
    }

    /**
     * Checks if current coordinates are within X kilometers from
     * the parameter.
     *
     * @param Coordinates $point An instance of this class containing the coordinates
     * @param integer $distance Distance in kilometers
     * 
     * @return boolean
     */
    public function isWithinDistance(Coordinates $point, $distance)
    {
        if (!is_numeric($distance)) {
            throw new InvalidParameterException();
        }

        $calculatedDistance = $this->getDistanceTo($point);
        
        if ($calculatedDistance <= $distance) {
            return true;
        }
        
        return false;
    }

    /**
     * Returns the distance between the current coordinates and a specified coodinate.
     *
     * @param Coordinates $point
     * @param integer $digits How many digits the result should be rounded to
     * 
     * @return float The distance rounded to the number of digits specified
     */
    public function getDistanceTo(Coordinates $point, $digits = 5)
    {
        if (!is_numeric($digits)) {
            throw new InvalidParameterException();
        }

        $latitudeDelta = $this->getRadianLatitude() - $point->getRadianLatitude();
        $longitudeDelta = $this->getRadianLongitude() - $point->getRadianLongitude();

        $angle = 2 * asin(sqrt(pow(sin($latitudeDelta / 2), 2)
                    + cos($this->getRadianLatitude())
                    * cos($point->getRadianLatitude())
                    * pow(sin($longitudeDelta / 2), 2)
                ));

        $calculatedDistance = $angle * $this::EARTH_RADIUS;
        
        return round($calculatedDistance, $digits);
    }

    /**
     * Returns the latitude
     *
     * @return float Current latitude
     */
    public function getLatitude()
    {
        return $this->_latitude;
    }

    /**
     * Returns the longitude
     *
     * @return float Current longitude
     */
    public function getLongitude()
    {
        return $this->_longitude;
    }
    
    /**
     * Returns the current latitude in radians
     *
     * @return float Current latitude in radians
     */
    public function getRadianLatitude()
    {
        return deg2rad($this->_latitude);
    }
    
    /**
     * Returns the current longitude in radians
     *
     * @return float Current longitude in radians
     */
    public function getRadianLongitude()
    {
        return deg2rad($this->_longitude);
    }
}
