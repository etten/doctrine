<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Tests\Unit;

class InvalidEntityTestClass extends EntityTestClass
{

	public function getName():string
	{
		return NULL; // Intentionally bad return type
	}

}
