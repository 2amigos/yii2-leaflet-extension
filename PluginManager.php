<?php
/**
 *
 * PluginManager.php
 *
 * Date: 17/02/14
 * Time: 04:56
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */

namespace dosamigos\leaflet;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class PluginManager extends Component
{
	private $_plugins = [];

	/**
	 * Check whether we have a plugin installed with that name previous firing up the call
	 * @param string $name
	 * @return mixed|void
	 */
	public function __get($name)
	{
		if (ArrayHelper::keyExists($name, $this->getPlugins())) {
			return $this->getPlugin($name);
		}
		return parent::__get($name);
	}

	/**
	 * Installs a plugin
	 * @param Plugin $plugin
	 * @return void
	 */
	public function install(Plugin $plugin)
	{
		$this->_plugins[$plugin->name] = $plugin;
	}

	/**
	 * Removes a plugin
	 * @param Plugin $plugin
	 * @return mixed|null the value of the element if found, default value otherwise
	 */
	public function remove(Plugin $plugin)
	{
		return ArrayHelper::remove($this->_plugins, $plugin->name);
	}

	/**
	 * @param \yii\web\View $view
	 * Registers plugin bundles
	 */
	public function registerAssetBundles($view)
	{
		foreach ($this->_plugins as $plugin) {
			$plugin->registerAssetBundle($view);
		}
	}

	/**
	 * @return array of installed plugins
	 */
	public function getInstalledPlugins()
	{
		return $this->_plugins;
	}

	/**
	 * Returns an installed plugin by name
	 * @param string $name
	 * @return Plugin|null
	 */
	public function getPlugin($name)
	{
		return isset($this->_plugins[$name]) ? $this->_plugins[$name] : null;
	}
} 