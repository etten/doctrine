<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Etten\Doctrine\Entities\IdProvider;

class FieldOrderHelper
{

	/** @var array */
	private $result;

	/** @var array */
	private $sortBy;

	/** @var callable */
	private $resultId;

	/** @var callable */
	private $sortById;

	/**
	 * @param array $result Result objects to filter.
	 * @param array $sortBy Object defining correct order.
	 */
	public function __construct(array $result, array $sortBy)
	{
		$this->result = $result;
		$this->sortBy = $sortBy;
		$this->setResultId([$this, 'sortByIdProvider']);
		$this->setSortById([$this, 'sortByIdProvider']);
	}

	/**
	 * How to obtain an ID from resulting Object?
	 * @param callable $resultId
	 * @return FieldOrderHelper
	 */
	public function setResultId(callable $resultId) :FieldOrderHelper
	{
		$this->resultId = $resultId;
		return $this;
	}

	/**
	 * How to obtain an ID from sorting Object?
	 * @param callable $sortById
	 * @return FieldOrderHelper
	 */
	public function setSortById(callable $sortById) :FieldOrderHelper
	{
		$this->sortById = $sortById;
		return $this;
	}

	/**
	 * Returns $result sorted by $sortBy.
	 * @return array
	 */
	public function sort() :array
	{
		$ids = array_map($this->sortById, $this->sortBy);
		$sortIds = array_flip($ids);

		usort($this->result, function ($a, $b) use ($sortIds) {
			$aId = call_user_func($this->resultId, $a);
			$bId = call_user_func($this->resultId, $b);
			return $sortIds[$aId] - $sortIds[$bId];
		});

		return $this->result;
	}

	/**
	 * @param IdProvider $item
	 * @return mixed
	 * @internal
	 */
	public function sortByIdProvider(IdProvider $item)
	{
		return $item->getId();
	}

}
