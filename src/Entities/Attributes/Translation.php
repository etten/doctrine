<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Etten\Doctrine\Entities;

trait Translation
{

	/**
	 * @var string
	 */
	protected $locale;

	/**
	 * Will be mapped to translatable entity
	 * by TranslatableSubscriber
	 * @var Entities\Translatable
	 */
	protected $translatable;

	/**
	 * Returns the translatable entity class name.
	 * @return string
	 */
	public static function getTranslatableEntityClass()
	{
		// By default, the translatable class has the same name but without the "Translation" suffix
		return substr(__CLASS__, 0, -11);
	}

	/**
	 * Sets entity, that this translation should be mapped to.
	 * @param Entities\Translatable $translatable The translatable
	 */
	public function setTranslatable($translatable)
	{
		$this->translatable = $translatable;
	}

	/**
	 * Returns entity, that this translation is mapped to.
	 * @return Entities\Translatable
	 */
	public function getTranslatable()
	{
		return $this->translatable;
	}

	/**
	 * Sets locale name for this translation.
	 * @param string|null $locale The locale
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;
	}

	/**
	 * Returns this translation locale.
	 * @return string
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * Tells if translation is empty
	 * @return bool true if translation is not filled
	 */
	public function isEmpty()
	{
		return FALSE;
	}

}
