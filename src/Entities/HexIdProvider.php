<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface HexIdProvider
{

	/**
	 * @return string
	 */
	public function getHexId();

}
