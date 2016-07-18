<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Query;

use Kdyby;

class QueryableFactory
{

	/** @var QueryFactory */
	private $queryFactory;

	public function __construct(QueryFactory $queryFactory)
	{
		$this->queryFactory = $queryFactory;
	}

	public function create(string $entityName) :Kdyby\Persistence\Queryable
	{
		return new EntityQueryable($this->queryFactory, $entityName);
	}

}
