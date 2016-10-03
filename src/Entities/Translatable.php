<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface Translatable
{

	/**
	 * @param null|string $locale
	 * @return Translation
	 */
	public function translate($locale = NULL);

	/**
	 * @param Translation $translation
	 * @return void
	 */
	public function addTranslation($translation);

	/**
	 * @param Translation $translation
	 * @return void
	 */
	public function removeTranslation($translation);

}
