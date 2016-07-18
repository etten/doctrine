<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

/**
 * @deprecated Use MagicAccessors instead.
 */
trait ArrayAccessors
{

	/**
	 * @return \ArrayIterator
	 * @internal
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->toArray());
	}

	public function offsetExists($offset)
	{
		$method = 'get' . ucfirst($offset);
		return method_exists($this, $method);
	}

	public function offsetGet($offset)
	{
		$method = 'get' . ucfirst($offset);
		return $this->$method();
	}

	public function offsetSet($offset, $value)
	{
		$method = 'set' . ucfirst($offset);
		$this->$method($value);
	}

	public function offsetUnset($offset)
	{
		throw new \LogicException(sprintf('%s is not supported.', __METHOD__));
	}

	public function toArray() :array
	{
		$arr = [];
		foreach ($this->mapArrayGetters() as $key => $method) {
			$arr[$key] = $this->$method();
		}

		return $arr;
	}

	public function toArraySilent() :array
	{
		$arr = [];
		foreach ($this->mapArrayGetters() as $key => $method) {
			try {
				$arr[$key] = $this->$method();
			} catch (\Throwable $e) {
				continue;
			}
		}

		return $arr;
	}

	public function fromArray(array $arr)
	{
		foreach ($arr as $key => $value) {
			$this->offsetSet($key, $value);
		}
	}

	public function fromArraySilent(array $arr)
	{
		foreach ($arr as $key => $value) {
			try {
				$this->offsetSet($key, $value);
			} catch (\Throwable $e) {
				continue;
			}
		}
	}

	/**
	 * @return array [property => method]
	 */
	private function mapArrayGetters() :array
	{
		$map = [];

		$methods = $this->mapArrayMethods(new \ReflectionClass($this));
		foreach ($methods as $method) {
			if (substr($method, 0, 3) === 'get') {
				$key = lcfirst(substr($method, 3));
				$map[$key] = $method;
			}
		}

		return $map;
	}

	/**
	 * @param \ReflectionClass $class
	 * @param string[] $methods
	 * @return string[]
	 */
	private function mapArrayMethods(\ReflectionClass $class, array $methods = []) :array
	{
		foreach ($class->getMethods() as $method) {
			$name = $method->getName();
			$isInternal = strpos($method->getDocComment(), '@internal') !== FALSE;

			if (!$method->isPublic() || $method->isStatic() || $isInternal) {
				unset($methods[$name]); // remove if were set previously
			} else {
				$methods[$name] = $name; // is ok
			}
		}

		if (($parent = $class->getParentClass())) {
			$methods = $this->mapArrayMethods($parent, $methods);
		}

		return $methods;
	}

}
