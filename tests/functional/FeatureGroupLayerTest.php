<?php

namespace tests;

use dosamigos\leaflet\layers\FeatureGroup;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\types\LatLng;
use yii\web\JsExpression;

/**
 * @group layers
 */
class FeatureGroupLayerTest extends TestCase
{
    public function testEncode() {
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new FeatureGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);

        $actual = $group->encode();

        $this->assertEquals(file_get_contents(__DIR__ . '/data/featureGroup-layer.bin'), $actual);

    }

    public function testEncodeWithName() {
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new FeatureGroup(['name' => 'testGroup']);
        $group->addLayer($littleton);
        $group->addLayer($denver);

        $actual = $group->encode();

        $this->assertEquals(file_get_contents(__DIR__ . '/data/featureGroup-layer-with-name.bin'), $actual);
    }

    public function testEncodeWithMapAndEvents() {
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new FeatureGroup(['map' => 'testMap', 'clientEvents' => [
            'click' => new JsExpression('function(e){ console.log(e); }')
        ]]);
        $group->addLayer($littleton);
        $group->addLayer($denver);

        $actual = $group->encode();

        $this->assertEquals(file_get_contents(__DIR__ . '/data/featureGroup-layer-with-map-and-events.bin'), $actual);
    }

    public function testOneLineEncode() {
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new FeatureGroup(['map' => 'testMap']);
        $group->addLayer($littleton);
        $group->addLayer($denver);

        $actual = $group->oneLineEncode();

        $this->assertEquals('L.featureGroup([L.marker([39.61,-105.02], {}),L.marker([39.74,-104.99], {})]).addTo(testMap);', $actual);
    }
}
