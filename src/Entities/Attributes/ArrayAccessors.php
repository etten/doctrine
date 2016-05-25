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
			$this->callSetterFromArray($key, $value);
		}

		return $this;
	}

	public function fromArraySilent(array $arr)
	{
		foreach ($arr as $key => $value) {
			try {
				$this->callSetterFromArray($key, $value);
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

	protected function callSetterFromArray(string $key, $value)
	{
		$name = 'set' . ucfirst($key);
		if (method_exists($this, $name)) {
			$this->$name($value);
		}
	}

}
