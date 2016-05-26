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
	public static $staticBar = 'Bar';

	/**
	 * @var string
	 */
	public $publicBar = 'Bar';

	/**
	 * @var string
	 */
	public $protectedBar = 'Bar';

	/**
	 * @var string
	 */
	public $privateBar = 'Bar';

	/**
	 * @var
	 */
	private $id = 5;

	/**
	 * @var string
	 */
	private $name = 'Foo';

	public static function getPublicStaticBar():string
	{
		return self::$staticBar;
	}

	public static function setPublicStaticBar(string $bar)
	{
		self::$staticBar = $bar;
	}

	/**
	 * @return string
	 * @internal
	 */
	public function getSomethingInternal()
	{
		return '#';
	}

	public function getId():int
	{
		return $this->id;
	}

	public function getName():string
	{
		return $this->name;
	}

	public function setName(string $name):EntityTestClass
	{
		$this->name = $name;
		return $this;
	}

	public function getPublicBar():string
	{
		return $this->publicBar;
	}

	public function setPublicBar(string $publicBar):EntityTestClass
	{
		$this->publicBar = $publicBar;
		return $this;
	}

	protected function getProtectedBar():string
	{
		return $this->protectedBar;
	}

	protected function setProtectedBar(string $protectedBar)
	{
		$this->protectedBar = $protectedBar;
		return $this;
	}

	private function getPrivateBar():string
	{
		return $this->privateBar;
	}

	private function setPrivateBar(string $privateBar)
	{
		$this->privateBar = $privateBar;
		return $this;
	}

}
