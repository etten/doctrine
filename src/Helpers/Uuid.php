<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Doctrine\DBAL\Types\ConversionException;
use Ramsey;

class Uuid
{

	public static function binaryToHex($value)
	{
		$uuid = Ramsey\Uuid\Uuid::fromBytes($value);
		return $uuid->getHex();
	}

	public static function binaryToString($value)
	{
		$uuid = Ramsey\Uuid\Uuid::fromBytes($value);
		return $uuid->toString();
	}

	public static function hexToBinary($value)
	{
		$uuid = Ramsey\Uuid\Uuid::fromString($value);
		return $uuid->getBytes();
	}

	public static function stringToBinary($value)
	{
		$uuid = Ramsey\Uuid\Uuid::fromString($value);
		return $uuid->getBytes();
	}

}
