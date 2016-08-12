<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Caching;

use Etten\Doctrine\Entities\Cacheable;

interface CacheInvalidator
{

	public function queue(Cacheable $cacheable);

	public function flush();

}
