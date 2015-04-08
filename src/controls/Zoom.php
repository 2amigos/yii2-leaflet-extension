<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\controls;

use yii\web\JsExpression;

/**
 * Zoom renders basic zoom control with two buttons (zoom in and zoom out). It is put on the map by default unless you
 * set the map's zoomControl option to false
 *
 * @see http://leafletjs.com/reference.html#control-zoom
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\leaflet\controls
 */
class Zoom extends Control
{
    /**
     * Returns the javascript ready code for the object to render
     * @return \yii\web\JsExpression
     */
    public function encode()
    {
        $this->clientOptions['position'] = $this->position;
        $options = $this->getOptions();
        $name = $this->getName();
        $map = $this->map;
        $js = "L.control.zoom($options)" . ($map !== null ? ".addTo($map);" : "");
        if (!empty($name)) {
            $js = "var $name = $js" . ($map !== null ? "" : ";");
        }
        return new JsExpression($js);
    }

}
