<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers\PairSelectorCodecs;

use Ramsey;

class UuidBinaryToHexCodec
{

	public function __invoke($k): callable
	{
		return Ramsey\Uuid\Uuid::fromBytes($k)->getHex();
	}

}
