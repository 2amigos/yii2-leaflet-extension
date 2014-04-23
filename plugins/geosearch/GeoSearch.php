<?php
/**
 *
 * GeoSearch.php
 *
 * Date: 22/04/14
 * Time: 19:09
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */

namespace dosamigos\leaflet\plugins\geosearch;

use dosamigos\leaflet\Plugin;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * GeoSearch adds geo search capabilities to your leaflet maps
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\geosearch
 */
class GeoSearch extends Plugin
{
    const SERVICE_BING = 'bing';
    const SERVICE_ESRI = 'esri';
    const SERVICE_GOOGLE = 'google';
    const SERVICE_NOKIA = 'nokia';
    const SERVICE_OPENSTREETMAP = 'openstreetmap';

    /**
     * @var string the service to register for the geosearch
     */
    public $service = self::SERVICE_OPENSTREETMAP;

    /**
     * Returns the plugin name
     * @return string
     */
    public function getPluginName()
    {
        return 'plugin:geosearch';
    }

    /**
     * Registers plugin asset bundle
     * @param \yii\web\View $view
     * @return mixed
     */
    public function registerAssetBundle($view)
    {
        switch ($this->service) {
            case static::SERVICE_OPENSTREETMAP:
            case static::SERVICE_BING:
            case static::SERVICE_ESRI:
            case static::SERVICE_GOOGLE:
            case static::SERVICE_NOKIA:
                GeoSearchAsset::register($view)->js[] = "js/l.geosearch.provider.{$this->service}.js";
                break;
            default:
                GeoSearchAsset::register($view);
        }
        return $this;
    }

    /**
     * Returns the javascript ready code for the object to render
     * @return \yii\web\JsExpression
     * @throws \yii\base\InvalidConfigException
     */
    public function encode()
    {
        switch ($this->service) {
            case static::SERVICE_OPENSTREETMAP:
                $provider = 'new L.GeoSearch.Provider.OpenStreetMap()';
                break;
            case static::SERVICE_BING:
                $provider = 'new L.GeoSearch.Provider.Bing()';
                break;
            case static::SERVICE_ESRI:
                $provider = 'new L.GeoSearch.Provider.Esri()';
                break;
            case static::SERVICE_GOOGLE:
                $provider = 'new L.GeoSearch.Provider.Google()';
                break;
            case static::SERVICE_NOKIA:
                $provider = 'new L.GeoSearch.Provider.Nokia()';
                break;
            default:
                throw new InvalidConfigException('"$service" holds an unrecognized service type.');
        }

        $this->clientOptions = ArrayHelper::merge([
            'provider' => new JsExpression($provider),
            'position' => 'topcenter',
            'showMarker' => true
        ], $this->clientOptions);

        $options = $this->getOptions();
        $name = $this->getName();
        $map = $this->map;

        $js = "new L.Control.GeoSearch($options).addTo($map)";

        if(!empty($name)) {
            $js = "var $name = $js;";
        }

        return new JsExpression($js);
    }

} 