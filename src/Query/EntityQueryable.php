<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Query;

use Doctrine;
use Kdyby;

class EntityQueryable implements Kdyby\Persistence\Queryable
{

	/** @var QueryFactory */
	private $queryFactory;

	/** @var string */
	private $entityName;

	public function __construct(QueryFactory $queryFactory, string $entityName)
	{
		$this->queryFactory = $queryFactory;
		$this->entityName = $entityName;
	}

	public function createQueryBuilder($alias = NULL, $indexBy = NULL)
	{
		$qb = $this->queryFactory->createQueryBuilder();

		if ($alias !== NULL) {
			$qb->select($alias)
				->from($this->entityName, $alias, $indexBy);
		}

		return $qb;
	}

	public function createQuery($dql = NULL)
	{
		return $this->queryFactory->createQuery($dql);
	}

	public function createNativeQuery($sql, Doctrine\ORM\Query\ResultSetMapping $rsm)
	{
		return $this->queryFactory->createNativeQuery($sql, $rsm);
	}

}
