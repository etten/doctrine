<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Caching;

use Etten\Doctrine\Entities\Cacheable;
use Nette\Caching as NCaching;

class NetteCacheInvalidator implements CacheInvalidator
{

	/** @var NCaching\IStorage */
	private $storage;

	public function __construct(NCaching\IStorage $storage)
	{
		$this->storage = $storage;
	}

	public function invalidate(Cacheable $cacheable)
	{
		$this->storage->clean([
			NCaching\Cache::TAGS => $cacheable->getCacheTags(),
		]);
	}

}
