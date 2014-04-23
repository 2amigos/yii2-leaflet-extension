Geo Search Plugin
=================

Yii 2 [LeafletJs](http://leafletjs.com/) Plugin that adds support for address lookup (a.k.a. geocoding / geoseaching) to
Leaflet. This Plugin works in conjunction with [LeafLet](https://github.com/2amigos/yii2-leaflet-extension) library for
[Yii 2](https://github.com/yiisoft/yii2) framework.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "2amigos/yii2-leaflet-geosearch-plugin" "*"
```
or add

```json
"2amigos/yii2-leaflet-geosearch-plugin" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----

```
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\plugins\geosearch\GeoSearch;

$center = new LatLng(['lat' => 39.67442740076734, 'lng' => 2.9347229003906246]);

$geoSearchPlugin = new GeoSearch([
    'service' => GeoSearch::SERVICE_OPENSTREETMAP
]);

$tileLayer = new TileLayer([
    'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg',
    'clientOptions' => [
        'attribution' => 'Tiles Courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> ' .
            '<img src="http://developer.mapquest.com/content/osm/mq_logo.png">, ' .
            'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' .
            '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
        'subdomains' => '1234'
    ]
]);

$leafLet = new LeafLet([
    'name' => 'geoMap',
    'tileLayer' => $tileLayer,
    'center' => $center,
    'zoom' => 10,
    'clientEvents' => [
        // setting up one of the geo search events for fun
        'geosearch_showlocation' => 'function(e){
            console.log(e.target);
        }'
    ]
]);

// add the plugin
$leafLet->installPlugin($geoSearchPlugin);

// run the widget (you can also use dosamigos\leaflet\widgets\Map::widget([...]))
echo $leafLet->widget();

```


> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)

<i>Web development has never been so fun!</i>
[www.2amigos.us](http://www.2amigos.us)