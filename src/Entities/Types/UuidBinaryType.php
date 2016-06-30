<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid;

class UuidBinaryType extends Uuid\Doctrine\UuidBinaryType
{

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		return $value;
	}

	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return $value;
	}

}
