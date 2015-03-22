<?php

namespace tests;

use dosamigos\leaflet\controls\Zoom;

/**
 * @group controls
 */
class ZoomControlTest extends TestCase
{
    public function testEncode()
    {
        $zoom = new Zoom();
        $expected = $zoom->encode();
        $this->assertEquals('L.control.zoom({"position":"topright"})', $expected);
    }

    public function testEncodeWithName() {
        $zoom = new Zoom(['name' => 'zoomName']);
        $expected = $zoom->encode();

        $this->assertEquals('var zoomName = L.control.zoom({"position":"topright"});', $expected);
    }

    public function testEncodeWithMap() {
        $zoom = new Zoom(['map' => 'mapName']);
        $expected = $zoom->encode();

        $this->assertEquals('L.control.zoom({"position":"topright"}).addTo(mapName);', $expected);
    }
}
