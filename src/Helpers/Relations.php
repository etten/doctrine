<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Doctrine\ORM\EntityManager;

class Relations
{

	/** @var EntityManager */
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function fetchRelated(string $column, array $entities)
	{
		$entity = current($entities);
		if ($entity) {
			$this->em->createQueryBuilder()
				->select('PARTIAL e.{id}, data')
				->from(get_class($entity), 'e')
				->leftJoin(sprintf('e.%s', $column), 'data')
				->andWhere('e.id IN (:entities)')
				->setParameter('entities', $entities)
				->getQuery()
				->getResult();
		}
	}

}
