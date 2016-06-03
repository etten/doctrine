<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

/**
 * @deprecated Use MagicAccessors instead.
 */
trait PropertyAccessors
{

	public function __set($name, $value)
	{
		$method = 'set' . ucfirst($name);
		$this->$method($value);
	}

	public function & __get($name)
	{
		$method = 'get' . ucfirst($name);
		$value = $this->$method();
		return $value;
	}

	public function __isset($name)
	{
		$method = 'get' . ucfirst($name);
		return method_exists($this, $method);
	}

	public function __unset($name)
	{
		throw new \LogicException(sprintf('%s is not supported.', __METHOD__));
	}

}
