<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Unit;

use Doctrine\Common\Collections\ArrayCollection;
use Etten\Doctrine\Entities\IdProvider;
use Etten\Doctrine\Helpers\Collections;

class CollectionsTest extends \PHPUnit_Framework_TestCase
{

	public function testReplace()
	{
		$data = [
			14 => $this->createEntity(14),
			15 => $this->createEntity(15),
			16 => $this->createEntity(16),
			17 => $this->createEntity(17),
		];

		$from = new ArrayCollection([
			$data[14],
			$data[15],
			$data[16],
		]);

		$to = new ArrayCollection([
			$data[16],
			$data[14],
			$data[17],
		]);

		Collections::replace($from, $to);
		$this->assertCount(3, $from);
		$this->assertContains($data[16], $from);
		$this->assertContains($data[14], $from);
		$this->assertContains($data[17], $from);
	}

	private function createEntity($id):IdProvider
	{
		return new class ($id) implements IdProvider
		{

			private $id;

			public function __construct($id)
			{
				$this->id = $id;
			}

			public function getId()
			{
				return $this->id;
			}

		};
	}

}
