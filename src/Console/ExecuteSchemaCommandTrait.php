<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Console;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait ExecuteSchemaCommandTrait
{

	/** @var string[] */
	private $ignoredNamespace = [];

	/** @var string[] */
	private $ignoredClass = [];

	public function setIgnoredNamespace(array $ignoredNamespace)
	{
		$this->ignoredNamespace = $ignoredNamespace;
		return $this;
	}

	public function setIgnoredClass(array $ignoredClass)
	{
		$this->ignoredClass = $ignoredClass;
		return $this;
	}

	protected function executeSchemaCommand(InputInterface $input, OutputInterface $output, SchemaTool $schemaTool, array $metadatas)
	{
		$metadatas = array_filter($metadatas, function (ClassMetadata $metadata) {
			$ret = !in_array($metadata->namespace, $this->ignoredNamespace);
			$ret &= !in_array($metadata->name, $this->ignoredClass);

			return $ret;
		});

		return parent::executeSchemaCommand($input, $output, $schemaTool, $metadatas);
	}

}
