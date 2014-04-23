<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\geocoder;

use dosamigos\leaflet\Plugin;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * GeoCoder adds geo search capabilities to your leaflet maps
 *
 * @see https://github.com/perliedman/leaflet-control-geocoder
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\geocoder
 */
class GeoCoder extends Plugin
{
    /**
     * @var BaseService the service to use for geo search
     */
    private $_service;

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->_service === null) {
            throw new InvalidConfigException('"service" cannot be empty.');
        }
    }

    /**
     * Sets the service to use for geocoding
     * @param BaseService $service
     */
    public function setService(BaseService $service)
    {
        $this->_service = $service;
    }

    /**
     * @return BaseService
     */
    public function getService()
    {
        return $this->_service;
    }

    /**
     * Returns the plugin name
     * @return string
     */
    public function getPluginName()
    {
        return 'plugin:geocoder';
    }

    /**
     * Registers plugin asset bundle
     * @param \yii\web\View $view
     * @return mixed
     */
    public function registerAssetBundle($view)
    {
        $this->getService()->registerAssetBundle($view);
        // GeoCoderAsset::register($view);
        return $this;
    }

    /**
     * Returns the javascript ready code for the object to render
     * @return \yii\web\JsExpression
     * @throws \yii\base\InvalidConfigException
     */
    public function encode()
    {

        $this->clientOptions = ArrayHelper::merge([
            'showMarker' => true
        ], $this->clientOptions);

        $this->clientOptions['geocoder'] = $this->getService()->getJs();

        $options = $this->getOptions();
        $name = $this->getName();
        $map = $this->map;

        $js = "new L.Control.Geocoder($options).addTo($map)";

        if (!empty($name)) {
            $js = "var $name = $js;";
        }

        return new JsExpression($js);
    }

} 