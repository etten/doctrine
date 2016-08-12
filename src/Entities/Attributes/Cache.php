<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

trait Cache
{

	public function getCacheId()
	{
		return $this->getHexId();
	}

	public function getCacheName()
	{
		$nameParts = explode('\\', get_called_class());
		return strtolower(end($nameParts));
	}

	public function getCacheKey(): string
	{
		return get_called_class() . ':' . $this->getCacheId();
	}

	public function getCacheTags(): array
	{
		$name = $this->getCacheName();

		return [
			$name,
			$name . ':' . $this->getCacheId(),
			get_called_class(),
			$this->getCacheKey(),
		];
	}

}
