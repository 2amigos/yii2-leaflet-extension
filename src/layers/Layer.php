<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\layers;

use dosamigos\leaflet\LeafLet;
use yii\base\Component;
use dosamigos\leaflet\types\Type;
use yii\helpers\Json;

/**
 * Layer is the base class for UI Layers
 *
 * @property string $name
 *
 * @package dosamigos\leaflet\layers
 */
abstract class Layer extends Component
{

    use NameTrait;

    /**
     * @var string the name of the javascript variable that will hold the reference
     * to the map object.
     */
    public $map;
    /**
     * @var array the options for the underlying LeafLetJs JS component.
     * Please refer to the LeafLetJs api reference for possible
     * [options](http://leafletjs.com/reference.html).
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the underlying LeafletJs JS plugin.
     * Please refer to the LeafLetJs js api object options for possible events.
     */
    public $clientEvents = [];

    /**
     * Returns the processed js options
     * @return array
     */
    public function getOptions()
    {
        $options = [];
        foreach ($this->clientOptions as $key => $option) {
            if ($option instanceof Type) {
                $option = $option->encode();
            }
            $options[$key] = $option;
        }
        return empty($options) ? '{}' : Json::encode($options, LeafLet::JSON_OPTIONS);
    }

    /**
     * @return string the processed js events
     */
    public function getEvents()
    {
        $js = [];
        if (!empty($this->clientEvents)) {
            if (!empty($this->name)) {
                $name = $this->name;
                $js[] = "{$name}";
                foreach ($this->clientEvents as $event => $handler) {
                    $js[] = ".on('$event', $handler)";
                }
            } else {
                foreach ($this->clientEvents as $event => $handler) {
                    $js[] = ".on('$event', $handler)";
                }
            }
        }
        return !empty($js) ? implode("", $js) . ($this->name !== null ? ";" : "") : "";
    }

    /**
     * Returns the javascript ready code for the object to render
     * @return \yii\web\JsExpression
     */
    abstract public function encode();
}
