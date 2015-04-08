<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\types;

use yii\base\InvalidConfigException;
use yii\web\JsExpression;


/**
 * Bounds represents a rectangular area in pixel coordinates.
 *
 * @see http://leafletjs.com/reference.html#bounds
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\types
 */

/**
 * @property Point $min
 * @property Point $max
 */
class Bounds extends Type implements ArrayableInterface
{

    /**
     * @var Point the top left corner of the rectangle
     */
    private $_min;

    /**
     * @var Point the bottom right corner of the rectangle
     */
    private $_max;

    /**
     * @param Point $max
     */
    public function setMax(Point $max)
    {
        $this->_max = $max;
    }

    /**
     * @return Point
     */
    public function getMax()
    {
        return $this->_max;
    }

    /**
     * @param Point $min
     */
    public function setMin(Point $min)
    {
        $this->_min = $min;
    }

    /**
     * @return Point
     */
    public function getMin()
    {
        return $this->_min;
    }

    /**
     * Initializes the object
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (empty($this->min) || empty($this->max)) {
            throw new InvalidConfigException("'min' and 'max' attributes cannot be empty.");
        }
    }

    /**
     * @return \yii\web\JsExpression the js initialization code of the object
     */
    public function encode()
    {
        $min = $this->getMin()->toArray(true);
        $max = $this->getMax()->toArray(true);

        return new JsExpression("L.bounds($min, $max)");
    }

    /**
     * Converts the object into an array.
     *
     * @param bool $encode whether to return the array json_encoded or raw
     *
     * @return array the array representation of this object
     */
    public function toArray($encode = false)
    {
        $min = $this->getMin()->toArray($encode);
        $max = $this->getMax()->toArray($encode);
        return $encode ? "[$min, $max]" : [$min, $max];
    }


}
