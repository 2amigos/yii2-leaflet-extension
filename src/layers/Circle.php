<?php
/**
 * /**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\layers;


use yii\web\JsExpression;

/**
 * Circle a class for drawing circle overlays on a map.
 *
 * @see http://leafletjs.com/reference.html#circle
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\layers
 */
/**
 * @property string $name
 */
class Circle extends Layer
{
    use LatLngTrait;
    use PopupTrait;

    /**
     * @var float Sets the radius of a circle. Units are in meters.
     */
    public $radius;

    /**
     * Returns the javascript ready code for the object to render
     * @return JsExpression
     */
    public function encode()
    {
        $bounds = $this->getLatLng()->toArray(true);
        $radius = $this->radius;
        $options = $this->getOptions();
        $name = $this->name;
        $map = $this->map;
        $js = $this->bindPopupContent("L.circle($bounds, $radius, $options)") . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }
        return new JsExpression($js);
    }

}
