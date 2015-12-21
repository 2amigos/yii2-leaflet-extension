<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\layers;

use dosamigos\leaflet\LeafLet;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Polygon is a class for drawing polygon overlays on a map
 *
 * @see http://leafletjs.com/reference.html#polygon
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\layers
 */
/**
 * @property string $name
 */
class Polygon extends PolyLine
{

    /**
     * @var bool whether to insert the layer at the bottom most position (z-index) on the map in reference to other
     * ui layers.
     */
    public $insertAtTheBottom = false;

    /**
     * Returns the javascript ready code for the object to render on the map.
     * To add a Polygon to the map, you need to use the special method [[LetLeaf::addPolygon]].
     * @return string
     */
    public function encode()
    {
        $latLngs = Json::encode($this->getLatLngstoArray(), LeafLet::JSON_OPTIONS);
        $options = $this->getOptions();
        $name = $this->name;
        $map = $this->map;
        $js = $this->bindPopupContent("L.polygon($latLngs, $options)") . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }
        return new JsExpression($js);
    }

}
