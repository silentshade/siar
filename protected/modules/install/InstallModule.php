<?php

class InstallModule extends Module
{
	public $version='1';
	public $name='Установка';
	public $model=InstallForm;
	public $not_menu=true;
	public $delete=false;
}
