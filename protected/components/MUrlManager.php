<?php
// TODO: Возможно подключать как в eximus отдельными файлами
/**
 * Load Module Routes
 */
class MUrlManager extends CUrlManager
{
	public function init()
	{
		$this->loadModulesUrl();
		parent::init();
	}

	/**
	 * Scan each module dir and include routes.php
	 * Add module urls at the beginning of $config['urlManager']['rules']
	 * @access protected
	 */
	protected function loadModulesUrl()
	{
		$cacheId = 'modules_urls';
		$cache=Yii::app()->getComponent('cache');
		if($cache!==null){
			$rules    = $cache->get($cacheId);
		}

		if(!$rules)
		{
			$rules       = array();
			$dirs = scandir(dirname(__FILE__).'/../modules');

			$modules = array();
			foreach ($dirs as $name){
				if ($name[0] != '.' && $name<>'admin')
					$modules[ucfirst($name).'Module'] = 'application.modules.' . $name . '.' . ucfirst($name) . 'Module';
			}

			foreach($modules as $name=>$module)
			{
				Yii::import($module);
                if(method_exists($name, 'rules'))
                {
					$rules = array_merge(call_user_func($name .'::rules'), $rules);
                }
			}

			if($cache!==null){
				$cache->set($cacheId, $rules, 3600);
			}
		}

		$this->rules = array_merge($rules, $this->rules);
	}

}
