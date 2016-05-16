<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

trait Cache
{

	public function getCacheKey():string
	{
		return get_called_class() . ':' . $this->getId();
	}

	public function getCacheTags():array
	{
		$nameParts = explode('\\', get_called_class());
		$name = strtolower(end($nameParts));

		return [$name];
	}

}
