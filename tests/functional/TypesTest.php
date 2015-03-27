<?php

namespace tests;

use dosamigos\leaflet\types\Bounds;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\types\Point;

/**
 * @group types
 */
class TypesTest extends TestCase
{
    public function testLatLngException()
    {
        $this->setExpectedException('yii\base\InvalidConfigException');
        $latLng = new LatLng();
    }

    public function testPoint()
    {
        $point = new Point(['x' => 1, 'y' => 2]);
        $this->assertEquals('L.point(1, 2)', $point->encode());
        $this->assertEquals([1, 2], $point->toArray());

        $this->setExpectedException('yii\base\InvalidConfigException');
        $point = new Point();

    }

    public function testBounds()
    {
        $pointMax = new Point(['x' => 1, 'y' => 2]);
        $pointMin = new Point(['x' => 0.5, 'y' => 1]);

        $bounds = new Bounds(['min' => $pointMin, 'max' => $pointMax]);
        $this->assertEquals($pointMax, $bounds->getMax());
        $this->assertEquals($pointMin, $bounds->getMin());

        $this->assertEquals('L.bounds([0.5,1], [1,2])', $bounds->encode());

        $this->assertEquals([[0.5, 1], [1, 2]], $bounds->toArray());

        $this->setExpectedException('yii\base\InvalidConfigException');
        $bounds = new Bounds();
    }
}
