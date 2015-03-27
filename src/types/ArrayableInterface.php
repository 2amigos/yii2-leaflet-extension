<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\types;


/**
 * Arrayable should be implemented by classes that need to be represented in array format.
 *
 * @package dosamigos\leaflet\types
 */
interface ArrayableInterface
{
    /**
     * Converts the object into an array.
     *
     * @param bool $encode whether to return the array json_encoded or raw
     *
     * @return array the array representation of this object
     */
    public function toArray($encode = false);
}
