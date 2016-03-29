<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

class InstanceIdGenerator
{

	/** @var string */
	public static $path = '';

	public static function generate():int
	{
		if (!self::$path) {
			throw new \RuntimeException('self::$path is not set.');
		}

		$id = (int)file_get_contents(self::$path) + 1;
		file_put_contents(self::$path, $id);
		return $id;
	}

}
