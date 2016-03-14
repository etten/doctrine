<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait Id
{

	/**
	 * @var int
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue()
	 */
	private $id;

	/**
	 * @return int
	 */
	final public function getId()
	{
		if (!$this->id) {
			throw new \RuntimeException('ID is not set.');
		}

		return $this->id;
	}

	public function __clone()
	{
		$this->id = NULL;
	}

}
