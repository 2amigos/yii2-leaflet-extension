Geo Search Plugin
=================

Yii 2 [LeafletJs](http://leafletjs.com/) Plugin that adds support for address lookup to
Leaflet with dropdown list capabilities and loading icon feedback. This Plugin works in conjunction with
[LeafLet](https://github.com/2amigos/yii2-leaflet-extension) library for [Yii 2](https://github.com/yiisoft/yii2)
framework.

***Important***
The libraries used on this plugin have been modified from
[the original plugin source](https://github.com/perliedman/leaflet-control-geocoder). So, if you wish to modify the
plugin, remember that you cannot update it from its original source.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "2amigos/yii2-leaflet-geocoder-plugin" "*"
```
or add

```json
"2amigos/yii2-leaflet-geocoder-plugin" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----

There are four services that you can use, even though we have implemented only three:

- Nominatim
- Bing
- MapQuest

Anybody will to help integrate more services, is very welcome :)



```
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\types\LatLng;
use backend\extensions\leaflet\ServiceNominatim;
use backend\extensions\leaflet\GeoCoder;


// lets use nominating service
$nominatim = new ServiceNominatim();

// create geocoder plugin and attach the service
$geoCoderPlugin = new GeoCoder([
    'service' => $nominatim,
    'clientOptions' => [
        // we could leave it to allocate a marker automatically
        // but I want to have some fun
        'showMarker' => false
    ]
]);

// add a marker to center
$marker = new Marker([
    'name' => 'geoMarker',
    'latLng' => $center,
    'clientOptions' => ['draggable' => true], // draggable marker
    'clientEvents' => [
        'dragend' => 'function(e){
            console.log(e.target._latlng.lat, e.target._latlng.lng);
        }'
    ]
]);

// configure the tile layer
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

// initialize our leafLet component
$leafLet = new LeafLet([
    'name' => 'geoMap',
    'tileLayer' => $tileLayer,
    'center' => $center,
    'zoom' => 10,
    'clientEvents' => [
        // I added an event to ease the collection of new position
        'geocoder_showresult' => 'function(e){
            // set markers position
            geoMarker.setLatLng(e.Result.center);
        }'
    ]
]);

// add the marker
$leafLet->addLayer($marker);

// install the plugin
$leafLet->installPlugin($geoCoderPlugin);

// run the widget (you can also use dosamigos\leaflet\widgets\Map::widget([...]))
echo $leafLet->widget();

```


> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)

<i>Web development has never been so fun!</i>
[www.2amigos.us](http://www.2amigos.us)