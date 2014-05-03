LeafLet Extension for Yii2
==========================

Extension library to display interactive maps with [LeafletJs](http://leafletjs.com/)

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "2amigos/yii2-leaflet-extension" "*"
```
or add

```json
"2amigos/yii2-leaflet-extension" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----

One of the things to take into account when working with [LeafletJs](http://leafletjs.com/) is that we need a Tile
Provider. Is very important, if we fail to provide a Tile Provider Url, the map will display plain, without any maps at
all.

The following example, is making use of [MapQuest](http://developer.mapquest.com/):

```
// first lets setup the center of our map
$center = new dosamigos\leaflet\types\LatLng(['lat' => 51.508, 'lng' => -0.11]);

// now lets create a marker that we are going to place on our map
$marker = new \dosamigos\leaflet\layers\Marker(['latLng' => $center, 'popupContent' => 'Hi!']);

// The Tile Layer (very important)
$tileLayer = new \dosamigos\leaflet\layers\TileLayer([
   'urlTemplate' => 'http://otile{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.jpeg',
    'clientOptions' => [
        'attribution' => 'Tiles Courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> ' .
        '<img src="http://developer.mapquest.com/content/osm/mq_logo.png">, ' .
        'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
        'subdomains' => '1234'
    ]
]);

// now our component and we are going to configure it
$leaflet = new \dosamigos\leaflet\LeafLet([
    'tileLayer' => $tileLayer, // set the TileLayer
    'center' => $center, // set the center
]);
$leaflet->addLayer($marker); // add the marker (addLayer is used to add different layers to our map)

// finally render the widget
echo \dosamigos\leaflet\widgets\Map::widget(['leafLet' => $leaflet]);

// we could also do
// echo $leaflet->widget();
```

Further Information
-------------------

For further information regarding the multiple settings of LeafLetJS library please visit
[its API reference](http://leafletjs.com/reference.html)


> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)

<i>Web development has never been so fun!</i>
[www.2amigos.us](http://www.2amigos.us)