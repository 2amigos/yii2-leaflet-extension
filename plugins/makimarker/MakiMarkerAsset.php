<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\makimarker;


use yii\web\AssetBundle;

/**
 * MakiMarkerAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\markercluster
 */
class MakiMarkerAsset extends AssetBundle
{

	public $sourcePath = '@vendor/2amigos/yii2-2amigos-makimarker-plugin/assets';

	public $js = ['js/Leaflet.MakiMarkers.js'];

	public $depends = [
		'dosamigos\leaflet\LeafLetAsset',
	];
} 