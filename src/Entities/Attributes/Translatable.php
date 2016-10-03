<?php

/**
 * Copyright © 2016 Jaroslav Hranička <hranicka@outlook.com>
 */

namespace Etten\Doctrine\Entities\Attributes;

use Etten\Doctrine\Entities;
use Knp\DoctrineBehaviors;

trait Translatable
{

	use DoctrineBehaviors\Model\Translatable\TranslatableProperties;
	use DoctrineBehaviors\Model\Translatable\TranslatableMethods;

}
