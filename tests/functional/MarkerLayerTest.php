<?php
namespace tests;


use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\types\Icon;
use dosamigos\leaflet\types\LatLng;
use yii\web\JsExpression;

class MarkerLayerTest extends TestCase
{
    public function testInvalidConfiguration()
    {
        $this->setExpectedException('yii\base\InvalidConfigException');
        $marker = new Marker();
    }

    public function testEncode()
    {
        $latLng = new LatLng(['lat' => 51.508, 'lng' => -0.11]);
        $icon = new Icon(['iconUrl' => 'http://example.com/icon.png']);
        $marker = new Marker(
            [
                'icon' => $icon,
                'latLng' => $latLng,
                'popupContent' => 'test!'
            ]
        );

        $this->assertNotNull($marker->icon);
        $expected = 'L.marker([51.508,-0.11], {"icon":L.icon({"iconUrl":"http://example.com/icon.png"})}).bindPopup("test!")';

        $this->assertEquals($expected, $marker->encode());
    }

    public function testEncodeWithName()
    {
        $latLng = new LatLng(['lat' => 51.508, 'lng' => -0.11]);

        $marker = new Marker(
            [
                'name' => 'test',
                'latLng' => $latLng,
                'popupContent' => 'test!',
                'openPopup' => true
            ]
        );

        $expected = 'var test = L.marker([51.508,-0.11], {}).bindPopup("test!").openPopup();';

        $this->assertEquals($expected, $marker->encode());
    }

    public function testEncodeWithNameAndEvents() {
        $latLng = new LatLng(['lat' => 51.508, 'lng' => -0.11]);

        $marker = new Marker(
            [
                'name' => 'test',
                'latLng' => $latLng,
                'map' => 'testMap',
                'clientEvents' => [
                    'click' => new JsExpression('function(e){ console.log(e); }')
                ]
            ]
        );

        $expected = 'var test = L.marker([51.508,-0.11], {}).addTo(testMap);test.on(\'click\', function(e){ console.log(e); });';

        $this->assertEquals($expected, $marker->encode());
    }
    public function testEncodeWithoutNameAndEvents() {
        $latLng = new LatLng(['lat' => 51.508, 'lng' => -0.11]);

        $marker = new Marker(
            [
                'latLng' => $latLng,
                'map' => 'testMap',
                'clientEvents' => [
                    'click' => new JsExpression('function(e){ console.log(e); }')
                ]
            ]
        );

        $expected = 'L.marker([51.508,-0.11], {}).addTo(testMap).on(\'click\', function(e){ console.log(e); });';

        $this->assertEquals($expected, $marker->encode());
    }
}
