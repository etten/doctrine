<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Repositories;

trait Position
{

	public function findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
	{
		$orderBy = $orderBy ?: $this->getDefaultOrderBy();
		return parent::findBy($criteria, $orderBy, $limit, $offset);
	}

	public function findPairs($criteria, $value = NULL, $orderBy = [], $key = NULL)
	{
		$orderBy = $orderBy ?: $this->getDefaultOrderBy();
		return parent::findPairs($criteria, $value, $orderBy, $key);
	}

	public function findAll()
	{
		return $this->findBy([], $this->getDefaultOrderBy());
	}

	protected function getDefaultOrderBy()
	{
		return ['position' => 'desc'];
	}

}
