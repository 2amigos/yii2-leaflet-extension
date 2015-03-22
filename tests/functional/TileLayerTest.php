<?php

namespace tests;

use dosamigos\leaflet\layers\TileLayer;

/**
 * @group layers
 */
class TileLayerTest extends TestCase
{
    public function testException()
    {
        $this->setExpectedException('yii\base\InvalidConfigException');
        $tileLayer = new TileLayer();
    }

    public function testEncode()
    {
        $tileLayer = new TileLayer(
            [
                'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg'
            ]
        );

        $this->assertEquals(
            "L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg', {})",
            $tileLayer->encode()
        );
    }

    public function testEncodeWithName() {
        $tileLayer = new TileLayer(
            [
                'name' => 'testTileLayer',
                'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg'
            ]
        );

        $this->assertEquals(
            "var testTileLayer = L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg', {});",
            $tileLayer->encode()
        );
    }

    public function testEncodeWithMap() {
        $tileLayer = new TileLayer(
            [
                'map' => 'map',
                'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg'
            ]
        );

        $this->assertEquals(
            "L.tileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg', {}).addTo(map);",
            $tileLayer->encode()
        );
    }
}
