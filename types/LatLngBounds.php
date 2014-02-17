<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\types;

use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * LatLngBounds represents a rectangular geographical area on a map.
 *
 * @see http://leafletjs.com/reference.html#latlngbounds
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\types
 */
class LatLngBounds extends Type
{
	/**
	 * @var string the variable name. If not null, then the js icon creation script
	 * will be returned as a variable:
	 *
	 * ```
	 * var bounds = L.latLngBounds(...);
	 * // after it can be included to the map
	 * map.fitBounds(bounds);
	 * ```
	 * If null, the js icon creation script will be returned to be used as constructor so it can be used within another
	 * constructor options:
	 *
	 * ```
	 * L.map({maxBounds: L.latLngBounds(...));
	 * ```
	 */
	public $name;
	/**
	 * @var LatLng the southWest boundary
	 */
	private $_southWest;
	/**
	 * @var LatLng the northEast boundary
	 */
	private $_northEast;

	/**
	 * @return LatLng
	 */
	public function getSouthWest()
	{
		return $this->_southWest;
	}

	/**
	 * @param LatLng $latLng
	 */
	public function setSouthWest(LatLng $latLng)
	{
		$this->_southWest = $latLng;
	}

	/**
	 * @return LatLng
	 */
	public function getNorthEast()
	{
		return $this->_northEast;
	}

	/**
	 * @param LatLng $latLng
	 */
	public function setNorthEast(LatLng $latLng)
	{
		$this->_northEast = $latLng;
	}

	/**
	 * Initializes the class
	 * @throws \yii\base\InvalidConfigException
	 */
	public function init()
	{
		parent::init();
		if (empty($this->southWest) || empty($this->northEast)) {
			throw new InvalidConfigException("'southEast' and/or 'northEast' cannot be empty");
		}
	}

	/**
	 * @return \yii\web\JsExpression the js initialization code of the object
	 */
	public function encode()
	{
		$southWest = $this->getSouthWest()->toArray(true);
		$northEast = $this->getNorthEast()->toArray(true);
		$js = "L.latLngBounds($southWest, $northEast)";
		if (!empty($this->name)) {
			$js = "var $this->name = $js;\n";
		}
		return new JsExpression($js);
	}
}