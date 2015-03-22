<?php

namespace tests;


use dosamigos\leaflet\layers\Circle;
use dosamigos\leaflet\types\LatLng;

/**
 * @group layers
 */
class CircleLayerTest extends TestCase
{
    public function testEncode() {
        $circle = new Circle(['latLng' => new LatLng(['lat' => 50, 'lng' => 50]), 'radius' => 5]);
        $expected = $circle->encode();
        $this->assertEquals('L.circle([50,50], 5, {})', $expected);

    }

    public function testEncodeWithName() {
        $circle = new Circle(['name' => 'testCircle', 'latLng' => new LatLng(['lat' => 50, 'lng' => 50]), 'radius' => 5]);
        $expected = $circle->encode();
        $this->assertEquals('var testCircle = L.circle([50,50], 5, {});', $expected);
    }

    public function testEncodeWithMap() {
        $circle = new Circle(['map' => 'testMap', 'latLng' => new LatLng(['lat' => 50, 'lng' => 50]), 'radius' => 5]);
        $expected = $circle->encode();
        $this->assertEquals('L.circle([50,50], 5, {}).addTo(testMap);', $expected);
    }
}
