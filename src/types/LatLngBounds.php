<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\types;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\web\JsExpression;

/**
 * LatLngBounds represents a rectangular geographical area on a map.
 *
 * @see http://leafletjs.com/reference.html#latlngbounds
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\types
 */

/**
 * @property LatLng $southWest
 * @property LatLng $northEast
 */
class LatLngBounds extends Type
{
    /**
     * @var string the variable name. If not null, then the js icon creation script
     * will be returned as a variable:
     *
     * ```
     * var bounds = L.latLngBounds(...);
     * // after it can be included to the map
     * map.fitBounds(bounds);
     * ```
     * If null, the js icon creation script will be returned to be used as constructor so it can be used within another
     * constructor options:
     *
     * ```
     * L.map({maxBounds: L.latLngBounds(...));
     * ```
     */
    public $name;
    /**
     * @var LatLng the southWest boundary
     */
    private $_southWest;
    /**
     * @var LatLng the northEast boundary
     */
    private $_northEast;

    /**
     * @return LatLng
     */
    public function getSouthWest()
    {
        return $this->_southWest;
    }

    /**
     * @param LatLng $latLng
     */
    public function setSouthWest(LatLng $latLng)
    {
        $this->_southWest = $latLng;
    }

    /**
     * @return LatLng
     */
    public function getNorthEast()
    {
        return $this->_northEast;
    }

    /**
     * @param LatLng $latLng
     */
    public function setNorthEast(LatLng $latLng)
    {
        $this->_northEast = $latLng;
    }

    /**
     * Initializes the class
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->southWest) || empty($this->northEast)) {
            throw new InvalidConfigException("'southEast' and/or 'northEast' cannot be empty");
        }
    }

    /**
     * @return \yii\web\JsExpression the js initialization code of the object
     */
    public function encode()
    {
        $southWest = $this->getSouthWest()->toArray(true);
        $northEast = $this->getNorthEast()->toArray(true);
        $js = "L.latLngBounds($southWest, $northEast)";
        if (!empty($this->name)) {
            $js = "var $this->name = $js;";
        }
        return new JsExpression($js);
    }

    /**
     * Finds bounds of an array of LatLng instances
     *
     * @param LatLng[] $latLngs
     * @param int $margin
     *
     * @return LatLngBounds
     */
    public static function getBoundsOfLatLngs(array $latLngs, $margin = 0)
    {
        $min_lat = 1000;
        $max_lat = -1000;
        $min_lng = 1000;
        $max_lng = -1000;
        foreach ($latLngs as $latLng) {
            if (!($latLng instanceof LatLng)) {
                throw new InvalidParamException('"$latLngs" should be an array of LatLng instances.');
            }
            /* @var $coord LatLng */
            $min_lat = min($min_lat, $latLng->lat);
            $max_lat = max($max_lat, $latLng->lat);
            $min_lng = min($min_lng, $latLng->lng);
            $max_lng = max($max_lng, $latLng->lng);
        }
        if ($margin > 0) {
            $min_lat = $min_lat - $margin * ($max_lat - $min_lat);
            $min_lng = $min_lng - $margin * ($max_lng - $min_lng);
            $max_lat = $max_lat + $margin * ($max_lat - $min_lat);
            $max_lng = $max_lng + $margin * ($max_lng - $min_lng);
        }
        $bounds = new LatLngBounds(
            [
                'southWest' => new LatLng(['lat' => $min_lat, 'lng' => $min_lng]),
                'northEast' => new LatLng(['lat' => $max_lat, 'lng' => $max_lng])
            ]
        );
        return $bounds;
    }
}
