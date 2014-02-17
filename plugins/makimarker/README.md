Maki Marker Plugin
======================

Yii 2 [LeafletJs](http://leafletjs.com/) Plugin to create map icons using Maki Icons from MapBox. Markers are retrieved
from MapBox's [Static Marker Api](https://www.mapbox.com/developers/api/#Stand-alone.markers).

This Plugin works in conjunction with [LeafLet](https://github.com/2amigos/yii2-leaflet-extension)
library for [Yii 2](https://github.com/yiisoft/yii2) framework.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "2amigos/yii2-leaflet-makimarker-plugin" "*"
```
or add

```json
"2amigos/yii2-leaflet-makimarker-plugin" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----

Using its `make` method:

```
// LeafLet initialization component
// ...

// Initialize plugin
$makimarkers = new dosamigos\leaflet\plugins\makimarker\MakiMarker(['name' => 'makimarker']);

// install
$leafLet->installPlugin($makimarkers);

// sample location
$center = new dosamigos\leaflet\types\LatLng(['lat' => 51.508, 'lng' => -0.11]);

// generate icon through its icon
$marker = new dosamigos\leaflet\layers\Marker([
    'latLng' => $center,
	'icon' => $leafLet->plugins->makimarker->make("rocket",['color' => "#b0b", 'size' => "m"]),
    'popupContent' => 'Hey! I am a marker'
]);

```


> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)

<i>Web development has never been so fun!</i>
[www.2amigos.us](http://www.2amigos.us)