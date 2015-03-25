<?php
/**
 *
 * PopupTrait.php
 *
 * Date: 15/02/14
 * Time: 11:03
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */

namespace dosamigos\leaflet\layers;


trait PopupTrait
{
    /**
     * @var string the HTML content of the popup to display when clicking on the marker.
     */
    public $popupContent;
    /**
     * @var bool whether to open the popup dialog on display.
     */
    public $openPopup = false;

    /**
     * Binds popup content (if any) to the js code to register
     *
     * @param string $js
     *
     * @return string
     */
    protected function bindPopupContent($js)
    {
        if (!empty($this->popupContent)) {
            $content = addslashes($this->popupContent);
            $js .= ".bindPopup(\"{$content}\")";
            if ($this->openPopup) {
                $js .= ".openPopup()";
            }
        }
        return $js;
    }
}
