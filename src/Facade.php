<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine;

use Doctrine\ORM;

abstract class Facade
{

	/** @var ORM\EntityManager */
	protected $em;

	public function __construct(ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	protected function createQueryBuilder(): ORM\QueryBuilder
	{
		return $this->em->createQueryBuilder();
	}

	protected function getRepository(string $entityName): ORM\EntityRepository
	{
		return $this->em->getRepository($entityName);
	}

}
