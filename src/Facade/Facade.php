<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Facade;

use Kdyby\Doctrine;

abstract class Facade
{

	/** @var Doctrine\EntityManager */
	protected $em;

	public function __construct(Doctrine\EntityManager $em)
	{
		$this->em = $em;
	}

	protected function createQueryBuilder():Doctrine\QueryBuilder
	{
		return $this->em->createQueryBuilder();
	}

	protected function getRepository(string $entityName):Doctrine\EntityRepository
	{
		return $this->em->getRepository($entityName);
	}

}
