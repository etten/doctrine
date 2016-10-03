<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface Translation
{

	/**
	 * @param null|string $locale
	 * @return void
	 */
	public function setLocale($locale);

}
