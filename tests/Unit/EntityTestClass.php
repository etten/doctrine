<?php

/**
 * This file is part of etten/doctrine.
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Tests\Unit;

use Etten\Doctrine\Entities\Entity;

class EntityTestClass extends Entity
{

	public function getId()
	{
		return 5;
	}

}
