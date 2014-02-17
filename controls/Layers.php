<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\controls;


use dosamigos\leaflet\layers\LayerGroup;
use dosamigos\leaflet\layers\TileLayer;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Layers The layers control gives users the ability to switch between different base layers and switch overlays on/off.
 *
 * @see http://leafletjs.com/reference.html#control-layers
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\controls
 */
class Layers extends Control {
	/**
	 * @var \dosamigos\leaflet\layers\TileLayer[]
	 */
	private $_baseLayers = [];

	/**
	 * @param mixed $baseLayers
	 * @throws \yii\base\InvalidParamException
	 */
	public function setBaseLayers($baseLayers)
	{
		foreach((array)$baseLayers as $layer) {
			if(!($layer instanceof TileLayer)) {
				throw new InvalidParamException("All overlays should be of type TileLayer");
			}
		}
		$this->_baseLayers = $baseLayers;
	}

	/**
	 * @return \dosamigos\leaflet\layers\TileLayer[]
	 */
	public function getBaseLayers()
	{
		return $this->_baseLayers;
	}

	/**
	 * @return array of encoded base layers
	 */
	public function getEncodedBaseLayers()
	{
		$layers = [];
		foreach($this->getBaseLayers() as $key => $layer) {
			$layer->name = null;
			$layers[ucfirst($key)] = new JsExpression(str_replace(";", "", $layer->encode()));
		}
		return $layers;
	}

	/**
	 * @var \dosamigos\leaflet\layers\TileLayer[]
	 */
	private $_overlays = [];

	/**
	 * @param \dosamigos\leaflet\layers\TileLayer[] $overlays
	 * @throws \yii\base\InvalidParamException
	 * @todo: support for LayerGroups
	 */
	public function setOverlays($overlays)
	{
		foreach((array)$overlays as $overlay) {
			if(!($overlay instanceof TileLayer)) {
				throw new InvalidParamException("All overlays should be of type TileLayer");
			}
		}
		$this->_overlays = $overlays;
	}

	/**
	 * @return \dosamigos\leaflet\layers\TileLayer[]
	 */
	public function getOverlays()
	{
		return $this->_overlays;
	}

	/**
	 * @return array of encoded overlays
	 */
	public function getEncodedOverlays()
	{
		$overlays = [];
		foreach($this->getOverlays() as $key => $overlay) {
			$overlay->name = null;
			$overlays[ucfirst($key)] = str_replace(";", "", $overlay->encode());
		}
		return $overlays;
	}

	/**
	 * Returns the javascript ready code for the object to render
	 * @return \yii\web\JsExpression
	 */
	public function encode()
	{
		$this->clientOptions['position'] = $this->position;
		$layers = $this->getEncodedBaseLayers();
		$overlays = $this->getEncodedOverlays();
		$options = $this->getOptions();
		$name = $this->name;
		$map = $this->map;

		$layers = empty($layers) ? '{}' : Json::encode($layers);
		$overlays = empty($overlays) ? '{}' : Json::encode($overlays);

		$js = "L.control.layers($layers, $overlays, $options)" . ($map !== null ? ".addTo($map);" : "");
		if (!empty($name)) {
			$js = "var $name = $js" . ($map !== null ? "" : ";");
		}
		return new JsExpression($js);
	}
} 