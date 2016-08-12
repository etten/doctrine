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
			'entitytestclass:5',
			'Tests\Unit\EntityTestClass',
			'Tests\Unit\EntityTestClass:5',
		], $entity->getCacheTags());
	}

	public function testToArray()
	{
		$entity = new EntityTestClass();

		$this->assertSame([
			'id' => 5,
			'hexId' => '5',
			'name' => 'Foo',
			'publicBar' => 'Bar',
			'cacheId' => '5',
			'cacheName' => 'entitytestclass',
			'cacheKey' => 'Tests\Unit\EntityTestClass:5',
			'cacheTags' => [
				'entitytestclass',
				'entitytestclass:5',
				'Tests\Unit\EntityTestClass',
				'Tests\Unit\EntityTestClass:5',
			],
			'test' => TRUE,
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
			'hexId' => '5',
			'publicBar' => 'Bar',
			'cacheId' => '5',
			'cacheName' => 'invalidentitytestclass',
			'cacheKey' => 'Tests\Unit\InvalidEntityTestClass:5',
			'cacheTags' => [
				'invalidentitytestclass',
				'invalidentitytestclass:5',
				'Tests\Unit\InvalidEntityTestClass',
				'Tests\Unit\InvalidEntityTestClass:5',
			],
			'test' => TRUE,
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
			'hexId' => '5', // read-only
			'name' => 'Fooo',
			'publicBar' => 'Barr',
			'cacheId' => '5',
			'cacheName' => 'entitytestclass',
			'cacheKey' => 'Tests\Unit\EntityTestClass:5', // read-only
			'cacheTags' => [
				'entitytestclass',
				'entitytestclass:5',
				'Tests\Unit\EntityTestClass',
				'Tests\Unit\EntityTestClass:5',
			], // read-only
			'test' => TRUE, // read-only
		];

		$entity = new EntityTestClass();
		$entity->fromArray($from);

		$this->assertSame($to, $entity->toArray());
	}

	public function testFromArrayInvalid()
	{
		$from = [
			'id' => 9,
			'hexId' => '9',
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
			'hexId' => '9',
			'name' => NULL,
			'publicBar' => 'Barr',
			'cacheKey' => '###',
			'cacheTags' => '###',
		];

		$to = [
			'id' => 5, // read-only
			'hexId' => '5', // read-only
			'publicBar' => 'Barr',
			'cacheId' => '5',
			'cacheName' => 'invalidentitytestclass',
			'cacheKey' => 'Tests\Unit\InvalidEntityTestClass:5', // read-only
			'cacheTags' => [
				'invalidentitytestclass',
				'invalidentitytestclass:5',
				'Tests\Unit\InvalidEntityTestClass',
				'Tests\Unit\InvalidEntityTestClass:5',
			], // read-only
			'test' => TRUE, // read-only
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

	public function testPropertyAccess()
	{
		$entity = new EntityTestClass();

		$this->assertSame('Foo', $entity->name);
		$entity->name = 'Bar';
		$this->assertSame('Bar', $entity->name);

		$this->assertSame(TRUE, $entity->test);
	}

	public function testTraversable()
	{
		$entity = new EntityTestClass();

		$this->assertSame([
			'id' => 5,
			'hexId' => '5',
			'name' => 'Foo',
			'publicBar' => 'Bar',
			'cacheId' => '5',
			'cacheName' => 'entitytestclass',
			'cacheKey' => 'Tests\Unit\EntityTestClass:5',
			'cacheTags' => [
				'entitytestclass',
				'entitytestclass:5',
				'Tests\Unit\EntityTestClass',
				'Tests\Unit\EntityTestClass:5',
			],
			'test' => TRUE,
		], iterator_to_array($entity));
	}

}
