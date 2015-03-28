<?php

namespace tests;

use dosamigos\leaflet\controls\Layers;
use dosamigos\leaflet\layers\LayerGroup;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\types\LatLng;
use yii\helpers\Json;

/**
 * @group controls
 */
class LayersControlTest extends TestCase
{
    /**
     * @var \dosamigos\leaflet\controls\Layers $layers
     */
    public $layers;

    public function setUp()
    {
        parent::setUp();
        $this->layers = new Layers();
    }

    public function testGetOptions() {
        $this->assertEquals("{}", $this->layers->getOptions());
    }

    public function testSetName() {
        $this->layers->name = 'map';
        $this->assertEquals('map', $this->layers->name);
        $this->assertEquals('map', $this->layers->getName(true));

    }

    public function testAutoGenerate() {
        $name = $this->layers->getName(true);
        $this->assertEquals($name, $this->layers->getName(true));
    }

    public function testSetWrongBaseLayers()
    {
        $this->setExpectedException('yii\base\InvalidParamException');
        $this->layers->setBaseLayers(['bad']);

    }

    public function testSetBaseLayers() {

        $layers = new Layers();
        $tileLayer = new TileLayer([
            'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg'
        ]);

        $layers->setBaseLayers(['mqcdn'=> $tileLayer]);

        $expected = Json::encode($layers->getEncodedBaseLayers());

        $this->assertEquals(file_get_contents(__DIR__ . '/data/layers-control-baselayers.bin'), $expected);
    }

    public function testSetWrongOverlays() {
        $this->setExpectedException('yii\base\InvalidParamException');
        $this->layers->setOverlays(['bad']);
    }

    public function testSetOverlays() {

        $layers = new Layers();
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new LayerGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);
        $layers->setOverlays(['cities'  => $group]);
        $expected = Json::encode($layers->getEncodedOverlays());

        $this->assertEquals(file_get_contents(__DIR__ . '/data/layers-control-overlays.bin'), $expected);
    }

    public function testEncodeNoName() {
        $layers = new Layers();
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new LayerGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);
        $layers->setOverlays(['cities'  => $group]);

        $tileLayer = new TileLayer([
            'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg'
        ]);

        $layers->setBaseLayers(['mqcdn'=> $tileLayer]);

        $expected = Json::encode($layers->encode());

        $this->assertEquals(file_get_contents(__DIR__ . '/data/layers-control-no-map.bin'), $expected);
    }

    public function testEncodeWithName() {
        $layers = new Layers(['name' => 'layerGroupName']);
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new LayerGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);
        $layers->setOverlays(['cities'  => $group]);

        $tileLayer = new TileLayer([
            'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg'
        ]);

        $layers->setBaseLayers(['mqcdn'=> $tileLayer]);

        $expected = Json::encode($layers->encode());

        $this->assertEquals(file_get_contents(__DIR__ . '/data/layers-control-with-name.bin'), $expected);
    }

    public function testEncodeWithMap() {
        $layers = new Layers(['map' => 'mapName']);
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new LayerGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);
        $layers->setOverlays(['cities'  => $group]);

        $tileLayer = new TileLayer([
            'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg'
        ]);

        $layers->setBaseLayers(['mqcdn'=> $tileLayer]);

        $expected = Json::encode($layers->encode());

        $this->assertEquals(file_get_contents(__DIR__ . '/data/layers-control-with-map.bin'), $expected);
    }
}
