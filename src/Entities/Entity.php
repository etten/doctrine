<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

use Etten\Doctrine\Entities\Attributes;

abstract class Entity implements IdProvider, Cacheable, \ArrayAccess, \IteratorAggregate
{

	use Attributes\Cache;
	use Attributes\ArrayAccessors;

}
