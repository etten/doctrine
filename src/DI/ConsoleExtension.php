<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Etten\Doctrine\Console;
use Kdyby;
use Nette\DI;

class ConsoleExtension extends DI\CompilerExtension
{

	/** @var array */
	private $defaults = [
		'ignoredNamespace' => [],
		'ignoredClass' => [],
	];

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = DI\Config\Helpers::merge($this->defaults, $this->config);

		$map = [
			Kdyby\Doctrine\Console\SchemaCreateCommand::class => Console\SchemaCreateCommand::class,
			Kdyby\Doctrine\Console\SchemaUpdateCommand::class => Console\ SchemaUpdateCommand::class,
			Kdyby\Doctrine\Console\SchemaDropCommand::class => Console\SchemaDropCommand::class,
		];

		foreach ($builder->getDefinitions() as $definition) {
			$class = $definition->getClass();
			if (isset($map[$class])) {
				$definition->setFactory($map[$class]);
				$definition->addSetup('setIgnoredNamespace', [(array)$config['ignoredNamespace']]);
				$definition->addSetup('setIgnoredClass', [(array)$config['ignoredClass']]);
			}
		}
	}

}
