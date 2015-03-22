<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\types;

use yii\base\Component;

/**
 * Type is the abstract class for all Types
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\types
 */
abstract class Type extends Component
{
    /**
     * @return string|\yii\web\JsExpression the js initialization code of the object
     */
    abstract public function encode();
}
