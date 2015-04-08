<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\layers;

use dosamigos\leaflet\types\LatLngBounds;
use yii\web\JsExpression;

/**
 * Rectangle a class for drawing rectangle overlays on a map.
 *
 * @see http://leafletjs.com/reference.html#rectangle
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\layers
 */
/**
 * @property string $name
 * @property string $popupContent
 * @property bool $openPopup
 */
class Rectangle extends Layer
{
    use PopupTrait;

    /**
     * @var LatLngBounds
     */
    private $_bounds;

    /**
     * @param LatLngBounds $bounds
     */
    public function setBounds(LatLngBounds $bounds)
    {
        $bounds->name = null;
        $this->_bounds = $bounds;
    }

    /**
     * @return LatLngBounds
     */
    public function getBounds()
    {
        return $this->_bounds;
    }

    /**
     * Returns the javascript ready code for the object to render
     * @return string
     */
    public function encode()
    {
        $bounds = $this->getBounds()->encode();
        $options = $this->getOptions();
        $name = $this->name;
        $map = $this->map;
        $js = $this->bindPopupContent("L.rectangle($bounds, $options)") . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }
        return new JsExpression($js);
    }

}
