<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Nette\DI as NDI;
use Ramsey\Uuid;

class UuidExtension extends NDI\CompilerExtension
{

	/** @var array */
	private $types = [
		'uuid' => Uuid\Doctrine\UuidType::class,
		'uuid_binary' => Uuid\Doctrine\UuidBinaryType::class,
	];

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$connections = $builder->findByType('Kdyby\Doctrine\Connection');

		foreach ($connections as $connection) {
			foreach ($this->types as $dbType => $doctrineType) {
				$connection->addSetup(
					'$dbType = ?; $doctrineType = ?;' . "\n" .
					'if (\Doctrine\DBAL\Types\Type::hasType($dbType)) {' . "\n" .
					"\t" . '\Doctrine\DBAL\Types\Type::overrideType($dbType, $doctrineType);' . "\n" .
					'} else {' . "\n" .
					"\t" . '\Doctrine\DBAL\Types\Type::addType($dbType, $doctrineType);' . "\n" .
					'}' . "\n" .
					'$platform = $service->getDatabasePlatform();' . "\n" .
					'$platform->registerDoctrineTypeMapping($dbType, $dbType);' . "\n" .
					'$platform->markDoctrineTypeCommented(\Kdyby\Doctrine\DbalType::getType($dbType));' . "\n",
					[$dbType, $doctrineType]
				);
			}
		}
	}

}
