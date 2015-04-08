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
 * ImageOverlay it is used to load and display a single image over specific bounds of the map
 *
 * @see http://leafletjs.com/reference.html#imageoverlay
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package extensions\leafletjs\layers
 */
/**
 * @property string $name
 */
class ImageOverlay extends Layer
{
    /**
     * @var string the image Url
     */
    public $imageUrl;

    /**
     * @var LatLngBounds
     */
    private $_bounds;

    /**
     * @param LatLngBounds $bounds
     */
    public function setImageBounds(LatLngBounds $bounds)
    {
        $this->_bounds = $bounds;
    }

    /**
     * @return LatLngBounds
     */
    public function getImageBounds()
    {
        return $this->_bounds;
    }

    /**
     * Returns the javascript ready code for the object to render
     * @return \yii\web\JsExpression
     */
    public function encode()
    {
        $name = $this->name;
        $imageUrl = $this->imageUrl;
        $bounds = $this->getImageBounds()->encode();
        $options = $this->getOptions();
        $map = $this->map;
        $js = "L.imageOverlay('$imageUrl', $bounds, $options)" . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }

        return new JsExpression($js);
    }

}
