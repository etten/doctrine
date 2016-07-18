<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

trait MagicAccessors
{

	public function __set($name, $value)
	{
		$this->offsetSet($name, $value);
	}

	public function & __get($name)
	{
		$value = $this->offsetGet($name);
		return $value;
	}

	public function __isset($name)
	{
		return $this->offsetExists($name);
	}

	public function __unset($name)
	{
		$this->offsetUnset($name);
	}

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
		try {
			$this->formatGetter($offset);
			return TRUE;
		} catch (\InvalidArgumentException $e) {
			return FALSE;
		}
	}

	public function offsetGet($offset)
	{
		$method = $this->formatGetter($offset);
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

	private function getGetterPrefixes() :array
	{
		return ['get', 'is', 'has'];
	}

	private function formatGetter($property) :string
	{
		$name = ucfirst($property);

		foreach ($this->getGetterPrefixes() as $prefix) {
			$method = $prefix . $name;
			if (method_exists($this, $method)) {
				return $method;
			}
		}

		throw new \InvalidArgumentException(sprintf('Getter for %s does not exist.', $property));
	}

	/**
	 * @return array [property => method]
	 */
	private function mapArrayGetters() :array
	{
		$tempMap = [];

		// Search all methods and map prefix,key => method.
		$methods = $this->mapArrayMethods(new \ReflectionClass($this));
		foreach ($methods as $method) {
			foreach ($this->getGetterPrefixes() as $prefix) {
				$prefixLength = strlen($prefix);
				if (substr($method, 0, $prefixLength) === $prefix) {
					$key = lcfirst(substr($method, $prefixLength));
					$tempMap[$prefix][$key] = $method;
					break;
				}
			}
		}

		// Merge accessors by preferences (given by prefixes order).
		$map = [];
		foreach ($this->getGetterPrefixes() as $prefix) {
			if (isset($tempMap[$prefix])) {
				$map += $tempMap[$prefix];
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
