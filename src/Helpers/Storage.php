<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

interface Storage
{

	/**
	 * @return mixed
	 */
	public function read();

	/**
	 * @param mixed $content
	 */
	public function write($content);

}
