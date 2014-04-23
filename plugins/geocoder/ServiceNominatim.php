<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\plugins\geocoder;

use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * ServiceNominatim provides the required code and js files to use Nominatim geocoding service
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\plugins\geocoder
 */
class ServiceNominatim extends BaseService
{
    /**
     * @var string the URL of the service
     */
    public $serviceUrl = 'http://nominatim.openstreetmap.org/';
    /**
     * @var array additional URL parameters (strings) that will be added to geocoding requests
     */
    public $geocodingQueryParams = [];
    /**
     * @var array additional URL parameters (strings) that will be added to reverse geocoding requests
     */
    public $reverseQueryParams = [];

    /**
     * @inheritdoc
     */
    public function registerAssetBundle($view)
    {
        ServiceNominatimAsset::register($view);
    }

    /**
     * @return \yii\web\JsExpression the javascript code for the geocoder option to be set
     */
    public function getJs()
    {
        $options['serviceUrl'] = $this->serviceUrl;
        $options['geocodingQueryParams'] = !empty($this->geocodingQueryParams) ? $this->geocodingQueryParams : '{}';
        $options['reverseQueryParams'] = !empty($this->reverseQueryParams) ? $this->reverseQueryParams : '{}';
        $options = Json::encode($options);
        return new JsExpression("L.Control.Geocoder.nominatim({$options})");
    }

} 