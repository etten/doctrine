<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

use Doctrine\ORM;

/**
 * @ORM\Mapping\Entity()
 */
abstract class Entity implements IdProvider, Cacheable
{

	public function getCacheKey()
	{
		return get_called_class() . ':' . $this->getId();
	}

	public function getCacheTags()
	{
		$nameParts = explode('\\', get_called_class());
		$name = strtolower(end($nameParts));

		return [$name];
	}

}
