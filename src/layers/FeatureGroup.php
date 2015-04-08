<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\layers;


use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * FeatureGroup
 *
 * @see http://leafletjs.com/reference.html#featuregroup
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\layers
 */
/**
 * @property string $name
 */
class FeatureGroup extends LayerGroup
{
    use PopupTrait;

    /**
     * @var array the event handlers for the underlying LeafletJs featureGroup JS plugin.
     * Please refer to the [LeafLetJs::featureGroup](http://leafletjs.com/reference.html#featuregroup)
     * js api object options for possible events.
     */
    public $clientEvents = [];

    /**
     * @return JsExpression
     */
    public function encode()
    {
        $js = [];
        $layers = $this->getLayers();
        $name = $this->name;
        $names = str_replace(array('"', "'"), "", Json::encode(array_keys($layers)));
        $map = $this->map;
        foreach ($layers as $layer) {
            $js[] = $layer->encode();
        }
        $initJs = "L.featureGroup($names)" . $this->getEvents() . ($map !== null ? ".addTo($map);" : "");

        if (empty($name)) {
            $js[] = $initJs . ($map !== null ? "" : ";");
        } else {
            $js[] = "var $name = $initJs" . ($map !== null ? "" : ";");
        }
        return new JsExpression(implode("\n", $js));
    }

    /**
     * @inheritdoc
     */
    public function oneLineEncode() {
        $map = $this->map;
        $layers = $this->getLayers();
        $layersJs = [];
        /** @var \dosamigos\leaflet\layers\Layer $layer */
        foreach ($layers as $layer) {
            $layer->setName(null);
            $layersJs[] = $layer->encode();
        }
        $js = "L.featureGroup([" . implode(",", $layersJs) . "])" .
            $this->getEvents() .
            ($map !== null ? ".addTo($map);" : "");
        return new JsExpression($js);
    }

    /**
     * @return string the processed js events
     */
    protected function getEvents()
    {
        $js = [];
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = ".on('$event', $handler)";
            }
        }
        return !empty($js) ? implode("\n", $js) : "";
    }
}
