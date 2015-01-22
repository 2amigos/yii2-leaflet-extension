<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\markercluster;


use yii\web\AssetBundle;

/**
 * MarkerClusterAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\markercluster
 */
class MarkerClusterAsset extends AssetBundle
{

    public $css = [
        'css/MarkerCluster.css',
        'css/MarkerCluster.Default.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'dosamigos\leaflet\LeafLetAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        $this->js = YII_DEBUG ? ['js/leaflet.markercluster-src.js'] : ['js/leaflet.markercluster.js'];
    }
} 