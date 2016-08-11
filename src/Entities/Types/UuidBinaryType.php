<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Ramsey;

class UuidBinaryType extends Ramsey\Uuid\Doctrine\UuidBinaryType
{

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		// Nullable.
		if (empty($value)) {
			return NULL;
		}

		// Uuid instance.
		if ($value instanceof Ramsey\Uuid\Uuid) {
			return $value->getBytes();
		}

		// Binary value.
		if (strlen($value) === 16) {
			return $value;
		}

		// Otherwise, try convert.
		try {
			$uuid = Ramsey\Uuid\Uuid::fromString($value);
		} catch (\InvalidArgumentException $e) {
			throw ConversionException::conversionFailed($value, self::NAME);
		}

		return $uuid->getBytes();
	}

	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return $value;
	}

}
