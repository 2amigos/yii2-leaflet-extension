<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\plugins\markercluster;


use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\Plugin;
use yii\web\JsExpression;

/**
 * MarkerCluster provides beautiful animated Marker clustering functionality for Leaflet.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\markercluster
 */
class MarkerCluster extends Plugin
{
	/**
	 * @var bool whether to load markers from an external json file. The json file format must be (popup is optional):
	 *
	 * ```
	 * {
	 * 	markers: [
	 * 		{lat: 0.00000, lng: 0.00000, popup: 'Text'},
	 * 		{lat: 0.00000, lng: 0.00000},
	 * 	]
	 * }
	 * ```
	 */
	public $url = false;

	private $_markers = [];

	/**
	 * @return array the markers added
	 */
	public function getMarkers()
	{
		return $this->_markers;
	}

	/**
	 * Returns the name of the plugin
	 * @return string
	 */
	public function getPluginName()
	{
		return 'plugin:markercluster';
	}

	/**
	 * Registers plugin asset bundle
	 * @param \yii\web\View $view
	 * @return static the plugin
	 */
	public function registerAssetBundle($view)
	{
		MarkerClusterAsset::register($view);
		return $this;
	}

	/**
	 * @param Marker $marker
	 * @return static the plugin
	 */
	public function addLayer(Marker $marker)
	{
		$marker->name = $marker->map = null;
		$this->_markers[] = $marker;
		return $this;
	}

	/**
	 * Returns the javascript ready code for the object to render
	 * @return \yii\web\JsExpression|string
	 */
	public function encode()
	{
		$markers = $this->getMarkers();
		if(empty($markers) && $this->jsonUrl == false) {
			return "";
		}
		$js = [];
		$options = $this->getOptions();
		$name = $this->getName(true);
		$map = $this->map;
		$js[] = "var $name = L.markerClusterGroup($options);";

		if($this->jsonUrl) {
			$js[] = "$.getJSON('$this->jsonUrl', function(data){
				if(data.markers){
					$.each(data.markers, function(){
						var marker = L.marker(L.latLng(this.lat, this.lng));
						if(this.popup){
							marker.bindPopup(this.popup);
						}
						$name.addLayer(marker);
					});
				}
			});";
		}
		if($markers) {
			foreach($markers as $marker) {
				$js[] = "$name.addLayer({$marker->encode()});";
			}
		}
		$js[] = "$map.addLayer($name);";

		return new JsExpression(implode("\n", $js));
	}

}