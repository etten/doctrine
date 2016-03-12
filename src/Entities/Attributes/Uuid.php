<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid as RUuid;

trait Uuid
{

	/**
	 * @var string
	 * @ORM\Id()
	 * @ORM\Column(type="uuid_binary")
	 * @ORM\GeneratedValue(strategy="NONE")
	 */
	private $id;

	public function __construct()
	{
		$this->id = RUuid\Uuid::uuid4();
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

}
