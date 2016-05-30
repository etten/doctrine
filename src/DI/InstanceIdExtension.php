<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Nette\DI as NDI;
use Nette\PhpGenerator;

class InstanceIdExtension extends NDI\CompilerExtension
{

	/** @var array */
	protected $config = [
		'path' => 'safe://%storageDir%/instance-generator.id',
	];

	public function afterCompile(PhpGenerator\ClassType $class)
	{
		$config = NDI\Config\Helpers::merge(
			$this->getContainerBuilder()->parameters,
			$this->getContainerBuilder()->expand($this->config)
		);

		$initialize = $class->getMethod('initialize');
		$initialize->addBody('\Etten\Doctrine\Helpers\InstanceIdGenerator::$path = ?', [
			$config['path'],
		]);
	}

}
