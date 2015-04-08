<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\layers;

use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * Popup is used to open popups in certain places of the map. For popups directly attached to an
 * object (ie [[Marker]]) better use their `popup` attribute.
 *
 * @see http://leafletjs.com/reference.html#popup
 * @package dosamigos\leaflet\layers
 */

/**
 * @property \dosamigos\leaflet\types\LatLng $latLng
 */
class Popup extends Layer
{

    use LatLngTrait;

    /**
     * @var string the HTML content of the popup
     */
    public $content;

    /**
     * Initializes the marker.
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->latLng)) {
            throw new InvalidConfigException("'latLon' attribute cannot be empty.");
        }
    }

    /**
     * Returns the javascript ready code for the object to render
     * @return string
     */
    public function encode()
    {
        $latLon = $this->getLatLng()->encode();
        $options = $this->getOptions();
        $name = $this->name;
        $map = $this->map;
        $js = "L.popup($options).setLatLng($latLon).setContent('$this->content')" . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }

        return new JsExpression($js);
    }
}
