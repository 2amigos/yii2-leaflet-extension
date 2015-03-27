<?php

namespace tests;

use dosamigos\leaflet\layers\PolyLine;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\types\LatLngBounds;

/**
 * @group layers
 */
class PolylineTest extends TestCase
{
    public function testEncode()
    {
        $latLngs = [
            new LatLng(['lat' => 39.61, 'lng' => -105.02]),
            new LatLng(['lat' => 39.73, 'lng' => -104.88]),
            new LatLng(['lat' => 39.74, 'lng' => -104.99])
        ];

        $polyline = new PolyLine();

        $polyline->setLatLngs($latLngs);

        $this->assertCount(3, $polyline->getLatLngs());

        $this->assertEquals(
            [
                [39.61, -105.02],
                [39.73, -104.88],
                [39.74, -104.99]
            ],
            $polyline->getLatLngstoArray()
        );

        $bounds = new LatLngBounds(
            [
                'southWest' => new LatLng(['lat' => 39.61, 'lng' => -105.02]),
                'northEast' => new LatLng(['lat' => 39.74, 'lng' => -104.88])
            ]
        );

        $this->assertEquals($bounds, $polyline->getBounds());

        $actual = $polyline->encode();

        $this->assertEquals(
            "L.polyline([[39.61,-105.02],[39.73,-104.88],[39.74,-104.99]], {})",
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

        $polyline = new PolyLine(['name' => 'testPolyline']);

        $polyline->setLatLngs($latLngs);

        $this->assertCount(3, $polyline->getLatLngs());

        $this->assertEquals(
            [
                [39.61, -105.02],
                [39.73, -104.88],
                [39.74, -104.99]
            ],
            $polyline->getLatLngstoArray()
        );

        $bounds = new LatLngBounds(
            [
                'southWest' => new LatLng(['lat' => 39.61, 'lng' => -105.02]),
                'northEast' => new LatLng(['lat' => 39.74, 'lng' => -104.88])
            ]
        );

        $this->assertEquals($bounds, $polyline->getBounds());

        $actual = $polyline->encode();

        $this->assertEquals(
            "var testPolyline = L.polyline([[39.61,-105.02],[39.73,-104.88],[39.74,-104.99]], {});",
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

        $polyline = new PolyLine(['map' => 'testMap']);

        $polyline->setLatLngs($latLngs);

        $this->assertCount(3, $polyline->getLatLngs());

        $this->assertEquals(
            [
                [39.61, -105.02],
                [39.73, -104.88],
                [39.74, -104.99]
            ],
            $polyline->getLatLngstoArray()
        );

        $bounds = new LatLngBounds(
            [
                'southWest' => new LatLng(['lat' => 39.61, 'lng' => -105.02]),
                'northEast' => new LatLng(['lat' => 39.74, 'lng' => -104.88])
            ]
        );

        $this->assertEquals($bounds, $polyline->getBounds());

        $actual = $polyline->encode();

        $this->assertEquals(
            "L.polyline([[39.61,-105.02],[39.73,-104.88],[39.74,-104.99]], {}).addTo(testMap);",
            $actual
        );
    }

    public function testException() {
        $polyline = new PolyLine(['map' => 'testMap']);

        $this->setExpectedException('yii\base\InvalidParamException');
        $polyline->setLatLngs(['wrongValue']);
    }
}
