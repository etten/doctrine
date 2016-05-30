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

		$i = 0;
		foreach ($entityManagers as $name => $em) {
			$suffix = $i;
			$default = $i === 0;
			$i++;

			// Kdyby\Doctrine support
			if (preg_match('~kdyby\.doctrine\.([a-zA-Z0-9_]+)\.entityManager~', $name, $m)) {
				$suffix = $m[1];
				$default = $suffix === 'default';
			}

			$builder->addDefinition($this->fullName('persister', $suffix))
				->setClass(EDoctrine\Persister::class)
				->setArguments([$em])
				->setAutowired($default);

			$builder->addDefinition($this->fullName('repositoryLocator', $suffix))
				->setClass(EDoctrine\RepositoryLocator::class)
				->setArguments([$em])
				->setAutowired($default);

			$builder->addDefinition($this->fullName('transaction', $suffix))
				->setClass(EDoctrine\Transaction::class)
				->setArguments([$em])
				->setAutowired($default);
		}
	}

	private function fullName(string $name, string $suffix)
	{
		return $this->prefix($name) . '.' . $suffix;
	}

}
