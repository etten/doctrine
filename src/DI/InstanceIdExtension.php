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
		'storage' => 'Etten\Doctrine\Helpers\FileStorage',
	];

	public function afterCompile(PhpGenerator\ClassType $class)
	{
		$config = NDI\Config\Helpers::merge(
			$this->getContainerBuilder()->parameters,
			$this->getContainerBuilder()->expand($this->config)
		);

		$storageClass = '\\' . ltrim($config['storage'], '\\');

		$initialize = $class->getMethod('initialize');
		$initialize->addBody('\Etten\Doctrine\Helpers\InstanceIdGenerator::$storage = ?;', [
			new PhpGenerator\PhpLiteral(PhpGenerator\Helpers::formatArgs("new $storageClass(?)", [$config['path']])),
		]);
	}

}
