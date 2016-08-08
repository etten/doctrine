<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Caching\Decorators;

use Doctrine\Common\Cache;

class SQLite3Cache implements Cache\Cache, Cache\FlushableCache, Cache\ClearableCache, Cache\MultiGetCache, Cache\MultiPutCache
{

	/** @var Cache\SQLite3Cache */
	private $cache;

	public function __construct(string $path, $table = 'default')
	{
		if (!is_file($path)) {
			touch($path); // ensures ordinary file permissions
		}

		$sqlite = new \SQLite3($path);
		$this->cache = new Cache\SQLite3Cache($sqlite, $table);
	}

	public function fetch($id)
	{
		return $this->cache->fetch($id);
	}

	public function contains($id)
	{
		return $this->cache->contains($id);
	}

	public function save($id, $data, $lifeTime = 0)
	{
		return $this->cache->save($id, $data, $lifeTime);
	}

	public function delete($id)
	{
		return $this->cache->delete($id);
	}

	public function getStats()
	{
		return $this->cache->getStats();
	}

	public function deleteAll()
	{
		return $this->cache->deleteAll();
	}

	public function flushAll()
	{
		return $this->cache->flushAll();
	}

	public function fetchMultiple(array $keys)
	{
		return $this->cache->fetchMultiple($keys);
	}

	public function saveMultiple(array $keysAndValues, $lifetime = 0)
	{
		return $this->cache->saveMultiple($keysAndValues, $lifetime);
	}

}
