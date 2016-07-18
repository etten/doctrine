<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

/**
 * @ORM\Table(indexes={@ORM\Index(name="visibility", columns={"visibility"})})
 */
trait Visibility
{

	/**
	 * @var bool
	 * @ORM\Column(type="boolean")
	 */
	protected $visible;

	/**
	 * @return bool
	 */
	public function isVisible():bool
	{
		return $this->visible;
	}

	/**
	 * @param boolean $visible
	 * @return $this
	 */
	public function setVisible(bool $visible)
	{
		$this->visible = $visible;
		return $this;
	}

}
