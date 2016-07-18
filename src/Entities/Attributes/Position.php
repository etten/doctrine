<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(indexes={@ORM\Index(name="position", columns={"position"})})
 */
trait Position
{

	/**
	 * @var int
	 * @Gedmo\SortablePosition()
	 * @ORM\Column(type="integer")
	 */
	protected $position;

	public function getPosition() :int
	{
		return $this->position;
	}

	public function setPosition(int $position)
	{
		$this->position = $position;
	}

}
