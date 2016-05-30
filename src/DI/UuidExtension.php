<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Doctrine\DBAL;
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
		if (!$this->types) {
			return;
		}

		$builder = $this->getContainerBuilder();
		$connections = $builder->findByType(DBAL\Connection::class);

		foreach ($connections as $connection) {
			$connection->addSetup(
				'$typeHelper = new \Etten\Doctrine\DI\TypeHelper(?)',
				['@self']
			);

			foreach ($this->types as $dbType => $doctrineType) {
				$connection->addSetup(
					'$typeHelper->addType(?, ?)',
					[$dbType, $doctrineType]
				);
			}
		}
	}

}
