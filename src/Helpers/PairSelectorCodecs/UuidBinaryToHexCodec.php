<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Helpers\PairSelectorCodecs;

use Etten\Doctrine\Helpers\UuidCoverter;

class UuidBinaryToHexCodec
{

	public function __invoke($k)
	{
		return UuidCoverter::binaryToHex($k);
	}

}
