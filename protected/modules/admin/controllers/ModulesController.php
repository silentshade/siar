<?php
class ModulesController extends CAdminController
{
	public function actionIndex() {
		AdminHelper::scanModules();

		$model=new AdminModules('search');
		$model->unsetAttributes();
		if(isset($_GET['AdminModules']))
		$model->attributes=$_GET['AdminModules'];

		$this->render('index',array('model'=>$model));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Config'])){
			$model->saveParams();
			$this->redirect(array('index'));
		}

		$params=Config::model()->findAllByAttributes(array('module'=>$model->module));

		$sizes=new AdminImagesSizes('search');
		$sizes->unsetAttributes();
		if(isset($_GET['AdminImagesSizes']))
		$sizes->attributes=$_GET['AdminImagesSizes'];
		$sizes->module=$model->module;

		$this->render('update',array(
			'model'=>$model,
			'params'=>$params,
			'sizes'=>$sizes,
		));
	}

	public function loadModel($id)
	{
		$model=AdminModules::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionTurnModule($id)
	{
		$model=$this->loadModel($id);
		$str=ucfirst($model->module).'InstallHelper';
		Yii::import($model->module.'.install.'.  ucfirst($model->module).'InstallHelper');
		Yii::import('admin.models.AdminModules');
		$ih=new $str($model->module);

		if($_GET['action']=='OFF' && $model->delete)
			$ih->uninstall();
		if($_GET['action']=='ON')
			$ih->install();
	}

	public function actionEditable()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['pk']) && !empty($_POST['pk'])) {
                $model=AdminImagesSizes::model()->findByPk($_POST['pk']);
                $model->$_POST['name'] = $_POST['value'];
                if ($model->validate()){
					if($model->save()){
						AdminHelper::regenerateImage(Yii::getPathOfAlias('webroot.images').'/'.Yii::app()->getModule($model->module)->path_images, $model);
					}
				}
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

	public function actionDelete_size(){
		$size=AdminImagesSizes::model()->findByPk($_GET['id']);

		AdminHelper::removeDir(Yii::getPathOfAlias('webroot.images').'/'.Yii::app()->getModule($size->module)->path_images.'/'.$size->size);
		$size->delete();
	}

	public function actionCreate_size(){
		if(isset($_POST['AdminImagesSizes'])){
			$count=AdminImagesSizes::model()->countByAttributes(array('module'=>$_POST['AdminImagesSizes']['module'],'size'=>$_POST['AdminImagesSizes']['size']));
			if($count){
				echo 'Такой размер уже существует, введите другой';
			}else{
				$size=new AdminImagesSizes();
				$size->attributes=$_POST['AdminImagesSizes'];
				if($size->save()){
					AdminHelper::regenerateImage(Yii::getPathOfAlias('webroot.images').'/'.Yii::app()->getModule($size->module)->path_images, $size);
				}
			}
		}
	}
}
