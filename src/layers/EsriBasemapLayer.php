<?php
namespace dosamigos\leaflet\layers;

use \yii\web\JsExpression;

/**
 * Esri Leaflet extension basemap Layer wrapper.
 * Used to easily get different tile layers from ArcGIS withour having to setup TileLayer's with urlTemplates.
 * possible Basemaps are:
 *
 * Streets
 * Topographic
 * NationalGeographic
 * Oceans
 * Gray
 * DarkGray
 * Imagery
 * ImageryClarity
 * ImageryFirefly
 * ShadedRelief
 * Terrain
 * USATopo
 * Physical
 *
 * Also there is several helping label layers:
 *
 * OceansLabels - Labels to pair with the Oceans basemap
 * GrayLabels - Labels to pair with the Gray basemap
 * DarkGrayLabels - Labels to pair with the DarkGray basemap
 * ImageryLabels - Labels including political boundaries to pair with any Imagery basemap
 * ImageryTransportation - Street map labels for pairing with any Imagery basemap
 * ShadedReliefLabels - Labels for pairing with the ShadedRelief basemap
 * TerrainLabels - Labels for pairing with the Terrain or Physical basemap
 *
 * Class EsriBasemapLayer
 * @package dosamigos\leaflet\layers
 */
class EsriBasemapLayer extends Layer {
    public $basemap = 'Streets';

    public function encode(){
        $name = $this->getName();
        $map = $this->map;
        $js = "L.esri.basemapLayer('{$this->basemap}')" . ($map !== null? ".addTo({$map});":"");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
            $js .= $this->getEvents();
        }
        return new JsExpression($js);
    }
}