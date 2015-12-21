<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\types;

use dosamigos\leaflet\LeafLet;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\web\JsExpression;


/**
 * Icon represents an icon to provide when creating a marker.
 *
 * @see http://leafletjs.com/reference.html#icon
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\types
 */
class Icon extends Type
{
    /**
     * @var string the variable name. If not null, then the js icon creation script
     * will be returned as a variable:
     *
     * ```
     * var iconName = L.icon({...});
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
     * @var string (required) the URL to the icon image (absolute or relative to your script path).
     */
    public $iconUrl;
    /**
     * @var string the URL to a retina sized version of the icon image (absolute or relative to your script path). Used
     * for Retina screen devices.
     */
    public $iconRetinaUrl;
    /**
     * @var string the URL to the icon shadow image. If not specified, no shadow image will be created.
     */
    public $shadowUrl;
    /**
     * @var string the URL to the retina sized version of the icon shadow image. If not specified, no shadow image will
     * be created. Used for Retina screen devices.
     */
    public $shadowRetinaUrl;
    /**
     * @var string a custom class name to assign to both icon and shadow images. Empty by default.
     */
    public $className;
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
     * @var Point size of the shadow image in pixels.
     */
    private $_shadowSize;
    /**
     * @var Point the coordinates of the "tip" of the shadow (relative to its top left corner) (the same as iconAnchor
     * if not specified).
     */
    private $_shadowAnchor;
    /**
     * @var Point the coordinates of the point from which popups will "open", relative to the icon anchor.
     */
    private $_popupAnchor;

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
     * @param Point $popupAnchor
     */
    public function setPopupAnchor(Point $popupAnchor)
    {
        $this->_popupAnchor = $popupAnchor;
    }

    /**
     * @return Point
     */
    public function getPopupAnchor()
    {
        return $this->_popupAnchor;
    }

    /**
     * @param Point $shadowAnchor
     */
    public function setShadowAnchor(Point $shadowAnchor)
    {
        $this->_shadowAnchor = $shadowAnchor;
    }

    /**
     * @return Point
     */
    public function getShadowAnchor()
    {
        return $this->_shadowAnchor;
    }

    /**
     * @param Point $shadowSize
     */
    public function setShadowSize(Point $shadowSize)
    {
        $this->_shadowSize = $shadowSize;
    }

    /**
     * @return Point
     */
    public function getShadowSize()
    {
        return $this->_shadowSize;
    }

    /**
     * Initializes the object
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (empty($this->iconUrl)) {
            throw new InvalidConfigException("'iconUrl' attribute cannot be empty.");
        }
    }

    /**
     * @return string the js initialization code of the object
     */
    public function encode()
    {
        $options = Json::encode($this->getOptions(), LeafLet::JSON_OPTIONS);

        $js = "L.icon($options)";
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
        foreach (['iconAnchor', 'iconSize', 'popupAnchor', 'shadowAnchor', 'shadowSize'] as $property) {
            $point = $this->$property;
            if ($point instanceof Point) {
                $options[$property] = $point->toArray(true);
            }
        }
        return array_filter($options);
    }
}
