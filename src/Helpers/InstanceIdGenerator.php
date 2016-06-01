<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

class InstanceIdGenerator
{

	/** @var Storage */
	public static $storage;

	public static function generate():int
	{
		$storage = self::$storage;
		if (!$storage) {
			throw new \RuntimeException('self::$storage is not set.');
		}

		$id = (int)trim($storage->read());
		$storage->write(++$id);

		return $id;
	}

}
