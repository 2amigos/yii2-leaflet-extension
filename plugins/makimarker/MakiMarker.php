<?php
/**
 *
 * MakiMarker.php
 *
 * Date: 17/02/14
 * Time: 22:09
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */

namespace dosamigos\leaflet\plugins\makimarker;


use dosamigos\leaflet\Plugin;
use yii\web\JsExpression;
use yii\helpers\Json;

class MakiMarker extends Plugin
{
	/**
	 * @var string the maki icon name
	 * @see https://www.mapbox.com/maki/
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
		return "L.MakiMarkers.icon($icon, $options)";
	}

	/**
	 * Returns the plugin name
	 * @return string
	 */
	public function getPluginName()
	{
		return 'plugin:makimarker';
	}

	/**
	 * Registers plugin asset bundle
	 * @param \yii\web\View $view
	 * @return mixed
	 */
	public function registerAssetBundle($view)
	{
		MakiMarkerAsset::register($view);
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

		$js = "L.MakiMarkers.icon($options)";

		if (!empty($name)) {
			$js = "var $name = $js;";
		}

		return new JsExpression($js);
	}

} 