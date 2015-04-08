<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\layers;

use dosamigos\leaflet\types\Icon;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * Marker is used to put a marker on the map
 *
 * @see http://leafletjs.com/reference.html#circle
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\layers
 */
/**
 * @property string $name
 * @property \dosamigos\leaflet\types\LatLng $latLng
 * @property string $popupContent
 * @property bool $openPopup
 */
class Marker extends Layer
{
    use LatLngTrait;
    use PopupTrait;

    /**
     * Sets the marker's icon
     *
     * @param Icon $icon
     */
    public function setIcon($icon) //Icon - if you force the icon as type, the makimarker won't work...:(
    {
        $this->clientOptions['icon'] = $icon;
    }

    /**
     * @return \dosamigos\leaflet\types\Icon
     */
    public function getIcon()
    {
        return isset($this->clientOptions['icon']) ? $this->clientOptions['icon'] : null;
    }

    /**
     * Initializes the marker.
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->latLng)) {
            throw new InvalidConfigException("'latLng' attribute cannot be empty.");
        }
    }

    /**
     * @return \yii\web\JsExpression the marker constructor string
     */
    public function encode()
    {
        $latLon = $this->getLatLng()->toArray(true);
        $options = $this->getOptions();
        $name = $this->name;
        $map = $this->map;
        $js = $this->bindPopupContent("L.marker($latLon, $options)") . ($map !== null ? ".addTo($map)" : "");
        if (!empty($name)) {
            $js = "var $name = $js;";
        }
        $js .= $this->getEvents() . ($map !== null && empty($name)? ";" : "");

        return new JsExpression($js);
    }
}
