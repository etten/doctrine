<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Doctrine\ORM\Mapping as ORM;
use Etten\Doctrine\Helpers\InstanceIdGenerator;

trait InstanceId
{

	/**
	 * @var int
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	public function __construct()
	{
		if (is_callable('parent::__construct')) {
			parent::__construct();
		}

		$this->generateId();
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	public function __clone()
	{
		$this->generateId();
	}

	private function generateId()
	{
		$this->id = InstanceIdGenerator::generate();
	}

}
