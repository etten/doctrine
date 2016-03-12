<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Doctrine\DBAL\Types\Type;
use Kdyby\Doctrine;

class TypeHelper
{

	/** @var Doctrine\Connection */
	private $connection;

	public function __construct(Doctrine\Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @param string $dbType
	 * @param string $doctrineType
	 * @throws \Doctrine\DBAL\DBALException
	 */
	public function addType($dbType, $doctrineType)
	{
		if (Type::hasType($dbType)) {
			Type::overrideType($dbType, $doctrineType);
		} else {
			Type::addType($dbType, $doctrineType);
		}

		$platform = $this->connection->getDatabasePlatform();
		$platform->registerDoctrineTypeMapping($dbType, $dbType);
		$platform->markDoctrineTypeCommented(Doctrine\DbalType::getType($dbType));
	}

}
