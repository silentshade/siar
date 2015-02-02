<?php

class FeedModule extends Module
{
	public $version='1';
	public $name='RSS';
	public $path_images='';
	public $model='';

	public static function rules()
    {
        return array(
            'feed'=>'feed/main/index',
        );
    }
}
