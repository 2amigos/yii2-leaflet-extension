<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\layers;


use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * TileLayer is used to load and display tile layers on the map
 *
 * @see http://leafletjs.com/reference.html#tilelayer
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\layers
 */
class TileLayer extends Layer
{

    /**
     * @var string a template has the following form:
     *
     * ```
     * 'http://{s}.somedomain.com/blabla/{z}/{x}/{y}.png'
     * ```
     *
     * {s} means one of the available subdomains (used sequentially to help with browser parallel requests per domain
     * limitation; subdomain values are specified in options; a, b or c by default, can be omitted), {z} — zoom level,
     * {x} and {y} — tile coordinates.
     *
     * You can use custom keys in the template, which will be evaluated from TileLayer options, like this:
     *
     * ```
     * $layer = new TileLayer([
     *    'urlTemplate' => 'L.tileLayer('http://{s}.somedomain.com/{foo}/{z}/{x}/{y}.png',
     *    'clientOptions' => [
     *        'foo' => 'bar'
     *    ]
     * ]);
     * ```
     */
    public $urlTemplate;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (empty($this->urlTemplate)) {
            throw new InvalidConfigException("'urlTemplate' cannot be empty.");
        }
    }

    /**
     * @return \yii\web\JsExpression the marker constructor string
     */
    public function encode()
    {
        $options = $this->getOptions();
        $name = $this->getName();
        $map = $this->map;
        $js = "L.tileLayer('$this->urlTemplate', $options)" . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
            $js .= $this->getEvents();
        }

        return new JsExpression($js);
    }
}
