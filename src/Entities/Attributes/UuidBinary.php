<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid as RUuid;

trait UuidBinary
{

	use Uuid;

	/**
	 * @var string
	 * @ORM\Id()
	 * @ORM\Column(type="uuid_binary")
	 * @ORM\GeneratedValue(strategy="NONE")
	 */
	protected $id;

	/**
	 * @return string
	 */
	public function getHexId()
	{
		return RUuid\Uuid::fromBytes($this->getId())->getHex();
	}

	protected function generateId()
	{
		$this->id = RUuid\Uuid::uuid4()->getBytes();
	}

}
