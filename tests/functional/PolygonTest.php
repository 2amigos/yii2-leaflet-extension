<?php

namespace tests;

use dosamigos\leaflet\layers\Polygon;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\types\LatLngBounds;

/**
 * @group layers
 */
class PolygonTest extends TestCase
{
    public function testEncode()
    {
        $latLngs = [
            new LatLng(['lat' => 39.61, 'lng' => -105.02]),
            new LatLng(['lat' => 39.73, 'lng' => -104.88]),
            new LatLng(['lat' => 39.74, 'lng' => -104.99])
        ];

        $polygon = new Polygon();

        $polygon->setLatLngs($latLngs);

        $this->assertCount(3, $polygon->getLatLngs());

        $this->assertEquals(
            [
                [39.61, -105.02],
                [39.73, -104.88],
                [39.74, -104.99]
            ],
            $polygon->getLatLngstoArray()
        );

        $bounds = new LatLngBounds(
            [
                'southWest' => new LatLng(['lat' => 39.61, 'lng' => -105.02]),
                'northEast' => new LatLng(['lat' => 39.74, 'lng' => -104.88])
            ]
        );

        $this->assertEquals($bounds, $polygon->getBounds());

        $actual = $polygon->encode();

        $this->assertEquals(
            "L.polygon([[39.61,-105.02],[39.73,-104.88],[39.74,-104.99]], {})",
            $actual
        );
    }

    public function testEncodeWithName()
    {
        $latLngs = [
            new LatLng(['lat' => 39.61, 'lng' => -105.02]),
            new LatLng(['lat' => 39.73, 'lng' => -104.88]),
            new LatLng(['lat' => 39.74, 'lng' => -104.99])
        ];

        $polygon = new Polygon(['name' => 'testPolygon']);

        $polygon->setLatLngs($latLngs);

        $this->assertCount(3, $polygon->getLatLngs());

        $this->assertEquals(
            [
                [39.61, -105.02],
                [39.73, -104.88],
                [39.74, -104.99]
            ],
            $polygon->getLatLngstoArray()
        );

        $bounds = new LatLngBounds(
            [
                'southWest' => new LatLng(['lat' => 39.61, 'lng' => -105.02]),
                'northEast' => new LatLng(['lat' => 39.74, 'lng' => -104.88])
            ]
        );

        $this->assertEquals($bounds, $polygon->getBounds());

        $actual = $polygon->encode();

        $this->assertEquals(
            "var testPolygon = L.polygon([[39.61,-105.02],[39.73,-104.88],[39.74,-104.99]], {});",
            $actual
        );
    }

    public function testEncodeWithMapName()
    {
        $latLngs = [
            new LatLng(['lat' => 39.61, 'lng' => -105.02]),
            new LatLng(['lat' => 39.73, 'lng' => -104.88]),
            new LatLng(['lat' => 39.74, 'lng' => -104.99])
        ];

        $polygon = new Polygon(['map' => 'testMap']);

        $polygon->setLatLngs($latLngs);

        $this->assertCount(3, $polygon->getLatLngs());

        $this->assertEquals(
            [
                [39.61, -105.02],
                [39.73, -104.88],
                [39.74, -104.99]
            ],
            $polygon->getLatLngstoArray()
        );

        $bounds = new LatLngBounds(
            [
                'southWest' => new LatLng(['lat' => 39.61, 'lng' => -105.02]),
                'northEast' => new LatLng(['lat' => 39.74, 'lng' => -104.88])
            ]
        );

        $this->assertEquals($bounds, $polygon->getBounds());

        $actual = $polygon->encode();

        $this->assertEquals(
            "L.polygon([[39.61,-105.02],[39.73,-104.88],[39.74,-104.99]], {}).addTo(testMap);",
            $actual
        );
    }

    public function testException() {
        $polygon = new Polygon(['map' => 'testMap']);

        $this->setExpectedException('yii\base\InvalidParamException');
        $polygon->setLatLngs(['wrongValue']);
    }
}
