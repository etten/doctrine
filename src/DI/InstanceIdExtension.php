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
	private $defaults = [
		'path' => '%storageDir%/instance-generator.id',
	];

	public function afterCompile(PhpGenerator\ClassType $class)
	{
		$config = NDI\Config\Helpers::merge(
			$this->getConfig(),
			$this->getContainerBuilder()->expand($this->defaults)
		);

		$initialize = $class->getMethod('initialize');
		$initialize->addBody('\Etten\Doctrine\Helpers\InstanceIdGenerator::$lock = ?;', [
			new PhpGenerator\PhpLiteral(PhpGenerator\Helpers::formatArgs('new \Etten\Utils\FileLock(?)', [$config['path']])),
		]);
	}

}
