<?php

namespace Aposoftworks\LaravelUtilities\Traits;

trait Clearable {
    public static function clear () {
		$key = static::getModel()->primaryKey;
		return static::getModel()->whereNotNull($key)->delete();
    }
}
