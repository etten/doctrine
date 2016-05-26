<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

trait ArrayAccessors
{

	public function offsetExists($offset)
	{
		$name = 'get' . ucfirst($offset);
		return method_exists($this, $name);
	}

	public function offsetGet($offset)
	{
		$name = 'get' . ucfirst($offset);
		return $this->$name();
	}

	public function offsetSet($offset, $value)
	{
		$name = 'set' . ucfirst($offset);
		$this->$name($value);
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
			return $method->isPublic() && !$method->isStatic();
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
