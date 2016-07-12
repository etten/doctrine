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
		'invalidator' => EDoctrine\Caching\NetteCacheInvalidator::class,
	];

	public function beforeCompile()
	{
		$builder = $this->getContainerBuilder();
		$config = NDI\Config\Helpers::merge($this->config, $this->defaults);

		$invalidator = $config['invalidator'];
		if (is_string($invalidator)) {
			$invalidator = $builder->addDefinition($this->prefix('invalidator'))
				->setClass($invalidator)
				->setAutowired(FALSE);
		}

		$cacheSubscriber = $builder->addDefinition($this->prefix('subscriber'))
			->setClass(EDoctrine\Caching\CacheSubscriber::class)
			->setArguments([$invalidator])
			->setAutowired(FALSE);

		$entityManagers = $builder->findByType(ORM\EntityManager::class);
		foreach ($entityManagers as $name => $em) {
			$em->addSetup('$service->getEventManager()->addEventSubscriber(?)', [$cacheSubscriber]);
		}
	}

}
