<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet;

use yii\web\AssetBundle;

/**
 * LeafLetAsset Registers widget requires files. Please, use the following in order to override bundles for CDN:
 *
 * ```
 *  return [
 *        // ...
 *        'components' => [
 *            'bundles' => [
 *                'dosamigos\leaftlet\LeafLetAsset' => [
 *                    'sourcePath' => null,
 *                    'js' => [ 'http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js' ],
 *                    'css' => [ 'http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css' ]
 *                ]
 *            ]
 *        ]
 *    ]
 * ```
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet
 */
class LeafLetAsset extends AssetBundle
{
    public $sourcePath = '@bower/leaflet/dist';

    public $css = [
        'leaflet.css'
    ];

    public $js = [
        'leaflet-src.js'
    ];
}