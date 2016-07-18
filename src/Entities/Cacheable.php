<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

interface Cacheable
{

	public function getCacheKey() :string;

	public function getCacheTags() :array;

}
