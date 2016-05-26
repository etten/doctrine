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

	public function testToArrayInvalid()
	{
		$entity = new InvalidEntityTestClass();

		$this->expectException(\Throwable::class);
		$entity->toArray();
	}

	public function testToArraySilentInvalid()
	{
		$entity = new InvalidEntityTestClass();

		$this->assertSame([
			'id' => 5,
			'publicBar' => 'Bar',
			'cacheKey' => 'Tests\Unit\InvalidEntityTestClass:5',
			'cacheTags' => ['invalidentitytestclass'],
		], $entity->toArraySilent());
	}

	public function testFromArray()
	{
		$from = [
			'name' => 'Fooo',
			'publicBar' => 'Barr',
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

	public function testFromArrayInvalid()
	{
		$from = [
			'id' => 9,
			'name' => NULL,
			'publicBar' => 'Barr',
		];

		$entity = new InvalidEntityTestClass();

		$this->expectException(\Throwable::class);
		$entity->fromArray($from);
	}

	public function testFromArraySilentInvalid()
	{
		$from = [
			'id' => 9,
			'name' => NULL,
			'publicBar' => 'Barr',
			'cacheKey' => '###',
			'cacheTags' => '###',
		];

		$to = [
			'id' => 5, // read-only
			'publicBar' => 'Barr',
			'cacheKey' => 'Tests\Unit\InvalidEntityTestClass:5', // read-only
			'cacheTags' => ['invalidentitytestclass'], // read-only
		];

		$entity = new InvalidEntityTestClass();
		$entity->fromArraySilent($from);

		$this->assertSame($to, $entity->toArraySilent());
	}

	public function testArrayAccess()
	{
		$entity = new EntityTestClass();

		$this->assertSame('Foo', $entity['name']);
		$entity['name'] = 'Bar';
		$this->assertSame('Bar', $entity['name']);
	}

	public function testTraversable()
	{
		$entity = new EntityTestClass();

		$this->assertSame([
			'id' => 5,
			'name' => 'Foo',
			'publicBar' => 'Bar',
			'cacheKey' => 'Tests\Unit\EntityTestClass:5',
			'cacheTags' => ['entitytestclass'],
		], iterator_to_array($entity));
	}

}
