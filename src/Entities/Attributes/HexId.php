<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait HexId
{

	use Id;

	/**
	 * @return string
	 */
	public function getHexId()
	{
		return (string)$this->id;
	}

}
