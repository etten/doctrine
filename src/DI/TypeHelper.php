<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Doctrine\DBAL;

class TypeHelper
{

	/** @var array */
	private $types = [];

	public function __construct(DBAL\Connection $connection)
	{
		$connection->getEventManager()->addEventListener(DBAL\Events::postConnect, $this);
	}

	/**
	 * @param string $dbType
	 * @param string $doctrineType
	 * @throws \Doctrine\DBAL\DBALException
	 */
	public function addType(string $dbType, string $doctrineType)
	{
		if (DBAL\Types\Type::hasType($dbType)) {
			DBAL\Types\Type::overrideType($dbType, $doctrineType);
		} else {
			DBAL\Types\Type::addType($dbType, $doctrineType);
		}

		// Register later, in postConnect.
		// This prevents unnecessary early connection.
		$this->types[] = [$dbType, $doctrineType];
	}

	/**
	 * @param DBAL\Event\ConnectionEventArgs $args
	 * @internal
	 */
	public function postConnect(DBAL\Event\ConnectionEventArgs $args)
	{
		$platform = $args->getDatabasePlatform();

		foreach ($this->types as list($dbType, $doctrineType)) {
			$platform->registerDoctrineTypeMapping($dbType, $dbType);
			$platform->markDoctrineTypeCommented(DBAL\Types\Type::getType($dbType));
		}
	}

}
