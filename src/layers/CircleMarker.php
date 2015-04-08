<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\layers;


use yii\web\JsExpression;

/**
 * CircleMarker is a circle of a fixed size with radius specified in pixels. Setting its radius wont change its size.
 *
 * @see http://leafletjs.com/reference.html#circlemarker
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\layers
 */
/**
 * @property string $name
 */
class CircleMarker extends Circle
{
    /**
     * Returns the javascript ready code for the object to render
     * @return JsExpression
     */
    public function encode()
    {
        $bounds = $this->getLatLng()->toArray(true);
        $options = $this->getOptions();
        $name = $this->name;
        $map = $this->map;
        $js = $this->bindPopupContent("L.circleMarker($bounds, $options)") . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }
        return new JsExpression($js);
    }

}
