<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers;

use Doctrine\Common\Collections\Collection;
use Etten\Doctrine\Entities\IdProvider;

class Collections
{

	/**
	 * @param Collection|IdProvider[] $from
	 * @param Collection|IdProvider[] $to
	 * @return void
	 */
	public static function replace(Collection $from, $to)
	{
		$to = self::fillKeys($to);

		// Remove removed items.
		foreach ($from as $key => $item) {
			$id = $item->getId();

			if (isset($to[$id])) {
				unset($to[$id]);
			} else {
				unset($from[$key]);
			}
		}

		// Add new items.
		foreach ($to as $item) {
			$from[] = $item;
		}
	}

	/**
	 * @param IdProvider[] $items
	 * @return IdProvider[]
	 */
	private static function fillKeys($items) :array
	{
		$return = [];

		foreach ($items as $item) {
			$return[$item->getId()] = $item;
		}

		return $return;
	}

}
