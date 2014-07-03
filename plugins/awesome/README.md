Awesome Plugin
==============

Yii 2 [LeafletJs](http://leafletjs.com/) Plugin to create map icons using [Font Awesome](http://fontawesome.io/) Icons.

This Plugin works in conjunction with [LeafLet](https://github.com/2amigos/yii2-leaflet-extension)
library for [Yii 2](https://github.com/yiisoft/yii2) framework and [Font Awesome](http://fontawesome.io/) iconic font
and css toolkit.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "2amigos/yii2-leaflet-awesome-plugin" "*"
```
or add

```json
"2amigos/yii2-leaflet-awesome-plugin" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----

```
// LeafLet initialization component
// ...

// Initialize plugin
$awesomeMarkers = new dosamigos\leaflet\plugins\awesome\AwesomeMarker(['name' => 'awesome']);

// install
$leafLet->installPlugin($awesomeMarkers);

// sample location
$center = new dosamigos\leaflet\types\LatLng(['lat' => 51.508, 'lng' => -0.11]);

// generate icon through its icon
$marker = new dosamigos\leaflet\layers\Marker([
    'latLng' => $center,
	'icon' => $leafLet->plugins->awesome->make("start",['markerColor' => "green", 'prefix' => "fa"]),
    'popupContent' => 'Hey! I am a marker'
]);

```


> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)

<i>Web development has never been so fun!</i>
[www.2amigos.us](http://www.2amigos.us)