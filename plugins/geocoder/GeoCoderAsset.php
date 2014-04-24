<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\geocoder;

use yii\web\AssetBundle;

/**
 * GeoCoderAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\geocoder
 */
class GeoCoderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/2amigos/yii2-leaflet-geocoder-plugin/assets';

    public $css = [
        'css/l.geocoder.css'
    ];

    public $js = [
        'js/l.control.geocoder.js'
    ];
} 