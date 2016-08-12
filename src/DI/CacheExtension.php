<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Doctrine\ORM;
use Etten\Doctrine as EDoctrine;
use Nette\DI as NDI;

class CacheExtension extends NDI\CompilerExtension
{

	private $defaults = [
		'invalidators' => [
			EDoctrine\Caching\NetteCacheInvalidator::class,
		],
	];

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$config = NDI\Config\Helpers::merge($this->config, $this->defaults);

		$invalidatorStack = $builder->addDefinition($this->prefix('invalidator'))
			->setClass(EDoctrine\Caching\CacheInvalidatorStack::class)
			->setAutowired(FALSE);

		foreach ($config['invalidators'] as $invalidator) {
			$invalidatorStack->addSetup('add', [$invalidator]);
		}

		$cacheSubscriber = $builder->addDefinition($this->prefix('subscriber'))
			->setClass(EDoctrine\Caching\CacheSubscriber::class)
			->setArguments([$invalidatorStack])
			->setAutowired(FALSE);

		$entityManagers = $builder->findByType(ORM\EntityManager::class);
		foreach ($entityManagers as $name => $em) {
			$em->addSetup('$service->getEventManager()->addEventSubscriber(?)', [$cacheSubscriber]);
		}
	}

}
