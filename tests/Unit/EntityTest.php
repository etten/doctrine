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

	public function testToArray()
	{
		$entity = new EntityTestClass();

		$this->assertSame([
			'id' => 5,
			'name' => 'Foo',
			'publicBar' => 'Bar',
			'cacheKey' => 'Tests\Unit\EntityTestClass:5',
			'cacheTags' => ['entitytestclass'],
		], $entity->toArray());
	}

	public function testFromArray()
	{
		$from = [
			'id' => 9,
			'name' => 'Fooo',
			'publicBar' => 'Barr',
			'cacheKey' => '###',
			'cacheTags' => '###',
		];

		$to = [
			'id' => 5, // read-only
			'name' => 'Fooo',
			'publicBar' => 'Barr',
			'cacheKey' => 'Tests\Unit\EntityTestClass:5', // read-only
			'cacheTags' => ['entitytestclass'], // read-only
		];

		$entity = new EntityTestClass();
		$entity->fromArray($from);

		$this->assertSame($to, $entity->toArray());
	}

}
