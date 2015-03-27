<?php

namespace tests;

use dosamigos\leaflet\layers\Popup;
use dosamigos\leaflet\types\LatLng;

/**
 * @group layers
 */
class PopupTest extends TestCase
{
    public function testEncode()
    {
        $popup = new Popup(
            [
                'latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02]),
                'content' => 'Hey!'
            ]
        );

        $actual = $popup->encode();

        $this->assertEquals("L.popup({}).setLatLng(L.latLng(39.61, -105.02)).setContent('Hey!')", $actual);

        $popup->name = 'testName';

        $actual = $popup->encode();

        $this->assertEquals(
            "var testName = L.popup({}).setLatLng(L.latLng(39.61, -105.02)).setContent('Hey!');",
            $actual
        );

        $popup->map = 'testMap';

        $actual = $popup->encode();

        $this->assertEquals(
            "var testName = L.popup({}).setLatLng(L.latLng(39.61, -105.02)).setContent('Hey!').addTo(testMap);",
            $actual
        );
    }

    public function testException()
    {
        $this->setExpectedException('yii\base\InvalidConfigException');
        $popup = new Popup();
    }
}
