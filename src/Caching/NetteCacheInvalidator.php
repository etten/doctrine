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

	/** @var array[] */
	private $queue = [];

	public function __construct(NCaching\IStorage $storage)
	{
		$this->storage = $storage;
	}

	public function queue(Cacheable $cacheable)
	{
		$this->queue[] = [
			NCaching\Cache::TAGS => $cacheable->getCacheTags(),
		];
	}

	public function flush()
	{
		// Clean IStorage step-by-step due to possible bind limits
		// (SQL and cache tags as parameters).
		foreach ($this->queue as $conditions) {
			$this->storage->clean($conditions);
		}

		$this->queue = [];
	}

}
