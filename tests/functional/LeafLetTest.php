<?php

namespace tests;


use dosamigos\leaflet\controls\Layers;
use dosamigos\leaflet\controls\Zoom;
use dosamigos\leaflet\layers\LayerGroup;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\Polygon;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\Plugin;
use dosamigos\leaflet\types\LatLng;
use yii\web\AssetBundle;
use yii\web\JsExpression;

class LeafLetTest extends TestCase
{
    public function testControls()
    {
        $zoomControl = new Zoom();
        $leafLet = new LeafLet(
            [
                'center' => new LatLng(['lat' => 51.508, 'lng' => -0.11]),
                'zoom' => 13
            ]
        );
        $leafLet->setControls([$zoomControl]);
        $this->assertEquals([$zoomControl], $leafLet->getControls());

        $layers = new Layers();
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new LayerGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);
        $layers->setOverlays(['cities'  => $group]);

        $leafLet->addControl($layers);
        $this->assertEquals([$zoomControl, $layers], $leafLet->getControls());

        $this->setExpectedException('yii\base\InvalidParamException');
        $leafLet->setControls(['wrong']);
    }

    public function testInitException() {
        $this->setExpectedException('yii\base\InvalidConfigException');
        $leafLet = new LeafLet();
    }

    public function testTileLayer() {
        $tileLayer = new TileLayer(
            [
                'map' => 'testMap',
                'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg',
                'clientOptions' => [
                    'attribution' => 'Tiles Courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> ' .
                        '<img src="http://developer.mapquest.com/content/osm/mq_logo.png">, ' .
                        'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                    'subdomains' => '1234'
                ]
            ]
        );
        $leafLet = new LeafLet(
            [
                'tileLayer' => $tileLayer,
                'center' => new LatLng(['lat' => 51.508, 'lng' => -0.11]),
                'zoom' => 13
            ]
        );
        $this->assertEquals('testMap', $leafLet->name);
    }

    public function testLayerGroup() {
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new LayerGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);

        $leafLet = new LeafLet(
            [
                'center' => new LatLng(['lat' => 51.508, 'lng' => -0.11]),
                'zoom' => 13
            ]
        );

        $this->assertEquals([$group], $leafLet->addLayerGroup($group)->getLayerGroups());
        $this->assertEmpty($leafLet->clearLayerGroups()->getLayerGroups());
    }

    public function testJs() {
        $latLngs = [
            new LatLng(['lat' => 39.61, 'lng' => -105.02]),
            new LatLng(['lat' => 39.73, 'lng' => -104.88]),
            new LatLng(['lat' => 39.74, 'lng' => -104.99])
        ];

        $polygon = new Polygon();

        $polygon->setLatLngs($latLngs);
        $polygon->insertAtTheBottom = true;
        $littleton = new Marker(['latLng' => new LatLng(['lat' => 39.61, 'lng' => -105.02])]);
        $denver = new Marker(['latLng' => new LatLng([ 'lat' => 39.74, 'lng' => -104.99])]);

        $group = new LayerGroup();
        $group->addLayer($littleton);
        $group->addLayer($denver);
        $leafLet = new LeafLet(
            [
                'center' => new LatLng(['lat' => 51.508, 'lng' => -0.11]),
                'zoom' => 13
            ]
        );

        $leafLet->addLayer($polygon);
        $leafLet->addLayerGroup($group);
        $leafLet->setJs(['var test = null;']);
        $leafLet->appendJs('var appendedJs = null;');
        $plugin = new TestPlugin([
            'name' => 'testPlugin',
            'clientEvents' => [
                'click' => new JsExpression('function(e){ console.log(e); }')
            ]
        ]);
        $leafLet->installPlugin($plugin);
        $actual = $leafLet->getJs();

        $this->assertEquals(file_get_contents(__DIR__ . '/data/leaflet-js.bin'), implode("\n", $actual));
    }

    public function testWidget() {
        $view = \Yii::$app->getView();
        $content = $view->render('//map-leaflet');
        $actual = $view->render('//layouts/main', ['content' => $content]);

        $expected = file_get_contents(__DIR__ . '/data/test-map-leaflet.bin');
        $this->assertEquals($expected, $actual);
    }

    public function testWidgetConfigHeightNumeric() {
        $view = \Yii::$app->getView();
        $content = $view->render('//map-leaflet-config', ['config' => [
            'height' => 200,
            'options' => [
                'id' => 'w0',
                'style' => 'color:#000;'
            ],
        ]]);
        $actual = $view->render('//layouts/main', ['content' => $content]);

        $expected = file_get_contents(__DIR__ . '/data/test-map-leaflet.bin');
        $this->assertEquals($expected, $actual);
    }

    public function testWidgetConfigHeightPx() {
        $view = \Yii::$app->getView();
        $content = $view->render('//map-leaflet-config', ['config' => [
            'height' => '200px',
            'options' => [
                'id' => 'w0',
                'style' => 'color:#000;'
            ],
        ]]);
        $actual = $view->render('//layouts/main', ['content' => $content]);

        $expected = file_get_contents(__DIR__ . '/data/test-map-leaflet.bin');
        $this->assertEquals($expected, $actual);
    }

    public function testWidgetConfigHeightPercent() {
        $view = \Yii::$app->getView();
        $content = $view->render('//map-leaflet-config', ['config' => [
            'height' => '100%',
            'options' => [
                'id' => 'w0',
                'style' => 'color: #000;'
            ],
        ]]);
        $actual = $view->render('//layouts/main', ['content' => $content]);

        $expected = file_get_contents(__DIR__ . '/data/test-map-leaflet-height-percent.bin');
        $this->assertEquals($expected, $actual);
    }

    public function testPlugins() {
        $leafLet = new LeafLet(
            [
                'center' => new LatLng(['lat' => 51.508, 'lng' => -0.11]),
                'zoom' => 13
            ]
        );
        $plugin = new TestPlugin(['name' => 'test']);

        $leafLet->installPlugin($plugin);
        $this->assertCount(1, $leafLet->getPlugins()->getInstalledPlugins());
        $this->assertEquals($plugin, $leafLet->getPlugins()->getPlugin('test'));
        $this->assertEquals($plugin, $leafLet->plugins->test);
        $this->assertEquals($leafLet->name, $plugin->map);
        $leafLet->removePlugin($plugin);
        $this->assertEmpty($leafLet->getPlugins()->getInstalledPlugins());

        $plugin->setName(null);
        $autogenerated = $plugin->getName(true);
        $this->assertNotNull($plugin->getName());
        $this->assertEquals($autogenerated, $plugin->getName());

        $this->setExpectedException('yii\base\UnknownPropertyException');
        $leafLet->plugins->unknown;
    }
}

class TestPlugin extends Plugin {
    /**
     * Returns the plugin name
     * @return string
     */
    public function getPluginName()
    {
        return 'plugin:TestPlugin';
    }

    /**
     * Registers plugin asset bundle
     *
     * @param \yii\web\View $view
     *
     * @return mixed
     */
    public function registerAssetBundle($view)
    {
        TestAsset::register($view);
    }

    /**
     * Returns the javascript ready code for the object to render
     * @return \yii\web\JsExpression
     */
    public function encode()
    {
        $name = $this->getName();
        $options = $this->getOptions();
        $js = "L.TestPlugin()";
        if($name) {
            $js = "var $name = $js;";
        }
        $js .= "\n" . $this->getEvents();
        return new JsExpression($js);
    }

}

class TestAsset extends AssetBundle {
    public $sourcePath = '@tests/data';

    public $js = [
        'empty-test.js'
    ];
}
