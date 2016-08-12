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

	/** @var array */
	private $queue = [];

	public function __construct(NCaching\IStorage $storage)
	{
		$this->storage = $storage;
	}

	public function queue(Cacheable $cacheable)
	{
		$tags = $this->queue[NCaching\Cache::TAGS] ?? [];
		$tags = array_merge($tags, $cacheable->getCacheTags());

		$this->queue[NCaching\Cache::TAGS] = $tags;
	}

	public function flush()
	{
		if ($this->queue) {
			$this->storage->clean($this->queue);
			$this->queue = [];
		}
	}

}
