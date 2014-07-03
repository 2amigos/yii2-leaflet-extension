<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\awesome;


use dosamigos\leaflet\Plugin;
use yii\web\JsExpression;
use yii\helpers\Json;

/**
 * AwesomeMarker allows to create map icons using FontAwesome Icons.
 *
 * Font awesome files are required to be installed
 *
 * @see https://github.com/lvoogdt/Leaflet.awesome-markers
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\awesome
 */
class AwesomeMarker extends Plugin
{
	/**
	 * @var string the icon name
     * @see https://github.com/lvoogdt/Leaflet.awesome-markers#properties
	 */
	public $icon;

	/**
	 * Generates the code to generate a maki marker. Helper method made for speed purposes.
	 * @param string $icon the icon name
	 * @param array $options the maki marker icon
	 * @return string the resulting js code
	 */
	public function make($icon, $options = [])
	{
		$options['icon'] = $icon;
		$options = Json::encode($options);
		return new JsExpression("L.AwesomeMarkers.icon($options)");
	}

	/**
	 * Returns the plugin name
	 * @return string
	 */
	public function getPluginName()
	{
		return 'plugin:awesomemarker';
	}

	/**
	 * Registers plugin asset bundle
	 * @param \yii\web\View $view
	 * @return mixed
	 */
	public function registerAssetBundle($view)
	{
		AwesomeMarkerAsset::register($view);
		return $this;
	}

	/**
	 * Returns the javascript ready code for the object to render
	 * @return \yii\web\JsExpression
	 */
	public function encode()
	{
		$icon = $this->icon;

		if (empty($icon)) {
			return "";
		}
		$this->clientOptions['icon'] = $icon;
		$options = $this->getOptions();
		$name = $this->getName();

		$js = "L.AwesomeMarkers.icon($options)";

		if (!empty($name)) {
			$js = "var $name = $js;";
		}

		return new JsExpression($js);
	}

} 