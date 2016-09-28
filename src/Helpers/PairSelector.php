<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Doctrine\ORM;
use Etten\Doctrine\Helpers\PairSelectorCodecs;

class PairSelector
{

	const ENTITY_SELECTOR = 'e';

	/** @var ORM\EntityManager */
	private $em;

	/** @var string */
	private $entityName;

	/** @var callable|null */
	private $codec;

	/** @var array */
	private $where = [];

	/** @var string */
	private $groupBy = '';

	/** @var string */
	private $orderBy = '';

	public function __construct(ORM\EntityManager $em, string $entityName)
	{
		$this->em = $em;
		$this->entityName = $entityName;
	}

	public function setCodec(callable $codec): PairSelector
	{
		$this->codec = $codec;
		return $this;
	}

	public function setWhere(string $where): PairSelector
	{
		$this->where = [$where];
		return $this;
	}

	public function andWhere(string $where): PairSelector
	{
		$this->where[] = $where;
		return $this;
	}

	public function setGroupBy(string $groupBy): PairSelector
	{
		$this->groupBy = $groupBy;
		return $this;
	}

	public function setOrderBy(string $orderBy): PairSelector
	{
		$this->orderBy = $orderBy;
		return $this;
	}

	public function getPairs(string $key, string $value, callable $builder = NULL): array
	{
		$e = $this->parseSelector($key);

		$expandedKey = $this->expandQuery($key, $e);
		$expandedValue = $this->expandQuery($value, $e);

		$shrinkKey = $this->shrinkQuery($key);
		$shrinkValue = $this->shrinkQuery($value);

		$qb = $this->em->createQueryBuilder()
			->select("$expandedKey, $expandedValue")
			->from($this->entityName, $e);

		if ($builder) {
			$builder($qb);
		}

		if ($this->where) {
			foreach ($this->where as $where) {
				$qb->andWhere($this->expandQuery($where, $e));
			}
		}

		if ($this->groupBy) {
			$qb->groupBy($this->expandQuery($this->groupBy, $e));
		}

		if ($this->orderBy) {
			$qb->orderBy($this->expandQuery($this->orderBy, $e));
		}

		$data = $qb
			->getQuery()
			->getResult(ORM\AbstractQuery::HYDRATE_ARRAY);

		$pairs = [];
		foreach ($data as $row) {
			$k = $row[$shrinkKey];

			$codec = $this->getCodec();
			$k = $codec($k);

			$pairs[$k] = $row[$shrinkValue];
		}

		return $pairs;
	}

	private function getCodec(): callable
	{
		if ($this->codec === NULL) {
			$this->codec = new PairSelectorCodecs\ObjectToStringCodec();
		}

		return $this->codec;
	}

	private function parseSelector(string $q): string
	{
		if (strpos($q, '.') === FALSE) {
			return self::ENTITY_SELECTOR;
		} else {
			$exp = explode('.', $q);
			return array_shift($exp);
		}
	}

	private function expandQuery(string $q, string $selector): string
	{
		if (strpos($q, '.') === FALSE) {
			$q = $selector . '.' . $q;
		}

		return $q;
	}

	private function shrinkQuery(string $q): string
	{
		$exp = explode('.', $q);
		return array_pop($exp);
	}

}
