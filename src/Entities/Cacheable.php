<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface Cacheable
{

	/**
	 * @return string
	 */
	public function getCacheKey();

	/**
	 * @return string[]
	 */
	public function getCacheTags();

}
