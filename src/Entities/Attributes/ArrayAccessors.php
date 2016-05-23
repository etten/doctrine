<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

trait ArrayAccessors
{

	public function toArray():array
	{
		$arr = [];
		foreach ($this->getGetters() as $method) {
			$name = $method->getName();
			$key = lcfirst(substr($name, 3));
			$arr[$key] = $this->$name();
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

	/**
	 * @return \ReflectionMethod[]
	 */
	private function getGetters():array
	{
		return $this->getArrayMethods(function (\ReflectionMethod $method) {
			$name = $method->getName();
			return substr($name, 0, 3) === 'get';
		});
	}

	/**
	 * @param callable $filter
	 * @return \ReflectionMethod[]
	 */
	private function getArrayMethods(callable $filter = NULL):array
	{
		$reflection = new \ReflectionClass($this);
		return array_filter($reflection->getMethods(), function (\ReflectionMethod $method) use ($filter) {
			$isOk = $method->isPublic() && !$method->isStatic();

			if ($filter) {
				$isOk &= $filter($method);
			}

			return $isOk;
		});
	}

}
