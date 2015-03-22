<?php
namespace tests;


use dosamigos\leaflet\layers\GeoJson;

class GeoJsonLayerTest extends TestCase
{
    public function testEncode()
    {
        $json = new GeoJson(
            [
                'data' => [
                    "type" => "MultiPoint",
                    "coordinates" => [[100.0, 0.0], [101.0, 1.0]]
                ]
            ]
        );

        $expected = 'L.geoJson({"type":"MultiPoint","coordinates":[[100,0],[101,1]]}, {});';

        $this->assertEquals($expected, $json->encode());
    }

    public function testEncodeWithName() {
        $json = new GeoJson(
            [
                'name' => 'testJson',
                'data' => [
                    "type" => "MultiPoint",
                    "coordinates" => [[100.0, 0.0], [101.0, 1.0]]
                ]
            ]
        );

        $expected = 'var testJson = L.geoJson({"type":"MultiPoint","coordinates":[[100,0],[101,1]]}, {});';

        $this->assertEquals($expected, $json->encode());
    }
}
