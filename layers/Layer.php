<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\layers;

use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\types\Type;
use yii\helpers\Json;

/**
 * Layer is the base class for UI Layers
 *
 * @package dosamigos\leaflet\layers
 */
abstract class Layer extends \yii\base\Component
{
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
	 * @var string the variable name. If not null, then the js creation script
	 * will be returned as a variable. If null, then the js creation script will
	 * be returned as a constructor that you can use on other object's configuration options.
	 */
	private $_name;

	/**
	 * Returns the name of the layer.
	 * @param boolean $autoGenerate whether to generate a name if it is not set previously
	 * @return string name of the layer.
	 */
	public function getName($autoGenerate = false)
	{
		if ($autoGenerate && $this->_name === null) {
			$this->_name = LeafLet::generateName();
		}
		return $this->_name;
	}

	/**
	 * Sets the name of the layer.
	 * @param string $value name of the layer.
	 */
	public function setName($value)
	{
		$this->_name = $value;
	}

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
		return empty($options) ? '{}' : Json::encode($options);
	}

	/**
	 * @return string the processed js events
	 */
	public function getEvents()
	{
		$js = [];
		if (!empty($this->name) && !empty($this->clientEvents)) {
			$name = $this->name;
			foreach ($this->clientEvents as $event => $handler) {
				$js[] = "$name.on('$event', $handler);";
			}
		}
		return !empty($js) ? implode("\n", $js) : "";
	}

	/**
	 * Returns the javascript ready code for the object to render
	 * @return \yii\web\JsExpression
	 */
	abstract function encode();
}