<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

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

	public function toArray():array
	{
		$arr = [];
		foreach ($this->mapArrayGetters() as $key => $method) {
			$arr[$key] = $this->$method();
		}

		return $arr;
	}

	public function toArraySilent():array
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

		return $this;
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

		return $this;
	}

	/**
	 * @return \ReflectionMethod[]
	 */
	protected function mapArrayMethods():array
	{
		$reflection = new \ReflectionClass($this);
		return array_filter($reflection->getMethods(), function (\ReflectionMethod $method) {
			$isInternal = strpos($method->getDocComment(), '@internal') !== FALSE;
			return $method->isPublic() && !$method->isStatic() && !$isInternal;
		});
	}

	protected function mapArrayGetters():array
	{
		$map = [];
		foreach ($this->mapArrayMethods() as $method) {
			$name = $method->getName();
			if (substr($name, 0, 3) === 'get') {
				$key = lcfirst(substr($name, 3));
				$map[$key] = $name;
			}
		}

		return $map;
	}

}
