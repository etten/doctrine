<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Tests\Unit;

use Etten\Doctrine\Entities\AbstractEntity;

class AbstractEntityTest extends \PHPUnit_Framework_TestCase
{

	public function testGetCacheKey()
	{
		$entity = new TestEntity();
		$this->assertSame('Tests\Unit\TestEntity:5', $entity->getCacheKey());
	}

	public function testGetCacheTags()
	{
		$entity = new TestEntity();

		$this->assertSame([
			'testentity',
		], $entity->getCacheTags());
	}

}

class TestEntity extends AbstractEntity
{

	public function getId()
	{
		return 5;
	}

}
