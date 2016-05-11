<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Doctrine\ORM;

class Randomizer
{

	/** @var ORM\Query */
	private $query;

	/** @var int */
	private $step = 25;

	/**
	 * @param ORM\Query $query Query where make random selection.
	 */
	public function __construct(ORM\Query $query)
	{
		$this->query = $query;
	}

	/**
	 * @param int $step
	 * @return Randomizer
	 */
	public function setStep(int $step):Randomizer
	{
		$this->step = $step;
		return $this;
	}

	/**
	 * @param int $limit Number of returned records.
	 * @return array
	 */
	public function find(int $limit):array
	{
		$data = [];

		$remains = $limit;
		$rows = $this->countRows();

		while ($remains > 0) {
			$iteratorLimit = $this->getIteratorLimit($remains);
			$offset = $this->getRandomOffset($rows, $iteratorLimit);
			$remains -= $iteratorLimit;

			$q = clone $this->query;
			$q->setMaxResults($iteratorLimit);
			$q->setFirstResult($offset);

			$data = array_merge($data, iterator_to_array(new ORM\Tools\Pagination\Paginator($q)));
		}

		shuffle($data);

		return $data;
	}

	private function countRows():int
	{
		return count(new ORM\Tools\Pagination\Paginator($this->query));
	}

	private function getRandomOffset(int $rows, int $limit):int
	{
		return max(0, rand(0, $rows - $limit - 1));
	}

	private function getIteratorLimit(int $remains):int
	{
		$limit = $this->step;
		if ($remains < $limit) {
			$limit = $remains;
		}

		return $limit;
	}

}
