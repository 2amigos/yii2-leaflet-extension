<?php

namespace tests;

use dosamigos\leaflet\layers\CircleMarker;
use dosamigos\leaflet\types\LatLng;

/**
 * @group layers
 */
class CircleMarkerLayerTest extends TestCase
{
    public function testEncode() {
        $circle = new CircleMarker(['latLng' => new LatLng(['lat' => 50, 'lng' => 50]), 'radius' => 5]);
        $expected = $circle->encode();
        $this->assertEquals('L.circleMarker([50,50], {})', $expected);

    }

    public function testEncodeWithName() {
        $circle = new CircleMarker(['name' => 'testCircle', 'latLng' => new LatLng(['lat' => 50, 'lng' => 50]), 'radius' => 5]);
        $expected = $circle->encode();
        $this->assertEquals('var testCircle = L.circleMarker([50,50], {});', $expected);
    }

    public function testEncodeWithMap() {
        $circle = new CircleMarker(['map' => 'testMap', 'latLng' => new LatLng(['lat' => 50, 'lng' => 50]), 'radius' => 5]);
        $expected = $circle->encode();
        $this->assertEquals('L.circleMarker([50,50], {}).addTo(testMap);', $expected);
    }
}
