<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

class FileStorage implements Storage
{

	/** @var string */
	private $path;

	public function __construct(string $path)
	{
		$this->path = $path;
	}

	/**
	 * @return mixed
	 */
	public function read()
	{
		return @file_get_contents($this->path); // @ - file may not exists
	}

	/**
	 * @param mixed $content
	 */
	public function write($content)
	{
		file_put_contents($this->path, $content);
	}

}
