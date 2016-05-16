<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities;

abstract class Entity implements IdProvider, Cacheable
{

	public function toArray():array
	{
		$arr = [];
		foreach ($this->getArrayMethods() as $method) {
			$name = $method->getName();
			if (substr($name, 0, 3) === 'get') {
				$key = lcfirst(substr($name, 3));
				$arr[$key] = $this->$name();
			}
		}

		return $arr;
	}

	public function fromArray(array $arr)
	{
		foreach ($arr as $key => $value) {
			$name = 'set' . ucfirst($key);
			if (method_exists($this, $name)) {
				$this->$name($value);
			}
		}

		return $arr;
	}

	public function getCacheKey()
	{
		return get_called_class() . ':' . $this->getId();
	}

	public function getCacheTags()
	{
		$nameParts = explode('\\', get_called_class());
		$name = strtolower(end($nameParts));

		return [$name];
	}

	/**
	 * @return \ReflectionMethod[]
	 */
	private function getArrayMethods():array
	{
		$reflection = new \ReflectionClass($this);
		return array_filter($reflection->getMethods(), function (\ReflectionMethod $method) {
			return $method->isPublic() && !$method->isStatic();
		});
	}

}
