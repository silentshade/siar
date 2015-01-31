<?php

class MainController extends FrontController
{
	public $layout='admin.views.layouts.admin_no_column';
	public $install=false;

	public function init()
	{
		Yii::app()->getComponent('bootstrap');

		try{
			Yii::app()->db;
			$this->install=true;
		} catch (Exception $e) {
			$this->install=false;
		}

		if($this->install)
			throw new CHttpException(404,'The requested page does not exist.');

		return parent::init();
	}

	public function actionIndex()
	{
		$model=new InstallForm();
		$modules=AdminHelper::returnModules();

		if(isset($_POST['InstallForm'])) {
            $model->attributes=$_POST['InstallForm'];
            if($model->validate())
            {
				try
                {
					$connectionString = "mysql:host={$model->db_host};dbname={$model->db_name};port={$model->db_port}";
                    $connection = new CDbConnection($connectionString, $model->db_user, $model->db_password);
                    $connection->connectionString = $connectionString;
                    $connection->username = $model->db_user;
                    $connection->password = $model->db_password;
                    $connection->emulatePrepare = true;
                    $connection->charset = 'utf8';
                    $connection->tablePrefix = '';
                    $connection->active = true;

                    Yii::app()->setComponent('db', $connection);

                    $dbParams = array(
                        'class' => 'CDbConnection',
                        'connectionString' => $connectionString,
                        'username' => $model->db_user,
                        'password' => $model->db_password,
                        'emulatePrepare' => true,
                        'charset' => 'utf8',
                        'enableParamLogging' => false,
                        'enableProfiling' => false,
                        'schemaCachingDuration' => 3600,
                        'tablePrefix' => ''
                    );


					$db_config = Yii::app()->basePath . "/config/db.php";

                    $fw = fopen($db_config, 'w+');

                    if (!$fw) {
                        $model->addError('', "Не могу открыть файл '{$db_config}' для записи!");
                    } else {
                        fwrite($fw, "<?php\n return " . var_export($dbParams, true) . " ;\n?>");
                        fclose($fw);

                        @chmod($db_config, 0666);

						if(file_exists(Yii::app()->basePath.'/modules/admin/install/AdminInstallHelper.php')){
							Yii::import('admin.install.AdminInstallHelper');
							$ih=new AdminInstallHelper('admin');
							$ih->install();
						}

						Yii::import('admin.models.AdminModules');
						foreach ($modules as $name_module=>$module) {
							$installed=false;
							//if(($module->not_menu || !$module->delete) || isset($_POST['Module'][$name_module])){
							if(!$module->delete || (isset($_POST['Module'][$name_module]) && $_POST['Module'][$name_module]==1)){
								$name_class_install=ucfirst($name_module).'InstallHelper';

								if(file_exists(Yii::app()->basePath.'/modules/'.$name_module.'/install/'.$name_class_install.'.php')){
									Yii::import($name_module.'.install.'.$name_class_install);
									$ih=new $name_class_install($name_module);
									$ih->install();
									$installed=true;
								}
							}

							if(!$module->not_menu){
								$find=new AdminModules();
								$find->module=$name_module;
								$find->name=$module->name;
								$find->version=$module->version;
								$find->delete=(int)$module->delete;
								$find->state=(int)$installed;
								$find->save();
							}
						}

						Yii::import('users.models.User');
						$user=new User();
						$user->email=$model->admin_email;
						$user->password=$user->hashPassword($model->admin_password);
						$user->admin=1;
						if($user->save()){
							$identity=new UserIdentity($user->email,$model->admin_password);
							$identity->authenticate();
							if($identity->errorCode===UserIdentity::ERROR_NONE)
							{
								$duration=3600*24*30; // 30 days
								Yii::app()->user->login($identity,$duration);
							}
						}

                        $this->redirect(array('/admin'));
                    }

                } catch (Exception $e) {
                    $model->addError('', $e->getMessage());
                }
            }
        }

		$this->render('/index',array('model'=>$model,'modules'=>$modules));
	}
}