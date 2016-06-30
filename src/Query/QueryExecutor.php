<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Query;

use Kdyby;

class QueryExecutor
{

	/** @var QueryableFactory */
	private $queryableFactory;

	public function __construct(QueryableFactory $queryableFactory)
	{
		$this->queryableFactory = $queryableFactory;
	}

	public function fetch(Kdyby\Persistence\Query $query, string $entityName)
	{
		return $query->fetch($this->createQueryable($entityName));
	}

	public function fetchOne(Kdyby\Persistence\Query $query, string $entityName)
	{
		return $query->fetchOne($this->createQueryable($entityName));
	}

	public function count(Kdyby\Persistence\Query $query, string $entityName)
	{
		return $query->count($this->createQueryable($entityName));
	}

	private function createQueryable(string $entityName):Kdyby\Persistence\Queryable
	{
		return $this->createQueryable($entityName);
	}

}
