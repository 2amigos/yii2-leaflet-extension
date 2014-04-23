<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\geocoder;

use yii\base\Object;

/**
 * BaseService
 *
 * Is the base class
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\geocoder
 */
abstract class BaseService extends Object
{
    /**
     * Registers the required assets for the service to work
     * @param \yii\web\View $view
     */
    abstract public function registerAssetBundle($view);

    /**
     * @return \yii\web\JsExpression the javascript code for the geocoder option to be set
     */
    abstract public function getJs();
} 