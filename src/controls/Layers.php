<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\controls;


use dosamigos\leaflet\layers\LayerGroup;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use yii\base\InvalidParamException;
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
class Layers extends Control
{
    /**
     * @var \dosamigos\leaflet\layers\TileLayer[]
     */
    private $_baseLayers = [];

    /**
     * @param mixed $baseLayers
     *
     * @throws \yii\base\InvalidParamException
     */
    public function setBaseLayers(array $baseLayers)
    {
        foreach ($baseLayers as $key => $layer) {
            if (!($layer instanceof TileLayer)) {
                throw new InvalidParamException("All baselayers should be of type TileLayer ");
            }
            $this->_baseLayers[$key] = $layer;
        }
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
        foreach ($this->getBaseLayers() as $key => $layer) {
            $layer->name = null;
            $layers[$key] = new JsExpression(str_replace(";", "", $layer->encode()));
        }
        return $layers;
    }

    /**
     * @var \dosamigos\leaflet\layers\Layer[]
     */
    private $_overlays = [];

    /**
     * @param \dosamigos\leaflet\layers\LayerGroup[] $overlays
     *
     * @throws \yii\base\InvalidParamException
     */
    public function setOverlays($overlays)
    {
        foreach ($overlays as $key => $overlay) {
            if (!($overlay instanceof LayerGroup)) {
                throw new InvalidParamException("All overlays should be of type LayerGroup");
            }
            $this->_overlays[$key] = $overlay;
        }
    }

    /**
     * @return \dosamigos\leaflet\layers\Layer[]
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
        /**
         * @var \dosamigos\leaflet\layers\LayerGroup $overlay
         */
        foreach ($this->getOverlays() as $key => $overlay) {
            $overlays[$key] = $overlay->oneLineEncode();
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

        $layers = empty($layers) ? '{}' : Json::encode($layers, LeafLet::JSON_OPTIONS);
        $overlays = empty($overlays) ? '{}' : Json::encode($overlays, LeafLet::JSON_OPTIONS);

        $js = "L.control.layers($layers, $overlays, $options)" . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }
        return new JsExpression($js);
    }
}
