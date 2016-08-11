<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers\PairSelectorCodecs;

class ObjectToStringCodec
{

	public function __invoke($k): callable
	{
		// Convert possible Object keys to string (i.e. UUID).
		if (!is_scalar($k)) {
			$k = (string)$k;
		}

		return $k;
	}

}
