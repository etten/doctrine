<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Caching;

use Etten\Doctrine\Entities\Cacheable;

class CacheInvalidatorStack implements CacheInvalidator
{

	/** @var CacheInvalidator[] */
	private $invalidators = [];

	public function add(CacheInvalidator $invalidator)
	{
		$this->invalidators[] = $invalidator;
	}

	public function queue(Cacheable $cacheable)
	{
		foreach ($this->invalidators as $invalidator) {
			$invalidator->queue($cacheable);
		}
	}

	public function flush()
	{
		foreach ($this->invalidators as $invalidator) {
			$invalidator->flush();
		}
	}

}
