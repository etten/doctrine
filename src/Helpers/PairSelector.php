<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Doctrine\ORM;

class PairSelector
{

	/** @var ORM\EntityManager */
	private $em;

	/** @var string */
	private $entityName;

	/** @var string */
	private $where = '';

	/** @var string */
	private $groupBy = '';

	/** @var string */
	private $orderBy = '';

	public function __construct(ORM\EntityManager $em, string $entityName)
	{
		$this->em = $em;
		$this->entityName = $entityName;
	}

	public function setWhere($where):PairSelector
	{
		$this->where = $where;
		return $this;
	}

	public function setGroupBy(string $groupBy):PairSelector
	{
		$this->groupBy = $groupBy;
		return $this;
	}

	/**
	 * @param string $orderBy
	 * @return PairSelector
	 */
	public function setOrderBy(string $orderBy):PairSelector
	{
		$this->orderBy = $orderBy;
		return $this;
	}

	public function getPairs(string $key, string $value):array
	{
		$qb = $this->em->createQueryBuilder()
			->select("e.$key, e.$value")
			->from($this->entityName, 'e');

		if ($this->where) {
			$qb->where('e.' . $this->where);
		}

		if ($this->groupBy) {
			$qb->groupBy('e.' . $this->groupBy);
		}

		if ($this->orderBy) {
			$qb->orderBy('e.' . $this->orderBy);
		}

		$data = $qb
			->getQuery()
			->getResult(ORM\AbstractQuery::HYDRATE_ARRAY);

		$pairs = [];
		foreach ($data as $row) {
			$k = $row[$key];

			// Convert possible Object keys (i.e. UUID)
			if (!is_scalar($k)) {
				$k = (string)$k;
			}

			$pairs[$k] = $row[$value];
		}

		return $pairs;
	}

}
