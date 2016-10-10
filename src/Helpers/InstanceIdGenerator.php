<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Etten\LockException;
use Etten\Utils;

class InstanceIdGenerator
{

	/** @var Utils\Lock */
	public static $lock;

	public static function generate(): int
	{
		$lock = self::tryOpenLock();

		$id = (int)trim($lock->read());
		$lock->write(++$id);

		$lock->close();

		return $id;
	}

	private static function tryOpenLock(): Utils\Lock
	{
		$timeout = 10000; // 10000 μs = 10 ms
		$repeats = 100; // 100 * $timeout = 1000 ms = 1 s

		while (TRUE) {
			$repeats--;

			try {
				self::$lock->open();
				return self::$lock;
			} catch (LockException $e) {
				if ($repeats > 0) {
					usleep($timeout);
					continue;
				} else {
					throw $e;
				}
			}
		}

		throw new \RuntimeException('Cannot acquire a lock.');
	}

}
