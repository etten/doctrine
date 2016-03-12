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
					'$platform = $this->getDatabasePlatform();' . "\n" .
					'$platform->registerDoctrineTypeMapping($dbType = ?, $doctrineType = ?);' . "\n" .
					'$platform->markDoctrineTypeCommented(\Kdyby\Doctrine\DbalType::getType($dbType));' . "\n",
					[
						$dbType,
						$doctrineType,
					]
				);
			}
		}
	}

}
