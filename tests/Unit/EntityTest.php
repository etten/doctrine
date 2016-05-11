<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Tests\Unit;

class EntityTest extends \PHPUnit_Framework_TestCase
{

	public function testGetCacheKey()
	{
		$entity = new EntityTestClass();
		$this->assertSame('Tests\Unit\EntityTestClass:5', $entity->getCacheKey());
	}

	public function testGetCacheTags()
	{
		$entity = new EntityTestClass();

		$this->assertSame([
			'entitytestclass',
		], $entity->getCacheTags());
	}

}
