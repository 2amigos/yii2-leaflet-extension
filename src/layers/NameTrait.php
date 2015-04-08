<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\leaflet\layers;


use dosamigos\leaflet\LeafLet;

trait NameTrait
{
    /**
     * @var string the variable name. If not null, then the js creation script
     * will be returned as a variable. If null, then the js creation script will
     * be returned as a constructor that you can use on other object's configuration options.
     */
    private $_name;

    /**
     * Returns the name of the layer.
     *
     * @param boolean $autoGenerate whether to generate a name if it is not set previously
     *
     * @return string name of the layer.
     */
    public function getName($autoGenerate = false)
    {
        if ($autoGenerate && $this->_name === null) {
            $this->_name = LeafLet::generateName();
        }
        return $this->_name;
    }

    /**
     * Sets the name of the layer.
     *
     * @param string $value name of the layer.
     */
    public function setName($value)
    {
        $this->_name = $value;
    }
}
