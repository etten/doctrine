<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Doctrine\ORM;
use Etten\Doctrine as EDoctrine;
use Nette\DI as NDI;

class DIExtension extends NDI\CompilerExtension
{

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$entityManagers = $builder->findByType(ORM\EntityManager::class);

		foreach (array_values($entityManagers) as $i => $em) {
			$builder->addDefinition($this->prefix('persister'))
				->setClass(EDoctrine\Persister::class)
				->setArguments([$em])
				->setAutowired($i === 0);

			$builder->addDefinition($this->prefix('repositoryLocator'))
				->setClass(EDoctrine\RepositoryLocator::class)
				->setArguments([$em])
				->setAutowired($i === 0);

			$builder->addDefinition($this->prefix('transaction'))
				->setClass(EDoctrine\Transaction::class)
				->setArguments([$em])
				->setAutowired($i === 0);
		}
	}

}
