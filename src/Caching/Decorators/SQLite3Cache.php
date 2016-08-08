<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Caching\Decorators;

use Doctrine\Common\Cache;

class SQLite3Cache extends Cache\CacheProvider
{

	/** @var Cache\SQLite3Cache */
	private $cache;

	public function __construct(string $path, $table = 'data')
	{
		if (!is_file($path)) {
			touch($path); // ensures ordinary file permissions
		}

		$sqlite = new \SQLite3($path);
		$this->cache = new Cache\SQLite3Cache($sqlite, $table);
	}

	protected function doFetch($id)
	{
		return $this->cache->fetch($id);
	}

	protected function doContains($id)
	{
		return $this->cache->contains($id);
	}

	protected function doSave($id, $data, $lifeTime = 0)
	{
		return $this->cache->save($id, $data, $lifeTime);
	}

	protected function doDelete($id)
	{
		return $this->cache->delete($id);
	}

	protected function doFlush()
	{
		return $this->cache->flushAll();
	}

	protected function doGetStats()
	{
		return $this->cache->getStats();
	}

}
