<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Query;

use Doctrine\ORM;

class QueryFactory
{

	/** @var ORM\EntityManager */
	private $em;

	public function __construct(ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Creates a new Query object.
	 * @param string $dql The DQL string.
	 * @return ORM\Query
	 */
	public function createQuery(string $dql = ''):ORM\Query
	{
		return $this->em->createQuery($dql);
	}

	/**
	 * Creates a Query from a named query.
	 * @param string $name
	 * @return ORM\Query
	 */
	public function createNamedQuery(string $name):ORM\Query
	{
		return $this->em->createNamedQuery($name);
	}

	/**
	 * Creates a native SQL query.
	 * @param string $sql
	 * @param ORM\Query\ResultSetMapping $rsm The ResultSetMapping to use.
	 * @return ORM\NativeQuery
	 */
	public function createNativeQuery(string $sql, ORM\Query\ResultSetMapping $rsm):ORM\NativeQuery
	{
		return $this->em->createNativeQuery($sql, $rsm);
	}

	/**
	 * Creates a NativeQuery from a named native query.
	 * @param string $name
	 * @return ORM\NativeQuery
	 */
	public function createNamedNativeQuery(string $name):ORM\NativeQuery
	{
		return $this->em->createNamedNativeQuery($name);
	}

	/**
	 * Create a QueryBuilder instance
	 * @return ORM\QueryBuilder
	 */
	public function createQueryBuilder():ORM\QueryBuilder
	{
		return $this->em->createQueryBuilder();
	}

}
