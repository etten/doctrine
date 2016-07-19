<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine;

use Doctrine\ORM;

class RepositoryLocator
{

	/** @var ORM\EntityManager */
	private $em;

	public function __construct(ORM\EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * Gets the repository for an entity class.
	 * @param string $entityName
	 * @return ORM\EntityRepository
	 */
	public function get(string $entityName): ORM\EntityRepository
	{
		return $this->em->getRepository($entityName);
	}

}
