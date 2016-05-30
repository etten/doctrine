<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Doctrine\DBAL;

class TypeHelper
{

	/** @var DBAL\Connection */
	private $connection;

	public function __construct(DBAL\Connection $connection)
	{
		$this->connection = $connection;
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

		$platform = $this->connection->getDatabasePlatform();
		$platform->registerDoctrineTypeMapping($dbType, $dbType);
		$platform->markDoctrineTypeCommented(DBAL\Types\Type::getType($dbType));
	}

}
