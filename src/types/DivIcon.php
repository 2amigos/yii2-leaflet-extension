<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\types;

use dosamigos\leaflet\LeafLet;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 *
 * DivIcon represents a lightweight icon for markers that uses a simple div element instead of an image.
 *
 * @see http://leafletjs.com/reference.html#divicon
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\types
 */
class DivIcon extends Type
{
    /**
     * @var string the variable name. If not null, then the js icon creation script
     * will be returned as a variable:
     *
     * ```
     * var iconName = L.divIcon({...});
     * // after it can be shared among other markers
     * L.marker({icon: iconName, ...).addTo(map);
     * L.marker({icon: iconName, ...).addTo(map);
     * ```
     * If null, the js icon creation script will be returned to be used as constructor so it can be used within another
     * constructor options:
     *
     * ```
     * L.marker({icon: L.icon({...}), ...).addTo(map);
     * ```
     */
    public $name;
    /**
     * @var string a custom class name to assign to both icon and shadow images. Empty by default.
     */
    public $className;
    /**
     * @var string a custom HTML code to put inside the div element, empty by default.
     */
    public $html;
    /**
     * @var Point size of the icon image in pixels.
     */
    private $_iconSize;
    /**
     * @var Point the coordinates of the "tip" of the icon (relative to its top left corner). The icon will be aligned so
     * that this point is at the marker's geographical location. Centered by default if size is specified, also can be
     * set in CSS with negative margins.
     */
    private $_iconAnchor;

    /**
     * @param Point $iconSize
     */
    public function setIconSize(Point $iconSize)
    {
        $this->_iconSize = $iconSize;
    }

    /**
     * @return Point
     */
    public function getIconSize()
    {
        return $this->_iconSize;
    }

    /**
     * @param Point $iconAnchor
     */
    public function setIconAnchor(Point $iconAnchor)
    {
        $this->_iconAnchor = $iconAnchor;
    }

    /**
     * @return Point
     */
    public function getIconAnchor()
    {
        return $this->_iconAnchor;
    }

    /**
     * @return \yii\web\JsExpression the js initialization code of the object
     */
    public function encode()
    {
        $options = Json::encode($this->getOptions(), LeafLet::JSON_OPTIONS);

        $js = "L.divIcon($options)";
        if ($this->name) {
            $js = "var $this->name = $js;";
        }
        return new JsExpression($js);
    }

    /**
     * @return array the configuration options of the array
     */
    public function getOptions()
    {
        $options = [];
        $class = new \ReflectionClass(__CLASS__);
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $name = $property->getName();
                $options[$name] = $this->$name;
            }
        }
        foreach (['iconSize', 'iconAnchor'] as $property) {
            $point = $this->$property;
            if ($point instanceof Point) {
                $options[$property] = $point->toArray(true);
            }
        }
        return array_filter($options);
    }
}
