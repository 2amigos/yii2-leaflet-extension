<?php
/**
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\leaflet\widgets;

use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\LeafLetAsset;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Widget Map renders the map using the LeafLet component configurations for rendering on the view.
 * *Important* It is very important to specify the height of the widget, whether with a class name or through an inline
 * style. Failing to configure the height may have unexpected rendering results.
 *
 * @package dosamigos\leaflet\widgets
 */
class Map extends Widget
{
    /**
     * @var \dosamigos\leaflet\LeafLet component holding all configuration
     */
    public $leafLet;
    /**
     * @var int the height of the map. Failing to configure the height of the map, will result in
     * unexpected results.
     */
    public $height = 200;
    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];

    /**
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if (empty($this->leafLet) || !($this->leafLet instanceof LeafLet)) {
            throw new InvalidConfigException(
                "'leafLet' attribute cannot be empty and should be of type LeafLet component."
            );
        }
        $inlineStyles = ArrayHelper::getValue($this->options, 'style');
        if ($inlineStyles) {
            $styles = explode(';', $inlineStyles);
            $styles[] = "height:{$this->height}px";
            $this->options['style'] = implode(";", array_filter($styles));
        } else {
            // @codeCoverageIgnoreStart
            $this->options['style'] = "height:{$this->height}px;";
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Renders the map
     * @return string|void
     */
    public function run()
    {
        echo "\n" . Html::tag('div', '', $this->options);
        $this->registerScript();
    }

    /**
     * Register the script for the map to be rendered according to the configurations on the LeafLet
     * component.
     */
    public function registerScript()
    {
        $view = $this->getView();

        LeafLetAsset::register($view);
        $this->leafLet->getPlugins()->registerAssetBundles($view);

        $id = $this->options['id'];
        $name = $this->leafLet->name;
        $js = $this->leafLet->getJs();

        $clientOptions = $this->leafLet->clientOptions;

        $options = empty($clientOptions) ? '{}' : Json::encode($clientOptions, LeafLet::JSON_OPTIONS);
        array_unshift($js, "var $name = L.map('$id', $options);");
        if ($this->leafLet->getTileLayer() !== null) {
            $js[] = $this->leafLet->getTileLayer()->encode();
        }

        $clientEvents = $this->leafLet->clientEvents;

        if (!empty($clientEvents)) {
            foreach ($clientEvents as $event => $handler) {
                $js[] = "$name.on('$event', $handler);";
            }
        }
        $view->registerJs("function {$name}_init(){\n" . implode("\n", $js) . "}\n{$name}_init();");
    }
}
