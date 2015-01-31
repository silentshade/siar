<?
class LoginController extends Controller
{

	public $layout='/layouts/admin_column';

	public function init()
	{
		Yii::app()->getComponent('bootstrap');
		return parent::init();
	}

	public function actionIndex()
    {
		Yii::app()->getComponent('bootstrap');
		$this->layout='/layouts/admin_column';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->refresh();
				//$this->redirect(Yii::app()->user->returnUrl!='/' ? Yii::app()->user->returnUrl : '/admin');
		}
		// display the login form
		$this->render('login',array('model'=>$model));
    }

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}