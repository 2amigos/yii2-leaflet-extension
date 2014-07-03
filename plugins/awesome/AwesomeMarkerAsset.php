<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\awesome;

use yii\web\AssetBundle;

/**
 * AwesomeMarkerAsset
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\awesome
 */
class AwesomeMarkerAsset extends AssetBundle
{
    public $sourcePath = '@common/extensions/leafletAwesomePlugin/assets';

    public $css = ['css/leaflet.awesome-markers.css'];

    public $depends = [
        'dosamigos\leaflet\LeafLetAsset',
    ];

    public function init()
    {
        $this->js[] = YII_DEBUG ? 'js/leaflet.awesome-markers.js' : 'js/leaflet.awesome-markers.min.js';
    }
}
