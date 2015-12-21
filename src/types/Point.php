<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\types;

use dosamigos\leaflet\LeafLet;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Point represents a point with x and y coordinates in pixels.
 *
 * ```
 *  $map->panBy(new Point(['x' => 200, 'y' => '300']));
 * ```
 *
 * @see http://leafletjs.com/reference.html#point
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\types
 */
class Point extends Type implements ArrayableInterface
{
    /**
     * @var float x coordinate
     */
    public $x;
    /**
     * @var float y coordinate
     */
    public $y;
    /**
     * @var bool if round is set to true, LetLeaf will round the x and y values.
     */
    public $round = false;

    /**
     * Initializes the class
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (empty($this->x) || empty($this->y)) {
            throw new InvalidConfigException("'x' or 'y' cannot be empty.");
        }
    }

    /**
     * @return \yii\web\JsExpression the js initialization code of the object
     */
    public function encode()
    {
        $x = $this->x;
        $y = $this->y;
        return new JsExpression("L.point($x, $y)"); // no semicolon
    }

    /**
     * Returns the point values as array
     *
     * @param bool $encode whether to return the array json_encoded or raw
     *
     * @return array|JsExpression
     */
    public function toArray($encode = false)
    {
        $point = [$this->x, $this->y];
        return $encode ? new JsExpression(Json::encode($point, LeafLet::JSON_OPTIONS)) : $point;
    }
}
