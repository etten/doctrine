<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Tests\Unit;

use Etten\Doctrine\Entities\Entity;

class EntityTestClass extends Entity
{

	/**
	 * @var string
	 */
	private $name = 'Foo';

	public static function getPublicStaticBar():string
	{
		return 'Bar';
	}

	public function getId():int
	{
		return 5;
	}

	/**
	 * @return string
	 */
	public function getName():string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return EntityTestClass
	 */
	public function setName(string $name):EntityTestClass
	{
		$this->name = $name;
		return $this;
	}

	public function getPublicBar():string
	{
		return 'Bar';
	}

	protected function getProtectedBar():string
	{
		return 'Bar';
	}

	private function getPrivateBar():string
	{
		return 'Bar';
	}

}
