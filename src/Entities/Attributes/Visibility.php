<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

/**
 * @ORM\Table(indexes={@ORM\Index(name="visible", columns={"visible"})})
 */
trait Visibility
{

	/**
	 * @var bool
	 * @ORM\Column(type="boolean")
	 */
	protected $visible;

	public function isVisible() :bool
	{
		return $this->visible;
	}

	public function setVisible(bool $visible)
	{
		$this->visible = $visible;
	}

}
