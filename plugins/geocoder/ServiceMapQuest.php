<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\geocoder;

use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * ServiceMapQuest provides the required code and js files to use MapQuest geocoding service
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\geocoder
 */
class ServiceMapQuest extends BaseService
{
    /**
     * @var string the MapQuest's API key
     */
    public $key;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if($this->key === null) {
            throw new InvalidConfigException('"$key" cannot be empty.');
        }
    }

    /**
     * @inheritdoc
     */
    public function registerAssetBundle($view)
    {
        ServiceMapQuestAsset::register($view);
    }

    /**
     * @return \yii\web\JsExpression the javascript code for the geocoder option to be set
     */
    public function getJs()
    {
        return new JsExpression("L.Control.Geocoder.mapQuest('{$this->key}')");
    }

} 