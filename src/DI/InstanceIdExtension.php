<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\DI;

use Etten\Doctrine\Helpers\FileStorage;
use Nette\DI as NDI;
use Nette\PhpGenerator;

class InstanceIdExtension extends NDI\CompilerExtension
{

	/** @var array */
	private $defaults = [
		'path' => 'safe://%storageDir%/instance-generator.id',
		'storage' => FileStorage::class,
	];

	public function afterCompile(PhpGenerator\ClassType $class)
	{
		$config = NDI\Config\Helpers::merge(
			$this->getConfig(),
			$this->getContainerBuilder()->expand($this->defaults)
		);

		$storageClass = '\\' . ltrim($config['storage'], '\\');

		$initialize = $class->getMethod('initialize');
		$initialize->addBody('\Etten\Doctrine\Helpers\InstanceIdGenerator::$storage = ?;', [
			new PhpGenerator\PhpLiteral(PhpGenerator\Helpers::formatArgs("new $storageClass(?)", [$config['path']])),
		]);
	}

}
