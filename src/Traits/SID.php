<?php

namespace Aposoftworks\LaravelUtilities\Traits;

trait SID {
	//Disable integer autoincrement
	public $incrementing = false;

    public static function bootSID() {
        static::creating(function ($model) {
			$lenght 	= isset($model->sidSize) ? $model->sidSize:11;
			$primaryKey = $model->primaryKey;

        	if (!isset($model->{$primaryKey}) || is_null($model->{$primaryKey}) || $model->{$primaryKey} == "")
            	$model->id = substr(bin2hex(random_bytes(ceil($lenght / 2))), 0, $lenght);
        });
    }
}
